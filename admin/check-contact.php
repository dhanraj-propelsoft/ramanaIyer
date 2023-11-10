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
		$contactno = $_POST['contactno'];

		// mysqli_query($con, "insert into users(contactno) values('$contactno')");

		// $query1 = mysqli_query($con, "select max(id) as pid from users");
		// $result1 = mysqli_fetch_array($query1);
		// $userid = $result1['pid'];

		header("Location: profile-sec.php?mob=$contactno&ut=Offline_User");
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
								<h3>Add Order</h3>
							</div>
							<div class="module-body">
								<form class="form-horizontal row-fluid" name="addOrder" method="post">

									<div class="control-group">
										<label class="control-label" for="basicinput">Mobile Number <span>*</span></label>
										<div class="controls">
											<input type="text" pattern="\d*" placeholder="Enter Mobile Number"
												name="contactno" id="contactno" class="span8 tip" required maxlength="10">
											<button id="addNewBtn" disabled type="submit" name="submit" class="btn btn-ri">Add
												New</button>
										</div>
									</div>

									<div id="userList"></div>
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
		$('#contactno').keydown(function (event) {
			var kc, num, rt = false;
			kc = event.keyCode;
			//console.log(kc);
			if ((kc == 8) || ((kc > 47 && kc < 58) || (kc > 95 && kc < 106))) rt = true;
			return rt;
		})
		$("#contactno").on("input", function () {
			$.ajax({
				type: "POST",
				url: "check-user-mob.php",
				data: 'contactno=' + $(this).val(),
				success: function (data) {
					$("#userList").html(data);
				}
			});
		});
	</script>
<?php } ?>