<?php
session_start();
error_reporting();
include("includes/config.php");
date_default_timezone_set('Asia/Kolkata');
$ldate = date('d-m-Y h:i:s A', time());
mysqli_query($con, "UPDATE userlog  SET logout = '$ldate' WHERE userEmail = '" . $_SESSION['login'] . "' ORDER BY id DESC LIMIT 1");
mysqli_query($con, "DELETE FROM cart WHERE userId='" . $_SESSION['id'] . "'");
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $ins_query = "INSERT INTO cart(userId,pId,pQty,pPrice) VALUES ('" . $_SESSION['id'] . "',$key";
        foreach ($value as $key1 => $value1) {
            $ins_query .= "," . $value1;
        }
        $ins_query .= ")";
        mysqli_query($con, $ins_query);
    }
    unset($_SESSION['cart']);
}

//session_unset();
//session_destroy();
$_SESSION['errmsg'] = "You have successfully logout";
$_SESSION['login'] = "";
$_SESSION['id'] = "";
?>
<script language="javascript">
    document.location = "index.php";
</script>