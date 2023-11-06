<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_GET['del'])) {
        // $result1 = mysqli_query($con, "SELECT * FROM orders WHERE productId='" . $_GET['id'] . "' AND (orderStatus IS NULL OR orderStatus!='Delivered')");
        // $row_cnt1 = mysqli_num_rows($result1);
        // if ($row_cnt1 > 0) {
        //     $_SESSION['delmsg'] = "Could not delete since this combo has been ordered by customer !!";
        // } else {
        $dirname = "comboimages/" . $_GET['id'];
        array_map('unlink', glob("$dirname/*.*"));
        rmdir($dirname);
        mysqli_query($con, "delete from combo where id = '" . $_GET['id'] . "'");
        mysqli_query($con, "delete from combo_product where comboId = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "Combo deleted !!";
        //}
    }

    ?>
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
                                <b>Manage Combos</b>
                                <span style="float: right">
                                    <div class="controls">
                                        <a href="insert-combo.php" class="btn btn-ri">Create</a>
                                    </div>
                                </span>
                            </div>
                            <div class="module-body table">
                                <?php if (isset($_GET['del'])) { ?>
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Oh snap!</strong>
                                        <?php echo htmlentities($_SESSION['delmsg']); ?>
                                        <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                    </div>
                                <?php } ?>

                                <br />


                                <table cellpadding="0" cellspacing="0" border="0"
                                    class="datatable-1 table table-bordered table-striped	 display"
                                    style="width:100%;padding:5px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Combo Name</th>
                                            <th>Description </th>
                                            <th>Price</th>
                                            <th>Availability</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $query = mysqli_query($con, "select * from combo");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo htmlentities($cnt); ?>
                                                </td>
                                                <td class="wrap_td_100">
                                                    <?php echo htmlentities($row['comboName']); ?>
                                                </td>
                                                <td class="wrap_td_100">
                                                    <?php echo htmlentities($row['comboDescription']); ?>
                                                </td>
                                                <td class="wrap_td_100">
                                                    <?php echo htmlentities($row['comboPrice']); ?>
                                                </td>
                                                <td class="wrap_td_100">
                                                    <?php echo htmlentities($row['comboAvailability']); ?>
                                                </td>
                                                <td class="wrap_td_100">
                                                    <?php echo date("d-m-Y h:i:s A", strtotime($row['postingDate'])); ?>
                                                </td>
                                                <td>
                                                    <a href="edit-combo.php?id=<?php echo $row['id'] ?>"><i
                                                            class="icon-edit"></i></a>
                                                    <a onClick="delPopup('<?php echo $row['id'] ?>')"><i
                                                            class="icon-remove-sign"></i></a>
                                                </td>
                                            </tr>
                                            <?php $cnt = $cnt + 1;
                                        } ?>

                                </table>
                            </div>
                        </div>



                    </div><!--/.content-->
                </div><!--/.span9-->
            </div>
        </div><!--/.container-->
    </div><!--/.wrapper-->

    <?php include('include/footer.php'); ?>
    <script>
        $(document).ready(function () {
            $('.datatable-1').DataTable();
            // $('.dataTables_paginate').addClass("btn-group datatable-pagination");
            // $('.dataTables_paginate > a').wrapInner('<span />');
            // $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            // $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
        });

        function delPopup(ele) {
            Swal.fire({
                title: 'Warning!',
                text: 'Are you sure you want to delete?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'manage-combos.php?id=' + ele + '&del=delete';
                }
            });
        }
    </script>
<?php } ?>