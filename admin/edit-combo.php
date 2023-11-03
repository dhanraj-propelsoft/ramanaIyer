<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $pid = intval($_GET['id']); // combo id
    if (isset($_POST['submit'])) {
        $comboname = str_replace("'","''", $_POST['comboName']);
        $comboprice = $_POST['comboprice'];
        $combopricebd = $_POST['combopricebd'];
        $combodescription = str_replace("'","''", $_POST['comboDescription']);
        $comboscharge = $_POST['comboShippingcharge'];
        $comboavailability = $_POST['comboAvailability'];
        $comborating = $_POST['comboRating'];
        $productIds = $_POST['productId'];
        $quantity = $_POST['quantity'];

        $sql = mysqli_query($con, "update  combo set comboName='$comboname',comboPrice='$comboprice',comboDescription='$combodescription',shippingCharge='$comboscharge',comboAvailability='$comboavailability',comboRating='$comborating',comboPriceBeforeDiscount='$combopricebd' where id='$pid' ");
        
        $ictr=0;
        mysqli_query($con, "delete from combo_product where comboId = '" . $pid . "'");
        foreach($productIds as $productId){
            mysqli_query($con, "insert into combo_product(productId,productQuantity,comboId) values('$productId','$quantity[$ictr]','$pid')");
            $ictr++;
        }
        $_SESSION['msg'] = "Combo Updated Successfully !!";

    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | Update Combo</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='css/opensans.css' rel='stylesheet'>
        <script src="assets/js/nicEdit-latest.js" type="text/javascript"></script>
        <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>


    </head>

    <body>
        <?php include('include/header.php'); ?>

        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <?php
                    $actmenu = "ins_combo";
                    include('include/sidebar.php'); ?>
                    <div class="span9">
                        <div class="content">

                            <div class="module">
                                <div class="module-head">
                                    <h3>Update Combo</h3>
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

                                    <form class="form-horizontal row-fluid" name="insertcombo" method="post"
                                        enctype="multipart/form-data">

                                        <?php

                                        $query = mysqli_query($con, "select * from combo where id='$pid'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {



                                            ?>
                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Name</label>
                                                <div class="controls">
                                                    <input type="text" name="comboName" placeholder="Enter Combo Name"
                                                        value="<?php echo htmlentities($row['comboName']); ?>"
                                                        class="span8 tip">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Price Before
                                                    Discount</label>
                                                <div class="controls">
                                                    <input type="text" name="combopricebd" placeholder="Enter Combo Price"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
														value="<?php echo htmlentities($row['comboPriceBeforeDiscount']); ?>"
                                                        class="span8 tip" required>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Price</label>
                                                <div class="controls">
                                                    <input type="text" name="comboprice" placeholder="Enter Combo Price"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
														value="<?php echo htmlentities($row['comboPrice']); ?>"
                                                        class="span8 tip" required>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Description</label>
                                                <div class="controls">
                                                    <textarea name="comboDescription" placeholder="Enter Combo Description"
                                                        rows="6" class="span8 tip">
                <?php echo htmlentities($row['comboDescription']); ?>
                </textarea>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Shipping Charge</label>
                                                <div class="controls">
                                                    <input type="text" name="comboShippingcharge"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
														placeholder="Enter Combo Shipping Charge"
                                                        value="<?php echo htmlentities($row['shippingCharge']); ?>"
                                                        class="span8 tip" required>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Availability</label>
                                                <div class="controls">
                                                    <select name="comboAvailability" id="comboAvailability" class="span8 tip"
                                                        required>
                                                        <option value="In Stock" <?php if ($row['comboAvailability'] == "In Stock") {
                                                            echo "selected";
                                                        } ?>>In Stock</option>
                                                        <option value="Out of Stock" <?php if ($row['comboAvailability'] == "Out of Stock") {
                                                            echo "selected";
                                                        } ?>>Out of Stock</option>
                                                        <option value="Against Order" <?php if ($row['comboAvailability'] == "Against Order") {
                                                            echo "selected";
                                                        } ?>>Against Order</option>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Rating</label>
                                                <div class="controls">
                                                    <select name="comboRating" id="comboRating" class="span8 tip" required>
                                                        <option value="1" <?php if ($row['comboRating'] == "1") {
                                                            echo "selected";
                                                        } ?>>1</option>
                                                        <option value="2" <?php if ($row['comboRating'] == "2") {
                                                            echo "selected";
                                                        } ?>>2</option>
                                                        <option value="3" <?php if ($row['comboRating'] == "3") {
                                                            echo "selected";
                                                        } ?>>3</option>
                                                        <option value="4" <?php if ($row['comboRating'] == "4") {
                                                            echo "selected";
                                                        } ?>>4</option>
                                                        <option value="5" <?php if ($row['comboRating'] == "5") {
                                                            echo "selected";
                                                        } ?>>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="prodErr"></div>
                                            <table id="tblProd" cellpadding="0" cellspacing="0" border="0"
                                            class="table table-striped"
                                            style="width:100%;padding:5px;">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Product <span style="color: red">*</span></th>
                                                        <th>Quantity <span style="color: red">*</span></th>
                                                        <th><a id="addProduct"><i class="icon-plus-sign-alt"></i></a></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tblBody">
                                                    <?php
                                                    $query3 = mysqli_query($con, "select * from combo_product where comboId='$pid'");
                                                    $cnt = 1;
                                                    while ($row3 = mysqli_fetch_array($query3)) {
                                                    ?>
                                                    <tr>
                                                        <td class="slNo"><?=$cnt?></td>
                                                        <td>
                                                            <select name="productId[]" class="span8 tip" required>
                                                                <option value="" selected disabled>Select</option>
                                                                <?php $query2 = mysqli_query($con, "select * from products");
                                                                while ($row2 = mysqli_fetch_array($query2)) { ?>

                                                                    <option value="<?php echo $row2['id']; ?>" <?php if ($row3['productId'] == $row2['id']) {
                                                            echo "selected"; } ?>>
                                                                        <?php echo $row2['productName']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" value="<?php echo $row3['productQuantity']; ?>"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                        name="quantity[]" placeholder="Enter Quantity"
                                                        class="span8 tip" required></td>
                                                        <td><a class="remove"><i
                                                                    class="icon-remove-sign"></i></a></td>
                                                    </tr>
                                                    <?php 
                                                    $cnt++;
                                                    } ?>
                                                    <tr style="display: none;" id="prodRow">
                                                        <td>
                                                            <select name="productId[]" class="span8 tip">
                                                                <option value="" selected disabled>Select</option>
                                                                <?php $query4 = mysqli_query($con, "select * from products");
                                                                while ($row4 = mysqli_fetch_array($query4)) { ?>

                                                                    <option value="<?php echo $row4['id']; ?>">
                                                                        <?php echo $row4['productName']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td><input type="text"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                        name="quantity[]" placeholder="Enter Quantity"
                                                        class="span8 tip"></td>
                                                        <td><a class="remove"><i
                                                                    class="icon-remove-sign"></i></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br/>

                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Image1</label>
                                                <div class="controls">
                                                    <img src="comboimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['comboImage1']); ?>"
                                                        width="200" height="100"> <a
                                                        href="upd-combo-img1.php?id=<?php echo $row['id']; ?>">Change Image</a>
                                                </div>
                                            </div>


                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Image2</label>
                                                <div class="controls">
                                                    <?php if (!empty($row['comboImage2'])) { ?>
													<img src="comboimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['comboImage2']); ?>"
                                                        width="200" height="100"> <a
                                                        href="upd-combo-img2.php?id=<?php echo $row['id']; ?>">Change Image</a>
													<?php } else { echo '<a
														href="upd-combo-img2.php?id='.$row['id'].'">Add Image</a>'; } ?>
                                                </div>
                                            </div>



                                            <div class="control-group">
                                                <label class="control-label" for="basicinput">Combo Image3</label>
                                                <div class="controls">
                                                    <?php if (!empty($row['comboImage3'])) { ?>
													<img src="comboimages/<?php echo htmlentities($pid); ?>/<?php echo htmlentities($row['comboImage3']); ?>"
                                                        width="200" height="100"> <a
                                                        href="upd-combo-img3.php?id=<?php echo $row['id']; ?>">Change Image</a>
													<?php } else { echo '<a
														href="upd-combo-img3.php?id='.$row['id'].'">Add Image</a>'; } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="control-group">
                                            <div class="controls">
                                                <input class="btn btn-primary" type="button" value="Back"
                                                    onclick="window.location.href = 'manage-combos.php'" />
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
            let number = <?=$cnt?>; 
            $(document).ready(function () {
                $('.datatable-1').dataTable();
                $('.dataTables_paginate').addClass("btn-group datatable-pagination");
                $('.dataTables_paginate > a').wrapInner('<span />');
                $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
                $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
            });
            $(document).on('click','.remove',function(){
                $(this).parents('tr').remove();
                number--;
                let incrSlNo=$('#tblBody').children().find(".slNo");
                //console.log(incrSlNo.length);
                for (let j = 0; j < incrSlNo.length; j++) {
                    $(incrSlNo[j]).html(j+1);
                }
            });
            $("#addProduct").click(function(){
                let validInd = 0;
                let todoSelects=$('#tblBody').children().find("select");
                let todoInputs=$('#tblBody').children().find("input");
                for (let k = 0; k < todoSelects.length-1; k++) {
                    if((!($(todoSelects[k]).val())) || (!($(todoInputs[k]).val())))
                        validInd = 1;
                    else
                        validInd = 0;
                }
                if(validInd == 1)
                {
                    $("#prodErr").html("<br/><div class='alert alert-error'><strong>Attention!</strong> Please fill below Mandatory (*) fields.</div>");
                    $("#prodErr").fadeTo(5000, 500).slideUp(500, function(){
                        $("#prodErr").slideUp(500);
                    });
                } else {
                    for (let j = 0; j < todoSelects.length; j++) {
                        //console.log($(todoSelects[j]).val());
                        $("#prodRow").find("select option[value='"+$(todoSelects[j]).val()+"']").remove();
                    }
                    let todoValue = $("#prodRow").html();
                    $("#prodRow").before("<tr><td class='slNo'>"+`${number++}`+"</td>" + todoValue + "</tr>");
                }
            });
        </script>
    </body>
<?php } ?>