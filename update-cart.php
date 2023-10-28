<?php
session_start();
error_reporting(0);

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
    // Code for Remove a combo from Cart
    if (isset($_POST['cRemove_code'])) {
        foreach ($_POST['cRemove_code'] as $key) {
            unset($_SESSION['combo'][$key]);
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
    if (isset($_POST['pRemove_code'])) {
        foreach ($_POST['pRemove_code'] as $key) {
            unset($_SESSION['combo'][$key]);
        }
    }
    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Your Cart has been Updated!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
				location.reload(true);
				// $('.shopping-cart-table').load(' .shopping-cart-table > *');
				// $('#cartRefreshDiv').load(' #cartRefreshDiv > *');
            }
        });
        </script>";
}
?>