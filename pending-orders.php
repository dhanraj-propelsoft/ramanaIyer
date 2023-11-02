<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	$_SESSION['lastSeen'] = 'pending-orders.php';
	header('location:login.php');
} else {
	$_SESSION['lastSeen'] = '';
	include('includes/header.php');
	if (isset($_GET['id'])) {

		mysqli_query($con, "delete from orders  where userId='" . $_SESSION['id'] . "' and paymentMethod is null and id='" . $_GET['id'] . "' ");

	}
	?>
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="index.php">Home</a></li>
					<li class='active'>Pending Orders</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->

	<div class="body-content outer-top-xs">
		<div class="container">
			<div class="row inner-bottom-sm">
				<div class="shopping-cart">
					<div class="col-md-12 col-sm-12 shopping-cart-table ">
						<div class="table-responsive">
							<form name="cart" method="post">

								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="cart-romove item">#</th>
											<th class="cart-description item">Image</th>
											<th class="cart-product-name item">Product Name</th>

											<th class="cart-qty item">Quantity</th>
											<th class="cart-sub-total item">Price Per Unit</th>
											<th class="cart-sub-total item">Shiping Charge</th>
											<th class="cart-total">Grand Total</th>
											<th class="cart-total item">Payment Method</th>
											<th class="cart-description item">Order Date</th>
											<th class="cart-total last-item">Action</th>
										</tr>
									</thead><!-- /thead -->

									<tbody>

										<?php 
											$cnt = 1;
											$query = mysqli_query($con, "select products.productImage1 as pimg1,products.productName as pname,products.id as c,orders.productId as opid,orders.quantity as qty,products.productPrice as pprice,products.shippingCharge as shippingcharge,orders.paymentMethod as paym,orders.orderDate as odate,orders.id as oid,orders.receiptNo as oReceiptNo from orders join products on orders.productId=products.id where orders.userId='" . $_SESSION['id'] . "' and orders.paymentId is null"); //
											$num = mysqli_num_rows($query);
											$query1 = mysqli_query($con, "select combo.comboImage1 as cimg1,combo.comboName as cname,combo.id as c,orders.comboId as opid,orders.quantity as qty,combo.comboPrice as cprice,combo.shippingCharge as shippingcharge,orders.paymentMethod as paym,orders.orderDate as odate,orders.id as oid,orders.receiptNo as oReceiptNo from orders join combo on orders.comboId=combo.id where orders.userId='" . $_SESSION['id'] . "' and orders.paymentId is null"); //
											$num1 = mysqli_num_rows($query1);
											if (($num > 0) || ($num1 > 0)) {
												while ($row = mysqli_fetch_array($query)) {
													?>
												<tr>
													<td>
														<?php echo $cnt; ?>
													</td>
													<td class="cart-image">
														<a class="entry-thumbnail" href="product-details.php?pid=<?php echo $row['opid']; ?>">
															<img src="admin/productimages/<?php echo $row['c']; ?>/<?php echo $row['pimg1']; ?>"
																alt="" width="84" height="auto">
														</a>
													</td>
													<td class="cart-product-name-info">
														<h4 class='cart-product-description'><a
																href="product-details.php?pid=<?php echo $row['opid']; ?>">
																<?php echo $row['pname']; ?></a></h4>


													</td>
													<td class="cart-product-quantity">
														<?php echo $qty = $row['qty']; ?>
													</td>
													<td class="cart-product-sub-total">
														<?php echo $price = $row['pprice']; ?>
													</td>
													<td class="cart-product-sub-total">
														<?php echo $shippcharge = $row['shippingcharge']; ?>
													</td>
													<td class="cart-product-grand-total">
														<?php echo (($qty * $price) + $shippcharge); ?>
													</td>
													<td class="cart-product-sub-total">
														<?php echo $row['paym']; ?>
													</td>
													<td class="cart-product-sub-total">
														<?php echo $row['odate']; ?>
													</td>

													<td><a href="my-cart.php" title="Pay">Pay</td>
												</tr>
												<?php $cnt = $cnt + 1;
												} 
												while ($row1 = mysqli_fetch_array($query1)) {
													?>
												<tr>
													<td>
														<?php echo $cnt; ?>
													</td>
													<td class="cart-image">
														<a class="entry-thumbnail" href="combo-details.php?cid=<?php echo $row1['opid']; ?>">
															<img src="admin/comboimages/<?php echo $row1['c']; ?>/<?php echo $row1['cimg1']; ?>"
																alt="" width="84" height="auto">
														</a>
													</td>
													<td class="cart-product-name-info">
														<h4 class='cart-product-description'><a
																href="combo-details.php?cid=<?php echo $row1['opid']; ?>">
																<?php echo $row1['cname']; ?></a></h4>


													</td>
													<td class="cart-product-quantity">
														<?php echo $qty = $row1['qty']; ?>
													</td>
													<td class="cart-product-sub-total">
														<?php echo $price = $row1['cprice']; ?>
													</td>
													<td class="cart-product-sub-total">
														<?php echo $shippcharge = $row1['shippingcharge']; ?>
													</td>
													<td class="cart-product-grand-total">
														<?php echo (($qty * $price) + $shippcharge); ?>
													</td>
													<td class="cart-product-sub-total">
														<?php echo $row1['paym']; ?>
													</td>
													<td class="cart-product-sub-total">
														<?php echo $row1['odate']; ?>
													</td>

													<td><a href="my-cart.php" title="Pay">Pay</td>
												</tr>
												<?php $cnt = $cnt + 1;
												} ?>
											<!-- <tr>
	<td colspan="9"><div class="cart-checkout-btn pull-right">
							<button type="submit" name="ordersubmit" class="btn btn-primary"><a href="payment-method.php">PROCCED To Payment</a></button>
						
						</div></td>

</tr> -->
										<?php } else { ?>
											<tr>
												<td colspan="10" align="center">
													<h4>No Result Found</h4>
												</td>
											</tr>
										<?php } ?>


									</tbody><!-- /tbody -->
								</table><!-- /table -->

						</div>
					</div>

				</div><!-- /.shopping-cart -->
			</div> <!-- /.row -->
			</form>
			<!-- ============================================== BRANDS CAROUSEL ============================================== -->

			<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
		</div><!-- /.container -->
	</div><!-- /.body-content -->
	<?php include('includes/footer.php'); ?>
<?php } ?>