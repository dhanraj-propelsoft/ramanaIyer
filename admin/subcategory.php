<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_POST['submit'])) {
		$msg = "";
		$errmsg = "";
		$delmsg = "";
		$category = $_POST['category'];
		$subcat = $_POST['subcategory'];
		$result = mysqli_query($con, "SELECT id from subcategory where subcategory = '" . $subcat . "'");
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt > 0) {
			$errmsg = "<strong>Sorry!</strong> SubCategory has been already in the list !!";
		} else {
			mysqli_query($con, "insert into subcategory(categoryid,subcategory) values('$category','$subcat')");
			$msg = "<strong>Well done!</strong> SubCategory has been Created !!";
		}

	} else if (isset($_GET['del'])) {
		$msg = "";
		$errmsg = "";
		$delmsg = "";
		$result1 = mysqli_query($con, "SELECT id from products where subCategory = '" . $_GET['id'] . "'");
		$row_cnt1 = mysqli_num_rows($result1);
		if ($row_cnt1 > 0) {
			$delmsg = "Could not delete since reference data exist !!";
		} else {
			mysqli_query($con, "delete from subcategory where id = '" . $_GET['id'] . "'");
			$delmsg = "SubCategory deleted !!";
		}
	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | SubCategory</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='css/opensans.css' rel='stylesheet'>
		<link rel="stylesheet" href="css/sweetalert2.min.css">
		<script src="assets/js/sweetalert.js"></script>
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
									<h3>Sub Category</h3>
								</div>
								<div class="module-body">

									<?php if (isset($_POST['submit'])) {
										if ($msg != "") { ?>
											<div class="alert alert-success">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<?php echo $msg; ?>
											</div>
										<?php } else if ($errmsg != "") { ?>
												<div class="alert alert-error">
													<button type="button" class="close" data-dismiss="alert">×</button>
												<?php echo $errmsg; ?>
												</div>
										<?php }
									} else if (isset($_GET['del'])) { 
										if ($delmsg != "") { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo $delmsg; ?>
										</div>
										<?php }
									} ?>

									<br />

									<form class="form-horizontal row-fluid" name="subcategory" method="post">

										<div class="control-group">
											<label class="control-label" for="basicinput">Category <span>*</span></label>
											<div class="controls">
												<select name="category" class="span8 tip" required>
													<option value="">Select Category</option>
													<?php $query = mysqli_query($con, "select * from category");
													while ($row = mysqli_fetch_array($query)) { ?>

														<option value="<?php echo $row['id']; ?>">
															<?php echo $row['categoryName']; ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">SubCategory Name <span>*</span></label>
											<div class="controls">
												<input type="text" placeholder="Enter SubCategory Name" name="subcategory"
													class="span8 tip" required>
											</div>
										</div>



										<div class="control-group">
											<div class="controls">
												<button type="submit" name="submit" class="btn">Create</button>
											</div>
										</div>
									</form>
								</div>
							</div>


							<div class="module">
								<div class="module-head">
									<h3>Sub Category</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display"
										style="width:100%;padding:5px;">
										<thead>
											<tr>
												<th>#</th>
												<th>Category</th>
												<th>Sub-Category</th>
												<th>Creation date</th>
												<th>Last Updated</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

											<?php $query = mysqli_query($con, "select subcategory.id,category.categoryName,subcategory.subcategory,subcategory.creationDate,subcategory.updationDate from subcategory join category on category.id=subcategory.categoryid");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td class="wrap_td_100">
														<?php echo htmlentities($row['categoryName']); ?>
													</td>
													<td class="wrap_td_100">
														<?php echo htmlentities($row['subcategory']); ?>
													</td>
													<td class="wrap_td_100">
														<?php echo htmlentities($row['creationDate']); ?>
													</td>
													<td class="wrap_td_100">
														<?php echo htmlentities($row['updationDate']); ?>
													</td>
													<td>
														<a href="edit-subcategory.php?id=<?php echo $row['id'] ?>"><i
																class="icon-edit"></i></a>
														<a onClick="delPopup('<?php echo $row['id'] ?>')"><i
																class="icon-remove-sign"></i></a>
													</td>
												</tr>
												<?php $cnt = $cnt + 1;
											} ?>

									</table>
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

			function delPopup(ele) {
				Swal.fire({
					title: 'Warning!',
					text: 'Are you sure you want to delete?',
					icon: 'info',
					showCancelButton: true,
					confirmButtonText: 'Yes',
					cancelButtonText: 'No'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = 'subcategory.php?id=' + ele + '&del=delete';
					}
				});
			}
		</script>
	</body>
<?php } ?>