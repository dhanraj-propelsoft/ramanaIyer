<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	header('location:login.php');
} else {
	include('includes/header.php'); 
	// code for billing address updation
	if (isset($_POST['update'])) {
		$baddress = $_POST['billingaddress'];
		$bstate = $_POST['bilingstate'];
		$bcity = $_POST['billingcity'];
		$bpincode = $_POST['billingpincode'];
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
	}


	// code for Shipping address updation
	if (isset($_POST['shipupdate'])) {
		$saddress = $_POST['shippingaddress'];
		$sstate = $_POST['shippingstate'];
		$scity = $_POST['shippingcity'];
		$spincode = $_POST['shippingpincode'];
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
	}
	?>
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="index.php">Home</a></li>
					<li class='active'>Checkout</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->

	<div class="body-content outer-top-bd">
		<div class="container">
			<div class="checkout-box inner-bottom-sm">
				<div class="row">
					<div class="col-md-8">
						<div class="panel-group checkout-steps" id="accordion">
							<!-- checkout-step-01  -->
							<div class="panel panel-default checkout-step-01">

								<!-- panel-heading -->
								<div class="panel-heading">
									<h4 class="unicase-checkout-title">
										<a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
											<span>1</span>Billing Address
										</a>
									</h4>
								</div>
								<!-- panel-heading -->

								<div id="collapseOne" class="panel-collapse collapse in">

									<!-- panel-body  -->
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12 col-sm-12 already-registered-login">

												<?php
												$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
												while ($row = mysqli_fetch_array($query)) {
													?>

													<form class="register-form" role="form" method="post">
														<div class="form-group">
															<label class="info-title" for="Billing Address">Billing
																Address<span>*</span></label>
															<textarea class="form-control unicase-form-control text-input"
																name="billingaddress"
																required="required"><?php echo $row['billingAddress']; ?></textarea>
														</div>



														<div class="form-group">
															<label class="info-title" for="Billing State ">Billing State
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input"
																id="bilingstate" name="bilingstate"
																value="<?php echo $row['billingState']; ?>" required>
														</div>
														<div class="form-group">
															<label class="info-title" for="Billing City">Billing City
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input"
																id="billingcity" name="billingcity" required="required"
																value="<?php echo $row['billingCity']; ?>">
														</div>
														<div class="form-group">
															<label class="info-title" for="Billing Pincode">Billing Pincode
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input"
																id="billingpincode" name="billingpincode" required="required"
																value="<?php echo $row['billingPincode']; ?>">
														</div>


														<button type="submit" name="update"
															class="btn-upper btn btn-primary checkout-page-button">Update</button>
													</form>
												<?php } ?>
											</div>
											<!-- already-registered-login -->

										</div>
									</div>
									<!-- panel-body  -->

								</div><!-- row -->
							</div>
							<!-- checkout-step-01  -->
							<!-- checkout-step-02  -->
							<div class="panel panel-default checkout-step-02">
								<div class="panel-heading">
									<h4 class="unicase-checkout-title">
										<a data-toggle="collapse" class="collapsed" data-parent="#accordion"
											href="#collapseTwo">
											<span>2</span>Shipping Address
										</a>
									</h4>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse">
									<div class="panel-body">

										<?php
										$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
										while ($row = mysqli_fetch_array($query)) {
											?>

											<form class="register-form" role="form" method="post">
												<div class="form-group">
													<label class="info-title" for="Shipping Address">Shipping
														Address<span>*</span></label>
													<textarea class="form-control unicase-form-control text-input" name="shippingaddress" required="required"><?php echo $row['shippingAddress']; ?></textarea>
												</div>



												<div class="form-group">
													<label class="info-title" for="Billing State ">Shipping State
														<span>*</span></label>
													<input type="text" class="form-control unicase-form-control text-input"
														id="shippingstate" name="shippingstate"
														value="<?php echo $row['shippingState']; ?>" required>
												</div>
												<div class="form-group">
													<label class="info-title" for="Billing City">Shipping City
														<span>*</span></label>
													<input type="text" class="form-control unicase-form-control text-input"
														id="shippingcity" name="shippingcity" required="required"
														value="<?php echo $row['shippingCity']; ?>">
												</div>
												<div class="form-group">
													<label class="info-title" for="Billing Pincode">Shipping Pincode
														<span>*</span></label>
													<input type="text" class="form-control unicase-form-control text-input"
														id="shippingpincode" name="shippingpincode" required="required"
														value="<?php echo $row['shippingPincode']; ?>">
												</div>


												<button type="submit" name="shipupdate"
													class="btn-upper btn btn-primary checkout-page-button">Update</button>
											</form>
										<?php } ?>




									</div>
								</div>
							</div>
							<!-- checkout-step-02  -->

						</div><!-- /.checkout-steps -->
					</div>
					<?php include('includes/myaccount-sidebar.php'); ?>
				</div><!-- /.row -->
			</div><!-- /.checkout-box -->
			<?php ?>

		</div>
	</div>
	<?php include('includes/footer.php'); ?>
<?php } ?>