<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	?>
	<?php include('include/header.php'); ?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<?php
				$actmenu = "userlog";
				include('include/sidebar.php'); ?>
				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>All Users</h3>
							</div>
							<div class="module-body table">


								<table cellpadding="0" cellspacing="0" border="0"
									class="datatable-1 table table-bordered table-striped	 display"
									style="width:100%;padding:5px;">
									<thead>
										<tr>
											<th>#</th>
											<th>Customer Name</th>
											<th>Customer Mobile No</th>
											<th>Login Time</th>
											<th>Logout Time </th>
										</tr>
									</thead>
									<tbody>

										<?php $query = mysqli_query($con, "select * from userlog");
										$cnt = 1;
										while ($row = mysqli_fetch_array($query)) {
											$query1 = mysqli_query($con, "select * from users WHERE contactno='" . $row['userEmail'] . "'");
											while ($row1 = mysqli_fetch_array($query1)) {
												?>
												<tr>
													<td>
														<?php echo htmlentities($cnt); ?>
													</td>
													<td>
														<?php echo htmlentities($row1['name']); ?>
													</td>
													<td>
														<?php echo htmlentities($row1['contactno']); ?>
													</td>
													<td>
														<?php echo date("d-m-Y h:i:s A", strtotime($row['loginTime'])); ?>
													</td>
													<td>
														<?php echo htmlentities($row['logout']); ?>
													</td>
													<?php /* <td><?php echo htmlentities($row['userip']);?></td>
																												<td><?php $st=$row['status'];

																							 if($st==1)
																							 {
																								 echo "Successfull";
																							 }
																							 else
																							 {
																								 echo "Failed";
																							 }
																							 ?></td> */?>



													<?php $cnt++;
											}
										}
										?>

								</table>
							</div>
						</div>



					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

	<?php include('include/footer.php'); ?>
	<script>
		$(document).ready(function () {
			$('.datatable-1').DataTable();
			// $('.dataTables_paginate').addClass("btn-group datatable-pagination");
			// $('.dataTables_paginate > a').wrapInner('<span />');
			// $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			// $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		});
	</script>
<?php } ?>