<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/header.php');
$find = "%{$_POST['product']}%";

// COde for Wishlist
$pid = intval($_GET['pid']);

?>
<div class="body-content outer-top-xs">
	<div class='container'>
		<div class='row outer-bottom-sm'>
			<div class='col-md-3 sidebar'>
				<!-- ================================== TOP NAVIGATION ================================== -->
				<div class="side-menu animate-dropdown outer-bottom-xs">
					<div class="side-menu animate-dropdown outer-bottom-xs">
						<div class="head"><i class="icon fa fa-align-justify fa-fw"></i>Sub Categories</div>
						<nav class="yamm megamenu-horizontal" role="navigation">

							<ul class="nav">
								<li class="dropdown menu-item">
									<?php $sql = mysqli_query($con, "select id,subcategory  from subcategory");

									while ($row = mysqli_fetch_array($sql)) {
										?>
										<a href="sub-category.php?scid=<?php echo $row['id']; ?>" class="dropdown-toggle">
											<?php echo $row['subcategory']; ?>
										</a>
									<?php } ?>

								</li>
							</ul>
						</nav>
					</div>
				</div><!-- /.side-menu -->
				<!-- ================================== TOP NAVIGATION : END ================================== -->
				<div class="sidebar-module-container">
					<h3 class="section-title">shop by</h3>
					<div class="sidebar-filter">
						<!-- ============================================== SIDEBAR CATEGORY ============================================== -->
						<div class="sidebar-widget wow fadeInUp outer-bottom-xs ">
							<div class="widget-header m-t-20">
								<h4 class="widget-title">Category</h4>
							</div>
							<div class="sidebar-widget-body m-t-10" style="max-height:215px;overflow:auto">
								<?php $sql = mysqli_query($con, "select id,categoryName  from category");
								while ($row = mysqli_fetch_array($sql)) {
									?>
									<div class="accordion">
										<div class="accordion-group">
											<div class="accordion-heading">
												<a href="category.php?cid=<?php echo $row['id']; ?>"
													class="accordion-toggle collapsed">
													<?php echo $row['categoryName']; ?>
												</a>
											</div>
										</div>
									</div>
								<?php } ?>
							</div><!-- /.sidebar-widget-body -->
						</div><!-- /.sidebar-widget -->




						<!-- ============================================== COLOR: END ============================================== -->

					</div><!-- /.sidebar-filter -->
				</div><!-- /.sidebar-module-container -->
			</div><!-- /.sidebar -->
			<div class='col-md-9'>
				<!-- ========================================== SECTION – HERO ========================================= -->

				<div id="category" class="category-carousel hidden-xs">
					<div class="item">
						<div class="image">
							<img src="assets/images/banners/cat-banner-3.jpg" alt="" class="img-responsive">
						</div>
						<div class="container-fluid">
							<div class="caption vertical-top text-left">
								<div class="big-text">
									<br />
								</div>



							</div><!-- /.caption -->
						</div><!-- /.container-fluid -->
					</div>
				</div>

				<div class="search-result-container">
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane active " id="grid-container">
							<div class="category-product  inner-top-vs">
								<div class="row">
									<?php
									$ret = mysqli_query($con, "select * from products where productName like '$find'");
									$num = mysqli_num_rows($ret);
									if ($num > 0) {
										$rating = 0;
										while ($row = mysqli_fetch_array($ret)) {
											$rating = $row['productRating']; ?>
											<div class="col-sm-6 col-md-4 wow fadeInUp">
												<div class="products">
													<div class="product text-center">
														<div class="product-image"
															style="width: 100%; height: 300px; display: table;">
															<div class="image"
																style="display: table-cell; vertical-align: middle;">
																<a
																	href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img
																		src="assets/images/blank.gif"
																		data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>"
																		alt=""
																		style="height: auto; max-width: 100%; max-height: 300px; object-fit: contain;"></a>
															</div><!-- /.image -->
														</div><!-- /.product-image -->


														<div class="product-info">
															<h3 class="name"
																style="overflow: hidden; max-width: 100%; text-overflow: ellipsis; white-space: nowrap;">
																<a
																	href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
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

															</div><!-- /.product-price -->

														</div><!-- /.product-info -->
														<div id="ack"></div>
														<div class="cart clearfix animate-effect">
															<div class="action">
																<ul class="list-unstyled">
																	<li class="add-cart-button btn-group">
																		<?php if ($row['productAvailability'] == 'Out of Stock') { ?>
																			<div class="action" style="color:red">Out of Stock
																			</div>
																		<?php } else { ?>
																			<a onclick="CartList('<?php echo $row['id']; ?>')">
																				<button class="btn btn-upper btn-primary"
																					type="button"><i
																						class="fa fa-shopping-cart"></i> &nbsp; Add
																					to cart</button></a>
																		<?php } ?>
																	</li>

																	<li class="lnk wishlist">
																		<a class="add-to-cart"
																			onclick="WishList('<?php echo $row['id']; ?>')"
																			data-toggle="tooltip" data-placement="top"
																			id="WishList" title="Wishlist">
																			<i class="fa fa-heart"></i>
																		</a>

																	</li>


																</ul>
															</div><!-- /.action -->
														</div><!-- /.cart -->
													</div>
												</div>
											</div>
										<?php }
									} else { ?>

										<div class="col-sm-6 col-md-4 wow fadeInUp">
											<h3>No Product Found</h3>
										</div>

									<?php } ?>



								</div><!-- /.row -->
							</div><!-- /.category-product -->

						</div><!-- /.tab-pane -->



					</div><!-- /.search-result-container -->

				</div><!-- /.col -->
			</div>
		</div>


	</div>
</div>
<?php include('includes/footer.php'); ?>