<?php
session_start();
error_reporting(0);
//echo "<script>alert(".$_COOKIE['qi_id'].");</script>";
include('includes/config.php');

if (isset($_COOKIE['qi_id'])) {
	$qi_id = intval($_COOKIE['qi_id']);
	if ($qi_id > 0)
		$_SESSION['cart'][$qi_id]['quantity']++;
	setcookie("qi_id", "", time() -3600);
}

include('includes/header.php');
?>
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="index.php">Home</a></li>
				<li class='active'>Shopping Cart</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<form name="checkout" id="checkout" method="post">
					<div class="body-content outer-top-xs">
	<div class="container">
		<div class="row inner-bottom-sm">
			<div class="shopping-cart">
				<div class="col-md-12 col-sm-12 shopping-cart-table ">
					<div class="table-responsive">
						<?php
						if (!empty($_SESSION['cart'])) {
							?>
							<form name="cart" id="cart" method="post">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="cart-romove item">Remove</th>
											<th class="cart-description item">Image</th>
											<th class="cart-product-name item">Product Name</th>

											<th class="cart-qty item">Quantity</th>
											<th class="cart-sub-total item">Price Per unit</th>
											<th class="cart-sub-total item">Shipping Charge</th>
											<th class="cart-total last-item">Grandtotal</th>
										</tr>
									</thead><!-- /thead -->
									<tfoot>
										<tr>
											<td colspan="7">
												<div class="shopping-cart-btn">
													<span class="">
														<a href="index.php"
															class="btn btn-upper btn-primary outer-left-xs">Continue
															Shopping</a>
														<input type="submit" id="update" name="submit" value="Update shopping cart"
															class="btn btn-upper btn-primary pull-right outer-right-xs">
													</span>
												</div><!-- /.shopping-cart-btn -->
											</td>
										</tr>
									</tfoot>
									<tbody>
										<?php
										$pdtid = array();
										$pQty = array();
										$sql = "SELECT * FROM products WHERE id IN(";
										foreach ($_SESSION['cart'] as $id => $value) {
											$sql .= $id . ",";
										}
										$sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
										$query = mysqli_query($con, $sql);
										$totalprice = 0;
										$totalqunty = 0;
										if (!empty($query)) {
											$rating = 0;
											while ($row = mysqli_fetch_array($query)) {
												$quantity = $_SESSION['cart'][$row['id']]['quantity'];
												$subtotal = (int) $_SESSION['cart'][$row['id']]['quantity'] * (int) $row['productPrice'] + (int) $row['shippingCharge'];
												$totalprice += $subtotal;
												$_SESSION['qnty'] = $totalqunty += (int) $quantity;

												array_push($pdtid, $row['id']);
												array_push($pQty, $quantity);
												$rating = $row['productRating'];
												//print_r($_SESSION['pid'])=$pdtid;exit;
												?>

												<tr>
													<td class="romove-item"><input type="checkbox" name="remove_code[]"
															value="<?php echo htmlentities($row['id']); ?>" /></td>
													<td class="cart-image">
														<a class="entry-thumbnail"
															href="product-details.php?pid=<?php echo $row['id']; ?>">
															<img src="admin/productimages/<?php echo $row['id']; ?>/<?php echo $row['productImage1']; ?>"
																alt="" style="width: auto; height: 100px; max-width: 130px">
														</a>
													</td>
													<td class="cart-product-name-info">
														<h4 class='cart-product-description'><a
																href="product-details.php?pid=<?php echo htmlentities($pd = $row['id']); ?>"><?php echo $row['productName'];

																	 $_SESSION['sid'] = $pd;
																	 ?></a></h4>
														<div class="row">
															<div class="col-sm-12">
																<?php
																for ($jctr = 0; $jctr < 5; $jctr++) {
																	if ($jctr < $rating)
																		echo '<span class="fa fa-star rate-checked"></span>';
																	else
																		echo '<span class="fa fa-star"></span>';
																}
																?>
															</div>
															<!-- <div class="col-sm-8">
																<?php /*$rt = mysqli_query($con, "select * from productreviews where productId='$pd'");
																$num = mysqli_num_rows($rt); {
																	?>
																	<div class="reviews">
																		(
																		<?php echo htmlentities($num); ?> Reviews )
																	</div>
																<?php } */ ?>
															</div> -->
														</div><!-- /.row -->

													</td>
													<td class="cart-product-quantity">
														<div class="quant-input">
															<div class="arrows">
																<div class="arrow plus gradient"><span class="ir"><i
																			class="icon fa fa-sort-asc"></i></span></div>
																<div class="arrow minus gradient"><span class="ir"><i
																			class="icon fa fa-sort-desc"></i></span></div>
															</div>
															<input type="text" id="quantity[<?php echo $row['id']; ?>]"
																value="<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?>"
																name="quantity[<?php echo $row['id']; ?>]" required>

														</div>
													</td>
													<td class="cart-product-sub-total"><span class="cart-sub-total-price">
														₹ <?php echo $row['productPrice']; ?>.00
														</span></td>
													<td class="cart-product-sub-total"><span class="cart-sub-total-price">
														₹ <?php echo $row['shippingCharge']; ?>.00
														</span></td>

													<td class="cart-product-grand-total"><span class="cart-grand-total-price">
														₹ <?php echo ((int) $_SESSION['cart'][$row['id']]['quantity'] * (int) $row['productPrice'] + (int) $row['shippingCharge']); ?>.00
														</span></td>
												</tr>

											<?php }
										}
										$_SESSION['pid'] = $pdtid;
										$_SESSION['pQty'] = $pQty;
										?>

									</tbody><!-- /tbody -->
								</table><!-- /table -->
							</form>
						</div>
					</div><!-- /.shopping-cart-table -->

						<div class="col-md-4 col-sm-12 estimate-ship-tax">
							<?php
							$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
							while ($row = mysqli_fetch_array($query)) {
								?>

								<table class="table table-bordered">
									<thead>
										<tr>
											<th>
												<span class="estimate-title">Billing Address</span>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
													<div class="form-group">
														<div id="bill-ack"></div>
														<div class="form-group">
															<label class="info-title" for="Billing Address">Billing
																Address<span>*</span></label>
															<textarea class="form-control unicase-form-control text-input"
																name="billingaddress"
																required="required"><?php echo $row['billingAddress']; ?></textarea>
														</div>



														<div class="form-group">
															<label class="info-title" for="Billing State ">Billing State
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input"
																id="bilingstate" name="bilingstate"
																value="<?php echo $row['billingState']; ?>" required>
														</div>
														<div class="form-group">
															<label class="info-title" for="Billing City">Billing City
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input"
																id="billingcity" name="billingcity" required="required"
																value="<?php echo $row['billingCity']; ?>">
														</div>
														<div class="form-group">
															<label class="info-title" for="Billing Pincode">Billing Pincode
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input txtPinCode"
																maxlength="6" id="billingpincode" name="billingpincode" required="required"
																value="<?php echo $row['billingPincode']; ?>">
														</div>


														<button type="submit" id="billupdate" name="billupdate"
															class="btn-upper btn btn-primary checkout-page-button">Update</button>



													</div>
											</td>
										</tr>
									</tbody><!-- /tbody -->
								</table><!-- /table -->
							<?php } ?>
						</div>

						<div class="col-md-4 col-sm-12 estimate-ship-tax">
							<?php
							$query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
							while ($row = mysqli_fetch_array($query)) {
								?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>
												<span class="estimate-title">Shipping Address</span>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
													<div class="form-group">
														<div id="ship-ack"></div>
														<div class="form-group">
															<label class="info-title" for="Shipping Address">Shipping
																Address<span>*</span></label>
															<textarea class="form-control unicase-form-control text-input"
																name="shippingaddress"
																required="required"><?php echo $row['shippingAddress']; ?></textarea>
														</div>



														<div class="form-group">
															<label class="info-title" for="Billing State ">Shipping State
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input"
																id="shippingstate" name="shippingstate"
																value="<?php echo $row['shippingState']; ?>" required>
														</div>
														<div class="form-group">
															<label class="info-title" for="Billing City">Shipping City
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input"
																id="shippingcity" name="shippingcity" required="required"
																value="<?php echo $row['shippingCity']; ?>">
														</div>
														<div class="form-group">
															<label class="info-title" for="Billing Pincode">Shipping Pincode
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input txtPinCode"
																maxlength="6" id="shippingpincode" name="shippingpincode" required="required"
																value="<?php echo $row['shippingPincode']; ?>">
														</div>


														<button type="submit" id="shipupdate" name="shipupdate"
															class="btn-upper btn btn-primary checkout-page-button">Update</button>

													</div>
											</td>
										</tr>
									</tbody><!-- /tbody -->
								</table><!-- /table -->
							<?php } ?>
						</div>
						<div class="col-md-4 col-sm-12 cart-shopping-total">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>

											<div class="cart-grand-total">
												Grand Total<span class="inner-left-md">
												₹ <?php echo $_SESSION['tp'] = $totalprice; ?>.00
												</span>
											</div>
										</th>
									</tr>
								</thead><!-- /thead -->
								<tbody>
									<tr>
										<td>
											<div class="cart-checkout-btn pull-center">
												<button type="submit" id="ordersubmit" name="ordersubmit"
													class="btn btn-primary">PROCEED TO CHECKOUT</button>

											</div>
										</td>
									</tr>
								</tbody><!-- /tbody -->
							</table>
						</div>
				<?php } else {
							echo "Your shopping Cart is empty";
						} ?>
			</div>
		</div>

	</div>
</div>
					</form>
<div id="ack"></div>					
<?php include('includes/footer.php'); ?>
<script>
	
	$('#update').click(function (e) {
		e.preventDefault();
		jQuery.ajax({
			url: "update-cart.php",
			data: $("#checkout").serialize(),
			type: "POST",
			success: function (data) {
				$("#ack").html(data);
			},
			error: function () { }
		});
	});
	$('#billupdate').click(function (e) {
		e.preventDefault();
		jQuery.ajax({
			url: "upd-bill-adrs.php",
			data: $("#checkout").serialize(),
			type: "POST",
			success: function (data) {
				$("#bill-ack").html(data);
				$("#bill-ack").fadeTo(5000, 500).slideUp(500, function(){
					$("#bill-ack").slideUp(500);
				});
			},
			error: function () { }
		});
	});
	$('#shipupdate').click(function (e) {
		e.preventDefault();
		jQuery.ajax({
			url: "upd-ship-adrs.php",
			data: $("#checkout").serialize(),
			type: "POST",
			success: function (data) {
				$("#ship-ack").html(data);
				$("#ship-ack").fadeTo(5000, 500).slideUp(500, function(){
					$("#ship-ack").slideUp(500);
				});
			},
			error: function () { }
		});
	});
	$('#ordersubmit').click(function (e) {
		e.preventDefault();
		jQuery.ajax({
			url: "checkout.php",
			data: $("#checkout").serialize(),
			type: "POST",
			success: function (data) {
				$("#ack").html(data);
			},
			error: function () { }
		});
	});

</script>