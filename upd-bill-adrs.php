<?php
session_start();
error_reporting(0);
include('includes/config.php');

$baddress = $_POST['billingaddress'];
$bstate = $_POST['bilingstate'];
$bcity = $_POST['billingcity'];
$bpincode = $_POST['billingpincode'];


if((!empty($baddress)) && (!empty($bstate)) && (!empty($bcity)) && (!empty($bpincode)))
{
    $query = mysqli_query($con, "update users set billingAddress='$baddress',billingState='$bstate',billingCity='$bcity',billingPincode='$bpincode' where id='" . $_SESSION['id'] . "'");
    if ($query) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Billing Address has been updated!',
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