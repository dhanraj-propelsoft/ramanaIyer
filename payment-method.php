<?php
session_start();
//error_reporting(0);
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

		$popupText = "";
		$totProd = 0;
		$errorInd = 0;

		if($_POST['paymethod'] == "COD")
		{
			date_default_timezone_set("Asia/Kolkata");
			$orderId = "OID_".$_SESSION['id']."_".date("ymdHis");

			$cust_adrs = "";
            $query = mysqli_query($con, "select * from users where id='" . $_SESSION['id'] . "'");
            if ($row2 = mysqli_fetch_array($query)) {
                $cust_adrs = $row2['shippingAddress'].", ".$row2['shippingState'].", ".$row2['shippingCity'].", ".$row2['shippingPincode'];
            }

			foreach ($value as $prodId => $quant) {
				$totProd++;
				$query3 = mysqli_query($con, "select productName,productAvailability,prod_avail,allow_ao from products where id='" . $prodId . "'");
				if ($row3 = mysqli_fetch_array($query3)) {
					$productName = $row3['productName'];
					$productAvailability = $row3['productAvailability'];
					$prod_avail = $row3['prod_avail'];
					$allow_ao = $row3['allow_ao'];

					if($productAvailability == "Out of Stock") {
						$popupText .= "<b>$productName - </b>Out of Stock!!!<BR/>";
						$errorInd--;
					} else if($productAvailability == "Against Order") {
						$popupText .= "<b>$productName - </b>Against Order!!!<BR/>";
						$errorInd--;
					} else if(($productAvailability == "In Stock") && ($prod_avail < $quant)) {
						if($allow_ao == '1') {
							$new_prod_avail = $prod_avail - $quant;
							if($new_prod_avail < 0)
								$new_prod_avail = 0;
							mysqli_query($con, "UPDATE products SET prod_avail='$new_prod_avail' WHERE id='" . $prodId . "'");
							$popupText .= "<b>$productName - </b>The ordered quantity will be placed Against the Order.<BR/>";
							unset($_SESSION['cart'][$prodId]);
							mysqli_query($con, "DELETE FROM cart WHERE userId='" . $_SESSION['id'] . "' AND pId = '" . $prodId . "");
							mysqli_query($con, "insert into orders(userId,productId,quantity,paymentMethod,paymentId,orderId,orderBy) values('" . $_SESSION['id'] . "','$prodId','$quant','".$_POST['paymethod']."','".$_POST['paymethod']."','$orderId','Customer')");
							$errorInd++;
						} else {
							$popupText .= "<b>$productName - </b>Place the order within the Available Quantity. <b>[Available Quantity - $prod_avail]</b><BR/>";
							$errorInd--;
						}
					} else if(($productAvailability == "In Stock") && ($prod_avail >= $quant)) {
						$popupText .= "<b>$productName - </b>Your order has been received by Ramana Sweets.<BR/>";
						$new_prod_avail = $prod_avail - $quant;
						mysqli_query($con, "UPDATE products SET prod_avail='$new_prod_avail' WHERE id='" . $prodId . "'");
						unset($_SESSION['cart'][$prodId]);
						mysqli_query($con, "DELETE FROM cart WHERE userId='" . $_SESSION['id'] . "' AND pId = '" . $prodId . "'");
						mysqli_query($con, "insert into orders(userId,productId,quantity,paymentMethod,paymentId,orderId,orderBy) values('" . $_SESSION['id'] . "','$prodId','$quant','".$_POST['paymethod']."','".$_POST['paymethod']."','$orderId','Customer')");
						$errorInd++;
					}
				}
			}

			if($totProd == $errorInd)
			{
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
				
			} else
			{
				echo "<script>
				Swal.fire({
					title: 'Information!',
					html: '$popupText',
					icon: 'info',
					confirmButtonText: 'Ok'
				}).then((result) => {
					if (result.isConfirmed) {
						document.location = 'my-cart.php';
					}
				});
				</script>";
			}
		} else {

			date_default_timezone_set("Asia/Kolkata");
			$orderId = "OID_".$_SESSION['id']."_".date("YmdHis");
			
			$_SESSION['receiptNo']=$orderId;

			foreach ($value as $qty => $val34) {
				mysqli_query($con, "insert into orders(userId,productId,quantity,paymentMethod,receiptNo,orderId,orderBy) values('" . $_SESSION['id'] . "','$qty','$val34','".$_POST['paymethod']."','$receiptNo','$orderId','Customer')");
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
											<input type="radio" name="paymethod" value="PREPAID" disabled> UPI / Internet Banking / Debit Card / Credit Card / Wallet<br /><br />
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