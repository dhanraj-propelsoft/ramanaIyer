<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$pid = "";
	$mob = "";
	if (isset($_GET['id']))
		$pid = intval($_GET['id']); // product id
	if (isset($_GET['mob']))
		$mob = intval($_GET['mob']); // product id
	$ut = trim($_GET['ut']); // product id
	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$contactno = $_POST['contactno'];
		$shippingaddress = $_POST['shippingaddress'];
		$shippingstate = $_POST['shippingstate'];
		$shippingcity = $_POST['shippingcity'];
		$shippingpincode = $_POST['shippingpincode'];

		if($pid > 0)
			mysqli_query($con, "UPDATE users set name='$name',email='$email',contactno='$contactno',shippingAddress='$shippingaddress',shippingState='$shippingstate',shippingCity='$shippingcity',shippingPincode='$shippingpincode' where id='$pid' ");
		else
		{
			mysqli_query($con, "INSERT INTO users (`name`,`email`,`contactno`,`shippingAddress`,`shippingState`,`shippingCity`,`shippingPincode`) VALUES ('$name','$email','$contactno','$shippingaddress','$shippingstate','$shippingcity','$shippingpincode')");
			
			$query1 = mysqli_query($con, "select max(id) as pid from users");
			$result1 = mysqli_fetch_array($query1);
			$pid = $result1['pid'];
		}
		
		header("Location: insert-order.php?id=$pid");
		exit;
	}


	?>
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
									$name = "";
									$mail = "";
									$adrs = "";
									$pin = "";
									$state = "";
									$city = "";
									if ($row = mysqli_fetch_array($query)) {
										$name = $row['name'];
										$mob = $row['contactno'];
										$mail = $row['email'];
										$adrs = $row['shippingAddress'];
										$pin = $row['shippingPincode'];
										$state = $row['shippingState'];
										$city = $row['shippingCity'];
									}
									?>
									<div class="control-group">
										<label class="control-label" for="basicinput">Customer Name</label>
										<div class="controls">
											<input type="text" name="name" placeholder="Enter Customer Name"
												value="<?php echo htmlentities($name); ?>" class="span8 tip" <?php if ($ut == "Online_User") {
														echo "readonly";
													} ?>>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="basicinput">Mobile Number</label>
										<div class="controls">
											<input type="text" name="contactno" placeholder="Enter Mobile Number"
												value="<?php echo htmlentities($mob); ?>" class="span8 tip"
												readonly required>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="basicinput">Email</label>
										<div class="controls">
											<input type="text" name="email" id="email" placeholder="Enter Email"
												onblur="emailAvailability()"
												value="<?php echo htmlentities($mail); ?>" class="span8 tip" <?php if ($ut == "Online_User") {
														echo "readonly";
													} ?> required>
											<span id="user-availability-status1" style="font-size:12px;"></span>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="basicinput">Address</label>
										<div class="controls">
											<input type="text" name="shippingaddress" placeholder="Enter Shipping Address"
												value="<?php echo htmlentities($adrs); ?>"
												class="span8 tip" required>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="basicinput">Pincode</label>
										<div class="controls">
											<input type="text" pattern="\d*" maxlength="6" name="shippingpincode"
												placeholder="Enter Shipping Pincode"
												onkeypress="return event.charCode >= 48 && event.charCode <= 57"
												value="<?php echo htmlentities($pin); ?>"
												onblur="pull_st_dt(this)" class="span8 tip" required>
											<div id="adrs-ack" style="color: red;"></div>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="basicinput">State</label>
										<div class="controls">
											<input type="text" name="shippingstate" placeholder="Enter Shipping State"
												value="<?php echo htmlentities($state); ?>" class="span8 tip"
												required>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="basicinput">City</label>
										<div class="controls">
											<input type="text" name="shippingcity" placeholder="Enter Shipping City"
												value="<?php echo htmlentities($city); ?>" class="span8 tip"
												required>
										</div>
									</div>
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
	<script>

		function emailAvailability() {
			// $('#loaderIcon').css('visibility', 'visible');
			// $("#loaderIcon").show();
			let host = location.host;
			let url = "http://" + host + "/phpProjects/ramanaIyer/check_availability.php";
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
		

		function pull_st_dt(ele) {
			$.getJSON("https://api.postalpincode.in/pincode/" + $(ele).val(), function (data) {
				if (data[0].PostOffice && data[0].PostOffice.length) {
					for (var i = 0; i < data[0].PostOffice.length; i++) {
						$(ele).parent().parent().next().find("input").val(data[0].PostOffice[i].State);
						$(ele).parent().parent().next().next().find("input").val(data[0].PostOffice[i].District);
						return;
					}
				}
				else {
					$(ele).next().html("<div class='alert alert-danger'><strong>Attention!</strong> Enter Valid Pincode</div>");
					$(ele).next().fadeTo(5000, 500).slideUp(500, function(){
						$(ele).next().slideUp(500);
					});
				}
			})

		}
	</script>
<?php } ?>