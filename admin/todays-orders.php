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
				$actmenu = "orders";
				include('include/sidebar.php'); ?>
				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Today's Orders</h3>
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
									class="datatable-1 table table-bordered table-striped	 display table-responsive"
									style="width:100%;padding:5px;">
									<thead>
										<tr>
											<th>#</th>
											<th>Customer Name</th>
											<th width="50">Email / Contact no</th>
											<th>Shipping Address</th>
											<th>Product </th>
											<th>Qty </th>
											<th>Amount </th>
											<th>Order Date</th>
											<th>Supply Date</th>
											<th>Action</th>


										</tr>
									</thead>

									<tbody>
										<?php
										$f1 = "00:00:00";
										$from = date('Y-m-d') . " " . $f1;
										$t1 = "23:59:59";
										$to = date('Y-m-d') . " " . $t1;
										$todayDate = date('Y-m-d');
										$query = mysqli_query($con, "SELECT users.name AS username,users.email AS useremail,users.contactno AS usercontact,users.shippingAddress AS shippingaddress,users.shippingCity AS shippingcity,users.shippingState AS shippingstate,users.shippingPincode AS shippingpincode,products.productName AS productname,products.shippingCharge AS shippingcharge,orders.quantity AS quantity,orders.orderDate AS orderdate,products.productPrice AS productprice,orders.id AS id,orders.orderId AS orderId,orders.dtSupply AS dtSupply FROM orders JOIN users ON orders.userId=users.id JOIN products ON products.id=orders.productId WHERE orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND DATE(orders.dtSupply) LIKE '%$todayDate%' AND (orders.orderStatus!='Delivered' OR orders.orderStatus IS NULL)");
										$cnt = 1;
										while ($row = mysqli_fetch_array($query)) {
											?>
											<tr style="cursor:pointer"
												onclick="window.location.href = 'updateorder.php?oid=<?= $row['orderId']; ?>&sm=orders'">
												<td>
													<?php echo htmlentities($cnt); ?>
												</td>
												<td class="wrap_td_75">
													<?php echo htmlentities($row['username']); ?>
												</td>
												<td class="wrap_td_75">
													<?php echo htmlentities($row['useremail']); ?>/
													<?php echo htmlentities($row['usercontact']); ?>
												</td>

												<td class="wrap_td_75">
													<?php echo htmlentities($row['shippingaddress'] . "," . $row['shippingcity'] . "," . $row['shippingstate'] . "-" . $row['shippingpincode']); ?>
												</td>
												<td class="wrap_td_75">
													<?php echo htmlentities($row['productname']); ?>
												</td>
												<td class="wrap_td_25">
													<?php echo htmlentities($row['quantity']); ?>
												</td>
												<td class="wrap_td_25">
													<?php echo htmlentities($row['quantity'] * $row['productprice'] + $row['shippingcharge']); ?>
												</td>
												<td class="wrap_td_50">
													<?php echo date("d-m-Y h:i:s A", strtotime($row['orderdate'])); ?>
												</td>
												<td class="wrap_td_50">
													<?php echo date("d-m-Y h:i:s A", strtotime($row['dtSupply'])); ?>
												</td>
												<td><a href="updateorder.php?oid=<?php echo htmlentities($row['orderId']); ?>&sm=orders"
														title="Update order"><i class="icon-edit"></i></a>
												</td>
											</tr>

											<?php $cnt = $cnt + 1;
										}
										$query1 = mysqli_query($con, "SELECT users.name AS username,users.email AS useremail,users.contactno AS usercontact,users.shippingAddress AS shippingaddress,users.shippingCity AS shippingcity,users.shippingState AS shippingstate,users.shippingPincode AS shippingpincode,combo.comboName AS comboname,combo.shippingCharge AS shippingcharge,orders.quantity AS quantity,orders.orderDate AS orderdate,combo.comboPrice AS comboprice,orders.id AS id,orders.orderId AS orderId,orders.dtSupply AS dtSupply FROM orders JOIN users ON orders.userId=users.id JOIN combo ON combo.id=orders.comboId WHERE orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND DATE(orders.dtSupply) LIKE '%$todayDate%' AND (orders.orderStatus!='Delivered' OR orders.orderStatus IS NULL)");
										while ($row1 = mysqli_fetch_array($query1)) {
											?>
											<tr style="cursor:pointer"
												onclick="window.location.href = 'updateorder.php?oid=<?= $row1['orderId']; ?>&sm=orders'">
												<td>
													<?php echo htmlentities($cnt); ?>
												</td>
												<td class="wrap_td_75">
													<?php echo htmlentities($row1['username']); ?>
												</td>
												<td class="wrap_td_75">
													<?php echo htmlentities($row1['useremail']); ?>/
													<?php echo htmlentities($row1['usercontact']); ?>
												</td>

												<td class="wrap_td_75">
													<?php echo htmlentities($row1['shippingaddress'] . "," . $row1['shippingcity'] . "," . $row1['shippingstate'] . "-" . $row1['shippingpincode']); ?>
												</td>
												<td class="wrap_td_75">
													<?php echo htmlentities($row1['comboname']); ?>
												</td>
												<td class="wrap_td_25">
													<?php echo htmlentities($row1['quantity']); ?>
												</td>
												<td class="wrap_td_25">
													<?php echo htmlentities($row1['quantity'] * $row1['comboprice'] + $row1['shippingcharge']); ?>
												</td>
												<td class="wrap_td_50">
													<?php echo date("d-m-Y h:i:s A", strtotime($row1['orderdate'])); ?>
												</td>
												<td class="wrap_td_50">
													<?php echo date("d-m-Y h:i:s A", strtotime($row1['dtSupply'])); ?>
												</td>
												<td><a href="updateorder.php?oid=<?php echo htmlentities($row1['orderId']); ?>&sm=orders"
														title="Update order"><i class="icon-edit"></i></a>
												</td>
											</tr>

											<?php $cnt = $cnt + 1;
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
			// $('.dataTables_paginate').addClass("btn-group datatable-pagination");
			// $('.dataTables_paginate > a').wrapInner('<span />');
			// $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			// $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		});
	</script>
<?php } ?>