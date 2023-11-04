<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());


	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | Order Request</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='css/opensans.css' rel='stylesheet'>
		<link type="text/css" href="css/jquery.dataTables.min.css" rel="stylesheet">
		<link type="text/css" href="css/dataTables.dateTime.min.css" rel="stylesheet">
		<script src="assets\js\jspdf.min.js_1.5.3\cdnjs\jspdf.min.js"></script>
		<script src="assets\js\jspdf.plugin.autotable.min.js_3.5.6\cdnjs\jspdf.plugin.autotable.min.js"></script>
		<script language="javascript" type="text/javascript">
			var popUpWin = 0;
			function popUpWindow(URLStr, left, top, width, height) {
				if (popUpWin) {
					if (!popUpWin.closed) popUpWin.close();
				}
				popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
			}

		</script>
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
									<b>Order Request</b> 
									<span style="float: right">
                                        <div class="controls">
                                            <a href="check-contact.php" class="btn btn-ri">Add Order</a>
                                        </div>
                                    </span>
								</div>
								<div class="module-body table">
									<?php if (isset($_GET['del'])) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo htmlentities($_SESSION['delmsg']); ?>
											<?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
										</div>
									<?php } ?>

									<table class="table table-responsive" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td>Date Filter:</td>
												<td>
													<input type="text" id="min" name="min" placeholder="Choose Delivery Date">
												</td>
												<td><a class="btn btn-ri" onclick="window.location.reload();">Reset Filters</a></td>
												<td><button id="download-pdf-button" style="float:right" class="btn btn-ri">Download PDF</button></td>
											</tr>
										</tbody>
									</table>
									<table id="table-to-pdf" cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display table-responsive"
										style="width:100%;padding:5px;">
										<thead>
											<tr>
												<th>#</th>
												<th>Order Number</th>
												<th>Delivery Date & Time</th>
												<th>Customer Name</th>
												<th>Customer Mobile No / Email</th>
												<th>Shipping Address</th>
												<th>Product</th>
												<th>Quantity</th>
												<th>Order Date & Time</th>
												<th>Order by</th>
												<th>Action</th>

											</tr>
										</thead>

										<tbody>
											<?php
											$status = 'Delivered';
											$query = mysqli_query($con, "SELECT users.name as username,users.email as useremail,users.contactno as usercontact,users.shippingAddress as shippingaddress,users.shippingCity as shippingcity,users.shippingState as shippingstate,users.shippingPincode as shippingpincode,products.productName as productname,products.shippingCharge as shippingcharge,orders.quantity as quantity,orders.orderDate as orderdate,products.productPrice as productprice,orders.id as id,orders.orderId as orderId,orders.orderBy as orderBy,orders.dtSupply as dtSupply  from orders join users on  orders.userId=users.id join products on products.id=orders.productId where orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND (orders.orderStatus!='$status' OR orders.orderStatus IS NULL)");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												$oid = $row['orderId'];
												?>
												<tr style="cursor: pointer;" onclick="window.location.href = 'view-order.php?oid=<?=$oid?>'">
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row['orderId']); ?>
													</td>
													<td class="wrap_td_50">
														<?php 
														if(!empty($row['dtSupply'])) {
														echo date("d-m-Y h:i A", strtotime($row['dtSupply']));
														} ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row['username']); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row['useremail']); ?> /<BR/>
														<?php echo htmlentities($row['usercontact']); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row['shippingaddress'] . ", " . $row['shippingcity'] . ", " . $row['shippingstate'] . " - " . $row['shippingpincode']); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row['productname']); ?>
													</td>
													<td class="wrap_td_10">
														<?php echo htmlentities($row['quantity']); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo date("d-m-Y h:i A", strtotime($row['orderdate'])); ?>
													</td>
													<td>
														<?php echo htmlentities($row['orderBy']); ?>
													</td>
													<td>
													<a href="view-order.php?oid=<?=$oid?>"
															title="view order"><i class="icon-eye-open"></i></a>
													</td>
												</tr>

												<?php $cnt = $cnt + 1;
											}
											$query1 = mysqli_query($con, "SELECT users.name as username,users.email as useremail,users.contactno as usercontact,users.shippingAddress as shippingaddress,users.shippingCity as shippingcity,users.shippingState as shippingstate,users.shippingPincode as shippingpincode,combo.comboName as comboname,combo.shippingCharge as shippingcharge,orders.quantity as quantity,orders.orderDate as orderdate,combo.comboPrice as comboprice,orders.id as id,orders.orderId as orderId,orders.orderBy as orderBy,orders.dtSupply as dtSupply  from orders join users on  orders.userId=users.id join combo on combo.id=orders.comboId where orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND (orders.orderStatus!='$status' OR orders.orderStatus IS NULL)");
											while ($row1 = mysqli_fetch_array($query1)) {
												$oid = $row1['orderId'];
												?>
												<tr style="cursor: pointer;" onclick="window.location.href = 'view-order.php?oid=<?=$oid?>'">
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row1['orderId']); ?>
													</td>
													<td class="wrap_td_50">
														<?php 
														if(!empty($row1['dtSupply'])) {
														echo date("d-m-Y h:i A", strtotime($row1['dtSupply']));
														} ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row1['username']); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row1['useremail']); ?> /<BR/>
														<?php echo htmlentities($row1['usercontact']); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row1['shippingaddress'] . ", " . $row1['shippingcity'] . ", " . $row1['shippingstate'] . " - " . $row1['shippingpincode']); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo htmlentities($row1['comboname']); ?>
													</td>
													<td class="wrap_td_10">
														<?php echo htmlentities($row1['quantity']); ?>
													</td>
													<td class="wrap_td_50">
														<?php echo date("d-m-Y h:i A", strtotime($row1['orderdate'])); ?>
													</td>
													<td>
														<?php echo htmlentities($row1['orderBy']); ?>
													</td>
													<td>
													<a href="view-order.php?oid=<?=$oid?>"
															title="view order"><i class="icon-eye-open"></i></a>
													</td>
												</tr>

												<?php $cnt = $cnt + 1;
											} ?>
										</tbody>
									</table>
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
		<script src="scripts/datatables/jquery.dataTables.min.js"></script>
		<script src="scripts/moment.min.js"></script>
		<script src="scripts/datatables/dataTables.dateTime.min.js"></script>
		<script>
			$(document).ready(function () {
				$('.datatable-1').DataTable();
				
				let minDate;
				
				// Create date inputs
				minDate = new DateTime('#min', {
					format: 'MMMM Do YYYY'
				});
				
				$("#min").change(function(){
					DataTable.ext.search.push( function(settings, data, dataIndex) {
						let min = minDate.val();
						
						var newmin = moment(min).format("YYYY-MM-DD");

						var mydate = moment(data[2], 'DD-MM-YYYY'); 
						var newdate = moment(mydate).format("YYYY-MM-DD");
						
						if (newmin == newdate) {
							return true;
						}
						return false;
					});
					
					// DataTables initialisation
					let table = new DataTable('#table-to-pdf');

					table.draw();
				});
			});

			document.getElementById("download-pdf-button").addEventListener("click", () => {
				const table = document.getElementById("table-to-pdf");
				var doc = new jsPDF('l', 'pt', 'letter');

				const d = new Date();
				const pageSize = doc.internal.pageSize;
				const pageWidth = pageSize.width ? pageSize.width : pageSize.getWidth();
				const pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();

				doc.setFontSize(12);

				const filDate = 'Filtered Date - '+$("#min").val();

				if($("#min").val() != "")
					doc.text(pageWidth / 2 - (doc.getTextWidth(filDate) / 2), 45, filDate);

				// Convert the HTML table to PDF
				doc.autoTable({
					startY: 60,
					html: table, 
					columns: 
					[
						{header: 'header1', dataKey: 'dataKey1'},
						{header: 'header2', dataKey: 'dataKey2'},
						{header: 'header3', dataKey: 'dataKey3'},
						{header: 'header4', dataKey: 'dataKey4'},
						{header: 'header5', dataKey: 'dataKey5'},
						{header: 'header6', dataKey: 'dataKey6'},
						{header: 'header7', dataKey: 'dataKey7'},
						{header: 'header8', dataKey: 'dataKey8'},
						{header: 'header9', dataKey: 'dataKey9'},
						{header: 'header10', dataKey: 'dataKey10'}
					],
					headStyles:{ valign: 'middle', halign : 'center'},
					columnStyles: {
					0: {cellWidth: 20, valign: 'middle', halign: 'center'},
					1: {cellWidth: 80, valign: 'middle', halign: 'center'},
					2: {cellWidth: 60, valign: 'middle', halign: 'center'},
					3: {cellWidth: 90, valign: 'middle', halign: 'center'},
					4: {cellWidth: 120, valign: 'middle', halign: 'center'},
					5: {cellWidth: 140, valign: 'middle', halign: 'center'},
					6: {cellWidth: 60, valign: 'middle', halign: 'center'},
					7: {cellWidth: 30, valign: 'middle', halign: 'center'},
					8: {cellWidth: 60, valign: 'middle', halign: 'center'},
					9: {cellWidth: 55, valign: 'middle', halign: 'center'}
					}
				});

				const pageCount = doc.internal.getNumberOfPages();
				for(let i = 1; i <= pageCount; i++) {
					doc.setPage(i);
					const headerL = 'Ramana Iyer Sweets & Snacks';
					const headerR = 'Order Request List';
					const footerL = `PDF downloaded at: ${d}`;
					const footerR = `Page ${i} of ${pageCount}`;

					doc.text(headerL, 40, 15, { align: 'left', baseline: 'top' });
					doc.text(headerR, pageWidth - 40, 15, { align: 'right', baseline: 'top' });
					doc.text(footerL, 40, pageHeight - 25, { align: 'left', baseline: 'top' });
					doc.text(footerR, pageWidth - 40, pageHeight - 25, { align: 'right', baseline: 'top' });
					//doc.text(footerR, pageWidth / 2 - (doc.getTextWidth(footer) / 2), pageHeight - 15, { baseline: 'bottom' });
				}

				// Save the PDF with a filename
				doc.save("order-request.pdf");
			});
		</script>
	</body>
<?php } ?>