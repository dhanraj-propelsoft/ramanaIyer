<?php
session_start();
error_reporting(0);

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
    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Your Cart has been Updated!',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        </script>";
}
?>