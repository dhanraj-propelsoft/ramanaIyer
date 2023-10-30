<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    $_SESSION['lastSeen'] = 'my-cart.php';
	echo "<script>location.href='login.php';</script>";
} else {

    if ((!empty($_SESSION['product'])) || (!empty($_SESSION['combo']))) {
        if (isset($_POST['pQuantity'])) {
            foreach ($_POST['pQuantity'] as $key => $val) {
                if ($val == 0) {
                    unset($_SESSION['product'][$key]);
                } else {
                    $_SESSION['product'][$key]['quantity'] = $val;

                }
            }
        }
        // Code for Remove a Product from Cart
        if (isset($_POST['pRemove_code'])) {
            foreach ($_POST['pRemove_code'] as $key) {
                unset($_SESSION['product'][$key]);
            }
        }
        if (isset($_POST['cQuantity'])) {
            foreach ($_POST['cQuantity'] as $key => $val) {
                if ($val == 0) {
                    unset($_SESSION['combo'][$key]);
                } else {
                    $_SESSION['combo'][$key]['quantity'] = $val;

                }
            }
        }
        // Code for Remove a combo from Cart
        if (isset($_POST['cRemove_code'])) {
            foreach ($_POST['cRemove_code'] as $key) {
                unset($_SESSION['combo'][$key]);
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
        $dateTime = $_POST['dateTime'];

        if((!empty($baddress)) && (!empty($bstate)) && (!empty($bcity)) && (!empty($bpincode)) && (!empty($saddress)) && (!empty($sstate)) && (!empty($scity)) && (!empty($spincode)) && (!empty($dateTime)))
        {
            $_SESSION['dtSupply'] = $dateTime;
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