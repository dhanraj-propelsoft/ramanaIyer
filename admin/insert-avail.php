<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$pid = intval($_GET['id']);
	if (isset($_POST['submit'])) {
		$prodAvail = ($_POST['prodOldAvail']) ? $_POST['prodOldAvail'] + $_POST['prodAvail'] : $_POST['prodAvail'];

		$sql = mysqli_query($con, "UPDATE products SET prod_avail='$prodAvail' WHERE id='$pid'");

		$_SESSION['msg'] = "Product Updated Successfully !!";
	}


	?>
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
								<h3>Update Product Availability</h3>
							</div>
							<div class="module-body">
								<?php if (isset($_POST['submit'])) {
									if ($_SESSION['errmsg'] != "") { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong>
											<?php echo htmlentities($_SESSION['errmsg']); ?>
											<?php echo htmlentities($_SESSION['errmsg'] = ""); ?>
										</div>
									<?php } else { ?>
										<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Well done!</strong>
											<?php echo htmlentities($_SESSION['msg']); ?>
											<?php echo htmlentities($_SESSION['msg'] = ""); ?>
										</div>
									<?php }
								} ?>

								<br />

								<form class="form-horizontal row-fluid" name="insertavail" method="post"
									enctype="multipart/form-data">

									<?php

									$query = mysqli_query($con, "select products.*,category.categoryName as catname,subcategory.subcategory as subcatname from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory where products.id='$pid'");
									while ($row = mysqli_fetch_array($query)) {



										?>

										<div class="control-group">
											<label class="control-label" for="basicinput">Category <span>*</span></label>
											<div class="controls">
												<input type="text" name="category" placeholder="Enter category Name"
													class="span8 tip" value="<?php echo $row['catname']; ?>" readonly required>
											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">Sub Category <span>*</span></label>
											<div class="controls">
												<input type="text" name="subcategory" placeholder="Enter subcategory Name"
													class="span8 tip" value="<?php echo $row['subcatname']; ?>" readonly
													required>
											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">Product Name <span>*</span></label>
											<div class="controls">
												<input type="text" name="productName" placeholder="Enter Product Name"
													value="<?php echo htmlentities($row['productName']); ?>" class="span8 tip"
													readonly required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Product Company <span>*</span></label>
											<div class="controls">
												<input type="text" name="productCompany"
													value="<?php echo htmlentities($row['productCompany']); ?>"
													placeholder="Enter Product Comapny Name" class="span8 tip" readonly
													required>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Kg or Nos <span>*</span></label>
											<div class="controls">
												<input type="text"
													onkeypress="return event.charCode >= 48 && event.charCode <= 57"
													name="prodAvail" placeholder="Enter Kg or Nos"
													value="<?php echo htmlentities($row['prod_avail']); ?>" class="span8 tip"
													required>
											</div>
										</div>
									<?php } ?>
									<div class="control-group">
										<div class="controls">
											<input class="btn btn-primary" type="button" value="Back"
												onclick="window.location.href = 'product-avail.php'" />
											<button type="submit" name="submit" class="btn btn-ri">Update</button>
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
<?php } ?>