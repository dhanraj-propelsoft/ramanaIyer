<?php
require_once("includes/config.php");
if (!empty($_POST["email"])) {
	$email = $_POST["email"];

	$result = mysqli_query($con, "SELECT  email FROM  users WHERE  email='$email'");
	$count = mysqli_num_rows($result);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<span style='color:red'> Invalid email format</span>";
		echo "<script>$('#submit').prop('disabled',true);</script>";
	} else {
		if ($count > 0) {
			echo "<span style='color:red'> Email already exists</span>";
			echo "<script>$('#submit').prop('disabled',true);</script>";
		} else {
	
			echo "<span style='color:green'> Email available for Registration</span>";
			echo "<script>$('#submit').prop('disabled',false);</script>";
		}
	}
}
?>