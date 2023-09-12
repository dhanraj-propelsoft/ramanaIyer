<?php 
session_start();
error_reporting(0);
if(!empty($_POST["session_id"]))
	$session_id= $_POST["session_id"];
if(!empty($_POST["product_id"]))
    $product_id= $_POST["product_id"];

include('includes/config.php');
$sql_p = "SELECT * FROM wishlist WHERE userId={$session_id} AND productId={$product_id}";
$query_p = mysqli_query($con, $sql_p);
if (mysqli_num_rows($query_p) != 0) {
    echo "<script>
        Swal.fire({
            title: 'Information',
            text: 'Product Already in Wishlist!',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    </script>";
} else {
    mysqli_query($con, "insert into wishlist(userId,productId) values('" . $session_id . "','$product_id')");

    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Product has been added to the Wishlist.',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Go to Wishlist',
            cancelButtonText: 'Continue Shopping'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location = 'my-wishlist.php';
            }
        });
    </script>";
}
?>