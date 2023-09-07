<?php
session_start();
include('includes/config.php');
$id = intval($_POST['product_id']);
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity']++;
    echo "<script>
        Swal.fire({
            title: 'Product Already in Cart!',
            text: 'Do you want to proceed?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
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
            title: 'Product Added!',
            text: 'Product has been added to the cart.',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Go to Cart',
            cancelButtonText: 'Continue Shopping'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location = 'my-cart.php';
            }
        });
    </script>";
    } else {
        $message = "Product ID is invalid";
    }
}
?>