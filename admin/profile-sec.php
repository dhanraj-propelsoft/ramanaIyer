<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$pid = intval($_GET['id']); // product id
	$ut = trim($_GET['ut']); // product id
	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$contactno = $_POST['contactno'];
		$shippingaddress = $_POST['shippingaddress'];
		$shippingstate = $_POST['shippingstate'];
		$shippingcity = $_POST['shippingcity'];
		$shippingpincode = $_POST['shippingpincode'];
		
		mysqli_query($con, "update users set name='$name',email='$email',contactno='$contactno',shippingAddress='$shippingaddress',shippingState='$shippingstate',shippingCity='$shippingcity',shippingPincode='$shippingpincode' where id='$pid' ");
        header("Location: insert-order.php?id=$pid");
        exit;
	}


	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | Profile</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='css/opensans.css' rel='stylesheet'>
		<script src="assets/js/nicEdit-latest.js" type="text/javascript"></script>
		<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

	</head>

	<body>
		<?php include('include/header.php'); ?>

		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php
					$actmenu = "pending";
					include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<h3>Profile</h3>
								</div>
								<div class="module-body">

									<?php if (isset($_POST['submit'])) { ?>
										<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Well done!</strong>
											<?php echo htmlentities($_SESSION['msg']); ?>
											<?php echo htmlentities($_SESSION['msg'] = ""); ?>
										</div>
									<?php } ?>


									<?php if (isset($_GET['del'])) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo htmlentities($_SESSION['delmsg']); ?>
											<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>

									<br />

									<form class="form-horizontal row-fluid" name="insertproduct" method="post"
										enctype="multipart/form-data">

										<?php

										$query = mysqli_query($con, "select * from users where id='$pid'");
                                        $adrs = "";
										while ($row = mysqli_fetch_array($query)) {
                                            ?>

											<div class="control-group">
												<label class="control-label" for="basicinput">Customer Name</label>
												<div class="controls">
													<input type="text" name="name" placeholder="Enter Customer Name"
														value="<?php echo htmlentities($row['name']); ?>"
														class="span8 tip" <?php if($ut=="Online_User") { echo "readonly"; }?>>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Mobile Number</label>
												<div class="controls">
													<input type="text" name="contactno"
														placeholder="Enter Mobile Number"
														value="<?php echo htmlentities($row['contactno']); ?>"
														class="span8 tip" readonly required>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="basicinput">Email</label>
												<div class="controls">
													<input type="text" name="email" id="email" placeholder="Enter Email"
													onblur="emailAvailability()" value="<?php echo htmlentities($row['email']); ?>"
														class="span8 tip" <?php if($ut=="Online_User") { echo "readonly"; }?> required>
													<span id="user-availability-status1" style="font-size:12px;"></span>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Address</label>
												<div class="controls">
													<input type="text" name="shippingaddress" placeholder="Enter Shipping Address"
														value="<?php echo htmlentities($row['shippingAddress']); ?>"
														class="span8 tip" required>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Pincode</label>
												<div class="controls">
													<input type="text" pattern="\d*" maxlength="6" name="shippingpincode"
														placeholder="Enter Shipping Pincode" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
														value="<?php echo htmlentities($row['shippingPincode']); ?>"
														class="span8 tip" required>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">State</label>
												<div class="controls">
													<input type="text" name="shippingstate"
														placeholder="Enter Shipping State"
														value="<?php echo htmlentities($row['shippingState']); ?>"
														class="span8 tip" required>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">City</label>
												<div class="controls">
													<input type="text" name="shippingcity" placeholder="Enter Shipping City"
														value="<?php echo htmlentities($row['shippingCity']); ?>"
														class="span8 tip" required>
												</div>
											</div>
										<?php } ?>
										<div class="control-group">
											<div class="controls">
												<input class="btn btn-primary" type="button" value="Back"
													onclick="window.location.href = 'check-contact.php'" />
												<button type="submit" name="submit" class="btn btn-ri">Next</button>
											</div>
										</div>
									</form>
								</div>
							</div>





						</div><!--/.content-->
					</div><!--/.span9-->
				</div>
			</div><!--/.container-->
		</div><!--/.wrapper-->

		<?php include('include/footer.php'); ?>

		<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
		<script>
		
		function emailAvailability() {
			// $('#loaderIcon').css('visibility', 'visible');
			// $("#loaderIcon").show();
			let host = location.host;
			let url = "http://"+ host +"/phpProjects/ramanaIyer/check_availability.php";
			jQuery.ajax({
				url: url,
				data: 'email=' + $("#email").val(),
				type: "POST",
				success: function (data) {
					$("#user-availability-status1").html(data);
					// $('#loaderIcon').css('visibility', 'hidden');
					// $("#loaderIcon").hide();
				},
				error: function () { }
			});
		}

		</script>
	</body>
<?php } ?>