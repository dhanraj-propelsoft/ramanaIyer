<?php
session_start();
//error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:login.php');
} else {
    // Code forProduct deletion from  wishlist	
    if (isset($_POST)) {
        $pgAmount = "";
        $pgBuyer = "";
        $pgBuyerName = "";
        $pgBuyerPhone = "";
        $pgCurrency = "";
        $pgFees = "";
        $pgLongurl = "";
        $pgMac = "";
        $pgPaymentId = "";
        $pgRequestId = "";
        $pgPurpose = "";
        $pgShorturl = "";
        $paymentStatus = "";
        /*
        Basic PHP script to handle Instamojo RAP webhook.
        */

        $data = $_POST;
        $mac_provided = $data['mac']; // Get the MAC from the POST data
        unset($data['mac']); // Remove the MAC key from the data.
        $ver = explode('.', phpversion());
        $major = (int) $ver[0];
        $minor = (int) $ver[1];
        if ($major >= 5 and $minor >= 4) {
            ksort($data, SORT_STRING | SORT_FLAG_CASE);
        } else {
            uksort($data, 'strcasecmp');
        }

        if (isset($_POST['amount']))
            $pgAmount = $_POST['amount'];
        if (isset($_POST['buyer']))
            $pgBuyer = $_POST['buyer'];
        if (isset($_POST['buyer_name']))
            $pgBuyerName = $_POST['buyer_name'];
        if (isset($_POST['buyer_phone']))
            $pgBuyerPhone = $_POST['buyer_phone'];
        if (isset($_POST['currency']))
            $pgCurrency = $_POST['currency'];
        if (isset($_POST['fees']))
            $pgFees = $_POST['fees'];
        if (isset($_POST['longurl']))
            $pgLongurl = $_POST['longurl'];
        if (isset($_POST['mac']))
            $pgMac = $_POST['mac'];
        if (isset($_POST['payment_id']))
            $pgPaymentId = $_POST['payment_id'];
        if (isset($_POST['payment_request_id']))
            $pgRequestId = $_POST['payment_request_id'];
        if (isset($_POST['purpose']))
            $pgPurpose = $_POST['purpose'];
        if (isset($_POST['shorturl']))
            $pgShorturl = $_POST['shorturl'];
        if (isset($_POST['status']))
            $paymentStatus = $_POST['status'];


        if (($_SESSION['receiptNo'] != "") && ($_SESSION['total_amt'] != "0")) {
            // You can get the 'salt' from Instamojo's developers page(make sure to log in first): https://www.instamojo.com/developers
            // Pass the 'salt' without <>
            $mac_calculated = hash_hmac("sha1", implode("|", $data), "bfcbd3a642b84b658e2c1fbce3a3f107");
            if ($mac_provided == $mac_calculated) {

                include('includes/config.php');
                mysqli_query($con, "insert into payment(userId, receipt_no, total_amt, pg_buyer, pg_buyer_name, pg_buyer_phone, pg_currency, pg_fees, pg_longurl, pg_mac, pg_payment_id, pg_request_id, pg_purpose, pg_shorturl, payment_status) values('" . $_SESSION['id'] . "','" . $_SESSION['receiptNo'] . "','" . $_SESSION['total_amt'] . "', '$pgBuyer', '$pgBuyerName', '$pgBuyerPhone', '$pgCurrency', '$pgFees', '$pgLongurl', '$pgMac', '$pgPaymentId', '$pgRequestId', '$pgPurpose', '$pgShorturl', '$paymentStatus')");

                if ($data['status'] == "Credit") {
                    // Payment was successful, mark it as successful in your database.
                    // You can acess payment_request_id, purpose etc here. 
                    mysqli_query($con, "UPDATE orders SET pg_payment_id='$pgPaymentId' WHERE userId='" . $_SESSION['id'] . "' AND receiptNo='" . $_SESSION['receiptNo'] . "'");
                    unset($_SESSION['receiptNo']);
                    unset($_SESSION['total_amt']);

                    mysqli_query($con, "DELETE FROM cart WHERE userId='" . $_SESSION['id'] . "'");
                    unset($_SESSION['cart']);

                    $cust_adrs = "";
                    $query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
                    if ($row = mysqli_fetch_array($query)) {
                        $cust_adrs = $row['shippingAddress'] . ", " . $row['shippingState'] . ", " . $row['shippingCity'] . ", " . $row['shippingPincode'];
                    }
                    echo "<h1>Your order has been received by Ramana Sweets.<BR/>Your sweets will be delivered to  customer shipping address</h1>";
                    echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Payment Successful. Your order has been received by Ramana Sweets. Your sweets will be delivered to mentioned shipping address! ($cust_adrs)',
                        icon: 'success',
                        showDenyButton: true,
                        confirmButtonText: 'Go to Order List',
                        denyButtonText: 'Continue Shopping',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'order-history.php';
                        } else if (result.isDenied) {
                            window.location.href = 'index.php';
                        }
                    });
                    </script>";
                } else {
                    // Payment was unsuccessful, mark it as failed in your database.
                    // You can acess payment_request_id, purpose etc here.
                    echo "<h1>Sorry!!!<BR/>Your payment transaction has failed.<BR/>Please retry the payment to checkout the order.</h1>";
                    echo "<script>
                    Swal.fire({
                        title: 'Oops...',
                        text: 'Your transaction has failed. Please try again.',
                        icon: 'error',
                        showDenyButton: true,
                        confirmButtonText: 'Retry Payment',
                        denyButtonText: 'Continue Shopping',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'pg-redirect.php';
                        } else if (result.isDenied) {
                            window.location.href = 'index.php';
                        }
                    });
                    </script>";
                }
            } else {
                echo "MAC mismatch";
            }
        }
    }
}

?>


<?php
/*session_start();
require_once('vendor/razorpay/razorpay/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$keyId = 'rzp_test_TIvjJmBIbM2Kci';
$keySecret = 'grIOrCY9qMtAsAeBrylYyYPi';
// $keyId = 'rzp_test_mCBWr5F7S9wokz';        
// $keySecret = '0GpW3L1LWUfnTURo5HmuB8Iu';
$displayCurrency = 'INR';
$api = new Api($keyId, $keySecret);
$razorpayPaymentId = "";
$razorpayOrderId = "";
$razorpaySignature = "";
$razorpayErrorCode = 0;
$razorpayErrorDesc = 0;
$razorpayErrorSource = 0;
$razorpayErrorStep = 0;
$razorpayErrorReason = 0;
$paymentStatus = 0;
$paymentInd = 0;
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:login.php');
} else {
    // Code forProduct deletion from  wishlist	
    if(isset($_POST))
    {
        if (isset($_POST['razorpay_payment_id']))
            $razorpayPaymentId = $_POST['razorpay_payment_id'];
        if (isset($_POST['razorpay_order_id']))
            $razorpayOrderId = $_POST['razorpay_order_id'];
        if (isset($_POST['razorpay_signature']))
            $razorpaySignature = $_POST['razorpay_signature'];
        if (isset($_POST['razorpay_error_code']))
            $razorpayErrorCode = $_POST['razorpay_error_code'];
        if (isset($_POST['razorpay_error_desc']))
            $razorpayErrorDesc = $_POST['razorpay_error_desc'];
        if (isset($_POST['razorpay_error_source']))
            $razorpayErrorSource = $_POST['razorpay_error_source'];
        if (isset($_POST['razorpay_error_step']))
            $razorpayErrorStep = $_POST['razorpay_error_step'];
        if (isset($_POST['razorpay_error_reason']))
            $razorpayErrorReason = $_POST['razorpay_error_reason'];

    }

    // echo $_SESSION['total_amt'] . ',' . $_SESSION['receiptNo'] . ',' .$paymentStatus. ',' .$razorpayPaymentId. ',' .$razorpayOrderId. ',' .$razorpaySignature. ',' .$razorpayErrorCode. ',' .$razorpayErrorDesc. ',' .$razorpayErrorSource. ',' .$razorpayErrorStep. ',' .$razorpayErrorReason;
    // exit();
    if (empty($razorpayPaymentId) === true){
        header('location:index.php');
    } else 
    {
    $razorpayOrderId = $_SESSION['razorpay_order_id'];

    if (empty($razorpayPaymentId) === false){
        try {
            $attributes = array(
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId,
                'razorpay_signature' => $razorpaySignature
            );

            $api->utility->verifyPaymentSignature($attributes);
            $paymentInd = 1;
            $paymentStatus = "SUCCESS";
        } catch(SignatureVerificationError $e) {
            $paymentInd = 0;
            $paymentStatus = "FAILED";
            $error = 'Razorpay Error : ' . $e->getMessage();
        }
    }

    include('includes/config.php');
    $razorpayErrorDesc = str_replace("'","\'",$razorpayErrorDesc);
    if(($_SESSION['receiptNo'] != "") && ($_SESSION['total_amt'] != "0"))
    {
        mysqli_query($con, "insert into payment(userId,total_amt,receipt_no,payment_status,pg_payment_id,pg_order_id,pg_signature,pg_error_code,pg_error_desc,pg_error_source,pg_error_step,pg_error_reason) values('" . $_SESSION['id'] . "','" . $_SESSION['total_amt'] . "','" . $_SESSION['receiptNo'] . "','$paymentStatus','$razorpayPaymentId','$razorpayOrderId','$razorpaySignature','$razorpayErrorCode','$razorpayErrorDesc','$razorpayErrorSource','$razorpayErrorStep','$razorpayErrorReason')");
        if($paymentInd == 1)
        {
            mysqli_query($con, "UPDATE orders SET paymentId='$razorpayPaymentId' WHERE userId='" . $_SESSION['id'] . "' AND receiptNo='" . $_SESSION['receiptNo'] . "'");
            unset($_SESSION['receiptNo']);
            unset($_SESSION['total_amt']);
    
            mysqli_query($con, "DELETE FROM cart WHERE userId='" . $_SESSION['id'] . "'");
            unset($_SESSION['cart']);

            $cust_adrs = "";
            $query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
            if ($row = mysqli_fetch_array($query)) {
                $cust_adrs = $row['shippingAddress'].", ".$row['shippingState'].", ".$row['shippingCity'].", ".$row['shippingPincode'];
            }
            echo "<h1>Your order has been received by Ramana Sweets.<BR/>Your sweets will be delivered to  customer shipping address</h1>";
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Payment Successful. Your order has been received by Ramana Sweets. Your sweets will be delivered to mentioned shipping address! ($cust_adrs)',
                    icon: 'success',
                    showDenyButton: true,
                    confirmButtonText: 'Go to Order List',
                    denyButtonText: 'Continue Shopping',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'order-history.php';
                    } else if (result.isDenied) {
                        window.location.href = 'index.php';
                    }
                });
                </script>";
        } else {
            echo "<h1>Sorry!!!<BR/>Your payment transaction has failed.<BR/>Please retry the payment to checkout the order.</h1>";
            echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Your transaction has failed. Please try again.',
                    icon: 'error',
                    showDenyButton: true,
                    confirmButtonText: 'Retry Payment',
                    denyButtonText: 'Continue Shopping',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'pg-redirect.php';
                    } else if (result.isDenied) {
                        window.location.href = 'index.php';
                    }
                });
                </script>";
        }
    }
    ?>
<?php } } */?>