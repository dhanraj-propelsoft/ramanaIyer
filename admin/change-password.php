<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());


	if (isset($_POST['submit'])) {
		$sql = mysqli_query($con, "SELECT password FROM  admin where password='" . md5($_POST['password']) . "' && username='" . $_SESSION['alogin'] . "'");
		$num = mysqli_fetch_array($sql);
		if ($num > 0) {
			mysqli_query($con, "update admin set password='" . md5($_POST['newpassword']) . "', updationDate='$currentTime' where username='" . $_SESSION['alogin'] . "'");
			$_SESSION['msg'] = "Password Changed Successfully !!";
		} else {
			$_SESSION['msg'] = "Old Password not match !!";
		}
	}
	?>
	<?php include('include/header.php'); ?>
	<script type="text/javascript">
		function valid() {
			if (document.chngpwd.password.value == "") {
				Swal.fire({
					title: 'Error!',
					text: 'Current Password Field is Empty!',
					icon: 'error',
					confirmButtonText: 'OK'
				});
				document.chngpwd.password.focus();
				return false;
			}
			else if (document.chngpwd.newpassword.value == "") {
				Swal.fire({
					title: 'Error!',
					text: 'New Password Field is Empty!',
					icon: 'error',
					confirmButtonText: 'OK'
				});
				document.chngpwd.newpassword.focus();
				return false;
			}
			else if (document.chngpwd.confirmpassword.value == "") {
				Swal.fire({
					title: 'Error!',
					text: 'Confirm Password Field is Empty!',
					icon: 'error',
					confirmButtonText: 'OK'
				});
				document.chngpwd.confirmpassword.focus();
				return false;
			}
			else if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
				Swal.fire({
					title: 'Error!',
					text: 'Password and Confirm Password Field do not match!',
					icon: 'error',
					confirmButtonText: 'OK'
				});
				document.chngpwd.confirmpassword.focus();
				return false;
			}
			return true;
		}
	</script>

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<?php include('include/sidebar.php'); ?>
				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Change Admin Password</h3>
							</div>
							<div class="module-body">

								<?php if (isset($_POST['submit'])) { ?>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<?php echo htmlentities($_SESSION['msg']); ?>
										<?php echo htmlentities($_SESSION['msg'] = ""); ?>
									</div>
								<?php } ?>
								<br />

								<form class="form-horizontal row-fluid" name="chngpwd" method="post"
									onSubmit="return valid();">

									<div class="control-group">
										<label class="control-label" for="basicinput">Current Password</label>
										<div class="controls">
											<input type="password" placeholder="Enter Your Current Password" name="password"
												class="span8 tip" required>
										</div>
									</div>


									<div class="control-group">
										<label class="control-label" for="basicinput">New Password</label>
										<div class="controls">
											<input type="password" placeholder="Enter Your New Password" name="newpassword"
												class="span8 tip" required>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="basicinput">Re-enter New Password</label>
										<div class="controls">
											<input type="password" placeholder="Re-enter Your New Password Again"
												name="confirmpassword" class="span8 tip" required>
										</div>
									</div>






									<div class="control-group">
										<div class="controls">
											<button type="submit" name="submit" class="btn btn-ri">Submit</button>
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
<?php } ?>