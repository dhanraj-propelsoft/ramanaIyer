<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $comboimage2 = "";
    $comboimage3 = "";
    if (isset($_POST['submit'])) {
        $comboname = $_POST['comboName'];
        $comboprice = $_POST['comboprice'];
        $combopricebd = $_POST['combopricebd'];
        $combodescription = $_POST['comboDescription'];
        $comboscharge = $_POST['comboShippingcharge'];
        $comboavailability = $_POST['comboAvailability'];
        $comborating = $_POST['comboRating'];
        $productIds = $_POST['productId'];
        $quantity = $_POST['quantity'];
        $comboimage1 = $_FILES["comboimage1"]["name"];
        if (isset($_FILES["comboimage2"]["name"]))
            $comboimage2 = $_FILES["comboimage2"]["name"];
        if (isset($_FILES["comboimage3"]["name"]))
            $comboimage3 = $_FILES["comboimage3"]["name"];

        $sql = mysqli_query($con, "insert into combo(comboName,comboPrice,comboDescription,shippingCharge,comboAvailability,comboRating,comboImage1,comboImage2,comboImage3,comboPriceBeforeDiscount) values('$comboname','$comboprice','$combodescription','$comboscharge','$comboavailability','$comborating','$comboimage1','$comboimage2','$comboimage3','$combopricebd')");

        //for getting combo id
        $query1 = mysqli_query($con, "select max(id) as cid from combo");
        $result1 = mysqli_fetch_array($query1);
        $comboid = $result1['cid'];
        $dir = "comboimages/" . $comboid;
        if (!is_dir($dir)) {
            mkdir("comboimages/" . $comboid);
        }
      
        move_uploaded_file($_FILES["comboimage1"]["tmp_name"], "comboimages/$comboid/" . $_FILES["comboimage1"]["name"]);
        if (isset($_FILES["comboimage2"]["name"]))
            move_uploaded_file($_FILES["comboimage2"]["tmp_name"], "comboimages/$comboid/" . $_FILES["comboimage2"]["name"]);
        if (isset($_FILES["comboimage3"]["name"]))
            move_uploaded_file($_FILES["comboimage3"]["tmp_name"], "comboimages/$comboid/" . $_FILES["comboimage3"]["name"]);

        $ictr=0;
        foreach($productIds as $productId){
            mysqli_query($con, "insert into combo_product(productId,productQuantity,comboId) values('$productId','$quantity[$ictr]','$comboid')");
            $ictr++;
        }
        $_SESSION['msg'] = "Combo Inserted Successfully !!";
    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | Insert Combo</title>
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
                                    <h3>Insert Combo</h3>
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

                                    <form class="form-horizontal row-fluid" name="insertcombo" method="post"
                                        enctype="multipart/form-data">

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Combo Name
                                                <span>*</span></label>
                                            <div class="controls">
                                                <input type="text" name="comboName" placeholder="Enter Combo Name"
                                                    class="span8 tip" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Combo Price Before
                                                Discount <span>*</span></label>
                                            <div class="controls">
                                                <input type="text"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    name="combopricebd" placeholder="Enter Combo Price"
                                                    class="span8 tip" required>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Combo Price After
                                                Discount(Selling Price) <span>*</span></label>
                                            <div class="controls">
                                                <input type="text"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    name="comboprice" placeholder="Enter Combo Price" class="span8 tip"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Combo Description</label>
                                            <div class="controls">
                                                <textarea name="comboDescription" placeholder="Enter Combo Description"
                                                    rows="6" class="span8 tip">
        </textarea>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Combo Shipping Charge
                                                <span>*</span></label>
                                            <div class="controls">
                                                <input type="text"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    name="comboShippingcharge" placeholder="Enter Combo Shipping Charge"
                                                    class="span8 tip" required>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Combo Availability
                                                <span>*</span></label>
                                            <div class="controls">
                                                <select name="comboAvailability" id="comboAvailability"
                                                    class="span8 tip" required>
                                                    <option value="">Select</option>
                                                    <option value="In Stock">In Stock</option>
                                                    <option value="Out of Stock">Out of Stock</option>
                                                    <option value="Against Order">Against Order</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Combo Rating
                                                <span>*</span></label>
                                            <div class="controls">
                                                <select name="comboRating" id="comboRating" class="span8 tip" required>
                                                    <option value="">Select</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
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
                                                <tr>
                                                    <td class="slNo">1</td>
                                                    <td>
                                                        <select name="productId[]" class="span8 tip" required>
                                                            <option value="" selected disabled>Select</option>
                                                            <?php $query = mysqli_query($con, "select * from products");
                                                            while ($row = mysqli_fetch_array($query)) { ?>

                                                                <option value="<?php echo $row['id']; ?>">
                                                                    <?php echo $row['productName']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="text"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    name="quantity[]" placeholder="Enter Quantity"
                                                    class="span8 tip" required></td>
                                                    <td><a class="remove"><i
                                                                class="icon-remove-sign"></i></a></td>
                                                </tr>
                                                <tr style="display: none;" id="prodRow">
                                                    <td>
                                                        <select name="productId[]" class="span8 tip">
                                                            <option value="" selected disabled>Select</option>
                                                            <?php $query = mysqli_query($con, "select * from products");
                                                            while ($row = mysqli_fetch_array($query)) { ?>

                                                                <option value="<?php echo $row['id']; ?>">
                                                                    <?php echo $row['productName']; ?>
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
                                            <label class="control-label" for="basicinput">Combo Image1
                                                <span>*</span></label>
                                            <div class="controls">
                                                <input type="file" name="comboimage1" id="comboimage1" value=""
                                                    accept="image/*" class="span8 tip" required>
                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Combo Image2</label>
                                            <div class="controls">
                                                <input type="file" name="comboimage2" accept="image/*" class="span8 tip">
                                            </div>
                                        </div>



                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Combo Image3</label>
                                            <div class="controls">
                                                <input type="file" name="comboimage3" accept="image/*" class="span8 tip">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <div class="controls">
                                            <input class="btn btn-primary" type="button" value="Back"
													onclick="window.location.href = 'manage-combos.php'" />
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
            let number = 2; 
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