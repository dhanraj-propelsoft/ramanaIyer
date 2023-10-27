<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$productimage2 = "";
	$productimage3 = "";
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
		$productimage1 = $_FILES["productimage1"]["name"];
		if (isset($_FILES["productimage2"]["name"]))
			$productimage2 = $_FILES["productimage2"]["name"];
		if (isset($_FILES["productimage3"]["name"]))
			$productimage3 = $_FILES["productimage3"]["name"];

		$sql = mysqli_query($con, "insert into products(category,subCategory,productName,productCompany,productPrice,productDescription,shippingCharge,productAvailability,productRating,productImage1,productImage2,productImage3,productPriceBeforeDiscount,allow_ao) values('$category','$subcat','$productname','$productcompany','$productprice','$productdescription','$productscharge','$productavailability','$productrating','$productimage1','$productimage2','$productimage3','$productpricebd','$allow_ao')");

		//for getting product id
		$query1 = mysqli_query($con, "select max(id) as pid from products");
		$result1 = mysqli_fetch_array($query1);
		$productid = $result1['pid'];
		$dir = "productimages/" . $productid;
		if (!is_dir($dir)) {
			mkdir("productimages/" . $productid);
		}
		move_uploaded_file($_FILES["productimage1"]["tmp_name"], "productimages/$productid/" . $_FILES["productimage1"]["name"]);
		if (isset($_FILES["productimage2"]["name"]))
			move_uploaded_file($_FILES["productimage2"]["tmp_name"], "productimages/$productid/" . $_FILES["productimage2"]["name"]);
		if (isset($_FILES["productimage3"]["name"]))
			move_uploaded_file($_FILES["productimage3"]["tmp_name"], "productimages/$productid/" . $_FILES["productimage3"]["name"]);

		$_SESSION['msg'] = "Product Inserted Successfully !!";
	}


	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | Insert Product</title>
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
									<h3>Insert Product</h3>
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

										<div class="control-group">
											<label class="control-label" for="basicinput">Category <span>*</span></label>
											<div class="controls">
												<select name="category" class="span8 tip" onChange="getSubcat(this.value);"
													required>
													<option value="">Select Category</option>
													<?php $query = mysqli_query($con, "select * from category");
													while ($row = mysqli_fetch_array($query)) { ?>

														<option value="<?php echo $row['id']; ?>">
															<?php echo $row['categoryName']; ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">Sub Category <span>*</span></label>
											<div class="controls">
												<select name="subcategory" id="subcategory" class="span8 tip" required>
												</select>
											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">Product Name <span>*</span></label>
											<div class="controls">
												<input type="text" name="productName" placeholder="Enter Product Name"
													class="span8 tip" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Product Company <span>*</span></label>
											<div class="controls">
												<input type="text" name="productCompany"
													placeholder="Enter Product Comapny Name" class="span8 tip" required>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Product Price Before
												Discount <span>*</span></label>
											<div class="controls">
												<input type="text"
													onkeypress="return event.charCode >= 48 && event.charCode <= 57"
													name="productpricebd" placeholder="Enter Product Price"
													class="span8 tip" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Product Price After
												Discount(Selling Price) <span>*</span></label>
											<div class="controls">
												<input type="text"
													onkeypress="return event.charCode >= 48 && event.charCode <= 57"
													name="productprice" placeholder="Enter Product Price" class="span8 tip"
													required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Product Description</label>
											<div class="controls">
												<textarea name="productDescription" placeholder="Enter Product Description"
													rows="6" class="span8 tip">
	</textarea>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Product Shipping Charge <span>*</span></label>
											<div class="controls">
												<input type="text"
													onkeypress="return event.charCode >= 48 && event.charCode <= 57"
													name="productShippingcharge" placeholder="Enter Product Shipping Charge"
													class="span8 tip" required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Product Status <span>*</span></label>
											<div class="controls">
												<select name="productAvailability" id="productAvailability"
													class="span8 tip" onchange="chkbox_ed(this.value)" required>
													<option value="">Select</option>
													<option value="In Stock">In Stock</option>
													<option value="Out of Stock">Out of Stock</option>
													<option value="Against Order">Against Order</option>
												</select>
											</div>
											<div class="controls">
												<input type="checkbox" id="allow_ao" name="allow_ao" value="1" /> 
												Allow Against Order if sale order exceeds availability
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Product Rating <span>*</span></label>
											<div class="controls">
												<select name="productRating" id="productRating" class="span8 tip" required>
													<option value="">Select</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div>
										</div>



										<div class="control-group">
											<label class="control-label" for="basicinput">Product Image1 <span>*</span></label>
											<div class="controls">
												<input type="file" name="productimage1" id="productimage1" value=""
													accept="image/*" class="span8 tip" required>
											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">Product Image2</label>
											<div class="controls">
												<input type="file" name="productimage2" accept="image/*" class="span8 tip">
											</div>
										</div>



										<div class="control-group">
											<label class="control-label" for="basicinput">Product Image3</label>
											<div class="controls">
												<input type="file" name="productimage3" accept="image/*" class="span8 tip">
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<input class="btn btn-primary" type="button" value="Back"
													onclick="window.location.href = 'manage-products.php'" />
												<button type="submit" name="submit" class="btn">Insert</button>
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