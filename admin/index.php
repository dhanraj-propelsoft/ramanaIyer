<?php
session_start();
error_reporting(0);
unset($_SESSION['alogin']);
unset($_SESSION['aid']);
include("include/config.php");
if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$username' and password='$password'");
	$num = mysqli_fetch_array($ret);
	if ($num > 0) {
		$extra = "todays-orders.php"; //
		$_SESSION['alogin'] = $_POST['username'];
		$_SESSION['aid'] = $num['id'];
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("location:http://$host$uri/$extra");
		exit();
	} else {
		$_SESSION['errmsg'] = "Invalid username or password";
		$extra = "index.php";
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("location:http://$host$uri/$extra");
		exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ramana Iyer | Admin login</title>
	<link type="text/css" href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="assets/css/theme.css" rel="stylesheet">
	<link type="text/css" href="assets/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='assets/css/opensans.css' rel='stylesheet'>
</head>

<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

				<a class="brand" href="index.php">
					<img src="assets/images/ramana-logo.jpg" style="max-height: 50px; width: auto" alt=""> | Admin
				</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">

					<!-- <ul class="nav pull-right">

						<li><a href="http://localhost/shopping/">
						Back to Portal
						
						</a></li>

						

						
					</ul> -->
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->



	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4">
					<form class="form-vertical" method="post">
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
						<span style="color:red;">
							<?php echo htmlentities($_SESSION['errmsg']); ?>
							<?php echo htmlentities($_SESSION['errmsg'] = ""); ?>
						</span>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="text" id="inputEmail" name="username"
										placeholder="Username">
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="password" id="inputPassword" name="password"
										placeholder="Password">
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" class="btn pull-right" name="submit">Login</button>

								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-lg-6">
					<b class="copyright">&copy; 2023 Ramana Iyer </b> All rights reserved.
				</div>
				<div class="col-md-6 col-sm-6 col-lg-6">
					Designed & Powered by <a href="http://www.propelsoft.in" target="_blank"
						style="color: #8000ff; text-decoration: none; font-weight: bold;">Propelsoft</a>.
				</div>

			</div>
		</div>
	</div>
	<script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<!-- <script src="assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script> -->
	<script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>