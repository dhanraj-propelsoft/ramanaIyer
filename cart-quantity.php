<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_POST['pQuantity'])) {
    $popupText = "";
    $pQty = $_POST["pQuantity"];
    $pId = $_POST["pId"];
    $query3 = mysqli_query($con, "SELECT productName,productAvailability,prod_avail,allow_ao from products where id='" . $pId . "'");
    if ($row3 = mysqli_fetch_array($query3)) {
        $productName = $row3['productName'];
        $productAvailability = $row3['productAvailability'];
        $prod_avail = intval($row3['prod_avail']);
        $allow_ao = intval($row3['allow_ao']);

        if($productAvailability == "Out of Stock") {
            $popupText .= "<b>$productName - </b>Out of Stock!!!<BR/>";
        } else if($productAvailability == "In Stock") {
            if(($allow_ao == 0) && ($prod_avail == 0))
                $popupText .= "<b>$productName - </b>Out of Stock!!!<BR/>";
            else if(($allow_ao == 0) && ($prod_avail < $pQty))
                $popupText .= "<b>$productName - </b>Please order the product within the available quantity of <b>[$prod_avail]</b><BR/>";
        }
    }
    
    if(!empty($popupText)) {
        echo "<script>
        Swal.fire({
            title: 'Attention!',
            html: '$popupText',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        </script>";
        return;
    } else {
        if (isset($_SESSION['product'][$pId])) {
            //$_SESSION['product'][$pId]['quantity']++;
            echo "<script>
                Swal.fire({
                    title: 'Product Already in Cart!',
                    text: 'Do you want to proceed?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const expires = new Date(Date.now() + 1000).toUTCString();
                        document.cookie = `qi_id=$pId; expires=expires`;
                        document.cookie = `qi_qty=$pQty; expires=expires`;
                        window.location.href = 'my-cart.php';
                    }
                });
            </script>";
        } else {
            $sql_p = "SELECT * FROM products WHERE id={$pId}";
            $query_p = mysqli_query($con, $sql_p);
            if (mysqli_num_rows($query_p) != 0) {
                $row_p = mysqli_fetch_array($query_p);
                $_SESSION['product'][$row_p['id']] = array("quantity" => $pQty, "price" => $row_p['productPrice']);
                echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Product has been added to the cart.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Go to Cart',
                    cancelButtonText: 'Continue Shopping'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.location = 'my-cart.php';
                    } else {
                        $('#cartRefreshDiv').load(' #cartRefreshDiv > *');
                    }
                });
            </script>";
            } else {
                $message = "Product ID is invalid";
            }
        }
    }
}

if (isset($_POST['cQuantity'])) {
    $popupText = "";
    $cQty = $_POST["cQuantity"];
    $cId = $_POST["cId"];
    $query3 = mysqli_query($con, "SELECT comboName,comboAvailability from combo where id='" . $cId . "'");
    if ($row3 = mysqli_fetch_array($query3)) {
        $comboName = $row3['comboName'];
        $comboAvailability = $row3['comboAvailability'];

        if($comboAvailability == "Out of Stock") {
            $popupText .= "<b>$comboName - </b>Out of Stock!!!<BR/>";
        }
    }

    if(!empty($popupText)) {
        echo "<script>
            Swal.fire({
                title: 'Attention!',
                html: '$popupText',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
        return;
    } else {
        if (isset($_SESSION['combo'][$cId])) {
            //$_SESSION['product'][$cId]['quantity']++;
            echo "<script>
                Swal.fire({
                    title: 'Combo Already in Cart!',
                    text: 'Do you want to proceed?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const expires = new Date(Date.now() + 1000).toUTCString();
                        document.cookie = `cqi_id=$cId; expires=expires`;
                        document.cookie = `cqi_qty=$cQty; expires=expires`;
                        window.location.href = 'my-cart.php';
                    }
                });
            </script>";
            return;
        } else {
            $sql_c = "SELECT * FROM combo WHERE id={$cId}";
            $query_c = mysqli_query($con, $sql_c);
            if (mysqli_num_rows($query_c) != 0) {
                $row_c = mysqli_fetch_array($query_c);
                $_SESSION['combo'][$row_c['id']] = array("quantity" => $cQty, "price" => $row_c['comboPrice']);
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Combo has been added to the cart.',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Go to Cart',
                        cancelButtonText: 'Continue Shopping'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.location = 'my-cart.php';
                        } else {
                            $('#cartRefreshDiv').load(' #cartRefreshDiv > *');
                        }
                    });
                </script>";
                return;
            } else {
                $message = "Combo ID is invalid";
            }
        }
    }
}
?>