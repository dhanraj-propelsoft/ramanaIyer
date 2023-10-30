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
				<li class='active'>Track your orders</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-bd">
	<div class="container">
		<div class="track-order-page inner-bottom-sm">
			<div class="row">
				<div class="col-md-12">
					<h2>Track your Order</h2>
					<span class="title-tag inner-top-vs">Please enter your Order ID in the box below and press Enter.
						This was given to you on your receipt and in the confirmation email you should have received.
					</span>
					<form class="register-form outer-top-xs" role="form" method="post" action="order-details.php">
						<div class="form-group">
							<label class="info-title" for="exampleOrderId1">Order ID</label>
							<input type="text" class="form-control unicase-form-control text-input" name="orderid"
								id="exampleOrderId1">
						</div>
						<div class="form-group">
							<label class="info-title" for="exampleBillingEmail1">Registered Email</label>
							<input type="email" class="form-control unicase-form-control text-input" name="email"
								id="exampleBillingEmail1">
						</div>
						<button type="submit" name="submit"
							class="btn-upper btn btn-primary checkout-page-button">Track</button>
					</form>
				</div>
			</div><!-- /.row -->
		</div><!-- /.sigin-in-->
		<!-- ============================================== BRANDS CAROUSEL ============================================== -->


	</div>
</div>
<?php include('includes/footer.php'); ?>