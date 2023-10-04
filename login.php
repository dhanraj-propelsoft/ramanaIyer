<?php
session_start();
error_reporting(0);
include('includes/config.php');

include('includes/header.php');
// Code user Registration
if (isset($_POST['submit'])) {
	$name = $_POST['fullname'];
	$email = $_POST['emailid'];
	$contactno = $_POST['contactno'];
	$password = md5($_POST['password']);
	$query = mysqli_query($con, "insert into users(name,email,contactno,password) values('$name','$email','$contactno','$password')");
	if ($query) {
		echo "<script>
		Swal.fire({
			title: 'Success!',
			text: 'You are successfully register!',
			icon: 'success',
			confirmButtonText: 'OK'
		});
		</script>";
	} else {
		echo "<script>
		Swal.fire({
			title: 'Error!',
			text: 'Not registered. Something went worng!',
			icon: 'error',
			confirmButtonText: 'OK'
		});
		</script>";
	}
}
// Code for Customer login
if (isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' and password='$password'");
	$num = mysqli_fetch_array($query);
	if ($num > 0) {
		$extra = "index.php";
		$_SESSION['login'] = $_POST['email'];
		$_SESSION['id'] = $num['id'];
		$_SESSION['username'] = $num['name'];

		//if(empty($_SESSION['cart']))
		{
			$sql_p = "SELECT * FROM cart WHERE userId={$_SESSION['id']}";
			$query_p = mysqli_query($con, $sql_p);
			if (mysqli_num_rows($query_p) != 0) {
				while ($row_p = mysqli_fetch_array($query_p)) {
					//print_r($row_p);exit();
					$_SESSION['cart'][$row_p['pId']] = array("quantity" => $row_p['pQty'], "price" => $row_p['pPrice']);
				}
			}
		}
		$uip = $_SERVER['REMOTE_ADDR'];
		$status = 1;
		$log = mysqli_query($con, "insert into userlog(userEmail,userip,status) values('" . $_SESSION['login'] . "','$uip','$status')");
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		//header("location:http://$host$uri/$extra");
		$header_loc = "http://$host$uri/$extra";
		echo "<script>location.href='$header_loc';</script>";
		exit();
		// echo "<script>
		// 	Swal.fire({
		// 		title: 'Logged In!',
		// 		text: 'You are successfully register',
		// 		icon: 'success',
		// 		showCancelButton: true,
		// 		confirmButtonText: 'Go to Home'
		// 	}).then((result) => {
		// 		if (result.isConfirmed) {
		// 			window.location.href = 'index.php';
		// 		}
		// 	});
		// </script>";
	} else {
		$extra = "login.php";
		$email = $_POST['email'];
		$uip = $_SERVER['REMOTE_ADDR'];
		$status = 0;
		$log = mysqli_query($con, "insert into userlog(userEmail,userip,status) values('$email','$uip','$status')");
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		//header("location:http://$host$uri/$extra");
		$header_loc = "http://$host$uri/$extra";
		echo "<script>location.href='$header_loc';</script>";
		$_SESSION['errmsg'] = "Invalid email id or Password";
		exit();
	}
}
?>
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="home.html">Home</a></li>
					<li class='active'>Authentication</li>
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
						<h4 class="">sign in</h4>
						<p class="">Hello, Welcome to your account.</p>
						<form class="register-form outer-top-xs" method="post">
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
									id="exampleInputEmail1">
							</div>
							<div class="form-group">
								<label class="info-title" for="exampleInputPassword1">Password <span>*</span></label>
								<input type="password" name="password"
									class="form-control unicase-form-control text-input" id="exampleInputPassword1">
							</div>
							<div class="radio outer-xs">
								<a href="forgot-password.php" class="forgot-password pull-right">Forgot your
									Password?</a>
							</div>
							<button type="submit" class="btn-upper btn btn-primary checkout-page-button"
								name="login">Login</button>
						</form>
					</div>
					<!-- Sign-in -->

					<!-- create a new account -->
					<div class="col-md-6 col-sm-6 create-new-account">
						<h4 class="checkout-subtitle">create a new account</h4>
						<p class="text title-tag-line">Create your own Shopping account.</p>
						<form class="register-form outer-top-xs" role="form" method="post" name="register"
							onSubmit="return valid();">
							<div class="form-group">
								<label class="info-title" for="fullname">Full Name <span>*</span></label>
								<input type="text" class="form-control unicase-form-control text-input" id="fullname"
									name="fullname" required="required">
							</div>


							<div class="form-group">
								<label class="info-title" for="exampleInputEmail2">Email Address <span>*</span></label>
								<input type="email" class="form-control unicase-form-control text-input" id="email"
									onBlur="emailAvailability()" name="emailid" required>
								<span id="user-availability-status1" style="font-size:12px;"></span>
							</div>

							<div class="form-group">
								<label class="info-title" for="contactno">Contact No. <span>*</span></label>
								<input type="text" class="form-control unicase-form-control text-input" id="contactno"
									onkeypress="return event.charCode >= 48 && event.charCode <= 57"
									onblur="contactAvailability()" name="contactno" maxlength="10" required>
								<span id="user-availability-status2" style="font-size:12px;"></span>
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


							<button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button"
								id="submit">Sign Up</button>
						</form>
						<span class="checkout-subtitle outer-top-xs">Sign Up Today And You'll Be Able To : </span>
						<div class="checkbox">
							<label class="checkbox">
								Speed your way through the checkout.
							</label>
							<label class="checkbox">
								Track your orders easily.
							</label>
							<label class="checkbox">
								Keep a record of all your purchases.
							</label>
						</div>
					</div>
					<!-- create a new account -->
				</div><!-- /.row -->
			</div>

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
		
		function emailAvailability() {
			// $('#loaderIcon').css('visibility', 'visible');
			// $("#loaderIcon").show();
			jQuery.ajax({
				url: "check_availability.php",
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
		function contactAvailability() {
			// $('#loaderIcon').css('visibility', 'visible');
			// $("#loaderIcon").show();
			jQuery.ajax({
				url: "check_mob_no.php",
				data: 'contactno=' + $("#contactno").val(),
				type: "POST",
				success: function (data) {
					$("#user-availability-status2").html(data);
					// $('#loaderIcon').css('visibility', 'hidden');
					// $("#loaderIcon").hide();
				},
				error: function () { }
			});
		}
	</script>