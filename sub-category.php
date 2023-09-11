
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="icon" type="image/x-icon" href="./img/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
	    <meta name="keywords" content="MediaCenter, Template, eCommerce">
	    <meta name="robots" content="all">

	    <title>Product Category</title>

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
		<!-- Demo Purpose Only. Should be removed in production : END -->

		
		<!-- Icons/Glyphs -->
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!-- Fonts --> 
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		
		<!-- Favicon -->
		

		<!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<?php include('userStyle.php');?>
	</head>
    <body class="cnt-home">
	<?php
session_start();
error_reporting(0);
include('includes/config.php');
$cid=intval($_GET['scid']);
if(isset($_GET['action']) && $_GET['action']=="add"){
	/*$id=intval($_GET['id']);
	if(isset($_SESSION['cart'][$id])){?>
		<script>
			Swal.fire({
				title: 'Product Already in Cart!',
				text: 'Do you want to proceed?',
				icon: 'info',
				showCancelButton: true,
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = 'my-cart.php?qi_id=<?php echo $id; ?>';
				}
			});
		</script>
		<?php 
	}else{
		$sql_p="SELECT * FROM products WHERE id={$id}";
		$query_p=mysqli_query($con,$sql_p);
		if(mysqli_num_rows($query_p)!=0){
			$row_p=mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
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
										document.location = 'my-cart.php';
									}
								});
							</script>";
		}else{
			$message="Product ID is invalid";
		}
	}*/
}
// COde for Wishlist
$pid=intval($_GET['pid']);
if(isset($_GET['action']) && $_GET['action']=="wishlist" ){
	/*if(strlen($_SESSION['login'])==0)
    {   
header('location:login.php');
}
else
{
mysqli_query($con,"insert into wishlist(userId,productId) values('".$_SESSION['id']."','".$pid."')");
echo "<script>
Swal.fire({
	title: 'Product Added!',
	text: 'Product added in wishlist.',
	icon: 'success',
	showCancelButton: true,
	confirmButtonText: 'Go to Wishlist',
	cancelButtonText: 'Continue Shopping'
}).then((result) => {
	if (result.isConfirmed) {
		document.location = 'my-wishlist.php';
	}
});
</script>";

}*/
}
?>	
<header class="header-style-1">

	<!-- ============================================== TOP MENU ============================================== -->
<?php include('includes/top-header.php');?>
<!-- ============================================== TOP MENU : END ============================================== -->
<?php include('includes/main-header.php');?>
	<!-- ============================================== NAVBAR ============================================== -->
<?php //include('includes/menu-bar.php');?>
<!-- ============================================== NAVBAR : END ============================================== -->

</header>
<!-- ============================================== HEADER : END ============================================== -->
</div><!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
	<div class='container'>
		<div class='row outer-bottom-sm'>
			<div class='col-md-3 sidebar'>
	            <!-- ================================== TOP NAVIGATION ================================== -->
<!-- ================================== TOP NAVIGATION : END ================================== -->	            <div class="sidebar-module-container">
	            	<h3 class="section-title">shop by</h3>
	            	<div class="sidebar-filter">
		            	<!-- ============================================== SIDEBAR CATEGORY ============================================== -->
<div class="sidebar-widget wow fadeInUp outer-bottom-xs ">
	<div class="widget-header m-t-20">
		<h4 class="widget-title">Category</h4>
	</div>
	<div class="sidebar-widget-body m-t-10" style="max-height:215px;overflow:auto">
	         <?php $sql=mysqli_query($con,"select id,categoryName  from category");
while($row=mysqli_fetch_array($sql))
{
    ?>
		<div class="accordion">
	    	<div class="accordion-group">
	            <div class="accordion-heading">
	                <a href="category.php?cid=<?php echo $row['id'];?>"  class="accordion-toggle collapsed">
	                   <?php echo $row['categoryName'];?>
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
				<img src="assets/images/banners/cat-banner-2.jpg" alt="" class="img-responsive">
			</div>
			<div class="container-fluid">
				<div class="caption vertical-top text-left">
					<div class="big-text">
						<br />
					</div>

					       <?php $sql=mysqli_query($con,"select subcategory  from subcategory where id='$cid'");
while($row=mysqli_fetch_array($sql))
{
    ?>

					<div class="excerpt hidden-sm hidden-md">
						<?php echo htmlentities($row['subcategory']);?>
					</div>
			<?php } ?>
			
				</div><!-- /.caption -->
			</div><!-- /.container-fluid -->
		</div>
</div>

				<div class="search-result-container">
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane active " id="grid-container">
							<div class="category-product  inner-top-vs">		
			<?php
$ret=mysqli_query($con,"select * from products where subCategory='$cid'");
$num=mysqli_num_rows($ret);
if($num>0)
{
$ictr = 0;
$rating = 0;
while ($row=mysqli_fetch_array($ret)) 
{
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
	if ($ictr == 0)
		echo "<div class='row'>";
	else if($ictr % 3 == 0)
		echo "</div><div class='row'>"; ?>							
		<div class="col-sm-4 col-md-4 wow fadeInUp">
			<div class="products">				
	<div class="product text-center">		
		<div class="product-image" style="width: 100%; height: 300px; display: table;">
			<div class="image" style="display: table-cell; vertical-align: middle;">
				<a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><img  src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="" style="height: auto; max-width: 100%; max-height: 300px; object-fit: contain;"></a>
			</div><!-- /.image -->			                      		   
		</div><!-- /.product-image -->
			
		
		<div class="product-info">
			<h3 class="name" style="overflow: hidden; max-width: 100%; text-overflow: ellipsis; white-space: nowrap;"><a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
			<?php 
			for($jctr = 0; $jctr < 5; $jctr++)
			{
				if($jctr < $rating)
					echo '<span class="fa fa-star rate-checked"></span>';
				else
					echo '<span class="fa fa-star"></span>';
			}
			?>
			<div class="description"></div>

			<div class="product-price">	
				<span class="price">
					Rs. <?php echo htmlentities($row['productPrice']);?>			</span>
										     <span class="price-before-discount">Rs. <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
									
			</div><!-- /.product-price -->
			
		</div><!-- /.product-info -->
					<div id="ack"></div>
				<div class="cart clearfix animate-effect">
				<div class="action">
					<ul class="list-unstyled">
						<li class="add-cart-button btn-group">
						<?php if($row['productAvailability']=='In Stock'){?>
										
							<a onclick="CartList('<?php echo $row['id']; ?>')">
							<button class="btn btn-primary" type="button"><i class="fa fa-shopping-cart"></i> &nbsp; Add to cart</button></a>
								<?php } else {?>
							<div class="action" style="color:red">Out of Stock</div>
					<?php } ?>
													
						</li>
	                   
		                <li class="lnk wishlist">
							<a class="add-to-cart" onclick="WishList('<?php echo $row['id']; ?>')" title="Wishlist">
								 <i class="icon fa fa-heart"></i>
							</a>
						</li>

						
					</ul>
				</div><!-- /.action -->
			</div><!-- /.cart -->
			</div>
			</div>
	  <?php 
		if ($num == $ictr+1) {
			echo "</div>
			</div>";
		}
		else
			echo "</div>";
		$ictr++;
	} } else {?>
	
		<div class="col-sm-6 col-md-4 wow fadeInUp"> <h3>No Product Found</h3>
		</div>
		
<?php } ?>	
		
	
		
		
	
		
	
		
	
		
										</div><!-- /.row -->
							</div><!-- /.category-product -->
						
						</div><!-- /.tab-pane -->
						
				

				</div><!-- /.search-result-container -->

			</div><!-- /.col -->
		</div></div>
		

</div>
</div>
<?php include('includes/footer.php');?>
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
	
	<!-- <script src="switchstylesheet/switchstylesheet.js"></script> -->
	
	<script>
		/*$(document).ready(function(){ 
			$(".changecolor").switchstylesheet( { seperator:"color"} );
			$('.show-theme-options').click(function(){
				$(this).parent().toggleClass('open');
				return false;
			});
		});

		$(window).bind("load", function() {
		   $('.show-theme-options').delay(2000).trigger('click');
		});*/
		
		function WishList(ele){
			var session_id = <?php echo intval($_SESSION['id']); ?>;

			if (session_id) {

				jQuery.ajax({
				url: "add-to-wishlist.php",
				data: { session_id: session_id, product_id: ele },
				type: "POST",
				success:function(data){
					$("#ack").html(data);
				},
				error:function (){}
				});
			} else {
				document.location = 'login.php';
			}
		}

		function CartList(ele){
			jQuery.ajax({
			url: "add-to-cart.php",
			data: { product_id: ele },
			type: "POST",
			success:function(data){
				$("#ack").html(data);
			},
			error:function (){}
			});
		}
	</script>
	<!-- For demo purposes – can be removed on production : End -->

	

</body>
</html>