<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    $_SESSION['lastSeen'] = 'my-cart.php';
	echo "<script>location.href='login.php';</script>";
} else {
    $_SESSION['lastSeen'] = '';
    if ((!empty($_SESSION['product'])) || (!empty($_SESSION['combo']))) {
        // Code for Remove a Product from Cart
        if (isset($_POST['pRemove_code'])) {
            foreach ($_POST['pRemove_code'] as $key) {
                unset($_SESSION['product'][$key]);
            }
        }
        if (isset($_POST['pQuantity'])) {
            $popupText = "";
            $ictr = 0;
            foreach ($_POST['pQuantity'] as $key => $val) {
                if (($val == 0) || ((isset($_POST['pRemove_code'])) && (in_array($key, $_POST['pRemove_code'])))) {
                    unset($_SESSION['product'][$key]);
                } else {
                    $query3 = mysqli_query($con, "SELECT productName,productAvailability,prod_avail,allow_ao from products where id='" . $key . "'");
                    if ($row3 = mysqli_fetch_array($query3)) {
                        $productName = $row3['productName'];
                        $productAvailability = $row3['productAvailability'];
                        $prod_avail = intval($row3['prod_avail']);
                        $allow_ao = intval($row3['allow_ao']);

                        if($productAvailability == "Out of Stock") {
                            $popupText .= "<b>$productName - </b>Out of Stock!!!<BR/>";
                        } else if($productAvailability == "In Stock") {
                            if(($allow_ao == 0) && ($prod_avail == 0))
                                $popupText .= "<b>$productName - </b>Out of Stock!!!<BR/>";
                            else if(($allow_ao == 0) && ($prod_avail < $val))
                                $popupText .= "<b>$productName - </b>Please order the product within the available quantity of <b>[$prod_avail]</b><BR/>";
                        }
                    }
                    $_SESSION['product'][$key]['quantity'] = $val;
                }
                $ictr++;
            }

            if(!empty($popupText)) {
                echo "<script>
                Swal.fire({
                    title: 'Attention!',
                    html: '$popupText',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(true);
                    }
                });
                </script>";
                return;
            }
        }
        // Code for Remove a combo from Cart
        if (isset($_POST['cRemove_code'])) {
            foreach ($_POST['cRemove_code'] as $key) {
                unset($_SESSION['combo'][$key]);
            }
        }
        if (isset($_POST['cQuantity'])) {
            $popupText = "";
            $ictr = 0;
            foreach ($_POST['cQuantity'] as $key => $val) {
                if (($val == 0) || ((isset($_POST['cRemove_code'])) && (in_array($key, $_POST['cRemove_code'])))) {
                    unset($_SESSION['combo'][$key]);
                } else {
                    $query3 = mysqli_query($con, "SELECT comboName,comboAvailability from combo where id='" . $key . "'");
                    if ($row3 = mysqli_fetch_array($query3)) {
                        $comboName = $row3['comboName'];
                        $comboAvailability = $row3['comboAvailability'];

                        if($comboAvailability == "Out of Stock") {
                            $popupText .= "<b>$comboName - </b>Out of Stock!!!<BR/>";
                        }
                    }
                    $_SESSION['combo'][$key]['quantity'] = $val;
                }
                $ictr++;
            }

            if(!empty($popupText)) {
                echo "<script>
                Swal.fire({
                    title: 'Attention!',
                    html: '$popupText',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(true);
                    }
                });
                </script>";
                return;
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
            
            if ((!empty($_SESSION['product'])) || (!empty($_SESSION['combo']))) {
                echo "<script>location.href='payment-method.php';</script>";
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Attention!',
                    html: 'Your Shopping Cart is empty!!!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(true);
                    }
                });
                </script>";
            }
        } else {

            echo "<script>
                Swal.fire({
                    title: 'Attention!',
                    text: 'Please enter Mandatory (*) fields.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                </script>";

        }
    }
}
?>