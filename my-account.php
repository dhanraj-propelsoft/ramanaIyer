<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if (strlen($_SESSION['login']) == 0) {
		header('location:login.php');
	} else {
		include('includes/header.php');
		if (isset($_POST['update'])) {
			$name = $_POST['name'];
			$_SESSION['username'] = $name;
			$contactno = $_POST['contactno'];
			$query = mysqli_query($con, "update users set name='$name',contactno='$contactno' where id='" . $_SESSION['id'] . "'");
			if ($query) {
				echo "<script>
				Swal.fire({
					title: 'Success!',
					text: 'Your info has been updated!',
					icon: 'success',
					confirmButtonText: 'OK'
				});
				</script>";
			}
		}


		date_default_timezone_set('Asia/Kolkata'); // change according timezone
		$currentTime = date('d-m-Y h:i:s A', time());


		if (isset($_POST['submit'])) {
			$sql = mysqli_query($con, "SELECT password FROM  users where password='" . md5($_POST['cpass']) . "' && id='" . $_SESSION['id'] . "'");
			$num = mysqli_fetch_array($sql);
			if ($num > 0) {
				mysqli_query($con, "update users set password='" . md5($_POST['newpass']) . "', updationDate='$currentTime' where id='" . $_SESSION['id'] . "'");
				echo "<script>
				Swal.fire({
					title: 'Success!',
					text: 'Password Changed Successfully!',
					icon: 'success',
					confirmButtonText: 'OK'
				});
				</script>";
			} else {
				echo "<script>
				Swal.fire({
					title: 'Error!',
					text: 'Current Password not match!',
					icon: 'error',
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
												<span>1</span>My Profile
											</a>
										</h4>
									</div>
									<!-- panel-heading -->

									<div id="collapseOne" class="panel-collapse collapse in">

										<!-- panel-body  -->
										<div class="panel-body">
											<div class="row">
												<h4>Personal info</h4>
												<div class="col-md-12 col-sm-12 already-registered-login">

													<?php
													$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
													if ($row = mysqli_fetch_array($query)) {
														?>

														<form class="register-form" role="form" method="post">
															<div class="form-group">
																<label class="info-title" for="name">Name<span>*</span></label>
																<input type="text"
																	class="form-control unicase-form-control text-input"
																	value="<?php echo $row['name']; ?>" id="name" name="name"
																	required="required">
															</div>



															<div class="form-group">
																<label class="info-title" for="exampleInputEmail1">Email Address
																	<span>*</span></label>
																<input type="email"
																	class="form-control unicase-form-control text-input"
																	id="exampleInputEmail1" value="<?php echo $row['email']; ?>"
																	readonly>
															</div>
															<div class="form-group">
																<label class="info-title" for="contactno">Contact No. <span>*</span></label>
																<input type="text" class="form-control unicase-form-control text-input" id="contactno"
																	onkeypress="return event.charCode >= 48 && event.charCode <= 57"
																	onblur="contactAvailability()" name="contactno" value="<?php echo $row['contactno']; ?>" maxlength="10" required>
																<span id="user-availability-status2" style="font-size:12px;"></span>
															</div>
															<input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['id']; ?>">
															<button type="submit" id="submit" name="update"
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
												<span>2</span>Change Password
											</a>
										</h4>
									</div>
									<div id="collapseTwo" class="panel-collapse collapse">
										<div class="panel-body">

											<form class="register-form" role="form" method="post" name="chngpwd"
												onSubmit="return valid();">
												<div class="form-group">
													<label class="info-title" for="Current Password">Current
														Password<span>*</span></label>
													<input type="password"
														class="form-control unicase-form-control text-input" id="cpass"
														name="cpass" required="required">
												</div>



												<div class="form-group">
													<label class="info-title" for="New Password">New Password
														<span>*</span></label>
													<input type="password"
														class="form-control unicase-form-control text-input" id="newpass"
														name="newpass">
												</div>
												<div class="form-group">
													<label class="info-title" for="Confirm Password">Confirm Password
														<span>*</span></label>
													<input type="password"
														class="form-control unicase-form-control text-input" id="cnfpass"
														name="cnfpass" required="required">
												</div>
												<button type="submit" name="submit"
													class="btn-upper btn btn-primary checkout-page-button">Change </button>
											</form>




										</div>
									</div>
								</div>
								<!-- checkout-step-02  -->

							</div><!-- /.checkout-steps -->
						</div>
						<?php include('includes/myaccount-sidebar.php'); ?>
					</div><!-- /.row -->
				</div><!-- /.checkout-box -->


			</div>
		</div>
		<?php include('includes/footer.php'); ?>

		<script type="text/javascript">
			function valid() {
				if (document.chngpwd.cpass.value == "") {
					Swal.fire({
						title: 'Error!',
						text: 'Current Password Field is Empty!',
						icon: 'error',
						confirmButtonText: 'OK'
					});
					document.chngpwd.cpass.focus();
					return false;
				}
				else if (document.chngpwd.newpass.value == "") {
					Swal.fire({
						title: 'Error!',
						text: 'New Password Field is Empty!',
						icon: 'error',
						confirmButtonText: 'OK'
					});
					document.chngpwd.newpass.focus();
					return false;
				}
				else if (document.chngpwd.cnfpass.value == "") {
					Swal.fire({
						title: 'Error!',
						text: 'Confirm Password Field is Empty!',
						icon: 'error',
						confirmButtonText: 'OK'
					});
					document.chngpwd.cnfpass.focus();
					return false;
				}
				else if (document.chngpwd.newpass.value != document.chngpwd.cnfpass.value) {
					Swal.fire({
						title: 'Error!',
						text: 'Password and Confirm Password Field do not match!',
						icon: 'error',
						confirmButtonText: 'OK'
					});
					document.chngpwd.cnfpass.focus();
					return false;
				}
				return true;
			}
			function contactAvailability() {
				// $('#loaderIcon').css('visibility', 'visible');
				// $("#loaderIcon").show();
				var data = new FormData();	
				data.append('contactno', $("#contactno").val());
				data.append('user_id', $("#user_id").val());
				
				jQuery.ajax({
					url: "check_mob_no.php",
					data: data,
					processData: false,
					type: 'POST',
					contentType: false,
					success: function (data) {
						$("#user-availability-status2").html(data);
						// $('#loaderIcon').css('visibility', 'hidden');
						// $("#loaderIcon").hide();
					},
					error: function () { }
				});
			}
		</script>
<?php } ?>