<?php
session_start();
error_reporting(0);
include_once 'includes/config.php';
$oid = intval($_GET['oid']);
?>
<script language="javascript" type="text/javascript">
  function f2() {
    window.close();
  } ser
  function f3() {
    window.print();
  }
</script>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
  <title>Order Tracking Details</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href="anuj.css" rel="stylesheet" type="text/css">
</head>

<body>

  <div style="background-color:#cf171d; color:#fff; padding:5px;">
    <center><img src="assets/images/ramana-logo.jpg" style="max-height: 50px; width: auto" alt="">
    <h2>ORDER TRACKING DETAILS</h2></center>
  </div>
    <form name="updateticket" id="updateticket" method="post">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th colspan="2">
              
              <hr />
            </th>
          </tr>
        </thead>
        <tbody>
        <tr height="20">
          <td class="fontkink1"><b>Order Id:</b></td>
          <td class="fontkink">
            <?php echo $oid; ?>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <hr />
          </td>
        </tr>
        <?php
        $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
        $num = mysqli_num_rows($ret);
        if ($num > 0) {
          while ($row = mysqli_fetch_array($ret)) {
            ?>
            <tr height="20">
              <td class="fontkink1"><b>At Date:</b></td>
              <td class="fontkink">
                <?php echo $row['postingDate']; ?>
              </td>
            </tr>
            <tr height="20">
              <td class="fontkink1"><b>Status:</b></td>
              <td class="fontkink">
                <?php echo $row['status']; ?>
              </td>
            </tr>
            <tr height="20">
              <td class="fontkink1"><b>Remark:</b></td>
              <td class="fontkink">
                <?php echo $row['remark']; ?>
              </td>
            </tr>


            <tr>
              <td colspan="2">
                <hr />
              </td>
            </tr>       
            <?php }
          } else {
            ?>
            <tr>
              <td class="fontkink1"><b>Status:</b></td>
              <td class="fontkink">Order Not Process Yet</td>
            </tr>
            <tr>
              <td colspan="2">
                <hr />
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
        <?php 
        $st = 'Delivered';
        $rt = mysqli_query($con, "SELECT * FROM orders WHERE id='$oid'");
        while ($num = mysqli_fetch_array($rt)) {
          $currrentSt = $num['orderStatus'];
        }
        if ($st == $currrentSt) { ?>
          <tr>
            <td colspan="2" align="center"><b>
                Product Delivered successfully </b></td>
          </tr>
          <tr>
            <td colspan="2">
              <hr />
            </td>
          </tr>
          <?php } ?>
        </tfoot>
      </table>
    </form>
</body>
</html>