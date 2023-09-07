<?php 
if(!empty($_POST["session_id"]))
	$session_id= $_POST["session_id"];
if(!empty($_POST["product_id"]))
    $product_id= $_POST["product_id"];

include('includes/config.php');
mysqli_query($con, "insert into wishlist(userId,productId) values('" . $session_id . "','$product_id')");

?>