<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Compliant</title>
<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link type="text/css" href="css/theme.css" rel="stylesheet">
<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
<?php include('userStyle.php');?>
</head>
<body>

<?php
session_start();

include_once 'include/config.php';
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:index.php');
}
else{
$oid=intval($_GET['oid']);
if(isset($_POST['submit2'])){
$status=$_POST['status'];
$remark=$_POST['remark'];//space char

$query=mysqli_query($con,"insert into ordertrackhistory(orderId,status,remark) values('$oid','$status','$remark')");
$sql=mysqli_query($con,"update orders set orderStatus='$status' where id='$oid'");
echo "<script>
Swal.fire({
  title: 'Success!',
  text: 'Order updated sucessfully...!',
  icon: 'success',
  confirmButtonText: 'OK'
});
</script>";
//}
}

 ?>
<script language="javascript" type="text/javascript">
function f2()
{
window.close();
}
function f3()
{
window.print(); 
}
</script>
<?php include('include/header.php');?>

<div class="wrapper">
  <div class="container">
    <div class="row">
<?php include('include/sidebar.php');?>				
    <div class="span9">
        <div class="content">

<div class="module">
            <div class="module-head">
              <h3>Order ID => <?php echo $oid;?></h3>
            </div>
            <div class="module-body table">
 <form name="updateticket" id="updateticket" method="post"> 
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped	 display table-responsive" >

    <thead>
      <tr>
        <th>At Date</th>
        <th>Status</th>
        <th width="300px">Remark</th>      
      
      </tr>
    </thead>
    
    <tbody>
    <?php 
$ret = mysqli_query($con,"SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
     while($row=mysqli_fetch_array($ret))
      {
     ?>
      <tr>
        <td><?php echo htmlentities($row['postingDate']);?></td>
        <td><?php echo htmlentities($row['status']);?></td>
        <td><?php echo htmlentities($row['remark']);?></td>
      </tr>
		
   <?php } ?>
   <?php 
$st='Delivered';
   $rt = mysqli_query($con,"SELECT * FROM orders WHERE id='$oid'");
     while($num=mysqli_fetch_array($rt))
     {
     $currrentSt=$num['orderStatus'];
   }
     if($st==$currrentSt)
     { ?>
   <tr><td colspan="3"><b>
      Product Delivered </b></td>
   <?php }else  {
      ?>
   
    <tr height="50">
      <td class="fontkink1">&nbsp;</td>
      <td class="fontkink"><span class="fontkink1" >
        <select name="status" class="fontkink" required="required" >
          <option value="">Select Status</option>
                 <option value="in Process">In Process</option>
                  <option value="Delivered">Delivered</option>
        </select>
        </span></td>
      <td class="fontkink" align="justify" ><span class="fontkink">
        <textarea cols="100" rows="7" name="remark"  required="required" ></textarea>
        </span></td>
    </tr>
    <tr><td colspan="3"><input type="submit" name="submit2"  value="Update" class="btn" /></td>
<?php } ?>
   </tbody>
</table>

 </form>
</div>
						</div>						

						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

<?php include('include/footer.php');?>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>
</html>
<?php } ?>

     