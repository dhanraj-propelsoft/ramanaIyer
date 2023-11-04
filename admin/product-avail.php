<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	date_default_timezone_set('Asia/Kolkata'); // change according timezone
	$currentTime = date('d-m-Y h:i:s A', time());

	if (isset($_GET['del'])) {
		$result1 = mysqli_query($con, "SELECT * FROM orders WHERE productId='" . $_GET['id'] . "' AND (orderStatus IS NULL OR orderStatus!='Delivered')");
		$row_cnt1 = mysqli_num_rows($result1);
		if ($row_cnt1 > 0) {
			$_SESSION['delmsg'] = "Could not delete since this product has been ordered by customer !!";
		} else {
			$dirname = "productimages/" . $_GET['id'];
			array_map('unlink', glob("$dirname/*.*"));
			rmdir($dirname);
			mysqli_query($con, "delete from products where id = '" . $_GET['id'] . "'");
			$_SESSION['delmsg'] = "Product deleted !!";
		}
	}

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | Manage Products</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='css/opensans.css' rel='stylesheet'>
		<link rel="stylesheet" href="css/sweetalert2.min.css">
		<script src="assets/js/sweetalert.js"></script>
		<script src="assets\js\jspdf.min.js_1.5.3\cdnjs\jspdf.min.js"></script>
		<script src="assets\js\jspdf.plugin.autotable.min.js_3.5.6\cdnjs\jspdf.plugin.autotable.min.js"></script>
	</head>

	<body>
		<?php include('include/header.php'); ?>

		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php
					$actmenu = "prod_avail";
					include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<b>Manage Products</b>
									<span style="float: right">
                                        <div class="controls">
										<button id="download-pdf-button" style="float:right" class="btn btn-ri">Download PDF</button>
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

									<br />

									<table id="table-to-pdf" cellpadding="0" cellspacing="0" border="0"
										class="datatable-1 table table-bordered table-striped	 display"
										style="width:100%;padding:5px;">
										<thead>
											<tr>
												<th>#</th>
												<th>Product Name</th>
												<th>Category </th>
												<th>Subcategory</th>
												<th>Selling Price</th>
												<th>Product Status</th>
												<th>Available</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

											<?php $query = mysqli_query($con, "select products.*,category.categoryName,subcategory.subcategory from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory");
											$cnt = 1;
											while ($row = mysqli_fetch_array($query)) {
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td class="wrap_td_100">
														<?php echo htmlentities($row['productName']); ?>
													</td>
													<td class="wrap_td_75">
														<?php echo htmlentities($row['categoryName']); ?>
													</td>
													<td class="wrap_td_100">
														<?php echo htmlentities($row['subcategory']); ?>
													</td>
													<td class="wrap_td_100">
														<?php echo htmlentities($row['productPrice']); ?>
													</td>
													<td class="wrap_td_100">
														<?php if($row['productAvailability'] == "In Stock") {
															if((intval($row['allow_ao']) == 0) && (intval($row['prod_avail']) == 0)) { 
																echo 'Out of Stock';
															} else if((intval($row['allow_ao']) == 1) && (intval($row['prod_avail']) == 0)) { 
																echo 'Against Order';
															} else {
																echo $row['productAvailability']; 
															}
														} else { 
															echo $row['productAvailability']; 
														} ?>
													</td>
													<td class="wrap_td_75">
														<?php echo htmlentities($row['prod_avail']); ?>
													</td>
													<td>
														<a href="insert-avail.php?id=<?php echo $row['id'] ?>"><i
																class="icon-edit"></i></a>
													</td>
												</tr>
												<?php $cnt = $cnt + 1;
											} ?>

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
		<script src="scripts/datatables/jquery.dataTables.js"></script>
		<script>
			$(document).ready(function () {
				$('.datatable-1').dataTable();
				$('.dataTables_paginate').addClass("btn-group datatable-pagination");
				$('.dataTables_paginate > a').wrapInner('<span />');
				$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
				$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');

				document.getElementById("download-pdf-button").addEventListener("click", () => {
					const table = document.getElementById("table-to-pdf");
					var doc = new jsPDF('p', 'pt', 'letter');

					const d = new Date();
					const pageSize = doc.internal.pageSize;
					const pageWidth = pageSize.width ? pageSize.width : pageSize.getWidth();
					const pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();

					doc.setFontSize(12);

					var res = doc.autoTableHtmlToJson(document.getElementById("table-to-pdf"));
					var columns = [res.columns[0], res.columns[1], res.columns[2], res.columns[3], res.columns[4], res.columns[5], res.columns[6]];
					var resData = [];
					var res_data = res.data;
					
					res_data.forEach(item => {
						resData.push([item[0]['content'], item[1]['content'],item[2]['content'],item[3]['content'],item[4]['content'],item[5]['content'],item[6]['content']]);
					});
					
					// Convert the HTML table to PDF
					doc.autoTable(columns, resData, {
						headStyles:{ valign: 'middle', halign : 'center'},
						columnStyles: {
							0: {cellWidth: 20, valign: 'middle'},
							1: {cellWidth: 135, valign: 'middle'},
							2: {cellWidth: 60, valign: 'middle'},
							3: {cellWidth: 100, valign: 'middle'},
							4: {cellWidth: 80, valign: 'middle'},
							5: {cellWidth: 80, valign: 'middle'},
							6: {cellWidth: 60, valign: 'middle'}
						}
					});

					const pageCount = doc.internal.getNumberOfPages();
					for(let i = 1; i <= pageCount; i++) {
						doc.setPage(i);
						const headerL = 'Ramana Iyer Sweets & Snacks';
						const headerR = 'Products List';
						const footerL = `PDF downloaded at: ${d}`;
						const footerR = `Page ${i} of ${pageCount}`;

						doc.text(headerL, 40, 15, { align: 'left', baseline: 'top' });
						doc.text(headerR, pageWidth - 40, 15, { align: 'right', baseline: 'top' });
						doc.text(footerL, 40, pageHeight - 25, { align: 'left', baseline: 'top' });
						doc.text(footerR, pageWidth - 40, pageHeight - 25, { align: 'right', baseline: 'top' });
						//doc.text(footerR, pageWidth / 2 - (doc.getTextWidth(footer) / 2), pageHeight - 15, { baseline: 'bottom' });
					}

					// Save the PDF with a filename
					doc.save("products-list.pdf");
				});
			});

			function delPopup(ele) {
				Swal.fire({
					title: 'Warning!',
					text: 'Are you sure you want to delete?',
					icon: 'info',
					showCancelButton: true,
					confirmButtonText: 'Yes',
					cancelButtonText: 'No'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = 'manage-products.php?id=' + ele + '&del=delete';
					}
				});
			}
		</script>
	</body>
<?php } ?>