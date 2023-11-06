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
				$actmenu = "delivered";
				include('include/sidebar.php'); ?>
				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Delivered Orders</h3>
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
											<th>Email / Contact no</th>
											<th>Shipping Address</th>
											<th>Product </th>
											<th>Qty </th>
											<th>Amount </th>
											<th>Order Date</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										<?php
										$st = 'Delivered';
										$query = mysqli_query($con, "SELECT users.name as username,users.email as useremail,users.contactno as usercontact,users.shippingAddress as shippingaddress,users.shippingCity as shippingcity,users.shippingState as shippingstate,users.shippingPincode as shippingpincode,products.productName as productname,products.shippingCharge as shippingcharge,orders.quantity as quantity,orders.orderDate as orderdate,products.productPrice as productprice,orders.id as id,orders.orderId AS orderId from orders join users on orders.userId=users.id join products on products.id=orders.productId where orders.orderId IS NOT NULL AND orders.orderStatus='$st'");
										$cnt = 1;
										while ($row = mysqli_fetch_array($query)) {
											?>
											<tr style="cursor:pointer"
												onclick="window.location.href = 'updateorder.php?oid=<?= $row['orderId']; ?>&sm=delivered'">
												<td>
													<?php echo htmlentities($cnt); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row['username']); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row['useremail']); ?>/
													<?php echo htmlentities($row['usercontact']); ?>
												</td>

												<td class="wrap_td_100">
													<?php echo htmlentities($row['shippingaddress'] . "," . $row['shippingcity'] . "," . $row['shippingstate'] . "-" . $row['shippingpincode']); ?>
												</td>
												<td class="wrap_td_100">
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
												<td><a href="updateorder.php?oid=<?php echo htmlentities($row['orderId']); ?>&sm=delivered"
														title="Update order"><i class="icon-eye-open"></i></a>
												</td>
											</tr>

											<?php $cnt = $cnt + 1;
										}
										$query1 = mysqli_query($con, "SELECT users.name as username,users.email as useremail,users.contactno as usercontact,users.shippingAddress as shippingaddress,users.shippingCity as shippingcity,users.shippingState as shippingstate,users.shippingPincode as shippingpincode,combo.comboName as comboname,combo.shippingCharge as shippingcharge,orders.quantity as quantity,orders.orderDate as orderdate,combo.comboPrice as comboprice,orders.id as id,orders.orderId AS orderId from orders join users on orders.userId=users.id join combo on combo.id=orders.comboId where orders.orderId IS NOT NULL AND orders.orderStatus='$st'");
										while ($row1 = mysqli_fetch_array($query1)) {
											?>
											<tr style="cursor:pointer"
												onclick="window.location.href = 'updateorder.php?oid=<?= $row1['orderId']; ?>&sm=delivered'">
												<td>
													<?php echo htmlentities($cnt); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row1['username']); ?>
												</td>
												<td class="wrap_td_100">
													<?php echo htmlentities($row1['useremail']); ?>/
													<?php echo htmlentities($row1['usercontact']); ?>
												</td>

												<td class="wrap_td_100">
													<?php echo htmlentities($row1['shippingaddress'] . "," . $row1['shippingcity'] . "," . $row1['shippingstate'] . "-" . $row1['shippingpincode']); ?>
												</td>
												<td class="wrap_td_100">
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
												<td><a href="updateorder.php?oid=<?php echo htmlentities($row1['orderId']); ?>&sm=delivered"
														title="Update order"><i class="icon-eye-open"></i></a>
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