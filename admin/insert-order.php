<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$uid = intval($_GET['id']); // product id
	if (isset($_POST['submit'])) {
		$productIds = $_POST['productId'];
		$table = $_POST['table'];
		$quantity = $_POST['quantity'];
		$amount = $_POST['amount'];
		$dateTime = date("Y-m-d H:i:s", strtotime($_POST["dateTime"]));
		$remarks = $_POST['remarks'];

        date_default_timezone_set("Asia/Kolkata");
		$orderId = "OID_".$uid."_".date("ymdHis");

        $ictr=0;
        foreach($productIds as $productId) {
            if($table[$ictr] == "combo")
                mysqli_query($con, "INSERT INTO orders (`userId`,`comboId`,`quantity`,`price`,`dtSupply`,`remarks`,`paymentMethod`,`orderId`,`orderBy`) VALUES ('$uid','$productId','$quantity[$ictr]','$amount[$ictr]','$dateTime','$remarks','ADMIN','$orderId','Admin')");
            else
                mysqli_query($con, "INSERT INTO orders (`userId`,`productId`,`quantity`,`price`,`dtSupply`,`remarks`,`paymentMethod`,`orderId`,`orderBy`) VALUES ('$uid','$productId','$quantity[$ictr]','$amount[$ictr]','$dateTime','$remarks','ADMIN','$orderId','Admin')");
            $ictr++;
        }
		
		header("Location: pending-orders.php");
        exit;
	}


	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | Insert Order</title>
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
					$actmenu = "pending";
					include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
                                    <b>Insert Order</b>
                                    <!-- <span style="float: right">
                                        <div class="controls">
                                            <a href="insert-combo.php" class="btn">Add Order</a>
                                        </div>
                                    </span> -->
								</div>
								<div class="module-body">

									<?php if (isset($_POST['submit'])) { ?>
										<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Well done!</strong>
											<?php echo htmlentities($_SESSION['msg']); ?>
											<?php echo htmlentities($_SESSION['msg'] = ""); ?>
										</div>
									<?php } ?>


									<?php if (isset($_GET['del'])) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo htmlentities($_SESSION['delmsg']); ?>
											<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>

									<br />

									<form class="form-horizontal row-fluid" name="insertproduct" method="post"
										enctype="multipart/form-data">

										<div id="prodErr"></div>
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
                                                    <th><a id="addProduct"><i class="icon-plus-sign-alt"></i></a></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tblBody">
                                                <tr>
                                                    <td class="slNo">1</td>
                                                    <td>
                                                        <select name="productId[]" class="productId span8 tip" required>
                                                            <option value="" selected disabled>Select</option>
                                                            <?php $query = mysqli_query($con, "select products.* from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory");
                                                            while ($row = mysqli_fetch_array($query)) { 
                                                                if(($row['productAvailability'] == 'Against Order') || (($row['productAvailability'] == 'In Stock') && ((intval($row['prod_avail']) > 0) || ((intval($row['prod_avail']) == 0) && (intval($row['allow_ao']) == 1))))) { ?>
                                                                <option price="<?php echo $row['productPrice']; ?>" table="products" value="<?php echo $row['id']; ?>">
                                                                    <?php echo $row['productName']; ?>
                                                                </option>
                                                            <?php } }
                                                            
                                                            $query1 = mysqli_query($con, "select * from combo");
                                                            while ($row1 = mysqli_fetch_array($query1)) { 
                                                                if(($row1['comboAvailability'] == 'Against Order') || (($row1['comboAvailability'] == 'In Stock'))) { ?>
                                                                <option price="<?php echo $row1['comboPrice']; ?>" table="combo" value="<?php echo $row1['id']; ?>">
                                                                    <?php echo $row1['comboName']; ?>
                                                                </option>
                                                            <?php } } ?>
                                                        </select>
                                                    </td>
                                                    <td><label style="font-weight: bold;" class="price"></label><input type="hidden" name="table[]" class="frmTbl"></td>
                                                    <td><input type="text"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    name="quantity[]" placeholder="Enter Quantity"
                                                    class="quantity span8 tip" required></td>
                                                    <td><input type="text"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    name="amount[]" placeholder="Enter Amount" onblur="calTotAmt()"
                                                    class="amount span8 tip" required></td>
                                                    <td><a class="remove"><i
                                                                class="icon-remove-sign"></i></a></td>
                                                </tr>
                                                <tr style="display: none;" id="prodRow">
                                                    <td>
                                                        <select name="productId[]" class="productId span8 tip"  onchange="pushPrice(this, this.options[this.selectedIndex].getAttribute('price'), this.options[this.selectedIndex].getAttribute('table'))">
                                                            <option value="" selected disabled>Select</option>
                                                            <?php $query = mysqli_query($con, "select products.* from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory");
                                                            while ($row = mysqli_fetch_array($query)) { 
                                                                if(($row['productAvailability'] == 'Against Order') || (($row['productAvailability'] == 'In Stock') && ((intval($row['prod_avail']) > 0) || ((intval($row['prod_avail']) == 0) && (intval($row['allow_ao']) == 1))))) { ?>
                                                                <option price="<?php echo $row['productPrice']; ?>" table="products" value="<?php echo $row['id']; ?>">
                                                                    <?php echo $row['productName']; ?>
                                                                </option>
                                                            <?php } } 
                                                            
                                                            $query1 = mysqli_query($con, "select * from combo");
                                                            while ($row1 = mysqli_fetch_array($query1)) { 
                                                                if(($row1['comboAvailability'] == 'Against Order') || (($row1['comboAvailability'] == 'In Stock'))) { ?>
                                                                <option price="<?php echo $row1['comboPrice']; ?>" table="combo" value="<?php echo $row1['id']; ?>">
                                                                    <?php echo $row1['comboName']; ?>
                                                                </option>
                                                            <?php } } ?>
                                                        </select>
                                                    </td>
                                                    <td><label style="font-weight: bold;" class="price"></label><input type="hidden" name="table[]" class="frmTbl"></td>
                                                    <td><input type="text" onkeyup="calAmount(this)"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    name="quantity[]" placeholder="Enter Quantity"
                                                    class="quantity span8 tip"></td>
                                                    <td><input type="text"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    name="amount[]" placeholder="Enter Amount" onblur="calTotAmt()"
                                                    class="amount span8 tip"></td>
                                                    <td><a class="remove"><i
                                                                class="icon-remove-sign"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table cellpadding="0" cellspacing="0" border="0"
                                        class="table"
                                        style="width:100%;padding:5px;">
                                            <tbody>
                                                <tr>
                                                    <td><input type="datetime-local" required name="dateTime" placeholder="Choose date and time"
                                                    class="span8 tip" step="any" min="<?= date('Y-m-d', strtotime('tomorrow'))."T".date('H:i:s'); ?>"></td>
                                                    <td><input type="text" name="remarks" placeholder="Enter remarks if any"
                                                    class="span8 tip"></td>
                                                    <td><div style="font-weight: bold;">Total Amount ₹<span id="totAmt">0.00</span></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br/>
										<div class="control-group">
											<div class="controls">
												<input class="btn btn-primary" type="button" value="Back"
													onclick="window.location.href = 'check-contact.php'" />
												<button type="submit" name="submit" class="btn btn-ri">Add Order</button>
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

		<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
		<script>
            let number = 2; 
            $(".productId").on('change',function() {
                let price = $('option:selected', this).attr('price');
                let table = $('option:selected', this).attr('table');
                pushPrice(this, price, table);
            });
            $(document).on('click','.remove',function(){
                $(this).parents('tr').remove();
                number--;
                let incrSlNo=$('#tblBody').children().find(".slNo");
                //console.log(incrSlNo.length);
                for (let j = 0; j < incrSlNo.length; j++) {
                    $(incrSlNo[j]).html(j+1);
                }
            });
            $("#addProduct").click(function(){
                let validInd = 0;
                let todoSelects=$('#tblBody').children().find("select");
                let todoInputs=$('#tblBody').children().find("input");
                for (let k = 0; k < todoSelects.length-1; k++) {
                    if((!($(todoSelects[k]).val())) || (!($(todoInputs[k]).val())))
                        validInd = 1;
                    else
                        validInd = 0;
                }
                if(validInd == 1)
                {
                    $("#prodErr").html("<div class='alert alert-error'><strong>Attention!</strong> Please fill below Mandatory (*) fields.</div>");
                    $("#prodErr").fadeTo(5000, 500).slideUp(500, function(){
                        $("#prodErr").slideUp(500);
                    });
                } else {
                    for (let j = 0; j < todoSelects.length; j++) {
                        //console.log($(todoSelects[j]).val());
                        $("#prodRow").find("select option[value='"+$(todoSelects[j]).val()+"']").remove();
                    }
                    let todoValue = $("#prodRow").html();
                    $("#prodRow").before("<tr><td class='slNo'>"+`${number++}`+"</td>" + todoValue + "</tr>");
                }
            });
            function pushPrice(ele, val, tbl) {
                $(ele).parents('tr').children().find(".price").html(val);
                $(ele).parents('tr').children().find(".frmTbl").val(tbl);
                let quantity = $(ele).parents('tr').children().find(".quantity").val();
                let calAmt = parseInt(quantity * val);
                $(ele).parents('tr').children().find(".amount").val(calAmt);
                calTotAmt();
            }
            $(".quantity").on('input',function() {   
                let quantity = $(this).val();
                let price = $(this).parents('tr').children().find(".price").html();
                let calAmt = parseInt(quantity * price);
                $(this).parents('tr').children().find(".amount").val(calAmt);       
                //calAmount(this);
                calTotAmt();
            });
            function calAmount(ele) {
                let quantity = $(ele).val();
                let price = $(ele).parents('tr').children().find(".price").html();
                let calAmt = parseInt(quantity * price);
                $(ele).parents('tr').children().find(".amount").val(calAmt);
                calTotAmt();
            }
            function calTotAmt() {
                let amountInp=$('#tblBody').children().find(".amount");
                let totAmt = 0;
                for (let j = 0; j < amountInp.length-1; j++) {
                    let amount = parseInt($(amountInp[j]).val());
                    totAmt = Math.round(totAmt + amount);
                }
                $('#totAmt').html(totAmt);
            }
		</script>
	</body>
<?php } ?>