<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	header('location:login.php');
} else {
	include('includes/header.php');
	if (isset($_POST['submit'])) {

		mysqli_query($con, "update orders set 	paymentMethod='" . $_POST['paymethod'] . "' where userId='" . $_SESSION['id'] . "' and paymentMethod is null ");
		mysqli_query($con, "DELETE FROM cart WHERE userId='" . $_SESSION['id'] . "'");
		unset($_SESSION['cart']);
		echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Your order has been successfully submitted!',
            icon: 'success',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location = 'order-history.php';
            }
        });
    	</script>";
	}
	?>
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="home.html">Home</a></li>
					<li class='active'>Payment Method</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->

	<div class="body-content outer-top-bd">
		<div class="container">
			<div class="checkout-box faq-page inner-bottom-sm">
				<div class="row">
					<div class="col-md-12">
						<h2>Choose Payment Method</h2>
						<div class="panel-group checkout-steps" id="accordion">
							<!-- checkout-step-01  -->
							<div class="panel panel-default checkout-step-01">

								<!-- panel-heading -->
								<div class="panel-heading">
									<h4 class="unicase-checkout-title">
										<a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
											Select your Payment Method
										</a>
									</h4>
								</div>
								<!-- panel-heading -->

								<div id="collapseOne" class="panel-collapse collapse in">

									<!-- panel-body  -->
									<div class="panel-body">
										<form name="payment" method="post">
											<input type="radio" name="paymethod" value="COD" checked="checked"> COD &nbsp;
											<input type="radio" name="paymethod" value="Internet Banking" disabled> Internet Banking &nbsp;
											<input type="radio" name="paymethod" value="Debit / Credit card" disabled> Debit / Credit
											card <br /><br />
											<input type="submit" value="submit" name="submit" class="btn btn-primary">


										</form>
									</div>
									<!-- panel-body  -->

								</div><!-- row -->
							</div>
							<!-- checkout-step-01  -->


						</div><!-- /.checkout-steps -->
					</div>
				</div><!-- /.row -->
			</div><!-- /.checkout-box -->
			<!-- ============================================== BRANDS CAROUSEL ============================================== -->

			<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
		</div><!-- /.container -->
	</div><!-- /.body-content -->
	<div id="ack"></div>
	<?php include('includes/footer.php'); ?>
<?php } ?>