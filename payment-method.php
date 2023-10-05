<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	header('location:login.php');
} else {
	include('includes/header.php');
	if (isset($_POST['submit'])) {
		//echo "<script>$('#loaderIcon').css('visibility', 'visible'); $('#loaderIcon').show();</script>";
		$prodid = array();
        $prodQt = array();
        if (!empty($_SESSION['cart'])) {
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

                    array_push($prodid, $row['id']);
                    array_push($prodQt, $quantity);
                }
            }
            // $_SESSION['pid'] = $prodid;
            // $_SESSION['prodQt'] = $prodQt;
        }

        $value = array_combine($prodid, $prodQt);

		mysqli_query($con, "DELETE FROM orders WHERE userId='" . $_SESSION['id'] . "' AND paymentId IS NULL");

		if($_POST['paymethod'] == "COD")
		{
			
			foreach ($value as $qty => $val34) {
				mysqli_query($con, "insert into orders(userId,productId,quantity,paymentMethod,paymentId) values('" . $_SESSION['id'] . "','$qty','$val34','".$_POST['paymethod']."','".$_POST['paymethod']."')");
			}
	
			mysqli_query($con, "DELETE FROM cart WHERE userId='" . $_SESSION['id'] . "'");
			unset($_SESSION['cart']);

			$cust_adrs = "";
            $query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
            if ($row2 = mysqli_fetch_array($query)) {
                $cust_adrs = $row2['shippingAddress'].", ".$row2['shippingState'].", ".$row2['shippingCity'].", ".$row2['shippingPincode'];
            }

			echo "<script>
			Swal.fire({
				title: 'Success!',
				text: 'Your order has been received by Ramana Sweets. Your sweets will be delivered to mentioned shipping address! ($cust_adrs)',
				icon: 'success',
				confirmButtonText: 'Ok'
			}).then((result) => {
				if (result.isConfirmed) {
					document.location = 'order-history.php';
				}
			});
			</script>";
		} else {

			date_default_timezone_set("Asia/Kolkata");
			$receiptNo = $_SESSION['id']."_".date("YmdHis");
			
			$_SESSION['receiptNo']=$receiptNo;

			foreach ($value as $qty => $val34) {
				mysqli_query($con, "insert into orders(userId,productId,quantity,paymentMethod,receiptNo) values('" . $_SESSION['id'] . "','$qty','$val34','".$_POST['paymethod']."','$receiptNo')");
			}
			//echo "<script>$('#loaderIcon').css('visibility', 'hidden'); $('#loaderIcon').hide();</script>";
			echo "<script>window.location.href = 'pg-redirect.php';</script>";
		}
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

								<div id="collapseOne" class="panel-collapse collapse in">

									<!-- panel-body  -->
									<div class="panel-body" align="center">
										<form name="payment" method="post">
											<input type="radio" name="paymethod" value="COD" checked="checked"> COD &nbsp;
											<input type="radio" name="paymethod" value="PREPAID"> UPI / Internet Banking / Debit Card / Credit Card / Wallet<br /><br />
											<input type="submit" value="SUBMIT" name="submit" class="btn btn-primary">
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