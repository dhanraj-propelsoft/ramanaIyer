<?php
session_start();
error_reporting(0);
include('includes/config.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="MediaCenter, Template, eCommerce">
	<meta name="robots" content="all">

	<title>Ramana Iyer Home Page</title>

	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Customizable CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/green.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/owl.transitions.css">
	<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
	<link href="assets/css/lightbox.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/rateit.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
	<!-- Demo Purpose Only. Should be removed in production -->
	<link rel="stylesheet" href="assets/css/config.css">

	<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
	<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
	<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
	<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
	<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">


    <!-- Other meta tags, styles, and scripts -->
	<?php include('userStyle.php');?>
</head>


<body class="cnt-home">



	<!-- ============================================== HEADER ============================================== -->
	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>

	<!-- ============================================== HEADER : END ============================================== -->
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
									<div class="item" style="background-image: url(assets/images/sliders/slider1.png);">
										<!-- /.container-fluid -->
									</div><!-- /.item -->
								</div><!-- /.full-width-slider -->

								<div class="full-width-slider">
									<div class="item full-width-slider" style="background-image: url(assets/images/sliders/slider2.png);">
									</div><!-- /.item -->
								</div><!-- /.full-width-slider -->

							</div><!-- /.owl-carousel -->
						</div>

						<!-- ========================================= SECTION – HERO : END ========================================= -->
						<!-- ============================================== INFO BOXES ============================================== -->
						<div class="info-boxes wow fadeInUp">
							<div class="info-boxes-inner">
								<div class="row">
									<div class="col-md-6 col-sm-4 col-lg-4">
										<div class="info-box">
											<div class="row">
												<div class="col-xs-2">
													<i class="icon fa fa-dollar"></i>
												</div>
												<div class="col-xs-10">
													<h4 class="info-box-heading green">money back</h4>
												</div>
											</div>
											<h6 class="text">30 Day Money Back Guarantee.</h6>
										</div>
									</div><!-- .col -->

									<div class="hidden-md col-sm-4 col-lg-4">
										<div class="info-box">
											<div class="row">
												<div class="col-xs-2">
													<i class="icon fa fa-truck"></i>
												</div>
												<div class="col-xs-10">
													<h4 class="info-box-heading orange">free shipping</h4>
												</div>
											</div>
											<h6 class="text">free ship-on oder over Rs. 600.00</h6>
										</div>
									</div><!-- .col -->

									<div class="col-md-6 col-sm-4 col-lg-4">
										<div class="info-box">
											<div class="row">
												<div class="col-xs-2">
													<i class="icon fa fa-gift"></i>
												</div>
												<div class="col-xs-10">
													<h4 class="info-box-heading red">Special Sale</h4>
												</div>
											</div>
											<h6 class="text">All items-sale up to 20% off </h6>
										</div>
									</div><!-- .col -->
								</div><!-- /.row -->
							</div><!-- /.info-boxes-inner -->

						</div><!-- /.info-boxes -->
						<!-- ============================================== INFO BOXES : END ============================================== -->
					</div><!-- /.homebanner-holder -->

				</div><!-- /.row -->


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
								<h3 class="section-title"><?php echo $row1['subcategory']; ?></h3>
								<div class="owl-carousel homepage-owl-carousel custom-carousel outer-top-xs owl-theme" data-item="2">
									<?php
									$ret = mysqli_query($con, "select * from products where category='" . $row1['categoryid'] . "' and subCategory='" . $row1['id'] . "'");
									while ($row = mysqli_fetch_array($ret)) {
									?>
										<div class="item item-carousel">
											<div class="products">
												<div class="product">
													<div class="product-image" style="width: 260px; height: 300px; display: table;">
														<div class="image" style="display: table-cell; vertical-align: middle;">
															<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img src="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['productImage1']); ?>"  style="width:auto; height: auto; max-width: 260px; max-height: 300px;"></a>
														</div><!-- /.image -->
													</div><!-- /.product-image -->
													<div class="product-info text-left">
														<h3 class="name" style="overflow: hidden; max-width: 278px; text-overflow: ellipsis; white-space: nowrap;"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['productName']); ?></a></h3>
														<div class="rating rateit-small"></div>
														<div class="description"></div>

														<div class="product-price">
															<span class="price">
																Rs. <?php echo htmlentities($row['productPrice']); ?> </span>
															<span class="price-before-discount">Rs.<?php echo htmlentities($row['productPriceBeforeDiscount']); ?></span>
														</div>
													</div>
													<?php if ($row['productAvailability'] == 'In Stock') { ?>
														<div class="action"><a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add to Cart</a></div>
													<?php } else { ?>
														<div class="action" style="color:red">Out of Stock</div>
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

			<script src="assets/js/jquery-1.11.1.min.js"></script>

			<script src="assets/js/bootstrap.min.js"></script>

			<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
			<script src="assets/js/owl.carousel.min.js"></script>

			<script src="assets/js/echo.min.js"></script>
			<script src="assets/js/jquery.easing-1.3.min.js"></script>
			<script src="assets/js/bootstrap-slider.min.js"></script>
			<script src="assets/js/jquery.rateit.min.js"></script>
			<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
			<script src="assets/js/bootstrap-select.min.js"></script>
			<script src="assets/js/wow.min.js"></script>
			<script src="assets/js/scripts.js"></script>

			<!-- For demo purposes – can be removed on production -->

			<script src="switchstylesheet/switchstylesheet.js"></script>

			<script>
				$(document).ready(function() {
					$(".changecolor").switchstylesheet({
						seperator: "color"
					});
					$('.show-theme-options').click(function() {
						$(this).parent().toggleClass('open');
						return false;
					});
				});

				$(window).bind("load", function() {
					$('.show-theme-options').delay(2000).trigger('click');
				});
			</script>
			<!-- For demo purposes – can be removed on production : End -->



</body>

</html>
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_GET['action']) && $_GET['action'] == "add") {
	$id = intval($_GET['id']);
	if (isset($_SESSION['cart'][$id])) {?>
		<script>
			Swal.fire({
				title: 'Product Already in Cart!',
				text: 'Do you want to proceed?',
				icon: 'info',
				showCancelButton: true,
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.isConfirmed) {
					<?php $_SESSION['cart'][$id]['quantity']++; ?>
					window.location.href = 'my-cart.php';
				}
			});
		</script>
		<?php 	
	} else {
		$sql_p = "SELECT * FROM products WHERE id={$id}";
		$query_p = mysqli_query($con, $sql_p);
		if (mysqli_num_rows($query_p) != 0) {
			$row_p = mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']] = array("quantity" => 1, "price" => $row_p['productPrice']);
		} else {
			$message = "Product ID is invalid";
		}

		echo "<script>
			Swal.fire({
				title: 'Product Added!',
				text: 'Product has been added to the cart.',
				icon: 'success',
				showCancelButton: true,
				confirmButtonText: 'Go to Cart',
				cancelButtonText: 'Continue Shopping'
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = 'my-cart.php';
				}
			});
		</script>";
	}
	
}


?>