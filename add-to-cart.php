<?php
session_start();
error_reporting(0);
include('includes/config.php');
$id = intval($_POST['product_id']);

$page = "";
if (isset($_POST['page']))
    $page = trim($_POST['page']);

if ($page == 'wishlist')
    mysqli_query($con, "delete from wishlist where productId='$id'");

if (isset($_SESSION['cart'][$id])) {
    //$_SESSION['cart'][$id]['quantity']++;
    echo "<script>
        Swal.fire({
            title: 'Product Already in Cart!',
            text: 'Do you want to proceed?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                const expires = new Date(Date.now() + 1000).toUTCString();
                document.cookie = `qi_id=$id; expires=expires`;
                window.location.href = 'my-cart.php';
            }
        });
    </script>";
} else {
    $sql_p = "SELECT * FROM products WHERE id={$id}";
    $query_p = mysqli_query($con, $sql_p);
    if (mysqli_num_rows($query_p) != 0) {
        $row_p = mysqli_fetch_array($query_p);
        $_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);
        echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Product has been added to the cart.',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Go to Cart',
            cancelButtonText: 'Continue Shopping'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location = 'my-cart.php';
            } else {
                $('#cartRefreshDiv').load(' #cartRefreshDiv > *');
            }
        });
    </script>";
    } else {
        $message = "Product ID is invalid";
    }
}
?>