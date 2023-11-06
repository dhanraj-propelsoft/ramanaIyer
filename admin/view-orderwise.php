<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $oid = trim($_GET['oid']);
    ?>
    <?php include('include/header.php'); ?>

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <?php
                $actmenu = "orderwise";
                include('include/sidebar.php'); ?>
                <div class="span9">
                    <div class="content">

                        <div class="module">
                            <div class="module-head">
                                <b>View OrderWise</b>
                                <span style="float: right">
                                    <div class="controls">
                                        <button id="download-pdf-button" style="float:right" class="btn btn-ri">Download
                                            PDF</button>
                                    </div>
                                </span>
                            </div>
                            <div class="module-body">

                                <form class="form-horizontal row-fluid" name="vieworder" method="post"
                                    enctype="multipart/form-data">

                                    <div id="prodErr"></div>
                                    <?php
                                    $dtSupply = '';
                                    $remarks = '';
                                    $oDate = '';
                                    $uName = '';
                                    $uMobNo = '';
                                    $uAdrs = '';
                                    $cnt = 1;
                                    $totAmt = 0;

                                    $tblArray = array();

                                    $query = mysqli_query($con, "SELECT users.name AS uName, users.contactno AS uMobNo, users.shippingAddress AS sAdrs, users.shippingState AS sState, users.shippingCity AS sCity, users.shippingPincode AS sPin,orders.orderDate AS oDate, orders.quantity AS oQuantity,orders.price AS oPrice,orders.dtSupply AS oDtSupply,orders.remarks AS oRemarks,products.productName AS pName,products.productPrice AS pPrice from orders JOIN users ON users.id=orders.userId JOIN products WHERE products.id=orders.productId AND orders.orderId='" . $oid . "'");
                                    while ($row = mysqli_fetch_array($query)) {
                                        $dtSupply = $row['oDtSupply'];
                                        $remarks = $row['oRemarks'];
                                        $oDate = $row['oDate'];
                                        $uName = $row['uName'];
                                        $uMobNo = $row['uMobNo'];
                                        $uAdrs = $row['sAdrs'] . ", " . $row['sState'] . ", " . $row['sCity'] . ", " . $row['sPin'];
                                        $amount = 0;
                                        if (intval($row['oPrice']) > 0) {
                                            $totAmt += intval($row['oPrice']);
                                            $amount = $row['oPrice'];
                                        } else {
                                            $totAmt += intval($row['pPrice']);
                                            $amount = $row['pPrice'];
                                        }
                                        $tblArray[] = array(
                                            'dtSupply' => $dtSupply,
                                            'remarks' => $remarks,
                                            'oDate' => $oDate,
                                            'uName' => $uName,
                                            'uMobNo' => $uMobNo,
                                            'uAdrs' => $uAdrs,
                                            'cnt' => $cnt,
                                            'iName' => $row['pName'],
                                            'iPrice' => $row['pPrice'],
                                            'iQty' => $row['oQuantity'],
                                            'amount' => $amount
                                        );
                                        $cnt++;
                                    }
                                    $query1 = mysqli_query($con, "SELECT users.name AS uName, users.contactno AS uMobNo, users.shippingAddress AS sAdrs, users.shippingState AS sState, users.shippingCity AS sCity, users.shippingPincode AS sPin,orders.orderDate AS oDate, orders.quantity AS oQuantity,orders.price AS oPrice,orders.dtSupply AS oDtSupply,orders.remarks AS oRemarks,combo.comboName AS cName,combo.comboPrice AS cPrice from orders JOIN users ON users.id=orders.userId JOIN combo WHERE combo.id=orders.comboId AND orders.orderId='" . $oid . "'");
                                    while ($row1 = mysqli_fetch_array($query1)) {
                                        $dtSupply = $row1['oDtSupply'];
                                        $remarks = $row1['oRemarks'];
                                        $oDate = $row1['oDate'];
                                        $uName = $row1['uName'];
                                        $uMobNo = $row1['uMobNo'];
                                        $uAdrs = $row1['sAdrs'] . ", " . $row1['sState'] . ", " . $row1['sCity'] . ", " . $row1['sPin'];
                                        $amount = 0;
                                        if (intval($row1['oPrice']) > 0) {
                                            $totAmt += intval($row1['oPrice']);
                                            $amount = $row1['oPrice'];
                                        } else {
                                            $totAmt += intval($row1['cPrice']);
                                            $amount = $row1['cPrice'];
                                        }
                                        $tblArray[] = array(
                                            'dtSupply' => $dtSupply,
                                            'remarks' => $remarks,
                                            'oDate' => $oDate,
                                            'uName' => $uName,
                                            'uMobNo' => $uMobNo,
                                            'uAdrs' => $uAdrs,
                                            'cnt' => $cnt,
                                            'iName' => $row1['cName'],
                                            'iPrice' => $row1['cPrice'],
                                            'iQty' => $row1['oQuantity'],
                                            'amount' => $amount
                                        );
                                        $cnt++;
                                    }
                                    ?>
                                    <div id="content">
                                        <p><label style="font-weight: bold; display: inline">Total Amount - </label>Rs.<span
                                                id="totAmt">
                                                <?= $totAmt; ?>
                                            </span></p>
                                        <p><label style="font-weight: bold; display: inline">Order Id - </label>
                                            <?= $oid ?>
                                        </p>
                                        <p><label style="font-weight: bold; display: inline">Customer Name - </label>
                                            <?= $uName ?>
                                        </p>
                                        <p><label style="font-weight: bold; display: inline">Customer Mobile Number -
                                            </label>
                                            <?= $uMobNo ?>
                                        </p>
                                        <p><label style="font-weight: bold; display: inline">Shipping Address - </label>
                                            <?= $uAdrs ?>
                                        </p>
                                        <p><label style="font-weight: bold; display: inline">Ordered Date - </label>
                                            <?php if (!empty($oDate)) {
                                                echo htmlentities(date('d-m-Y h:i:s A', strtotime($oDate)));
                                            } ?>
                                        </p>
                                        <p><label style="font-weight: bold; display: inline">Delivery Date & Time - </label>
                                            <?php if (!empty($dtSupply)) {
                                                echo htmlentities(date('d-m-Y h:i:s A', strtotime($dtSupply)));
                                            } ?>
                                        </p>
                                        <p><label style="font-weight: bold; display: inline">Remarks - </label>
                                            <?= $remarks ?>
                                        </p>
                                    </div>
                                    <br />
                                    <table id="tblProd" cellpadding="0" cellspacing="0" border="0"
                                        class="table table-striped" style="width:100%;padding:5px;">
                                        <thead>
                                            <tr>
                                                <th width="100">S.No</th>
                                                <th width="400">Item <span style="color: red">*</span></th>
                                                <th width="250">Unit per Price <span style="color: red">*</span></th>
                                                <th width="250">No of Packs <span style="color: red">*</span></th>
                                                <th width="200">Amount <span style="color: red">*</span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblBody">
                                            <?php
                                            foreach ($tblArray as $rw) { ?>
                                                <tr>
                                                    <td>
                                                        <?= $rw['cnt'] ?>
                                                    </td>
                                                    <td><label style="font-weight: bold;">
                                                            <?= $rw['iName']; ?>
                                                        </label></td>
                                                    <td><label style="font-weight: bold;">
                                                            <?= $rw['iPrice']; ?>
                                                        </label></td>
                                                    <td><label style="font-weight: bold;">
                                                            <?= $rw['iQty']; ?>
                                                        </label></td>
                                                    <td><label style="font-weight: bold;">
                                                            <?= $rw['amount']; ?>
                                                        </label></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <br />
                                    <input class="btn btn-primary" type="button" value="Back"
                                        onclick="window.location.href = 'orderwise.php'" />
                                </form>
                            </div>
                        </div>





                    </div><!--/.content-->
                </div><!--/.span9-->
            </div>
        </div><!--/.container-->
    </div><!--/.wrapper-->

    <?php include('include/footer.php'); ?>
    <script>
        document.getElementById("download-pdf-button").addEventListener("click", () => {
            var doc = new jsPDF('p', 'pt', 'letter');

            const d = new Date();
            const pageSize = doc.internal.pageSize;
            const pageWidth = pageSize.width ? pageSize.width : pageSize.getWidth();
            const pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();

            source = $('#content')[0];

            specialElementHandlers = {
                '#editor': function (element, renderer) {
                    return true
                }
            };

            margins = {
                top: 40,
                left: 40,
                width: pageSize.getWidth(),
                height: pageSize.getHeight()
            };

            doc.setFontSize(14);

            doc.fromHTML(
                source,
                margins.left, // x coord
                margins.top, { // y coord
                'width': margins.width, // max width of content on PDF
                'height': margins.height, // max height of content on PDF
                'elementHandlers': specialElementHandlers
            }
            );

            //doc.addPage();

            doc.setFontSize(12);
            //doc.text(40, 45, '');

            const table = document.getElementById("tblProd");

            //Convert the HTML table to PDF
            doc.autoTable({
                startY: 240,
                html: table
            });

            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                const headerL = 'Ramana Iyer Sweets & Snacks';
                const headerR = 'Orderwise List';
                const footerL = `PDF downloaded at: ${d}`;
                const footerR = `Page ${i} of ${pageCount}`;

                doc.text(headerL, 40, 15, { align: 'left', baseline: 'top' });
                doc.text(headerR, pageWidth - 40, 15, { align: 'right', baseline: 'top' });
                doc.text(footerL, 40, pageHeight - 25, { align: 'left', baseline: 'top' });
                doc.text(footerR, pageWidth - 40, pageHeight - 25, { align: 'right', baseline: 'top' });
                //doc.text(footerR, pageWidth / 2 - (doc.getTextWidth(footer) / 2), pageHeight - 15, { baseline: 'bottom' });
            }

            doc.save('order-wise.pdf')
        });
    </script>
<?php } ?>