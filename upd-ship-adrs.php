<?php
session_start();
error_reporting(0);
include('includes/config.php');

$saddress = $_POST['shippingaddress'];
$sstate = $_POST['shippingstate'];
$scity = $_POST['shippingcity'];
$spincode = $_POST['shippingpincode'];



if((!empty($saddress)) && (!empty($sstate)) && (!empty($scity)) && (!empty($spincode)))
{
    $query = mysqli_query($con, "update users set shippingAddress='$saddress',shippingState='$sstate',shippingCity='$scity',shippingPincode='$spincode' where id='" . $_SESSION['id'] . "'");
    if ($query) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Shipping Address has been updated!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            </script>";
    }
} else {
    echo "<div class='alert alert-danger'>
            <strong>Caution!</strong> Please enter Mandatory (*) fields.
        </div>";
}
?>