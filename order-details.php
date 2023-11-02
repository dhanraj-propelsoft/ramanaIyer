<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/header.php');
?>
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="index.php">Home</a></li>
				<li class='active'>Order Details</li>
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
										<th class="cart-sub-total item">Price Per unit</th>
										<th class="cart-total item">Grandtotal</th>
										<th class="cart-total item">Payment Method</th>
										<th class="cart-description item">Order Date</th>
										<th class="cart-total last-item">Action</th>
									</tr>
								</thead><!-- /thead -->

								<tbody>
									<?php
									$orderid = $_POST['orderid'];
									$email = $_POST['email'];
									$ret = mysqli_query($con, "select t.email,t.id from (select usr.email,odrs.id from users as usr join orders as odrs on usr.id=odrs.userId) as t where  t.email='$email' and (t.id='$orderid')");
									$num = mysqli_num_rows($ret);
									if ($num > 0) {
										$query = mysqli_query($con, "select products.productImage1 as pimg1,products.productName as pname,orders.productId as opid,orders.quantity as qty,products.productPrice as pprice,orders.paymentMethod as paym,orders.orderDate as odate,orders.id as orderid from orders join products on orders.productId=products.id where orders.id='$orderid' and orders.paymentMethod is not null");
										$cnt = 1;
										if ($row = mysqli_fetch_array($query)) {
											?>
											<tr>
												<td>
													<?php echo $cnt; ?>
												</td>
												<td class="cart-image">
													<a class="entry-thumbnail" href="product-details.php?pid=<?php echo $row['opid']; ?>">
														<img src="admin/productimages/<?php echo $row['opid']; ?>/<?php echo $row['pimg1']; ?>"
															alt="" width="84" height="146">
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
												<td class="cart-product-grand-total">
													<?php echo $qty * $price; ?>
												</td>
												<td class="cart-product-sub-total">
													<?php echo $row['paym']; ?>
												</td>
												<td class="cart-product-sub-total">
													<?php echo $row['odate']; ?>
												</td>

												<td>
													<a href="javascript:void(0);"
														onClick="popUpWindow('track-order.php?oid=<?php echo htmlentities($row['orderid']); ?>');"
														title="Track order">
														Track
												</td>
											</tr>
											<?php $cnt = $cnt + 1;
										}
										$query1 = mysqli_query($con, "select combo.comboImage1 as cimg1,combo.comboName as cname,orders.comboId as opid,orders.quantity as qty,combo.comboPrice as cprice,orders.paymentMethod as paym,orders.orderDate as odate,orders.id as orderid from orders join combo on orders.comboId=combo.id where orders.id='$orderid' and orders.paymentMethod is not null");
										if ($row1 = mysqli_fetch_array($query1)) {
											?>
											<tr>
												<td>
													<?php echo $cnt; ?>
												</td>
												<td class="cart-image">
													<a class="entry-thumbnail" href="combo-details.php?cid=<?php echo $row1['opid']; ?>">
														<img src="admin/comboimages/<?php echo $row1['opid']; ?>/<?php echo $row1['cimg1']; ?>"
															alt="" width="84" height="146">
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
												<td class="cart-product-grand-total">
													<?php echo $qty * $price; ?>
												</td>
												<td class="cart-product-sub-total">
													<?php echo $row1['paym']; ?>
												</td>
												<td class="cart-product-sub-total">
													<?php echo $row1['odate']; ?>
												</td>

												<td>
													<a href="javascript:void(0);"
														onClick="popUpWindow('track-order.php?oid=<?php echo htmlentities($row1['orderid']); ?>');"
														title="Track order">
														Track
												</td>
											</tr>
											<?php $cnt = $cnt + 1;
										}
									} else { ?>
										<tr>
											<td colspan="8">Either order id or Registered email id is invalid</td>
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

<script language="javascript" type="text/javascript">
	var popUpWin = 0;
	function popUpWindow(URLStr, left, top, width, height) {
		if (popUpWin) {
			if (!popUpWin.closed) popUpWin.close();
		}
		popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
	}
</script>