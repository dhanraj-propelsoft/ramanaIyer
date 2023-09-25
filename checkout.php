<?php
session_start();
error_reporting(0);
include('includes/config.php');

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
    
    $prodid = array();
    $prodQt = array();
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

        $sql = "SELECT * FROM products WHERE id IN(";
        foreach ($_SESSION['cart'] as $id => $value) {
            $sql .= $id . ",";
        }
        $sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
        $query = mysqli_query($con, $sql);
        $totalprice = 0;
        $totalqunty = 0;
        if (!empty($query)) {
            $rating = 0;
            while ($row = mysqli_fetch_array($query)) {
                $quantity = $_SESSION['cart'][$row['id']]['quantity'];
                $subtotal = (int) $_SESSION['cart'][$row['id']]['quantity'] * (int) $row['productPrice'] + (int) $row['shippingCharge'];
                $totalprice += $subtotal;
                $_SESSION['qnty'] = $totalqunty += (int) $quantity;

                array_push($prodid, $row['id']);
                array_push($prodQt, $quantity);
            }
        }
        $_SESSION['pid'] = $prodid;
        $_SESSION['prodQt'] = $prodQt;
    }

    $quantity = $_SESSION['pQty'];
    $pdd = $_SESSION['pid'];
    $value = array_combine($prodid, $prodQt);

    foreach ($value as $qty => $val34) {
        mysqli_query($con, "insert into orders(userId,productId,quantity) values('" . $_SESSION['id'] . "','$qty','$val34')");
        mysqli_query($con, "DELETE FROM cart WHERE userId='" . $_SESSION['id'] . "'");
		unset($_SESSION['cart']);
		echo "<script>location.href='payment-method.php';</script>";
    }
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

?>