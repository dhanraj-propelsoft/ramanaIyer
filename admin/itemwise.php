<?php
session_start();
error_reporting(0);
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
		<title>Admin | Itemwise Orders</title>
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
					$actmenu = "itemwise";
					include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<h3>Itemwise Orders</h3>									
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
											<td><input type="text" id="min" name="min" placeholder="Choose Date"></td>
											<td><a class="btn btn-ri" onclick="window.location.reload();">Reset Filters</a></td>
											<td><button id="download-pdf-button" style="float:right" class="btn btn-ri">Download PDF</button></td>
										</tr>
									</tbody></table>
									<table cellpadding="0" id="table-to-pdf" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display table-responsive" style="width:100%;padding:5px;">
										<thead>
											<tr>
												<th>#</th>
												<th>Date</th>
												<th>Item</th>
												<th>Required Quantity</th>
											</tr>
										</thead>

										<tbody>
											<?php
											$cnt = 1;
											$query = mysqli_query($con, "SELECT DISTINCT DATE_FORMAT(dtSupply, '%Y-%m-%d') AS dtSupply FROM orders WHERE dtSupply IS NOT NULL AND paymentMethod IS NOT NULL AND (orderStatus!='Delivered' OR orderStatus IS NULL) ORDER BY (dtSupply) ASC");
											while ($row = mysqli_fetch_array($query)) {

												$query1 = mysqli_query($con, "SELECT SUM(orders.quantity) AS quanSum,products.productName AS productname,orders.quantity AS quantity,orders.dtSupply AS dtSupply,orders.id AS id  FROM orders JOIN users ON  orders.userId=users.id JOIN products ON products.id=orders.productId AND dtSupply IS NOT NULL AND paymentMethod IS NOT NULL AND (orderStatus!='Delivered' OR orderStatus IS NULL) AND orders.dtSupply LIKE '%" . $row['dtSupply'] . "%' GROUP BY orders.productId");

												while ($row1 = mysqli_fetch_array($query1)) {
											?>
													<tr>
														<td>
															<?php echo htmlentities($cnt); ?>
														</td>
														<td class="wrap_td_100">
															<?php echo htmlentities(date('d-m-Y', strtotime($row1['dtSupply']))); ?>
														</td>
														<td class="wrap_td_100">
															<?php echo htmlentities($row1['productname']); ?>
														</td>
														<td class="wrap_td_100">
															<?php echo htmlentities($row1['quanSum']); ?>
														</td>
													</tr>

											<?php $cnt++;
												}
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
			$(document).ready(function() {
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

						var mydate = moment(data[1], 'DD-MM-YYYY'); 
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
				var doc = new jsPDF('p', 'pt', 'letter');

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
					html: table
				});

				const pageCount = doc.internal.getNumberOfPages();
				for(let i = 1; i <= pageCount; i++) {
					doc.setPage(i);
					const headerL = 'Ramana Iyer Sweets & Snacks';
					const headerR = 'Item Wise Order List';
					const footerL = `PDF downloaded at: ${d}`;
					const footerR = `Page ${i} of ${pageCount}`;

					doc.text(headerL, 40, 15, { align: 'left', baseline: 'top' });
					doc.text(headerR, pageWidth - 40, 15, { align: 'right', baseline: 'top' });
					doc.text(footerL, 40, pageHeight - 25, { align: 'left', baseline: 'top' });
					doc.text(footerR, pageWidth - 40, pageHeight - 25, { align: 'right', baseline: 'top' });
					//doc.text(footerR, pageWidth / 2 - (doc.getTextWidth(footer) / 2), pageHeight - 15, { baseline: 'bottom' });
				}

				// Save the PDF with a filename
				doc.save("item-wise.pdf");
			});
		</script>
	</body>
<?php } ?>