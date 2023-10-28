<?php
session_start();
error_reporting(0);
include('includes/config.php');
$id = intval($_POST['combo_id']);

$page = "";
if (isset($_POST['page']))
    $page = trim($_POST['page']);

if ($page == 'wishlist')
    mysqli_query($con, "delete from wishlist where comboId='$id'");

if (isset($_SESSION['combo'][$id])) {
    //$_SESSION['combo'][$id]['quantity']++;
    echo "<script>
        Swal.fire({
            title: 'Combo Already in Cart!',
            text: 'Do you want to proceed?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                const expires = new Date(Date.now() + 1000).toUTCString();
                document.cookie = `cqi_id=$id; expires=expires`;
                window.location.href = 'my-cart.php';
            }
        });
    </script>";
} else {
    $sql_p = "SELECT * FROM combo WHERE id={$id}";
    $query_p = mysqli_query($con, $sql_p);
    if (mysqli_num_rows($query_p) != 0) {
        $row_p = mysqli_fetch_array($query_p);
        $_SESSION['combo'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['comboPrice']);
        echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Combo has been added to the cart.',
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
        $message = "Combo ID is invalid";
    }
}
?>