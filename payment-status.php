<?php
session_start();
require_once('vendor/razorpay/razorpay/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$keyId = 'rzp_test_TIvjJmBIbM2Kci';
$keySecret = 'grIOrCY9qMtAsAeBrylYyYPi';
$displayCurrency = 'INR';
$api = new Api($keyId, $keySecret);
$razorpayPaymentId = 0;
$razorpayOrderId = 0;
$razorpaySignature = 0;
$razorpayErrorCode = 0;
$razorpayErrorDesc = 0;
$razorpayErrorSource = 0;
$razorpayErrorStep = 0;
$razorpayErrorReason = 0;
$paymentStatus = 0;
$paymentInd = 0;
error_reporting(0);
//include('includes/config.php');
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
    // if($razorpayPaymentId == 0)
    // {
    //     header('location:index.php');
    // }
    // else
    {
    $razorpayOrderId = $_SESSION['razorpay_order_id'];
    //echo "<BR/>Session Order ID - ".$razorpayOrderId;
    $secret = "grIOrCY9qMtAsAeBrylYyYPi";
    $string = $razorpayOrderId . "|" . $razorpayPaymentId;
    $GeneratedSign = hash_hmac('sha256', $string, $secret);
    //echo "<BR/>".$GeneratedSign;
    if ($GeneratedSign == $razorpaySignature) {
        $paymentInd = 1;
        $paymentStatus = "SUCCESS";
    } else {
        $paymentInd = 0;
        $paymentStatus = "FAILED";
    }

    include('includes/config.php');
    include('includes/header.php');
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
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="home.html">Home</a></li>
					<li class='active'>Payment Status</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
            <?php
            if($paymentInd == 1)
                echo "<h1>Your order has been received by Ramana Sweets. Your sweets will be delivered to  customer shipping address</h1>";
            else
                echo "<h1>Sorry!!! Your payment transaction has failed. Please retry the payment to checkout the order.</h1>";
            ?>
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->
	
	<?php include('includes/footer.php'); ?>
	<script>
	</script>
<?php } } ?>