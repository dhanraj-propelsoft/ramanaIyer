<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$oid = trim($_GET['oid']);
	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | View OrderWise</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='css/opensans.css' rel='stylesheet'>
		<script src="assets/js/nicEdit-latest.js" type="text/javascript"></script>
		<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

	</head>

	<body>
		<?php include('include/header.php'); ?>

		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php
					$actmenu = "orderwise";
					include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
                                    <b>View OrderWise</b>
                                    <!-- <span style="float: right">
                                        <div class="controls">
                                            <a href="insert-combo.php" class="btn">Add Order</a>
                                        </div>
                                    </span> -->
								</div>
								<div class="module-body">

									<form class="form-horizontal row-fluid" name="vieworder" method="post"
										enctype="multipart/form-data">

										<div id="prodErr"></div>
                                        <?php 
                                        $dtSupply = '';
                                        $remarks = '';
                                        $cnt = 1;
                                        $totAmt = 0;
                                        ?>
                                        <table id="tblProd" cellpadding="0" cellspacing="0" border="0"
                                        class="table table-striped"
                                        style="width:100%;padding:5px;">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Item <span style="color: red">*</span></th>
                                                    <th width="100">Unit per Price <span style="color: red">*</span></th>
                                                    <th>No of Packs <span style="color: red">*</span></th>
                                                    <th>Amount <span style="color: red">*</span></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tblBody">
                                                <?php 
                                                $query = mysqli_query($con, "select orders.quantity AS oQuantity,orders.price AS oPrice,orders.dtSupply AS oDtSupply,orders.remarks AS oRemarks,products.productName AS pName,products.productPrice AS pPrice from orders JOIN products WHERE products.id=orders.productId AND orders.orderId='".$oid."'");
                                                $amount = 0;
                                                while ($row = mysqli_fetch_array($query)) { 
                                                    $dtSupply = $row['oDtSupply'];
                                                    $remarks = $row['oRemarks'];
                                                    if(intval($row['oPrice']) > 0) {
                                                        $totAmt += intval($row['oPrice']);
                                                        $amount = $row['oPrice'];
                                                    } else {
                                                        $totAmt += intval($row['pPrice']);
                                                        $amount = $row['pPrice'];
                                                    }
                                                    ?>
                                                <tr>
                                                    <td><?=$cnt?></td>
                                                    <td><label style="font-weight: bold;"><?=$row['pName']; ?></label></td>
                                                    <td><label style="font-weight: bold;"><?=$row['pPrice']; ?></label></td>
                                                    <td><label style="font-weight: bold;"><?=$row['oQuantity']; ?></label></td>
                                                    <td><label style="font-weight: bold;"><?=$amount; ?></label></td>
                                                </tr>
                                                <?php 
                                                $cnt++;
                                                }
                                                $query1 = mysqli_query($con, "select orders.quantity AS oQuantity,orders.price AS oPrice,orders.dtSupply AS oDtSupply,orders.remarks AS oRemarks,combo.comboName AS cName,combo.comboPrice AS cPrice from orders JOIN combo WHERE combo.id=orders.comboId AND orders.orderId='".$oid."'");
                                                while ($row1 = mysqli_fetch_array($query1)) { 
                                                    $dtSupply = $row1['oDtSupply'];
                                                    $remarks = $row1['oRemarks'];
                                                    if(intval($row1['oPrice']) > 0) {
                                                        $totAmt += intval($row1['oPrice']);
                                                        $amount = $row1['oPrice'];
                                                    } else {
                                                        $totAmt += intval($row1['cPrice']);
                                                        $amount = $row1['cPrice'];
                                                    }
                                                    ?>
                                                <tr>
                                                    <td><?=$cnt?></td>
                                                    <td><label style="font-weight: bold;"><?=$row1['cName']; ?></label></td>
                                                    <td><label style="font-weight: bold;"><?=$row1['cPrice']; ?></label></td>
                                                    <td><label style="font-weight: bold;"><?=$row1['oQuantity']; ?></label></td>
                                                    <td><label style="font-weight: bold;"><?=$amount; ?></label></td>
                                                </tr>
                                                <?php 
                                                $cnt++;
                                                } ?>
                                                
                                            </tbody>
                                        </table>
                                        <table cellpadding="0" cellspacing="0" border="0"
                                        class="table"
                                        style="width:100%;padding:5px;">
                                            <tbody>
                                                <tr>
                                                    <td><label style="font-weight: bold;">Delivery Date & Time - <?php if(!empty($dtSupply)) { echo htmlentities(date('d-m-Y h:i:s A', strtotime($dtSupply))); } ?></label></td>
                                                    <td><input type="text" name="remarks" readonly placeholder="Remarks" value="<?=$remarks?>"
                                                    class="span8 tip"></td>
                                                    <td><label style="font-weight: bold;">Total Amount ₹<span id="totAmt"><?=$totAmt;?></span></label></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br/>
										<div class="control-group">
											<div class="controls" style="float:left">
												<input class="btn btn-primary" type="button" value="Back"
													onclick="window.location.href = 'orderwise.php'" />
											</div>
										</div>
									</form>
								</div>
							</div>





						</div><!--/.content-->
					</div><!--/.span9-->
				</div>
			</div><!--/.container-->
		</div><!--/.wrapper-->

		<?php include('include/footer.php'); ?>
	</body>
<?php } ?>