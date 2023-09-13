<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/header.php');

if (isset($_POST['change'])) {
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$password = md5($_POST['password']);
	$query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' and contactno='$contact'");
	$num = mysqli_fetch_array($query);
	if ($num > 0) {
		$extra = "forgot-password.php";
		mysqli_query($con, "update users set password='$password' WHERE email='$email' and contactno='$contact' ");
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		//header("location:http://$host$uri/$extra");
		$header_loc = "http://$host$uri/$extra";
		echo "<script>location.href='$header_loc';</script>";
		$_SESSION['errmsg'] = "Password Changed Successfully";
		exit();
	} else {
		$extra = "forgot-password.php";
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		//header("location:http://$host$uri/$extra");
		$header_loc = "http://$host$uri/$extra";
		echo "<script>location.href='$header_loc';</script>";
		$_SESSION['errmsg'] = "Invalid email id or Contact no";
		exit();
	}
}
?>
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="home.html">Home</a></li>
					<li class='active'>Forgot Password</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->

	<div class="body-content outer-top-bd">
		<div class="container">
			<div class="sign-in-page inner-bottom-sm">
				<div class="row">
					<!-- Sign-in -->
					<div class="col-md-6 col-sm-6 sign-in">
						<h4 class="">Forgot password</h4>
						<form class="register-form outer-top-xs" name="register" method="post"
							onSubmit="return valid();">
							<span style="color:red;">
								<?php
								echo htmlentities($_SESSION['errmsg']);
								?>
								<?php
								echo htmlentities($_SESSION['errmsg'] = "");
								?>
							</span>
							<div class="form-group">
								<label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
								<input type="email" name="email" class="form-control unicase-form-control text-input"
									id="exampleInputEmail1" required>
							</div>
							<div class="form-group">
								<label class="info-title" for="exampleInputPassword1">Contact no <span>*</span></label>
								<input type="text" name="contact" class="form-control unicase-form-control text-input"
									id="contact" maxlength="10"
									onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
							</div>
							<div class="form-group">
								<label class="info-title" for="password">Password. <span>*</span></label>
								<input type="password" class="form-control unicase-form-control text-input"
									id="password" name="password" required>
							</div>

							<div class="form-group">
								<label class="info-title" for="confirmpassword">Confirm Password. <span>*</span></label>
								<input type="password" class="form-control unicase-form-control text-input"
									id="confirmpassword" name="confirmpassword" required>
							</div>



							<button type="submit" class="btn-upper btn btn-primary checkout-page-button"
								name="change">Change</button>
						</form>
					</div>
					<!-- Sign-in -->


					<!-- create a new account -->
				</div><!-- /.row -->
			</div>
			<?php ?>
		</div>
	</div>
	<?php include('includes/footer.php'); ?>
	<script type="text/javascript">
		function valid() {
			if (document.register.password.value != document.register.confirmpassword.value) {
				Swal.fire({
					title: 'Error!',
					text: 'Password and Confirm Password Field do not match!',
					icon: 'error',
					confirmButtonText: 'OK'
				});
				document.register.confirmpassword.focus();
				return false;
			}
			return true;
		}
	</script>