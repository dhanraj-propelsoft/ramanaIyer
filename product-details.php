
<?php 
	session_start();
	error_reporting(0);
	include('includes/config.php');
	include('includes/header.php'); 

	$pid = intval($_GET['pid']);
	if (isset($_POST['submit'])) {
		$qty = $_POST['quality'];
		$price = $_POST['price'];
		$value = $_POST['value'];
		$name = $_POST['name'];
		$summary = $_POST['summary'];
		$review = $_POST['review'];
		mysqli_query($con, "insert into productreviews(productId,quality,price,value,name,summary,review) values('$pid','$qty','$price','$value','$name','$summary','$review')");
	}
	?>
	<style>
		.rating1 {
		/* margin-top: 40px; */
		border: none;
		float: left;
		}

		.rating1 > label {
		color: #90A0A3;
		float: right;
		}

		.rating1 > label:before {
		margin: 5px;
		font-size: 2em;
		font-family: FontAwesome;
		content: "\f005";
		display: inline-block;
		}

		.rating1 > input {
		display: none;
		}

		.rating1 > input:checked ~ label,
		.rating1:not(:checked) > label:hover,
		.rating1:not(:checked) > label:hover ~ label {
		color: #F79426;
		}

		.rating1 > input:checked + label:hover,
		.rating1 > input:checked ~ label:hover,
		.rating1 > label:hover ~ input:checked ~ label,
		.rating1 > input:checked ~ label:hover ~ label {
		color: #FECE31;
		}
		.rating2 {
		/* margin-top: 40px; */
		border: none;
		float: left;
		}

		.rating2 > label {
		color: #90A0A3;
		float: right;
		}

		.rating2 > label:before {
		margin: 5px;
		font-size: 2em;
		font-family: FontAwesome;
		content: "\f005";
		display: inline-block;
		}

		.rating2 > input {
		display: none;
		}

		.rating2 > input:checked ~ label,
		.rating2:not(:checked) > label:hover,
		.rating2:not(:checked) > label:hover ~ label {
		color: #F79426;
		}

		.rating2 > input:checked + label:hover,
		.rating2 > input:checked ~ label:hover,
		.rating2 > label:hover ~ input:checked ~ label,
		.rating2 > input:checked ~ label:hover ~ label {
		color: #FECE31;
		}
		.rating3 {
		/* margin-top: 40px; */
		border: none;
		float: left;
		}

		.rating3 > label {
		color: #90A0A3;
		float: right;
		}

		.rating3 > label:before {
		margin: 5px;
		font-size: 2em;
		font-family: FontAwesome;
		content: "\f005";
		display: inline-block;
		}

		.rating3 > input {
		display: none;
		}

		.rating3 > input:checked ~ label,
		.rating3:not(:checked) > label:hover,
		.rating3:not(:checked) > label:hover ~ label {
		color: #F79426;
		}

		.rating3 > input:checked + label:hover,
		.rating3 > input:checked ~ label:hover,
		.rating3 > label:hover ~ input:checked ~ label,
		.rating3 > input:checked ~ label:hover ~ label {
		color: #FECE31;
		}
	</style>
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<?php
				$ret = mysqli_query($con, "select category.categoryName as catname,subCategory.subcategory as subcatname,products.productName as pname from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory where products.id='$pid'");
				while ($rw = mysqli_fetch_array($ret)) {

					?>


					<ul class="list-inline list-unstyled">
						<li><a href="index.php">Home</a></li>
						<li>
							<?php echo htmlentities($rw['catname']); ?></a>
						</li>
						<li>
							<?php echo htmlentities($rw['subcatname']); ?>
						</li>
						<li class='active'>
							<?php echo htmlentities($rw['pname']); ?>
						</li>
					</ul>
				<?php } ?>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->
	<div class="body-content outer-top-xs">
		<div class='container'>
			<div class='row single-product outer-bottom-sm '>
				<div class='col-md-3 sidebar'>
					<div class="sidebar-module-container">


						<!-- ==============================================CATEGORY============================================== -->
						<div class="sidebar-widget outer-bottom-xs wow fadeInUp">
							<h3 class="section-title">Category</h3>
							<div class="sidebar-widget-body m-t-10" style="max-height:215px;overflow:auto">
								<div class="accordion">

									<?php $sql = mysqli_query($con, "select id,categoryName  from category");
									while ($row = mysqli_fetch_array($sql)) {
										?>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a href="category.php?cid=<?php echo $row['id']; ?>"
													class="accordion-toggle collapsed">
													<?php echo $row['categoryName']; ?>
												</a>
											</div>

										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<!-- ============================================== CATEGORY : END ============================================== -->
						<!-- ============================================== HOT DEALS ============================================== -->


						<!-- ============================================== COLOR: END ============================================== -->
					</div>
				</div><!-- /.sidebar -->
				<?php
				$ret = mysqli_query($con, "select * from products where id='$pid'");
				while ($row = mysqli_fetch_array($ret)) {

					?>


					<div class='col-md-9'>
						<div class="row  wow fadeInUp">
							<div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
								<div class="product-item-holder size-big single-product-gallery small-gallery">

									<div id="owl-single-product" class="hidden-xs">

										<?php if (!empty($row['productImage1'])) { ?>
											<div class="single-product-gallery-item" id="slide1">
												<a data-lightbox="image-1" data-title="Gallery"
													href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>">
													<img class="img-responsive" alt="" src="assets/images/blank.gif"
														data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>"
														style="max-height:350px; width: auto;" />
												</a>
											</div><!-- /.single-product-gallery-item -->
										<?php }
										if (!empty($row['productImage2'])) { ?>
											<div class="single-product-gallery-item" id="slide2">
												<a data-lightbox="image-1" data-title="Gallery"
													href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>">
													<img class="img-responsive" alt="" src="assets/images/blank.gif"
														data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>"
														style="max-height:350px; width: auto;" />
												</a>
											</div><!-- /.single-product-gallery-item -->
										<?php }
										if (!empty($row['productImage3'])) { ?>
											<div class="single-product-gallery-item" id="slide3">
												<a data-lightbox="image-1" data-title="Gallery"
													href="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>">
													<img class="img-responsive" alt="" src="assets/images/blank.gif"
														data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>"
														style="max-height:350px; width: auto;" />
												</a>
											</div>
										<?php } ?>
									</div><!-- /.single-product-slider -->


									<div class="single-product-gallery-thumbs gallery-thumbs hidden-sm">

										<div id="owl-single-product-thumbnails">
											<?php if (!empty($row['productImage1'])) { ?>
												<div class="item">
													<a class="horizontal-thumb active" data-target="#owl-single-product"
														data-slide="0" href="#slide1">
														<img class="img-responsive" alt="" src="assets/images/blank.gif"
															data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>"
															style="width: 349px;" />
													</a>
												</div>
											<?php }
											if (!empty($row['productImage2'])) { ?>
												<div class="item">
													<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="1"
														href="#slide2">
														<img class="img-responsive" alt="" src="assets/images/blank.gif"
															data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage2']); ?>"
															style="width: 349px;" />
													</a>
												</div>
											<?php }
											if (!empty($row['productImage3'])) { ?>
												<div class="item">

													<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="2"
														href="#slide3">
														<img class="img-responsive" alt="" src="assets/images/blank.gif"
															data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage3']); ?>"
															style="width: 349px;" />
													</a>
												</div>
											<?php } ?>



										</div><!-- /#owl-single-product-thumbnails -->



									</div>

								</div>
							</div>




							<div class='col-sm-6 col-md-7 product-info-block'>
								<div class="product-info">
									<h1 class="name">
										<?php echo htmlentities($row['productName']); ?>
									</h1>
									<?php $rt = mysqli_query($con, "select COUNT(id) as idCnt, SUM(quality) AS qulSum, SUM(price) AS priSum, SUM(value) AS valSum from productreviews where productId='$pid'");
									$row1 = mysqli_fetch_array($rt);

									$rowCnt = 0;
									if($row1['idCnt'] > 0) {
										$rowCnt = $row1['idCnt'];
										//$rating = intval(intval($row1['qulSum'] / $rowCnt) + intval($row1['priSum'] / $rowCnt) + intval($row1['valSum'] / $rowCnt)) / 3;
									}
									$rating = $row['productRating'];
									?>
									<div class="rating-reviews m-t-20">
										<div class="row">
											<div class="col-sm-3 col-xs-5">
												<?php
												for ($ictr = 0; $ictr < 5; $ictr++) {
													if ($ictr < $rating)
														echo '<span class="fa fa-star rate-checked"></span>';
													else
														echo '<span class="fa fa-star"></span>';
												}
												?>
											</div>
											<div class="col-sm-9 col-xs-7">
												<!-- <div class="reviews">
													<a href="#" class="lnk">(
														<?php //echo htmlentities($rowCnt); ?> Reviews)
													</a>
												</div> -->
											</div>
										</div><!-- /.row -->
									</div><!-- /.rating-reviews -->
									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3 col-xs-5">
												<div class="stock-box">
													<span class="label">Availability :</span>
												</div>
											</div>
											<div class="col-sm-9 col-xs-7">
												<div class="stock-box">
													<span class="value">
														<?php echo htmlentities($row['productAvailability']); ?>
													</span>
												</div>
											</div>
										</div><!-- /.row -->
									</div>



									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3 col-xs-5">
												<div class="stock-box">
													<span class="label">Product Brand :</span>
												</div>
											</div>
											<div class="col-sm-9 col-xs-7">
												<div class="stock-box">
													<span class="value">
														<?php echo htmlentities($row['productCompany']); ?>
													</span>
												</div>
											</div>
										</div><!-- /.row -->
									</div>


									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3 col-xs-5">
												<div class="stock-box">
													<span class="label">Shipping Charge :</span>
												</div>
											</div>
											<div class="col-sm-9 col-xs-7">
												<div class="stock-box">
													<span class="value">
														<?php if ($row['shippingCharge'] == 0) {
															echo "Free";
														} else {
															echo htmlentities($row['shippingCharge']);
														}

														?>
													</span>
												</div>
											</div>
										</div><!-- /.row -->
									</div>

									<div class="price-container info-container m-t-20">
										<div class="row">


											<div class="col-sm-6 col-xs-9">
												<div class="price-box">
													<span class="price">₹ 
														<?php echo htmlentities($row['productPrice']); ?>
													</span>
													<span class="price-strike">₹ 
														<?php echo htmlentities($row['productPriceBeforeDiscount']); ?>
													</span>
												</div>
											</div>



											<div class="col-sm-6 col-xs-3">
												<div class="favorite-button m-t-10">
													<a class="btn btn-primary" data-toggle="tooltip"
														onclick="WishList('<?php echo $pid; ?>')" data-placement="right"
														id="WishList" title="Wishlist">
														<i class="fa fa-heart"></i>
													</a>

													</a>
												</div>
											</div>

										</div><!-- /.row -->
									</div><!-- /.price-container -->


									<div id="ack"></div>



									<div class="quantity-container info-container">
										<div class="row">

											<div class="col-sm-2 col-xs-3">
												<span class="label">Qty :</span>
											</div>

											<div class="col-sm-2 col-xs-3">
												<div class="cart-quantity">
													<div class="quant-input">
														<div class="arrows">
															<div class="arrow plus gradient"><span class="ir"><i
																		class="icon fa fa-sort-asc"></i></span></div>
															<div class="arrow minus gradient"><span class="ir"><i
																		class="icon fa fa-sort-desc"></i></span></div>
														</div>
														<input type="text" id="pQuantity" name="pQuantity" value="1" required>
													</div>
												</div>
											</div>

											<div class="col-sm-7 col-xs-6">
												<?php if (($row['productAvailability'] == 'Out of Stock') || ((intval($row['prod_avail']) == 0) && (intval($row['allow_ao']) != 1))) { ?>
													<div class="action" style="color:red">Out of Stock
													</div>
												<?php } else { ?>
													<a id="add-quantity" class="btn-upper btn btn-primary"><i
															class="fa fa-shopping-cart inner-right-vs"></i> Add to Cart</a>
												<?php } ?>
											</div>


										</div><!-- /.row -->
									</div><!-- /.quantity-container -->
								</div><!-- /.product-info -->
							</div><!-- /.col-sm-7 -->
						</div><!-- /.row -->


						<div class="product-tabs inner-bottom-xs  wow fadeInUp">
							<div class="row">
								<div class="col-sm-3">
									<ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
										<li class="active"><a data-toggle="tab" href="#description">DESCRIPTION</a></li>
										<li><a data-toggle="tab" href="#review">REVIEW</a></li>
									</ul><!-- /.nav-tabs #product-tabs -->
								</div>
								<div class="col-sm-9">

									<div class="tab-content">

										<div id="description" class="tab-pane in active">
											<div class="product-tab">
												<p class="text">
													<?php echo $row['productDescription']; ?>
												</p>
											</div>
										</div><!-- /.tab-pane -->

										<div id="review" class="tab-pane">
											<div class="product-tab">

												<div class="product-reviews">
													<h4 class="title">Customer Reviews</h4>
													<?php $qry = mysqli_query($con, "select * from productreviews where productId='$pid'");
													while ($rvw = mysqli_fetch_array($qry)) {
														?>

														<div class="reviews" style="bor der: solid 1px #000; padding-left: 2% ">
															<div class="review">
																<div class="review-title"><span class="summary">
																		<?php echo htmlentities($rvw['summary']); ?>
																	</span><span class="date"><i
																			class="fa fa-calendar"></i><span>
																			<?php echo htmlentities($rvw['reviewDate']); ?>
																		</span></span></div>

																<div class="text">"
																	<?php echo htmlentities($rvw['review']); ?>"
																</div>
																<div class="text"><b>Quality :</b>
																	<?php echo htmlentities($rvw['quality']); ?> Star
																</div>
																<div class="text"><b>Price :</b>
																	<?php echo htmlentities($rvw['price']); ?> Star
																</div>
																<div class="text"><b>value :</b>
																	<?php echo htmlentities($rvw['value']); ?> Star
																</div>
																<div class="author m-t-15"><i class="fa fa-pencil-square-o"></i>
																	<span class="name">
																		<?php echo htmlentities($rvw['name']); ?>
																	</span></div>
															</div>

														</div>
													<?php } ?><!-- /.reviews -->
												</div><!-- /.product-reviews -->
												<form role="form" class="cnt-form" name="review" method="post">


													<div class="product-add-review">
														<h4 class="title">Write your own review</h4>
														<div class="row">
															<div class="col-md-6 col-xs-4">
																<b>Quality</b>
															</div>
															<div class="col-md-6 col-xs-8">
																<div class="rating1">
																	<input type="radio" id="star15" name="quality" value="5" />
																	<label class="star" for="star15" title="Awesome" aria-hidden="true"></label>
																	<input type="radio" id="star14" name="quality" value="4" />
																	<label class="star" for="star14" title="Great" aria-hidden="true"></label>
																	<input type="radio" id="star13" name="quality" value="3" />
																	<label class="star" for="star13" title="Very good" aria-hidden="true"></label>
																	<input type="radio" id="star12" name="quality" value="2" />
																	<label class="star" for="star12" title="Good" aria-hidden="true"></label>
																	<input type="radio" id="star11" name="quality" value="1" />
																	<label class="star" for="star11" title="Bad" aria-hidden="true"></label>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-xs-4">
																<b>Price</b>
															</div>
															<div class="col-md-6 col-xs-8">
																<div class="rating2">
																	<input type="radio" id="star25" name="price" value="5" />
																	<label class="star" for="star25" title="Awesome" aria-hidden="true"></label>
																	<input type="radio" id="star24" name="price" value="4" />
																	<label class="star" for="star24" title="Great" aria-hidden="true"></label>
																	<input type="radio" id="star23" name="price" value="3" />
																	<label class="star" for="star23" title="Very good" aria-hidden="true"></label>
																	<input type="radio" id="star22" name="price" value="2" />
																	<label class="star" for="star22" title="Good" aria-hidden="true"></label>
																	<input type="radio" id="star21" name="price" value="1" />
																	<label class="star" for="star21" title="Bad" aria-hidden="true"></label>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-xs-4">
																<b>Value</b>
															</div>
															<div class="col-md-6 col-xs-8">
																<div class="rating3">
																	<input type="radio" id="star35" name="value" value="5" />
																	<label class="star" for="star35" title="Awesome" aria-hidden="true"></label>
																	<input type="radio" id="star34" name="value" value="4" />
																	<label class="star" for="star34" title="Great" aria-hidden="true"></label>
																	<input type="radio" id="star33" name="value" value="3" />
																	<label class="star" for="star33" title="Very good" aria-hidden="true"></label>
																	<input type="radio" id="star32" name="value" value="2" />
																	<label class="star" for="star32" title="Good" aria-hidden="true"></label>
																	<input type="radio" id="star31" name="value" value="1" />
																	<label class="star" for="star31" title="Bad" aria-hidden="true"></label>
																</div>
															</div>
														</div>

														<div class="review-form">
															<div class="form-container">


																<div class="row">
																	<div class="col-sm-6">
																		<div class="form-group">
																			<label for="exampleInputName">Your Name <span
																					class="astk">*</span></label>
																			<input type="text" class="form-control txt"
																				id="exampleInputName" placeholder=""
																				name="name" required="required">
																		</div><!-- /.form-group -->
																		<div class="form-group">
																			<label for="exampleInputSummary">Summary <span
																					class="astk">*</span></label>
																			<input type="text" class="form-control txt"
																				id="exampleInputSummary" placeholder=""
																				name="summary" required="required">
																		</div><!-- /.form-group -->
																	</div>

																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="exampleInputReview">Review <span
																					class="astk">*</span></label>

																			<textarea class="form-control txt txt-review"
																				id="exampleInputReview" rows="4"
																				placeholder="" name="review"
																				required="required"></textarea>
																		</div><!-- /.form-group -->
																	</div>
																</div><!-- /.row -->

																<div class="action text-right">
																	<button name="submit"
																		class="btn btn-primary btn-upper">SUBMIT
																		REVIEW</button>
																</div><!-- /.action -->

												</form><!-- /.cnt-form -->
											</div><!-- /.form-container -->
										</div><!-- /.review-form -->

									</div><!-- /.product-add-review -->

								</div><!-- /.product-tab -->
							</div><!-- /.tab-pane -->



						</div><!-- /.tab-content -->
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.product-tabs -->

			<?php $cid = $row['category'];
			$subcid = $row['subCategory'];
				} ?>
		<!-- ============================================== UPSELL PRODUCTS ============================================== -->
		<section class="section featured-product wow fadeInUp">
			<h3 class="section-title">Realted Products </h3>
			<div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">

				<?php
				$rating = 0;
				$qry = mysqli_query($con, "select * from products where subCategory='$subcid' and category='$cid'");
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
					$rating = $rw['productRating'];
					?>


					<div class="item item-carousel">
						<div class="products">
							<div class="product">
								<div class="product-image" style="width: 100%; height: 300px; display: table;">
									<div class="image" style="display: table-cell; vertical-align: middle;">
										<a href="product-details.php?pid=<?php echo htmlentities($rw['id']); ?>"><img
												src="assets/images/blank.gif"
												data-echo="admin/productimages/<?php echo htmlentities($rw['id']); ?>/<?php echo htmlentities($rw['productImage1']); ?>"
												style="height: auto; max-width: 100%; max-height: 300px; object-fit: contain;"
												alt=""></a>
									</div><!-- /.image -->


								</div><!-- /.product-image -->


								<div class="product-info text-left">
									<h3 class="name"
										style="overflow: hidden; max-width: 100%; text-overflow: ellipsis; white-space: nowrap;">
										<a href="product-details.php?pid=<?php echo htmlentities($rw['id']); ?>"><?php echo htmlentities($rw['productName']); ?></a></h3>
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
											<?php echo htmlentities($rw['productPrice']); ?>
										</span>
										<span class="price-before-discount">₹ 
											<?php echo htmlentities($rw['productPriceBeforeDiscount']); ?>
										</span>

									</div><!-- /.product-price -->

								</div><!-- /.product-info -->
								<div class="cart clearfix animate-effect">
									<div class="action">
										<ul class="list-unstyled">
											<li class="add-cart-button btn-group">
												<?php if (($rw['productAvailability'] == 'Out of Stock') || ((intval($rw['prod_avail']) == 0) && (intval($rw['allow_ao']) != 1))) { ?>
													<div class="action" style="color:red">Out of Stock
													</div>
												<?php } else { ?>
													<a id="CartList" onclick="CartList('<?php $rw['id']; ?>')"
														class="lnk btn btn-primary btn-upper"><i
															class="fa fa-shopping-cart inner-right-vs"></i> &nbsp; Add to Cart</a>
												<?php } ?>
											</li>
											<li class="lnk wishlist">
												<a class="add-to-cart" onclick="WishList('<?php echo $rw['id']; ?>')"
													title="Wishlist">
													<i class="icon fa fa-heart"></i>
												</a>
											</li>

										</ul>
									</div><!-- /.action -->
								</div><!-- /.cart -->
							</div><!-- /.product -->

						</div><!-- /.products -->
					</div><!-- /.item -->
				<?php } ?>


			</div><!-- /.home-owl-carousel -->
		</section><!-- /.section -->


		<!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

	</div><!-- /.col -->
	<div class="clearfix"></div>
	</div>

	</div>
	</div>
	<?php include('includes/footer.php'); ?>
	<!-- For demo purposes – can be removed on production : End -->
	<script>
		
		$('#add-quantity').click(function (e) {
			e.preventDefault();
			jQuery.ajax({
				url: "cart-quantity.php",
				data: {pId: <?=$pid?>, pQuantity: $('#pQuantity').val()},
				type: "POST",
				success: function (data) {
					$("#ack").html(data);
				},
				error: function () { }
			});
		});

	</script>
	<style>
		.owl-item {
			width: 360px;
		}
	</style>