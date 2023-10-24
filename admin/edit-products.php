<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$pid = intval($_GET['id']); // product id
	if (isset($_POST['submit'])) {
		$category = $_POST['category'];
		$subcat = $_POST['subcategory'];
		$productname = $_POST['productName'];
		$productcompany = $_POST['productCompany'];
		$productprice = $_POST['productprice'];
		$productpricebd = $_POST['productpricebd'];
		$productdescription = $_POST['productDescription'];
		$productscharge = $_POST['productShippingcharge'];
		$productavailability = $_POST['productAvailability'];
		$allow_ao = $_POST['allow_ao'];
		$productrating = $_POST['productRating'];

		$sql = mysqli_query($con, "update  products set category='$category',subCategory='$subcat',productName='$productname',productCompany='$productcompany',productPrice='$productprice',productDescription='$productdescription',shippingCharge='$productscharge',productAvailability='$productavailability',productRating='$productrating',productPriceBeforeDiscount='$productpricebd',allow_ao='$allow_ao' where id='$pid' ");
		$_SESSION['msg'] = "Product Updated Successfully !!";

	}


	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | Update Product</title>
		<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link type="text/css" href="css/theme.css" rel="stylesheet">
		<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
		<link type="text/css" href='css/opensans.css' rel='stylesheet'>
		<script src="assets/js/nicEdit-latest.js" type="text/javascript"></script>
		<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

		<script>
			function getSubcat(val) {
				$.ajax({
					type: "POST",
					url: "get_subcat.php",
					data: 'cat_id=' + val,
					success: function (data) {
						$("#subcategory").html(data);
					}
				});
			}
			function selectCountry(val) {
				$("#search-box").val(val);
				$("#suggesstion-box").hide();
			}
		</script>


	</head>

	<body>
		<?php include('include/header.php'); ?>

		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php
					$actmenu = "all_product";
					include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<h3>Update Product</h3>
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

										<?php

										$query = mysqli_query($con, "select products.*,category.categoryName as catname,category.id as cid,subcategory.subcategory as subcatname,subcategory.id as subcatid from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory where products.id='$pid'");
										$cnt = 1;
										while ($row = mysqli_fetch_array($query)) {



											?>


											<div class="control-group">
												<label class="control-label" for="basicinput">Category</label>
												<div class="controls">
													<select name="category" class="span8 tip" onChange="getSubcat(this.value);"
														required>
														<?php $query = mysqli_query($con, "select * from category");
														while ($rw = mysqli_fetch_array($query)) {
																?>

															<option value="<?php echo $rw['id']; ?>" <?php if ($row['cid'] == $rw['id']) { echo "selected"; } ?>>
																<?php echo $rw['categoryName']; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>


											<div class="control-group">
												<label class="control-label" for="basicinput">Sub Category</label>
												<div class="controls">

													<select name="subcategory" id="subcategory" class="span8 tip" required>
														<option value="<?php echo htmlentities($row['subcatid']); ?>">
															<?php echo htmlentities($row['subcatname']); ?>
														</option>
													</select>
												</div>
											</div>


											<div class="control-group">
												<label class="control-label" for="basicinput">Product Name</label>
												<div class="controls">
													<input type="text" name="productName" placeholder="Enter Product Name"
														value="<?php echo htmlentities($row['productName']); ?>"
														class="span8 tip">
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Product Company</label>
												<div class="controls">
													<input type="text" name="productCompany"
														placeholder="Enter Product Comapny Name"
														value="<?php echo htmlentities($row['productCompany']); ?>"
														class="span8 tip" required>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="basicinput">Product Price Before
													Discount</label>
												<div class="controls">
													<input type="text" name="productpricebd" placeholder="Enter Product Price"
														value="<?php echo htmlentities($row['productPriceBeforeDiscount']); ?>"
														class="span8 tip" required>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Product Price</label>
												<div class="controls">
													<input type="text" name="productprice" placeholder="Enter Product Price"
														value="<?php echo htmlentities($row['productPrice']); ?>"
														class="span8 tip" required>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Product Description</label>
												<div class="controls">
													<textarea name="productDescription" placeholder="Enter Product Description"
														rows="6" class="span8 tip">
		<?php echo htmlentities($row['productDescription']); ?>
		</textarea>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Product Shipping Charge</label>
												<div class="controls">
													<input type="text" name="productShippingcharge"
														placeholder="Enter Product Shipping Charge"
														value="<?php echo htmlentities($row['shippingCharge']); ?>"
														class="span8 tip" required>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Product Status</label>
												<div class="controls">
													<select name="productAvailability" id="productAvailability"
														class="span8 tip" onchange="chkbox_ed(this.value)" required>
														<option value="In Stock" <?php if ($row['productAvailability'] == "In Stock") { echo "selected"; } ?>>In Stock</option>
														<option value="Out of Stock" <?php if ($row['productAvailability'] == "Out of Stock") { echo "selected"; } ?>>Out of Stock</option>
														<option value="Against Order" <?php if ($row['productAvailability'] == "Against Order") { echo "selected"; } ?>>Against Order</option>
													</select>
												</div>
												<div class="controls">
													<input type="checkbox" id="allow_ao" name="allow_ao" value="1" <?php if ($row['allow_ao'] == "1") { echo "checked"; } ?>/> 
													Allow Against Order if sale order exceeds availability
												</div>
											</div>



											<div class="control-group">
												<label class="control-label" for="basicinput">Product Rating</label>
												<div class="controls">
													<select name="productRating" id="productRating" class="span8 tip" required>
														<option value="1" <?php if ($row['productRating'] == "1") { echo "selected"; } ?>>1</option>
														<option value="2" <?php if ($row['productRating'] == "2") { echo "selected"; } ?>>2</option>
														<option value="3" <?php if ($row['productRating'] == "3") { echo "selected"; } ?>>3</option>
														<option value="4" <?php if ($row['productRating'] == "4") { echo "selected"; } ?>>4</option>
														<option value="5" <?php if ($row['productRating'] == "5") { echo "selected"; } ?>>5</option>
													</select>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Product Image1</label>
												<div class="controls">
													<img src="productimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['productImage1']); ?>"
														width="200" height="100"> <a
														href="update-image1.php?id=<?php echo $row['id']; ?>">Change Image</a>
												</div>
											</div>


											<div class="control-group">
												<label class="control-label" for="basicinput">Product Image2</label>
												<div class="controls">
													<img src="productimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['productImage2']); ?>"
														width="200" height="100"> <a
														href="update-image2.php?id=<?php echo $row['id']; ?>">Change Image</a>
												</div>
											</div>



											<div class="control-group">
												<label class="control-label" for="basicinput">Product Image3</label>
												<div class="controls">
													<img src="productimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['productImage3']); ?>"
														width="200" height="100"> <a
														href="update-image3.php?id=<?php echo $row['id']; ?>">Change Image</a>
												</div>
											</div>
										<?php } ?>
										<div class="control-group">
											<div class="controls">
												<input class="btn" type="button" value="Back"
													onclick="window.location.href = 'manage-products.php'" />
												<button type="submit" name="submit" class="btn">Update</button>
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
		<script>
			chkbox_ed($('#productAvailability').val());
			function chkbox_ed(ele) {
				if(ele == "Against Order")
				{
					document.getElementById("allow_ao").disabled = false;
					$("#allow_ao").prop('checked', true).attr("onclick", 'return false');
				}						
				else if(ele == "Out of Stock")
				{
					document.getElementById("allow_ao").disabled = true;
					$("#allow_ao").prop('checked', false).attr("onclick", 'return true');
				}					
				else
				{
					document.getElementById("allow_ao").disabled = false;
					$("#allow_ao").prop('checked', false).attr("onclick", 'return true');
				}
			}
		</script>
	</body>
<?php } ?>