<?php
session_start();
error_reporting(0);

include_once 'include/config.php';
if (strlen($_SESSION['alogin']) == 0) {
  header('location:index.php');
} else {
  $oid = trim($_GET['oid']);
  include('include/header.php');
  if (isset($_POST['submit2'])) {
    $status = $_POST['status'];
    $remark = $_POST['remark']; //space char

    $ret = mysqli_query($con, "SELECT id FROM orders WHERE orderId='$oid'");
    while ($row = mysqli_fetch_array($ret)) {
      echo $row_id = $row['id'];
      mysqli_query($con, "insert into ordertrackhistory(orderId,status,remark) values('$row_id','$status','$remark')");
      mysqli_query($con, "update orders set orderStatus='$status' where id='$row_id'");
    }
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

  <div class="wrapper">
    <div class="container">
      <div class="row">
        <?php
        $actmenu = $_GET['sm'];
        include('include/sidebar.php'); ?>
        <div class="span9">
          <div class="content">

            <div class="module">
              <div class="module-head">
                <h3>Order Number =>
                  <?php echo $oid; ?>
                </h3>
              </div>
              <div class="module-body table">
                <form name="updateticket" id="updateticket" method="post">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    class="table table-bordered table-striped	 display table-responsive">

                    <thead>
                      <tr>
                        <th>At Date</th>
                        <th>Status <span style="color: red;">*</span></th>
                        <th width="300px">Remark <span style="color: red;">*</span></th>
                        <th>Order Id</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $ret1 = mysqli_query($con, "SELECT id FROM orders WHERE orderId='$oid'");
                      while ($row1 = mysqli_fetch_array($ret1)) {
                        $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='" . $row1['id'] . "'");
                        while ($row = mysqli_fetch_array($ret)) {
                          ?>
                          <tr>
                            <td>
                              <?php echo htmlentities($row['postingDate']); ?>
                            </td>
                            <td>
                              <?php echo htmlentities($row['status']); ?>
                            </td>
                            <td>
                              <?php echo htmlentities($row['remark']); ?>
                            </td>
                            <td>
                              <?php echo htmlentities($row['orderId']); ?>
                            </td>
                          </tr>
                        <?php
                        }
                      }
                      ?>
                      <?php
                      $st = 'Delivered';
                      $rt = mysqli_query($con, "SELECT * FROM orders WHERE orderId='$oid'");
                      if ($num = mysqli_fetch_array($rt)) {
                        $currrentSt = $num['orderStatus'];
                      }
                      if ($st == $currrentSt) { ?>
                        <tr>
                          <td colspan="4"><b>
                              Product Delivered </b></td>
                        </tr>
                        <tr>
                          <td colspan="4"><input class="btn btn-primary" type="button" value="Back"
                              onclick="window.location.href = 'delivered-orders.php'; return false;" /> </td>
                        </tr>
                      <?php } else {
                        ?>

                        <tr height="50">
                          <td class="fontkink1">&nbsp;</td>
                          <td class="fontkink"><span class="fontkink1">
                              <select name="status" class="fontkink" required="required">
                                <option value="">Select Status</option>
                                <option value="In Process">In Process</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Delivered">Delivered</option>
                              </select>
                            </span></td>
                          <td class="fontkink" align="justify"><span class="fontkink">
                              <textarea cols="100" rows="7" name="remark" required="required"></textarea>
                            </span></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td colspan="4"><input class="btn btn-primary" type="button" value="Back"
                              onclick="window.history.go(-1); return false;" />
                            <input type="submit" name="submit2" value="Update" class="btn btn-ri" />
                          </td>
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

  <?php include('include/footer.php'); ?>
<?php } ?>