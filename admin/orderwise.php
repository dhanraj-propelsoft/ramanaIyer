<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());


	?>
	<?php include('include/header.php'); ?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<?php
				$actmenu = "orderwise";
				include('include/sidebar.php'); ?>
				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Order Wise</h3>
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

								<table class="table table-responsive" border="0" cellspacing="0" cellpadding="0">
									<tbody>
										<tr>
											<td>Date Filter:</td>
											<td><input type="text" id="min" name="min" placeholder="Choose Date"></td>
											<td><a class="btn btn-ri" onclick="window.location.reload();">Reset Filters</a>
											</td>
										</tr>
									</tbody>
								</table>
								<table cellpadding="0" id="table-to-pdf" cellspacing="0" border="0"
									class="datatable-1 table table-bordered table-striped	 display table-responsive"
									style="width:100%;padding:5px;">
									<thead>
										<tr>
											<th>#</th>
											<th>Order Id</th>
											<th>Delivery Date</th>
											<th>Customer Name</th>
											<th>Customer Ph / Email</th>
											<th>Shipping Address</th>
											<th>Billing Address</th>
											<th>Ordered Date</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										<?php
										$cnt = 1;
										$query1 = mysqli_query($con, "SELECT users.name AS username,users.email AS useremail,users.contactno AS usercontact,users.shippingAddress AS shippingaddress,users.shippingCity AS shippingcity,users.shippingState AS shippingstate,users.shippingPincode AS shippingpincode,users.billingAddress AS billingaddress,users.billingCity AS billingcity,users.billingState AS billingstate,users.billingPincode AS billingpincode,orders.orderDate AS orderdate,orders.id AS id,orders.orderId AS orderId,orders.dtSupply AS dtSupply  FROM orders JOIN users ON  orders.userId=users.id WHERE orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND (orders.orderStatus!='$status' OR orders.orderStatus IS NULL) GROUP BY orderId");

										while ($row1 = mysqli_fetch_array($query1)) {
											?>
											<tr style="cursor: pointer;"
												onclick="window.location.href = 'view-orderwise.php?oid=<?= $row1['orderId'] ?>'">
												<td>
													<?php echo htmlentities($cnt); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row1['orderId']); ?>
												</td>
												<td class="wrap_td_50">
													<?php if (!empty($row1['dtSupply'])) {
														echo date("d-m-Y h:i A", strtotime($row1['dtSupply']));
													} ?>
												</td>
												<td class="wrap_td_50">
													<?php echo htmlentities($row1['username']); ?>
												</td>
												<td class="wrap_td_50">
													<?php echo htmlentities($row1['usercontact'] . " / " . $row1['useremail']); ?>
												</td>
												<td class="wrap_td_50">
													<?php echo htmlentities($row1['shippingaddress'] . ", " . $row1['shippingstate'] . ", " . $row1['shippingcity'] . ", " . $row1['shippingpincode']); ?>
												</td>
												<td class="wrap_td_50">
													<?php echo htmlentities($row1['billingaddress'] . ", " . $row1['billingstate'] . ", " . $row1['billingcity'] . ", " . $row1['billingpincode']); ?>
												</td>
												<td class="wrap_td_50">
													<?php echo date("d-m-Y h:i A", strtotime($row1['orderdate'])); ?>
												</td>
												<td>
													<a href="view-orderwise.php?oid=<?= $row1['orderId'] ?>" title="view order"><i
															class="icon-eye-open"></i></a>
												</td>
											</tr>

											<?php $cnt++;
										} ?>
									</tbody>
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

			let minDate;

			// Create date inputs
			minDate = new DateTime('#min', {
				format: 'MMMM Do YYYY'
			});

			$("#min").change(function () {
				DataTable.ext.search.push(function (settings, data, dataIndex) {
					let min = minDate.val();
					var newmin = moment(min).format("YYYY-MM-DD");

					var mydate = moment(data[2], 'DD-MM-YYYY');
					var newdate = moment(mydate).format("YYYY-MM-DD");

					if (newmin == newdate) {
						return true;
					}
					return false;
				});

				// DataTables initialisation
				let table = new DataTable('#table-to-pdf');

				table.draw();
			});
		});
	</script>
<?php } ?>