<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$pid = intval($_GET['id']); // product id

	define("MAX_SIZE", "3000");
	function getExtension($str)
	{
		$i = strrpos($str, ".");
		if (!$i) {
			return "";
		}
		$l = strlen($str) - $i;
		$ext = substr($str, $i + 1, $l);
		return $ext;
	}

	function imageUpload($image, $uploadedfile, $productid)
	{
		if ($image) {

			$filename = stripslashes($image);

			$extension = getExtension($filename);
			$extension = strtolower($extension);


			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				//echo "Unknown Extension..!";
			} else {

				$size = filesize($uploadedfile);

				if ($size > MAX_SIZE * 1024) {
					//echo "File Size Excedeed..!!";
				}

				if ($extension == "jpg" || $extension == "jpeg") {
					$src = imagecreatefromjpeg($uploadedfile);
				} else if ($extension == "png") {
					$src = imagecreatefrompng($uploadedfile);
				} else {
					$src = imagecreatefromgif($uploadedfile);
				}

				list($width, $height) = getimagesize($uploadedfile);


				$newwidth = 1280;
				$newheight = ($height / $width) * $newwidth;
				$tmp = imagecreatetruecolor($newwidth, $newheight);

				imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


				$filename = "productimages/$productid/" . $image;

				move_uploaded_file($uploadedfile, "productimages/$productid/ORG_ " . $image);

				imagejpeg($tmp, $filename, 100);

				imagedestroy($src);
				imagedestroy($tmp);
			}
		}
	}
	if (isset($_POST['submit'])) {
		$productname = $_POST['productName'];
		$productimage1 = $_FILES["productimage1"]["name"];

		$uploadedfile1 = $_FILES["productimage1"]["tmp_name"];
		imageUpload($productimage1, $uploadedfile1, $pid);

		//move_uploaded_file($_FILES["productimage1"]["tmp_name"], "productimages/$pid/" . $_FILES["productimage1"]["name"]);
		$sql = mysqli_query($con, "update  products set productImage1='$productimage1' where id='$pid' ");
		$_SESSION['msg'] = "Product Image Updated Successfully !!";

	}


	?>
	<?php include('include/header.php'); ?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<?php $actmenu = "all_product";
				include('include/sidebar.php'); ?>
				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Update Product Image1</h3>
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



								<br />

								<form class="form-horizontal row-fluid" name="insertproduct" method="post"
									enctype="multipart/form-data">

									<?php

									$query = mysqli_query($con, "select productName,productImage1 from products where id='$pid'");
									$cnt = 1;
									while ($row = mysqli_fetch_array($query)) {



										?>


										<div class="control-group">
											<label class="control-label" for="basicinput">Product Name</label>
											<div class="controls">
												<input type="text" name="productName" readonly
													value="<?php echo htmlentities($row['productName']); ?>" class="span8 tip"
													required>
											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="basicinput">Current Product Image1</label>
											<div class="controls">
												<img src="productimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['productImage1']); ?>"
													width="200" height="100">
											</div>
										</div>



										<div class="control-group">
											<label class="control-label" for="basicinput">New Product Image1</label>
											<div class="controls">
												<input type="file" name="productimage1" id="productimage1" value=""
													class="span8 tip" required>
											</div>
										</div>


									<?php } ?>

									<div class="control-group">
										<div class="controls">
											<input class="btn btn-primary" type="button" value="Back"
												onclick="window.location.href = 'edit-products.php?id=<?php echo $pid; ?>'" />
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