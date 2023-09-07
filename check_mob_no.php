<?php 
require_once("includes/config.php");
if(!empty($_POST["contactno"])) {
	$contactno= $_POST["contactno"];
	
		$result =mysqli_query($con,"SELECT  contactno FROM  users WHERE  contactno='$contactno'");
		$count=mysqli_num_rows($result);
if($count>0)
{
echo "<span style='color:red'>Contact No already exists .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'>Contact No available for Registration .</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}


?>
