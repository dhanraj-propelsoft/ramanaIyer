<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());

	if (isset($_GET['del'])) {
		mysqli_query($con, "delete from products where id = '" . $_GET['id'] . "'");
		$_SESSION['delmsg'] = "Product deleted !!";
	}

	?>
	<?php include('include/header.php'); ?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<?php
				$actmenu = "allusers";
				include('include/sidebar.php'); ?>
				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>All Users</h3>
							</div>
							<div class="module-body table">
								<?php if (isset($_GET['del'])) { ?>
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Oh snap!</strong>
										<?php echo htmlentities($_SESSION['delmsg']); ?>
										<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
									</div>
								<?php } ?>

								<br />


								<table cellpadding="0" cellspacing="0" border="0"
									class="datatable-1 table table-bordered table-striped	 display"
									style="width:100%;padding:5px;">
									<thead>
										<tr>
											<th>#</th>
											<th>Customer Name</th>
											<th>Email </th>
											<th>Contact no</th>
											<th>Shippping Address / City / State / Pincode </th>
											<th>Billing Address / City / State / Pincode </th>
											<th>Reg. Date </th>

										</tr>
									</thead>
									<tbody>

										<?php $query = mysqli_query($con, "select * from users");
										$cnt = 1;
										while ($row = mysqli_fetch_array($query)) {
											?>
											<tr>
												<td>
													<?php echo htmlentities($cnt); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row['name']); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row['email']); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row['contactno']); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row['shippingAddress'] . "," . $row['shippingCity'] . "," . $row['shippingState'] . "-" . $row['shippingPincode']); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row['billingAddress'] . "," . $row['billingCity'] . "," . $row['billingState'] . "-" . $row['billingPincode']); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo date("d-m-Y h:i:s A", strtotime($row['regDate'])); ?>
												</td>

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
	<script>
		$(document).ready(function () {
			$('.datatable-1').DataTable();
			// $('.dataTables_paginate').addClass("btn-group datatable-pagination");
			// $('.dataTables_paginate > a').wrapInner('<span />');
			// $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			// $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		});
	</script>
<?php } ?>