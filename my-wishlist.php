<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	$_SESSION['lastSeen'] = 'my-wishlist.php';
	header('location:login.php');
} else {
	$_SESSION['lastSeen'] = '';
	include('includes/header.php');
	// Code forProduct deletion from  wishlist	
	

	?>
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="index.php">Home</a></li>
					<li class='active'>Wishlist</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->

	<div class="body-content outer-top-bd">
		<div class="container">
			<div class="my-wishlist-page inner-bottom-sm">
				<div class="row">
					<div class="col-md-12 my-wishlist" id="wishRefreshDiv">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th colspan="4">my wishlist</th>
									</tr>
								</thead>
								<tfoot>
									<tr align="center">
										<td colspan="4"><a href="index.php"
															class="btn btn-upper btn-primary outer-left-xs">Continue
															Shopping</a></td>
									</tr>
								</tfoot>
								<tbody>
									<div id="ack"></div>
									<?php
									$ret = mysqli_query($con, "SELECT products.productName as pname,products.productName as proid,products.productImage1 as pimage,products.productPrice as pprice,products.productPriceBeforeDiscount as pdiscount,products.productRating as prating,products.productAvailability as pAvailability,wishlist.productId as pid,wishlist.id as wid from wishlist join products on products.id=wishlist.productId where wishlist.userId='" . $_SESSION['id'] . "'");
									$num = mysqli_num_rows($ret);

									$ret1 = mysqli_query($con, "SELECT combo.comboName as cname,combo.comboImage1 as cimage,combo.comboPrice as cprice,combo.comboPriceBeforeDiscount as cdiscount,combo.comboRating as crating,combo.comboAvailability as cAvailability,wishlist.comboId as cid,wishlist.id as wid from wishlist join combo on combo.id=wishlist.comboId where wishlist.userId='" . $_SESSION['id'] . "'");
									$num1 = mysqli_num_rows($ret1);
									
									if ($num > 0) {
										$rating = 0;
										while ($row = mysqli_fetch_array($ret)) {

											$rating = $row['prating'];
											?>

											<tr>
												<td class="col-md-2" style="text-align: center;"><a
														href="product-details.php?pid=<?php echo htmlentities($row['pid']); ?>"><img
															src="admin/productimages/<?php echo htmlentities($row['pid']); ?>/<?php echo htmlentities($row['pimage']); ?>"
															alt="<?php echo htmlentities($row['pname']); ?>"
															style="width: auto; height: 100px; max-width: 130px" /></a></td>
												<td class="col-md-6">
													<div class="product-name"><a
															href="product-details.php?pid=<?php echo htmlentities($pd = $row['pid']); ?>"><?php echo htmlentities($row['pname']); ?></a></div>
													<?php $rt = mysqli_query($con, "select * from productreviews where productId='$pd'");
													$num = mysqli_num_rows($rt); {
														?>

														<div class="">
															<?php
															for ($jctr = 0; $jctr < 5; $jctr++) {
																if ($jctr < $rating)
																	echo '<span class="fa fa-star rate-checked"></span>';
																else
																	echo '<span class="fa fa-star"></span>';
															}
															?>
															<!-- <span class="review">(
																<?php //echo htmlentities($num); ?> Reviews )
															</span> -->
														</div>
													<?php } ?>
													<div class="price">₹ 
														<?php echo htmlentities($row['pprice']); ?>.00
														<span>₹ 
															<?php echo htmlentities($row['pdiscount']); ?>
														</span>
													</div>
												</td>
												<td class="col-md-2">
													<?php if ($row['pAvailability'] == 'Out of Stock') { ?>
														<div class="action" style="color:red">Out of Stock
														</div>
													<?php } else { ?>
														<a onclick="CartList('<?php echo $row['pid']; ?>')"
														class="btn-upper btn btn-primary"><i
															class="fa fa-shopping-cart inner-right-vs"></i> Add to cart</a>
													<?php } ?>
												</td>
												<td class="col-md-2 close-btn">
													<a style="cursor: pointer;" onClick="DelWish('<?php echo htmlentities($row['wid']); ?>')"><i
															class="fa fa-trash"></i></a>
												</td>
											</tr>
										<?php }
									} else if ($num1 > 0) {
										$rating1 = 0;
										while ($row1 = mysqli_fetch_array($ret1)) {

											$rating1 = $row1['crating'];
											?>

											<tr>
												<td class="col-md-2" style="text-align: center;"><a
														href="combo-details.php?cid=<?php echo htmlentities($row1['cid']); ?>"><img
															src="admin/comboimages/<?php echo htmlentities($row1['cid']); ?>/<?php echo htmlentities($row1['cimage']); ?>"
															alt="<?php echo htmlentities($row1['cname']); ?>"
															style="width: auto; height: 100px; max-width: 130px" /></a></td>
												<td class="col-md-6">
													<div class="combo-name"><a
															href="combo-details.php?cid=<?php echo htmlentities($pd = $row1['cid']); ?>"><?php echo htmlentities($row1['cname']); ?></a></div>
													<?php $rt = mysqli_query($con, "select * from comboreviews where comboId='$pd'");
													$num = mysqli_num_rows($rt); {
														?>

														<div class="">
															<?php
															for ($jctr = 0; $jctr < 5; $jctr++) {
																if ($jctr < $rating1)
																	echo '<span class="fa fa-star rate-checked"></span>';
																else
																	echo '<span class="fa fa-star"></span>';
															}
															?>
															<!-- <span class="review">(
																<?php //echo htmlentities($num); ?> Reviews )
															</span> -->
														</div>
													<?php } ?>
													<div class="price">₹ 
														<?php echo htmlentities($row1['cprice']); ?>.00
														<span>₹ 
															<?php echo htmlentities($row1['cdiscount']); ?>
														</span>
													</div>
												</td>
												<td class="col-md-2">
													<?php if ($row1['cAvailability'] == 'Out of Stock') { ?>
														<div class="action" style="color:red">Out of Stock
														</div>
													<?php } else { ?>
														<a onclick="comboCart('<?php echo $row1['cid']; ?>')"
														class="btn-upper btn btn-primary"><i
															class="fa fa-shopping-cart inner-right-vs"></i> Add to cart</a>
													<?php } ?>
												</td>
												<td class="col-md-2 close-btn">
													<a style="cursor: pointer;" onClick="DelWish('<?php echo htmlentities($row1['wid']); ?>')"><i
															class="fa fa-trash"></i></a>
												</td>
											</tr>
										<?php } 
									} else { ?>
										<tr>
											<td style="font-size: 18px; font-weight:bold ">Your Wishlist is Empty</td>

										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.sigin-in-->

		</div>
	</div>
	<?php include('includes/footer.php'); ?>
	<script>
		function DelWish(ele) {
			jQuery.ajax({
				url: "del-from-wishlist.php",
				data: { wishlist_id: ele },
				type: "POST",
				success: function (data) {
					$("#ack").html(data);
					$('#wishRefreshDiv').load(' #wishRefreshDiv > *');
				},
				error: function () { }
			});
		}
	</script>
<?php } ?>