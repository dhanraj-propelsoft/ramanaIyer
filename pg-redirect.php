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
        //include('includes/header.php');
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
<form name='razorpayform' action="payment-status.php" method="POST">
    <!-- <button id="rzp-button1">Pay</button> -->
    <p align="center">Please wait while you are redirected to the gateway to make payment.<BR/>Please do not go back.</p>
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_order_id"  id="razorpay_order_id" >
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
    <input type="hidden" name="razorpay_error_code" id="razorpay_error_code" >
    <input type="hidden" name="razorpay_error_desc"  id="razorpay_error_desc" >
    <input type="hidden" name="razorpay_error_source"  id="razorpay_error_source" >
    <input type="hidden" name="razorpay_error_step" id="razorpay_error_step" >
    <input type="hidden" name="razorpay_error_reason"  id="razorpay_error_reason" >
</form>
<script>
    // Checkout details as a json
    var options = <?=$json?>;
    /**
    * The entire list of Checkout fields is available at
    * https://docs.razorpay.com/docs/checkout-form#checkout-fields
    */
    options.handler = function (response){
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;
        document.razorpayform.submit();
    };
    // Boolean whether to show image inside a white frame. (default: true)
    options.theme.image_padding = false;
    options.modal = {
        ondismiss: function() {
        //console.log("This code runs when the popup is closed");
        window.location = 'pg-cancel.php';
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
        document.getElementById('razorpay_error_code').value = response.error.code;
        document.getElementById('razorpay_error_desc').value = response.error.description;
        document.getElementById('razorpay_error_source').value = response.error.source;
        document.getElementById('razorpay_error_step').value = response.error.step;
        document.getElementById('razorpay_error_reason').value = response.error.reason;
        document.getElementById('razorpay_order_id').value = response.error.metadata.order_id;
        document.getElementById('razorpay_payment_id').value = response.error.metadata.payment_id;
        document.razorpayform.submit();
    });
    // document.getElementById('rzp-button1').onclick = function(e){
    //     rzp.open();
    //     e.preventDefault();
    // }
</script>
<?php //include('includes/footer.php'); ?>