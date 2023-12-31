<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $oid = trim($_GET['oid']); // product id
    $orderedPdts = array();
    if (isset($_POST['submit'])) {
        $productIds = $_POST['productId'];
        $table = $_POST['table'];
        $quantity = $_POST['quantity'];
        $amount = $_POST['amount'];
        $dateTime = date("Y-m-d H:i:s", strtotime($_POST["dateTime"]));
        $remarks = $_POST['remarks'];
        $userId = $_POST['userId'];

        $query7 = mysqli_query($con, "SELECT productId, quantity FROM orders WHERE orderId='$oid'");
        while ($row7 = mysqli_fetch_array($query7)) {
            $rowData = array(
                "productId" => $row7["productId"],
                "quantity" => $row7["quantity"],
            );
            $orderedPdts[] = $rowData;
        }

        $ictr = 0;
        $errorText = "";
        $pdtArray = array();
        $cmbArray = array();
        foreach ($productIds as $productId) {
            if ($table[$ictr] == "combo") {
                $cmbData = array(
                    "comboId" => $productId,
                    "quantity" => $quantity[$ictr],
                    "price" => $amount[$ictr]
                );
                $cmbArray[] = $cmbData;
            } else {
                $avail_qty = 0;
                foreach ($orderedPdts as $orderedPdt) {
                    if ($orderedPdt["productId"] == $productId)
                        $avail_qty += $orderedPdt["quantity"];
                }

                $quant = $quantity[$ictr];
                $query3 = mysqli_query($con, "SELECT productName,productAvailability,prod_avail,allow_ao from products where id='" . $productId . "'");
                if ($row3 = mysqli_fetch_array($query3)) {
                    $productName = $row3['productName'];
                    $productAvailability = $row3['productAvailability'];
                    $avail_qty += intval($row3['prod_avail']);
                    $allow_ao = intval($row3['allow_ao']);

                    if ($productAvailability == "Out of Stock") {
                        $errorText .= "<BR/><b>$productName - </b>Out of Stock!!!";
                    } else if ($productAvailability == "In Stock") {
                        if (($allow_ao == 0) && ($avail_qty == 0))
                            $errorText .= "<BR/><b>$productName - </b>Out of Stock!!!";
                        else if (($allow_ao == 0) && ($avail_qty < $quant))
                            $errorText .= "<BR/><b>$productName - </b>Please order the product within the available quantity of <b>[$avail_qty]</b>";
                    }
                }

                if ($errorText == "") {
                    $new_prod_avail = $avail_qty - $quant;
                    if ($new_prod_avail < 0)
                        $new_prod_avail = 0;

                    $pdtData = array(
                        "productId" => $productId,
                        "quantity" => $quant,
                        "price" => $amount[$ictr],
                        "new_prod_avail" => $new_prod_avail
                    );
                    $pdtArray[] = $pdtData;
                }
            }
            $ictr++;
        }

        if ($errorText == "") {
            foreach ($orderedPdts as $orderedPdt) {
                if (!in_array($orderedPdt['productId'], $productIds)) {
                    $ex_qty = $orderedPdt['quantity'];
                    mysqli_query($con, "UPDATE products SET prod_avail = prod_avail + $ex_qty WHERE id='" . $orderedPdt['productId'] . "'");
                }
            }
            mysqli_query($con, "DELETE FROM orders WHERE orderId='$oid'");
            foreach ($pdtArray as $pdtArr) {
                //echo $pdtArr["productId"].",".$pdtArr["quantity"].",".$pdtArr["price"].",".$pdtArr["new_prod_avail"];
                mysqli_query($con, "UPDATE products SET prod_avail='" . $pdtArr["new_prod_avail"] . "' WHERE id='" . $pdtArr["productId"] . "'");
                mysqli_query($con, "INSERT INTO orders (`userId`,`productId`,`quantity`,`price`,`dtSupply`,`remarks`,`paymentMethod`,`orderId`,`orderBy`) VALUES ('$userId','" . $pdtArr["productId"] . "','" . $pdtArr["quantity"] . "','" . $pdtArr["price"] . "','$dateTime','$remarks','ADMIN','$oid','Admin')");
            }
            foreach ($cmbArray as $cmbArr) {
                //echo $cmbArr["comboId"].",".$cmbArr["quantity"].",".$cmbArr["price"];
                mysqli_query($con, "INSERT INTO orders (`userId`,`comboId`,`quantity`,`price`,`dtSupply`,`remarks`,`paymentMethod`,`orderId`,`orderBy`) VALUES ('$userId','" . $cmbArr["comboId"] . "','" . $cmbArr["quantity"] . "','" . $cmbArr["price"] . "','$dateTime','$remarks','ADMIN','$oid','Admin')");
            }

            mysqli_query($con, "INSERT into orders(userId,paymentMethod,paymentId,orderId,orderBy,price,dtSupply,remarks) values('$userId','ADMIN','ADMIN','$oid','Admin','40','$dateTime','Shipping Charge')");

            header("Location: pending-orders.php");
            exit;
        }
    }


    ?>
    <?php include('include/header.php'); ?>

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <?php
                $actmenu = "pending";
                include('include/sidebar.php'); ?>
                <div class="span9">
                    <div class="content">

                        <div class="module">
                            <div class="module-head">
                                <h3>Edit Order</h3>
                                <!-- <span style="float: right">
                                        <div class="controls">
                                            <a href="insert-combo.php" class="btn">Add Order</a>
                                        </div>
                                    </span> -->
                            </div>
                            <div class="module-body">

                                <?php if ((isset($_POST['submit'])) && (!empty($errorText))) { ?>
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Oh snap!</strong>
                                        <?php echo $errorText; ?>
                                    </div>
                                <?php } ?>

                                <br />

                                <form class="form-horizontal row-fluid" name="insertproduct" method="post"
                                    enctype="multipart/form-data">

                                    <div id="prodErr"></div>
                                    <?php
                                    $dtSupply = '';
                                    $remarks = '';
                                    $uId = '';
                                    $cnt = 1;
                                    $totAmt = 0;
                                    ?>
                                    <table id="tblProd" cellpadding="0" cellspacing="0" border="0"
                                        class="table table-striped" style="width:100%;padding:5px;">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Item <span style="color: red">*</span></th>
                                                <th width="100">Unit per Price <span style="color: red">*</span></th>
                                                <th>No of Packs <span style="color: red">*</span></th>
                                                <th>Amount <span style="color: red">*</span></th>
                                                <th><a id="addProduct"><i class="icon-plus-sign-alt"></i></a></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblBody">
                                            <?php
                                            $query6 = mysqli_query($con, "select orders.userId AS uId,orders.quantity AS oQuantity,orders.price AS oPrice,orders.dtSupply AS oDtSupply,orders.remarks AS oRemarks,products.productName AS pName,products.productPrice AS pPrice, products.id AS pId from orders JOIN products WHERE products.id=orders.productId AND orders.orderId='" . $oid . "'");
                                            $amount = 0;
                                            while ($row6 = mysqli_fetch_array($query6)) {
                                                $dtSupply = str_replace(" ", "T", $row6['oDtSupply']);
                                                $remarks = $row6['oRemarks'];
                                                $uId = $row6['uId'];
                                                if (intval($row6['oPrice']) > 0) {
                                                    $totAmt += intval($row6['oPrice']);
                                                    $amount = $row6['oPrice'];
                                                } else {
                                                    $totAmt += intval($row6['pPrice']);
                                                    $amount = $row6['pPrice'];
                                                }
                                                ?>
                                                <tr>
                                                    <td class="slNo">
                                                        <?= $cnt ?>
                                                    </td>
                                                    <td>
                                                        <select name="productId[]" class="productId span8 tip" required>
                                                            <option value="" selected disabled>Select</option>
                                                            <?php $query5 = mysqli_query($con, "select products.* from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory");
                                                            while ($row5 = mysqli_fetch_array($query5)) {
                                                                if (($row5['productAvailability'] == 'Against Order') || (($row5['productAvailability'] == 'In Stock') && ((intval($row5['prod_avail']) > 0) || ((intval($row5['prod_avail']) == 0) && (intval($row5['allow_ao']) == 1))))) { ?>
                                                                    <option price="<?php echo $row5['productPrice']; ?>"
                                                                        table="products" value="<?php echo $row5['id']; ?>" <?php if ($row6['pId'] == $row5['id']) {
                                                                               echo 'selected';
                                                                           } ?>>
                                                                        <?php echo $row5['productName']; ?>
                                                                    </option>
                                                                <?php } else {
                                                                    if ($row6['pId'] == $row5['id']) {
                                                                        echo '<option price="' . $row5['productPrice'] . '" table="products" value="' . $row5['id'] . '" selected>
                                                                        ' . $row5['productName'] . '
                                                                    </option>';
                                                                    } else {
                                                                        echo '<option price="' . $row5['productPrice'] . '" table="products" value="' . $row5['id'] . '" disabled>
                                                                        ' . $row5['productName'] . '
                                                                    </option>';
                                                                    }
                                                                }
                                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td><label style="font-weight: bold;" class="price">
                                                            <?= $row6['pPrice']; ?>
                                                        </label><input type="hidden" name="table[]" value="products"
                                                            class="frmTbl"></td>
                                                    <td><input type="text" value="<?= $row6['oQuantity']; ?>"
                                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                            name="quantity[]" placeholder="Enter Quantity"
                                                            class="quantity span8 tip" required></td>
                                                    <td><input type="text" value="<?= $amount; ?>"
                                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                            name="amount[]" placeholder="Enter Amount" onblur="calTotAmt()"
                                                            class="amount span8 tip" required></td>
                                                    <td><a class="remove"><i class="icon-remove-sign"></i></a>
                                                        <input type="hidden" id="count" name="count" value="<?= $cnt; ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $cnt++;
                                            }
                                            $query4 = mysqli_query($con, "select orders.userId AS uId,orders.quantity AS oQuantity,orders.price AS oPrice,orders.dtSupply AS oDtSupply,orders.remarks AS oRemarks,combo.comboName AS cName,combo.comboPrice AS cPrice, combo.id AS cId from orders JOIN combo WHERE combo.id=orders.comboId AND orders.orderId='" . $oid . "'");
                                            while ($row4 = mysqli_fetch_array($query4)) {
                                                $dtSupply = str_replace(" ", "T", $row4['oDtSupply']);
                                                $remarks = $row4['oRemarks'];
                                                $uId = $row4['uId'];
                                                if (intval($row4['oPrice']) > 0) {
                                                    $totAmt += intval($row4['oPrice']);
                                                    $amount = $row4['oPrice'];
                                                } else {
                                                    $totAmt += intval($row4['cPrice']);
                                                    $amount = $row4['cPrice'];
                                                }
                                                ?>
                                                <tr>
                                                    <td class="slNo">
                                                        <?= $cnt ?>
                                                    </td>
                                                    <td>
                                                        <select name="productId[]" class="productId span8 tip" required>
                                                            <option value="" selected disabled>Select</option>
                                                            <?php $query3 = mysqli_query($con, "select * from combo");
                                                            while ($row3 = mysqli_fetch_array($query3)) {
                                                                if (($row3['comboAvailability'] == 'Against Order') || ($row3['comboAvailability'] == 'In Stock')) { ?>
                                                                    <option price="<?php echo $row3['comboPrice']; ?>" table="combo"
                                                                        value="<?php echo $row3['id']; ?>" <?php if ($row4['cId'] == $row3['id']) {
                                                                               echo 'selected';
                                                                           } ?>>
                                                                        <?php echo $row3['comboName']; ?>
                                                                    </option>
                                                                <?php } else {
                                                                    if ($row4['cId'] == $row3['id']) {
                                                                        echo '<option price="' . $row3['comboPrice'] . '" table="combo" value="' . $row3['id'] . '" selected>
                                                                        ' . $row3['comboName'] . '
                                                                    </option>';
                                                                    } else {
                                                                        echo '<option price="' . $row3['comboPrice'] . '" table="combo" value="' . $row3['id'] . '" disabled>
                                                                        ' . $row3['comboName'] . '
                                                                    </option>';
                                                                    }
                                                                }
                                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td><label style="font-weight: bold;" class="price">
                                                            <?= $row4['cPrice']; ?>
                                                        </label><input type="hidden" name="table[]" value="combo"
                                                            class="frmTbl"></td>
                                                    <td><input type="text" value="<?= $row4['oQuantity']; ?>"
                                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                            name="quantity[]" placeholder="Enter Quantity"
                                                            class="quantity span8 tip" required></td>
                                                    <td><input type="text" value="<?= $amount; ?>"
                                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                            name="amount[]" placeholder="Enter Amount" onblur="calTotAmt()"
                                                            class="amount span8 tip" required></td>
                                                    <td><a class="remove"><i class="icon-remove-sign"></i></a>
                                                        <input type="hidden" id="count" name="count" value="<?= $cnt; ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $cnt++;
                                            }
                                            $totAmt += 40; //shipping charges?>
                                            <tr style="display: none;" id="prodRow">
                                                <td>
                                                    <select name="productId[]" class="productId span8 tip"
                                                        onchange="pushPrice(this, this.options[this.selectedIndex].getAttribute('price'), this.options[this.selectedIndex].getAttribute('table'))">
                                                        <option value="" selected disabled>Select</option>
                                                        <?php $query = mysqli_query($con, "select products.* from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory");
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            if (($row['productAvailability'] == 'Against Order') || (($row['productAvailability'] == 'In Stock') && ((intval($row['prod_avail']) > 0) || ((intval($row['prod_avail']) == 0) && (intval($row['allow_ao']) == 1))))) {
                                                                echo '<option price="' . $row['productPrice'] . '" table="products" value="' . $row['id'] . '">
                                                                        ' . $row['productName'] . '
                                                                    </option>';
                                                            } else {
                                                                echo '<option price="' . $row['productPrice'] . '" table="products" value="' . $row['id'] . '" disabled>
                                                                        ' . $row['productName'] . '
                                                                    </option>';
                                                            }
                                                        }

                                                        $query1 = mysqli_query($con, "select * from combo");
                                                        while ($row1 = mysqli_fetch_array($query1)) {
                                                            if (($row1['comboAvailability'] == 'Against Order') || ($row1['comboAvailability'] == 'In Stock')) {
                                                                echo '<option price="' . $row1['comboPrice'] . '" table="combo" value="' . $row1['id'] . '">
                                                                        ' . $row1['comboName'] . '
                                                                    </option>';
                                                            } else {
                                                                echo '<option price="' . $row1['comboPrice'] . '" table="combo" value="' . $row1['id'] . '" disabled>
                                                                        ' . $row1['comboName'] . '
                                                                    </option>';
                                                            }
                                                        } ?>
                                                    </select>
                                                </td>
                                                <td><label style="font-weight: bold;" class="price"></label><input
                                                        type="hidden" name="table[]" class="frmTbl"></td>
                                                <td><input type="text" onkeyup="calAmount(this)"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                        name="quantity[]" placeholder="Enter Quantity"
                                                        class="quantity span8 tip"></td>
                                                <td><input type="text"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                        name="amount[]" placeholder="Enter Amount" onblur="calTotAmt()"
                                                        class="amount span8 tip"></td>
                                                <td><a class="remove"><i class="icon-remove-sign"></i></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table"
                                        style="width:100%;padding:5px;">
                                        <tbody>
                                            <tr>
                                                <td>Delivery Date <input type="datetime-local" required name="dateTime"
                                                        placeholder="Choose date and time" value="<?= $dtSupply; ?>"
                                                        class="span8 tip" step="any"
                                                        min="<?= date('Y-m-d', strtotime('tomorrow')) . "T" . date('H:i:s'); ?>">
                                                </td>
                                                <td><input type="text" name="remarks" placeholder="Enter remarks if any"
                                                        value="<?= $remarks; ?>" class="span8 tip"></td>
                                                <td>
                                                    <div style="font-weight: bold;">Total Amount ₹<span id="totAmt">
                                                            <?= $totAmt; ?>
                                                        </span>*</div>
                                                </td>
                                                <input type="hidden" name="userId" value="<?= $uId; ?>">
                                            </tr>
                                            <tr>
                                                <td colspan="3">* including shipping charges ₹ 40</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                    <table cellpadding="0" cellspacing="0" border="0" style="width:100%;padding:5px;">
                                        <tbody>
                                            <tr>
                                                <td><input class="btn btn-primary" type="button" value="Back"
                                                        onclick="window.location.href = 'view-order.php?oid=<?= $oid ?>'" />
                                                </td>
                                                <td align="center"><button type="submit" name="submit"
                                                        class="btn btn-ri">Update Order</button></td>
                                                <td><a class="btn btn-success" style="float:right"
                                                        href="updateorder.php?oid=<?= $oid ?>&sm=pending">Update
                                                        Status</a></td>
                                            </tr>
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
    <script>
        let number = 2;
        $(".productId").on('change', function () {
            let price = $('option:selected', this).attr('price');
            let table = $('option:selected', this).attr('table');
            pushPrice(this, price, table);
        });
        $(document).on('click', '.remove', function () {
            $(this).parents('tr').remove();
            number--;
            let incrSlNo = $('#tblBody').children().find(".slNo");
            //console.log(incrSlNo.length);
            for (let j = 0; j < incrSlNo.length; j++) {
                $(incrSlNo[j]).html(j + 1);
            }
        });
        $("#addProduct").click(function () {
            let incrSlNo = $('#tblBody').children().find(".slNo");
            //console.log(incrSlNo.length);
            number = incrSlNo.length + 1;

            let validInd = 0;
            let todoSelects = $('#tblBody').children().find("select");
            let todoInputs = $('#tblBody').children().find("input");
            for (let k = 0; k < todoSelects.length - 1; k++) {
                if ((!($(todoSelects[k]).val())) || (!($(todoInputs[k]).val())))
                    validInd = 1;
                else
                    validInd = 0;
            }
            if (validInd == 1) {
                $("#prodErr").html("<div class='alert alert-error'><strong>Attention!</strong> Please fill below Mandatory (*) fields.</div>");
                $("#prodErr").fadeTo(5000, 500).slideUp(500, function () {
                    $("#prodErr").slideUp(500);
                });
            } else {
                for (let j = 0; j < todoSelects.length; j++) {
                    //console.log($(todoSelects[j]).val());
                    $("#prodRow").find("select option[value='" + $(todoSelects[j]).val() + "']").remove();
                }
                let todoValue = $("#prodRow").html();
                $("#prodRow").before("<tr><td class='slNo'>" + `${number++}` + "</td>" + todoValue + "</tr>");
            }
        });
        function pushPrice(ele, val, tbl) {
            $(ele).parents('tr').children().find(".price").html(val);
            $(ele).parents('tr').children().find(".frmTbl").val(tbl);
            let quantity = $(ele).parents('tr').children().find(".quantity").val();
            let calAmt = parseInt(quantity * val);
            $(ele).parents('tr').children().find(".amount").val(calAmt);
            calTotAmt();
        }
        $(".quantity").on('input', function () {
            let quantity = $(this).val();
            let price = $(this).parents('tr').children().find(".price").html();
            let calAmt = parseInt(quantity * price);
            $(this).parents('tr').children().find(".amount").val(calAmt);
            //calAmount(this);
            calTotAmt();
        });
        function calAmount(ele) {
            let quantity = $(ele).val();
            let price = $(ele).parents('tr').children().find(".price").html();
            let calAmt = parseInt(quantity * price);
            $(ele).parents('tr').children().find(".amount").val(calAmt);
            calTotAmt();
        }
        function calTotAmt() {
            let amountInp = $('#tblBody').children().find(".amount");
            let totAmt = 0;
            for (let j = 0; j < amountInp.length - 1; j++) {
                let amount = parseInt($(amountInp[j]).val());
                totAmt = Math.round(totAmt + amount);
            }
            totAmt = totAmt + 40;
            $('#totAmt').html(totAmt);
        }
    </script>
<?php } ?>