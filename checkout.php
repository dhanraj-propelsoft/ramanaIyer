<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	echo "<script>location.href='login.php';</script>";
} else {

    if (!empty($_SESSION['cart'])) {
        if (isset($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $key => $val) {
                if ($val == 0) {
                    unset($_SESSION['cart'][$key]);
                } else {
                    $_SESSION['cart'][$key]['quantity'] = $val;

                }
            }
        }
        // Code for Remove a Product from Cart
        if (isset($_POST['remove_code'])) {
            foreach ($_POST['remove_code'] as $key) {
                unset($_SESSION['cart'][$key]);
            }
        }

        $baddress = $_POST['billingaddress'];
        $bstate = $_POST['bilingstate'];
        $bcity = $_POST['billingcity'];
        $bpincode = $_POST['billingpincode'];
        $saddress = $_POST['shippingaddress'];
        $sstate = $_POST['shippingstate'];
        $scity = $_POST['shippingcity'];
        $spincode = $_POST['shippingpincode'];

        if((!empty($baddress)) && (!empty($bstate)) && (!empty($bcity)) && (!empty($bpincode)) && (!empty($saddress)) && (!empty($sstate)) && (!empty($scity)) && (!empty($spincode)))
        {
            mysqli_query($con, "update users set billingAddress='$baddress',billingState='$bstate',billingCity='$bcity',billingPincode='$bpincode' where id='" . $_SESSION['id'] . "'");
            mysqli_query($con, "update users set shippingAddress='$saddress',shippingState='$sstate',shippingCity='$scity',shippingPincode='$spincode' where id='" . $_SESSION['id'] . "'");
            echo "<script>location.href='payment-method.php';</script>";
        } else {

            echo "<script>
                Swal.fire({
                    title: 'Caution!',
                    text: 'Please enter Mandatory (*) fields.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                </script>";

        }
    }
}
?>