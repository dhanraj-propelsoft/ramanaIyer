<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:login.php');
} else {
    include('includes/header.php');
    ?>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li class='active'>Order History</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row inner-bottom-sm">
                <div class="shopping-cart">
                    <div class="col-md-12 col-sm-12 shopping-cart-table ">
                        <div class="table-responsive">
                            <form name="cart" method="post">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="cart-romove item">#</th>
                                            <th class="cart-description item">Image</th>
                                            <th class="cart-product-name item">Product Name</th>

                                            <th class="cart-qty item">Quantity</th>
                                            <th class="cart-sub-total item">Price Per Unit</th>
                                            <th class="cart-sub-total item">Shipping Charge</th>
                                            <th class="cart-total item">Grand Total</th>
                                            <th class="cart-total item">Payment Method</th>
                                            <th class="cart-description item">Order Date</th>
                                            <th class="cart-total last-item">Action</th>
                                        </tr>
                                    </thead><!-- /thead -->
                                    <tfoot>
                                        <tr>
                                            <td colspan="10" align="center"><a href="index.php" class="btn btn-upper btn-primary">Continue Shopping</a></td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $query = mysqli_query($con, "select products.productImage1 as pimg1,products.productName as pname,products.id as proid,orders.productId as opid,orders.quantity as qty,products.productPrice as pprice,products.shippingCharge as shippingcharge,orders.paymentMethod as paym,orders.orderDate as odate,orders.id as orderid from orders join products on orders.productId=products.id where orders.userId='" . $_SESSION['id'] . "' and orders.paymentId is not null");
                                        $cnt = 1;
                                        $num = mysqli_num_rows($query);
                                        if ($num > 0) {
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $cnt; ?>
                                                    </td>
                                                    <td class="cart-image">
                                                        <a class="entry-thumbnail" href="detail.html">
                                                            <img src="admin/productimages/<?php echo $row['proid']; ?>/<?php echo $row['pimg1']; ?>"
                                                                alt="" width="84" height="auto">
                                                        </a>
                                                    </td>
                                                    <td class="cart-product-name-info">
                                                        <h4 class='cart-product-description'><a
                                                                href="product-details.php?pid=<?php echo $row['opid']; ?>">
                                                                <?php echo $row['pname']; ?></a></h4>


                                                    </td>
                                                    <td class="cart-product-quantity">
                                                        <?php echo $qty = $row['qty']; ?>
                                                    </td>
                                                    <td class="cart-product-sub-total">
                                                        <?php echo $price = $row['pprice']; ?>
                                                    </td>
                                                    <td class="cart-product-sub-total">
                                                        <?php echo $shippcharge = $row['shippingcharge']; ?>
                                                    </td>
                                                    <td class="cart-product-grand-total">
                                                        <?php echo (($qty * $price) + $shippcharge); ?>
                                                    </td>
                                                    <td class="cart-product-sub-total">
                                                        <?php echo $row['paym']; ?>
                                                    </td>
                                                    <td class="cart-product-sub-total">
                                                        <?php echo $row['odate']; ?>
                                                    </td>

                                                    <td>
                                                        <a href="javascript:void(0);"
                                                            onClick="popUpWindow('track-order.php?oid=<?php echo htmlentities($row['orderid']); ?>');"
                                                            title="Track order">
                                                            Track
                                                    </td>
                                                </tr>
                                                <?php $cnt = $cnt + 1;
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="10" align="center">
                                                    <h4>No Result Found</h4>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody><!-- /tbody -->
                                </table><!-- /table -->

                        </div>
                    </div>

                </div><!-- /.shopping-cart -->
            </div> <!-- /.row -->
            </form>
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->

            <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
    <?php include('includes/footer.php'); ?>

    <script language="javascript" type="text/javascript">
        var popUpWin = 0;

        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin',
                'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' +
                600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>
<?php } ?>