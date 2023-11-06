<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$pid = intval($_GET['id']); // combo id

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


				$filename = "comboimages/$productid/" . $image;

				move_uploaded_file($uploadedfile, "comboimages/$productid/ORG_ " . $image);

				imagejpeg($tmp, $filename, 100);

				imagedestroy($src);
				imagedestroy($tmp);
			}
		}
	}
	if (isset($_POST['submit'])) {
		$comboname = $_POST['comboName'];
		$comboimage1 = $_FILES["comboimage1"]["name"];

		$uploadedfile1 = $_FILES["comboimage1"]["tmp_name"];
		imageUpload($comboimage1, $uploadedfile1, $pid);

		//move_uploaded_file($_FILES["comboimage1"]["tmp_name"], "comboimages/$pid/" . $_FILES["comboimage1"]["name"]);
		$sql = mysqli_query($con, "update  combo set comboImage1='$comboimage1' where id='$pid' ");
		$_SESSION['msg'] = "Combo Image Updated Successfully !!";

	}


	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin | Update Combo Image 1</title>
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
					<?php $actmenu = "ins_combo";
					include('include/sidebar.php'); ?>
					<div class="span9">
						<div class="content">

							<div class="module">
								<div class="module-head">
									<h3>Update Combo Image 1</h3>
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

									<form class="form-horizontal row-fluid" name="insertcombo" method="post"
										enctype="multipart/form-data">

										<?php

										$query = mysqli_query($con, "select comboName,comboImage1 from combo where id='$pid'");
										$cnt = 1;
										while ($row = mysqli_fetch_array($query)) {



											?>


											<div class="control-group">
												<label class="control-label" for="basicinput">Combo Name</label>
												<div class="controls">
													<input type="text" name="comboName" readonly
														value="<?php echo htmlentities($row['comboName']); ?>"
														class="span8 tip" required>
												</div>
											</div>


											<div class="control-group">
												<label class="control-label" for="basicinput">Current Combo Image1</label>
												<div class="controls">
													<img src="comboimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['comboImage1']); ?>"
														width="200" height="100">
												</div>
											</div>



											<div class="control-group">
												<label class="control-label" for="basicinput">New Combo Image1</label>
												<div class="controls">
													<input type="file" name="comboimage1" id="comboimage1" value=""
														class="span8 tip" required>
												</div>
											</div>


										<?php } ?>

										<div class="control-group">
											<div class="controls">
												<input class="btn" type="button" value="Back"
													onclick="window.location.href = 'edit-combo.php?id=<?php echo $pid; ?>'" />
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
			});
		</script>
	</body>
<?php } ?>