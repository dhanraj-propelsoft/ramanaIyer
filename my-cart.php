<?php
session_start();
error_reporting(0);
//echo "<script>alert(".$_COOKIE['qi_id'].");</script>";
include('includes/config.php');

if (isset($_COOKIE['qi_id'])) {
	$qi_id = intval($_COOKIE['qi_id']);
	$qi_qty = intval($_COOKIE['qi_qty']);
	if ($qi_id > 0)
	{
		if($qi_qty > 0)
			$_SESSION['product'][$qi_id]['quantity']+=$qi_qty;
		else
			$_SESSION['product'][$qi_id]['quantity']++;
	}
	setcookie("qi_id", "", time() -3600);
	setcookie("qi_qty", "", time() -3600);
}

if (isset($_COOKIE['cqi_id'])) {
	$cqi_id = intval($_COOKIE['cqi_id']);
	$cqi_qty = intval($_COOKIE['cqi_qty']);
	if ($cqi_id > 0)
	{
		if($cqi_qty > 0)
			$_SESSION['combo'][$cqi_id]['quantity']+=$cqi_qty;
		else
			$_SESSION['combo'][$cqi_id]['quantity']++;
	}
	setcookie("cqi_id", "", time() -3600);
	setcookie("cqi_qty", "", time() -3600);
}
	
mysqli_query($con, "DELETE FROM orders WHERE userId='" . $_SESSION['id'] . "' AND paymentId IS NULL");
unset($_SESSION['receiptNo']);
unset($_SESSION['total_amt']);

include('includes/header.php');
date_default_timezone_set("Asia/Kolkata");
$against_order = 0;
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
						if ((!empty($_SESSION['product'])) || (!empty($_SESSION['combo']))) {
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
											<th class="cart-total last-item">Grand Total</th>
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
										if((isset($_SESSION['product'])) && (!empty($_SESSION['product']))){
											$pdtid = array();
											$pQty = array();
											$sql = "SELECT * FROM products WHERE id IN(";
											foreach ($_SESSION['product'] as $id => $value) {
												$sql .= $id . ",";
											}
											$sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
											$query = mysqli_query($con, $sql);
											$totalprice = 0;
											$totalqunty = 0;
											if (!empty($query)) {
												$rating = 0;
												while ($row = mysqli_fetch_array($query)) {
													if($row['productAvailability'] == "Against Order")
														$against_order = 1;
													$quantity = $_SESSION['product'][$row['id']]['quantity'];
													$subtotal = (int) $_SESSION['product'][$row['id']]['quantity'] * (int) $row['productPrice'] + (int) $row['shippingCharge'];
													$totalprice += $subtotal;
													$_SESSION['qnty'] = $totalqunty += (int) $quantity;

													array_push($pdtid, $row['id']);
													array_push($pQty, $quantity);
													$rating = $row['productRating'];
													//print_r($_SESSION['pid'])=$pdtid;exit;
													?>

													<tr>
														<td class="romove-item"><input type="checkbox" name="pRemove_code[]"
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
																<input type="text" id="pQuantity[<?php echo $row['id']; ?>]"
																	value="<?php echo $_SESSION['product'][$row['id']]['quantity']; ?>"
																	name="pQuantity[<?php echo $row['id']; ?>]" required>

															</div>
														</td>
														<td class="cart-product-sub-total"><span class="cart-sub-total-price">
															₹ <?php echo $row['productPrice']; ?>.00
															</span></td>
														<td class="cart-product-sub-total"><span class="cart-sub-total-price">
															₹ <?php echo $row['shippingCharge']; ?>.00
															</span></td>

														<td class="cart-product-grand-total"><span class="cart-grand-total-price">
															₹ <?php echo ((int) $_SESSION['product'][$row['id']]['quantity'] * (int) $row['productPrice'] + (int) $row['shippingCharge']); ?>.00
															</span></td>
													</tr>

												<?php }
											}
											// $_SESSION['pid'] = $pdtid;
											// $_SESSION['pQty'] = $pQty;
										}
										?>
										<?php
										if((isset($_SESSION['combo'])) && (!empty($_SESSION['combo']))){
											$cmbId = array();
											$cQty = array();
											$sql = "SELECT * FROM combo WHERE id IN(";
											foreach ($_SESSION['combo'] as $id => $value) {
												$sql .= $id . ",";
											}
											$sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
											$query = mysqli_query($con, $sql);
											if (!empty($query)) {
												$rating = 0;
												while ($row2 = mysqli_fetch_array($query)) {
													if($row2['comboAvailability'] == "Against Order")
														$against_order = 1;
													$quantity = $_SESSION['combo'][$row2['id']]['quantity'];
													$subtotal = (int) $_SESSION['combo'][$row2['id']]['quantity'] * (int) $row2['comboPrice'] + (int) $row2['shippingCharge'];
													$totalprice += $subtotal;
													$_SESSION['qnty'] = $totalqunty += (int) $quantity;

													array_push($cmbId, $row2['id']);
													array_push($cQty, $quantity);
													$rating = $row2['comboRating'];
													//print_r($_SESSION['pid'])=$cmbId;exit;
													?>

													<tr>
														<td class="romove-item"><input type="checkbox" name="cRemove_code[]"
																value="<?php echo htmlentities($row2['id']); ?>" /></td>
														<td class="cart-image">
															<a class="entry-thumbnail"
																href="combo-details.php?cid=<?php echo $row2['id']; ?>">
																<img src="admin/comboimages/<?php echo $row2['id']; ?>/<?php echo $row2['comboImage1']; ?>"
																	alt="" style="width: auto; height: 100px; max-width: 130px">
															</a>
														</td>
														<td class="cart-product-name-info">
															<h4 class='cart-combo-description'><a
																	href="combo-details.php?cid=<?php echo htmlentities($pd = $row2['id']); ?>"><?php echo $row2['comboName'];

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
																	<?php /*$rt = mysqli_query($con, "select * from comboreviews where comboId='$pd'");
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
																<input type="text" id="cQuantity[<?php echo $row2['id']; ?>]"
																	value="<?php echo $_SESSION['combo'][$row2['id']]['quantity']; ?>"
																	name="cQuantity[<?php echo $row2['id']; ?>]" required>

															</div>
														</td>
														<td class="cart-product-sub-total"><span class="cart-sub-total-price">
															₹ <?php echo $row2['comboPrice']; ?>.00
															</span></td>
														<td class="cart-product-sub-total"><span class="cart-sub-total-price">
															₹ <?php echo $row2['shippingCharge']; ?>.00
															</span></td>

														<td class="cart-product-grand-total"><span class="cart-grand-total-price">
															₹ <?php echo ((int) $_SESSION['combo'][$row2['id']]['quantity'] * (int) $row2['comboPrice'] + (int) $row2['shippingCharge']); ?>.00
															</span></td>
													</tr>

												<?php }
											}
											// $_SESSION['cid'] = $cmbId;
											// $_SESSION['cQty'] = $cQty;
										}
										$totalprice = $totalprice + 40;
										?>
										<tr>
											<td class="romove-item"></td>
											<td class="cart-image"></td>
											<td class="cart-product-name-info">
												<h4 class='cart-combo-description'>Shipping Charge</h4>
											</td>
											<td class="cart-product-quantity">
												
											</td>
											<td class="cart-product-sub-total"><span class="cart-sub-total-price">
												₹ 0.00
												</span></td>
											<td class="cart-product-sub-total"><span class="cart-sub-total-price">
												₹ 40.00
												</span></td>

											<td class="cart-product-grand-total"><span class="cart-grand-total-price">
												₹ 40.00
												</span></td>
										</tr>
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
															<label class="info-title" for="Billing Pincode">Billing Pincode
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input"
																maxlength="6" onblur="pull_st_ct(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="billingpincode" name="billingpincode" required="required"
																value="<?php echo $row['billingPincode']; ?>">
															<div id="bill-pin-ack" style="color: red;"></div>
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
															<label class="info-title" for="Billing Pincode">Shipping Pincode
																<span>*</span></label>
															<input type="text"
																class="form-control unicase-form-control text-input"
																maxlength="6" onblur="pull_st_ct(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="shippingpincode" name="shippingpincode" required="required"
																value="<?php echo $row['shippingPincode']; ?>">
															<div id="ship-pin-ack" style="color: red;"></div>
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
								<tbody>
									<tr>
										<td>
											<div class="pull-center">
												<div class="form-group">
													<label class="info-title" for="Billing Pincode">Choose Delivery Date and Time
														<span style="color: red;">*</span></label>
													<input type="datetime-local" required name="dateTime" placeholder="Choose date and time" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    class="form-control unicase-form-control text-input" step="any" value="<?php if($against_order == 0) { echo date('Y-m-d', strtotime('tomorrow'))."T".date('H:i:s'); } ?>" min="<?= date('Y-m-d', strtotime('tomorrow'))."T".date('H:i:s'); ?>">
												</div>
											</div>
										</td>
									</tr>
								</tbody><!-- /tbody -->
							</table>
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
				<?php } else {?>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Your Shopping Cart is empty</th>
										</tr>
									</thead>
									<tfoot>
										<tr align="center">
											<td><a href="index.php"
											class="btn btn-upper btn-primary outer-left-xs">Continue
											Shopping</a></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<?php } ?>
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