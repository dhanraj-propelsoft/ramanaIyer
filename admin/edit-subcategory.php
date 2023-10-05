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
		$category = $_POST['category'];
		$subcat = $_POST['subcategory'];
		$id = intval($_GET['id']);
		$sql = mysqli_query($con, "update subcategory set categoryid='$category',subcategory='$subcat',updationDate='$currentTime' where id='$id'");
		$_SESSION['msg'] = "Sub-Category Updated !!";

	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | Edit SubCategory</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='css/opensans.css' rel='stylesheet'>
	</head>

	<body>
		<?php include('include/header.php'); ?>

		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php
					$actmenu = "subcategory";
					include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<h3>Edit SubCategory</h3>
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


									<br />

									<form class="form-horizontal row-fluid" name="Category" method="post">
										<?php
										$id = intval($_GET['id']);
										$query = mysqli_query($con, "select category.id,category.categoryName,subcategory.subcategory from subcategory join category on category.id=subcategory.categoryid where subcategory.id='$id'");
										while ($row = mysqli_fetch_array($query)) {
											?>

											<div class="control-group">
												<label class="control-label" for="basicinput">Category</label>
												<div class="controls">
													<select name="category" class="span8 tip" required>
														<?php $ret = mysqli_query($con, "select * from category");
														while ($result = mysqli_fetch_array($ret)) { ?>
															<option value="<?php echo $result['id']; ?>" <?php if ($row['id'] == $result['id']) { echo "selected"; } ?>>
																<?php echo $result['categoryName']; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>




											<div class="control-group">
												<label class="control-label" for="basicinput">SubCategory Name</label>
												<div class="controls">
													<input type="text" placeholder="Enter category Name" name="subcategory"
														value="<?php echo htmlentities($row['subcategory']); ?>"
														class="span8 tip" required>
												</div>
											</div>


										<?php } ?>

										<div class="control-group">
											<div class="controls">
												<input class="btn" type="button" value="Back"
													onclick="window.location.href = 'subcategory.php'" />
												<button type="submit" name="submit" class="btn">Update</button>
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
		<script src="scripts/datatables/jquery.dataTables.js"></script>
		<script>
			$(document).ready(function () {
				$('.datatable-1').dataTable();
				$('.dataTables_paginate').addClass("btn-group datatable-pagination");
				$('.dataTables_paginate > a').wrapInner('<span />');
				$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
				$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
			});
		</script>
	</body>
<?php } ?>