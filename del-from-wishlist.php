<?php
session_start();
error_reporting(0);
if (!empty($_POST["wishlist_id"]))
    $wishlist_id = $_POST["wishlist_id"];

include('includes/config.php');

if (isset($_POST["wishlist_id"])) {
    mysqli_query($con, "delete from wishlist where id='$wishlist_id'");

    echo "<script>
        Swal.fire({
            title: 'Success',
            text: 'Wishlist product has been deleted!',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>";
}
?>