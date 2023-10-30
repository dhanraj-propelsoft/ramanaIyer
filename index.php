<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/header.php'); ?>
<div class="body-content outer-top-xs" id="top-banner-and-menu">
	<div class="container">
		<div class="furniture-container homepage-container">
			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-3 sidebar">
					<!-- ================================== TOP NAVIGATION ================================== -->
					<?php include('includes/side-menu.php'); ?>
					<!-- ================================== TOP NAVIGATION : END ================================== -->
				</div><!-- /.sidemenu-holder -->

				<div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
					<!-- ========================================== SECTION – HERO ========================================= -->

					<div id="hero" class="homepage-slider3">
						<div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
							<div class="full-width-slider">
								<img class="item" src="assets/images/sliders/slider1.jpg" />
								<!-- /.container-fluid -->
							</div><!-- /.full-width-slider -->

							<div class="full-width-slider">
								<img class="item full-width-slider" src="assets/images/sliders/slider2.jpg" />
							</div><!-- /.full-width-slider -->

						</div><!-- /.owl-carousel -->
					</div>

					<!-- ========================================= SECTION – HERO : END ========================================= -->
					<!-- ============================================== INFO BOXES ============================================== -->
					<div class="info-boxes wow fadeInUp">
						<div class="info-boxes-inner">
							<div class="row">
								<div class="col-md-4 col-sm-3 col-lg-4">
									<div class="info-box">
										<div class="row">
											<!-- <div class="col-xs-2">
												<i class="icon fa fa-leaf"></i>
											</div> -->
											<div class="col-xs-12" align="center">
												<h4 class="info-box-heading green">Fresh</h4>
											</div>
										</div>
										<!-- <h6 class="text">30 Day Money Back Guarantee</h6> -->
									</div>
								</div><!-- .col -->

								<div class="col-md-4 col-sm-3 col-lg-4">
									<div class="info-box">
										<div class="row">
											<!-- <div class="col-xs-2">
												<i class="icon fa fa-truck"></i>
											</div> -->
											<div class="col-xs-12" align="center">
												<h4 class="info-box-heading orange">Hygienic</h4>
											</div>
										</div>
										<!-- <h6 class="text">free shipping on order over ₹ 600</h6> -->
									</div>
								</div><!-- .col -->

								<div class="col-md-4 col-sm-6 col-lg-4">
									<div class="info-box">
										<div class="row">
											<!-- <div class="col-xs-2">
												<i class="icon fa fa-inr"></i>
											</div> -->
											<div class="col-xs-12" align="center">
												<h4 class="info-box-heading red">Value for money</h4>
											</div>
										</div>
										<!-- <h6 class="text">All items-sale up to 20% off </h6> -->
									</div>
								</div><!-- .col -->
							</div><!-- /.row -->
						</div><!-- /.info-boxes-inner -->

					</div><!-- /.info-boxes -->
					<!-- ============================================== INFO BOXES : END ============================================== -->
				</div><!-- /.homebanner-holder -->

			</div><!-- /.row -->

			<section class="section featured-product wow fadeInUp">
				<h3 class="section-title">Combo Offer </h3>
				<div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">

					<?php
					$rating = 0;
					$qry = mysqli_query($con, "select * from combo");
					while ($rw = mysqli_fetch_array($qry)) {
						/*$rt = mysqli_query($con, "select COUNT(id) as idCnt, SUM(quality) AS qulSum, SUM(price) AS priSum, SUM(value) AS valSum from productreviews where productId='".$rw['id']."'");
									$row2 = mysqli_fetch_array($rt);

									$rowCnt = 0;
									$rating = 0;
									//echo $row2['idCnt'];
									if($row2['idCnt'] > 0) {
										$rowCnt = $row2['idCnt'];
										$rating = round(round($row2['qulSum'] / $rowCnt) + round($row2['priSum'] / $rowCnt) + round($row2['valSum'] / $rowCnt)) / 3;
									}*/
						$rating = $rw['comboRating'];
						?>


						<div class="item item-carousel">
							<div class="products">
								<div class="product text-center">
									<div class="product-image" style="width: 100%; height: 300px; display: table;">
										<div class="image" style="display: table-cell; vertical-align: middle;">
											<a href="combo-details.php?pid=<?php echo htmlentities($rw['id']); ?>"><img
													src="assets/images/blank.gif"
													data-echo="admin/comboimages/<?php echo htmlentities($rw['id']); ?>/<?php echo htmlentities($rw['comboImage1']); ?>"
													style="height: auto; max-width: 100%; max-height: 300px; object-fit: contain;"
													alt=""></a>
										</div><!-- /.image -->


									</div><!-- /.product-image -->


									<div class="product-info text-center">
										<h3 class="name"
											style="overflow: hidden; max-width: 100%; text-overflow: ellipsis; white-space: nowrap;">
											<a href="combo-details.php?pid=<?php echo htmlentities($rw['id']); ?>"><?php echo htmlentities($rw['comboName']); ?></a></h3>
										<?php
										for ($jctr = 0; $jctr < 5; $jctr++) {
											if ($jctr < $rating)
												echo '<span class="fa fa-star rate-checked $rating"></span>';
											else
												echo '<span class="fa fa-star"></span>';
										}
										?>
										<div class="description"></div>

										<div class="product-price">
											<span class="price">
												₹ 
												<?php echo htmlentities($rw['comboPrice']); ?>
											</span>
											<span class="price-before-discount">₹ 
												<?php echo htmlentities($rw['comboPriceBeforeDiscount']); ?>
											</span>

										</div><!-- /.product-price -->

									</div><!-- /.product-info -->
									<?php if ($rw['comboAvailability'] == 'Out of Stock') { ?>
										<div class="action" style="color:red">Out of Stock
										</div>
									<?php } else { ?>
										<div class="action">
											<a onclick="comboCart('<?php echo $rw['id']; ?>')"
												class="lnk btn btn-primary"><i class="fa fa-shopping-cart"></i> &nbsp;
												Add to Cart</a> &nbsp;
											<a class="btn btn-primary" onclick="comboWish('<?php echo $rw['id']; ?>')"
												data-toggle="tooltip" data-placement="top" id="WishList"
												title="Wishlist">
												<i class="fa fa-heart"></i>
											</a>
										</div>
									<?php } ?><!-- /.cart -->
								</div><!-- /.product -->

							</div><!-- /.products -->
						</div><!-- /.item -->
					<?php } ?>


				</div><!-- /.home-owl-carousel -->
			</section>
			<!-- ============================================== TABS ============================================== -->
			<div class="sections prod-slider-small outer-top-small">
				<?php
				$ictr = 1;
				$res = mysqli_query($con, "select subcategory.id,subcategory.subcategory,subcategory.categoryid from subcategory LEFT JOIN category ON subcategory.categoryid = category.id WHERE category.id IS NOT NULL ORDER BY categoryid ASC");

				while ($row1 = mysqli_fetch_array($res)) {

					if ($ictr % 2 != 0)
						echo "<div class='row'>";
					?>

					<div class="col-md-6">
						<section class="section">
							<h3 class="section-title">
								<?php echo $row1['subcategory']; ?>
							</h3>
							<div class="owl-carousel homepage-owl-carousel custom-carousel outer-top-xs owl-theme"
								data-item="2">
								<?php
								$rating = 0;
								$ret = mysqli_query($con, "select * from products where category='" . $row1['categoryid'] . "' and subCategory='" . $row1['id'] . "'");
								while ($row = mysqli_fetch_array($ret)) {
									/*$rt = mysqli_query($con, "select COUNT(id) as idCnt, SUM(quality) AS qulSum, SUM(price) AS priSum, SUM(value) AS valSum from productreviews where productId='".$row['id']."'");
																							 $row2 = mysqli_fetch_array($rt);

																							 $rowCnt = 0;
																							 $rating = 0;
																							 //echo $row2['idCnt'];
																							 if($row2['idCnt'] > 0) {
																								 $rowCnt = $row2['idCnt'];
																								 $rating = round(round($row2['qulSum'] / $rowCnt) + round($row2['priSum'] / $rowCnt) + round($row2['valSum'] / $rowCnt)) / 3;
																							 }*/
									$rating = $row['productRating'];
									?>
									<div class="item item-carousel">
										<div class="products">
											<div class="product text-center">
												<div class="product-image" style="width: 100%; height: 300px; display: table;">
													<div class="image" style="display: table-cell; vertical-align: middle;">
														<a
															href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img
																src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>"
																data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>"
																style="height: auto; max-width: 100%; max-height: 300px; object-fit: contain;"></a>
													</div><!-- /.image -->
												</div><!-- /.product-image -->
												<div class="product-info">
													<h3 class="name"
														style="overflow: hidden; max-width: 100%; text-overflow: ellipsis; white-space: nowrap;">
														<a
															href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a>
													</h3>
													<?php
													for ($jctr = 0; $jctr < 5; $jctr++) {
														if ($jctr < $rating)
															echo '<span class="fa fa-star rate-checked"></span>';
														else
															echo '<span class="fa fa-star"></span>';
													}
													?>
													<div class="description"></div>

													<div class="product-price">
														<span class="price">
															₹ 
															<?php echo htmlentities($row['productPrice']); ?>
														</span>
														<span class="price-before-discount">₹ 
															<?php echo htmlentities($row['productPriceBeforeDiscount']); ?>
														</span>
													</div>
												</div>
												<div id="ack"></div>
												<?php if (($row['productAvailability'] == 'Out of Stock') || (($row['prod_avail'] == '0') && ($row['allow_ao'] != '1'))) { ?>
													<div class="action" style="color:red">Out of Stock
													</div>
												<?php } else { ?>
													<div class="action">
													<a onclick="CartList('<?php echo $row['id']; ?>')"
														class="lnk btn btn-primary"><i class="fa fa-shopping-cart"></i> &nbsp;
														Add to Cart</a> &nbsp;
													<a class="btn btn-primary" onclick="WishList('<?php echo $row['id']; ?>')"
														data-toggle="tooltip" data-placement="top" id="WishList"
														title="Wishlist">
														<i class="fa fa-heart"></i>
													</a>
												</div>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</section>
						<?php
						if ($ictr % 2 != 0)
							echo "</div>";
						else
							echo "</div>
					</div>";
						$ictr++;
				} ?>
				</div>
				<!-- ============================================== TABS : END ============================================== -->




				<?php include('includes/brands-slider.php'); ?>
			</div>
		</div>
		<?php include('includes/footer.php'); ?>