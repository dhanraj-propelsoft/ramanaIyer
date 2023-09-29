<?php
session_start();
require_once('vendor/razorpay/razorpay/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
//error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
	header('location:login.php');
    exit;
} else {
    include('includes/config.php');

    $total_amt = "0";
    $receiptNo = "";
    $cust_name = "";
    $cust_mob = "";
    $cust_mail = "";
    $cust_adrs = "";
    $order_id = "";
    $quantity = "";
    $result = mysqli_query($con, "SELECT * FROM orders WHERE userId='" . $_SESSION['id'] . "' AND receiptNo='".$_SESSION['receiptNo']."' AND (paymentMethod != 'COD' OR paymentMethod IS NULL) AND paymentID IS NULL");
    while ($row = mysqli_fetch_array($result)) {
        //$total_amt = $_SESSION['tp'];
        $receiptNo = $row['receiptNo'];
        $result1 = mysqli_query($con, "SELECT * FROM products WHERE id='" . $row['productId'] . "'");
        if($row1 = mysqli_fetch_array($result1))
        {
            $subtotal = (int) $row['quantity'] * (int) $row1['productPrice'] + (int) $row1['shippingCharge'];
            $total_amt += $subtotal;
        }
        $order_id .= $row['id']."_";
        $quantity .= $row['quantity']."_";
    }
    $_SESSION['receiptNo']=$receiptNo;
    $_SESSION['total_amt']=$total_amt;
    
    $result2 = mysqli_query($con, "SELECT * FROM users WHERE id='" . $_SESSION['id'] . "'");
    if($row2 = mysqli_fetch_array($result2))
    {
        $cust_name = $row2['name'];
        $cust_mob = $row2['contactno'];
        $cust_mail = $row2['email'];
        $cust_adrs = $row2['shippingState'].", ".$row2['shippingCity'];
    }

    if(($_SESSION['receiptNo']=="") || ($_SESSION['total_amt']=="0"))
    {
        header('location:index.php');
    } else {
        //session_start();
        $keyId = 'rzp_test_TIvjJmBIbM2Kci';
        $keySecret = 'grIOrCY9qMtAsAeBrylYyYPi';
        $displayCurrency = 'INR';
        $api = new Api($keyId, $keySecret);
        //
        // We create an razorpay order using orders api
        // Docs: https://docs.razorpay.com/docs/orders
        //
        $orderData = [
            'receipt'         => $receiptNo,
            'amount'          => $total_amt * 100, // 2000 rupees in paise
            'currency'        => 'INR',
            'notes'=> array('mercOId'=> $order_id,'mercOQty'=> $quantity),
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder = $api->order->create($orderData);
        $razorpayOrderId = $razorpayOrder['id'];
        $_SESSION['razorpay_order_id'] = $razorpayOrderId;
        $displayAmount = $amount = $orderData['amount'];

        if ($displayCurrency !== 'INR'){
            $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
            $exchange = json_decode(file_get_contents($url), true);
            $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
        }

        $checkout = 'automatic';

        if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
        {
            $checkout = $_GET['checkout'];
        }
        $data = [
            "key"               => $keyId,
            "amount"            => $amount,
            "currency"          => "INR",
            "name"              => "Ramana Iyer Sweets",
            "description"       => "Happy to help :)",
            "prefill"           => [
                "name"              => $cust_name,
                "email"             => $cust_mail,
                "contact"           => $cust_mob,
            ],
            "notes"             => [
                "address"           => $cust_adrs,
                "merchant_order_id" => $receiptNo,
            ],
            "theme"             => [
                "color"             => "#cf171d"
            ],
            "order_id"          => $razorpayOrderId,
        ];

        if ($displayCurrency !== 'INR')
        {
            $data['display_currency']  = $displayCurrency;
            $data['display_amount']    = $displayAmount;
        }
        $json = json_encode($data);
        include('includes/header.php');
    }
}
?>
<style>
    html, body {
        height: 100%;
    }

    html {
        display: table;
        margin: auto;
    }

    body {
        display: table-cell;
        vertical-align: middle;
    }
</style>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="home.html">Home</a></li>
                <li class='active'>Payment Status</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div>
<div id="ack" align="center"><h1>Please wait while you are redirected to the gateway to make payment.<BR/>Please do not go back.</h1></div>
<script>
    // Checkout details as a json
    var options = <?=$json?>;
    /**
    * The entire list of Checkout fields is available at
    * https://docs.razorpay.com/docs/checkout-form#checkout-fields
    */
    options.handler = function (response){
        console.log(response);
        var formData = new FormData();
        formData.append('razorpay_payment_id', response.razorpay_payment_id);
        formData.append('razorpay_order_id', response.razorpay_order_id);
        formData.append('razorpay_signature', response.razorpay_signature);

        $.ajax({
            method: 'POST',
            url: 'payment-status.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                //console.log(data);
                $("#ack").html(data);
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    };
    // Boolean whether to show image inside a white frame. (default: true)
    options.theme.image_padding = false;
    options.modal = {
        ondismiss: function() {
        //console.log("This code runs when the popup is closed");
        $("#ack").html("<h1>Oops!!!<BR/>Your Last Payment has been cancelled.<BR/>Please retry the payment to checkout the order.</h1>");
        Swal.fire({
            title: 'Oops!',
            text: 'Your Last Payment has been cancelled.',
            icon: 'info',
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
        },
        // Boolean indicating whether pressing escape key
        // should close the checkout form. (default: true)
        escape: true,
        // Boolean indicating whether clicking translucent blank
        // space outside checkout form should close the form. (default: false)
        backdropclose: false
    };
    var rzp = new Razorpay(options);
    rzp.open();
    rzp.on('payment.failed', function (response){
        console.log(response);
        var formData = new FormData();
        formData.append('razorpay_payment_id', response.error.metadata.payment_id);
        formData.append('razorpay_order_id', response.error.metadata.order_id);
        formData.append('razorpay_error_code', response.error.code);
        formData.append('razorpay_error_desc', response.error.description);
        formData.append('razorpay_error_source', response.error.source);
        formData.append('razorpay_error_step', response.error.step);
        formData.append('razorpay_error_reason', response.error.reason);

        $.ajax({
            method: 'POST',
            url: 'payment-status.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                //console.log(data);
                $("#ack").html(data);
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    });
    // document.getElementById('rzp-button1').onclick = function(e){
    //     rzp.open();
    //     e.preventDefault();
    // }
</script>
<?php include('includes/footer.php'); ?>