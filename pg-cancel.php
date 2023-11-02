<?php 
    session_start();
    error_reporting(0);
    if (strlen($_SESSION['login']) == 0) {
        $_SESSION['lastSeen'] = 'pg-cancel.php';
        header('location:login.php');
        exit;
    } else {
        $_SESSION['lastSeen'] = '';
    include('includes/config.php');
    echo "<h1>Oops!!! Your Last Payment has been cancelled. Please retry the payment to checkout the order.</h1>";
    echo "<script>
            Swal.fire({
                title: 'Oops!',
                text: 'Your Last Payment has been cancelled.',
                icon: 'info',
                showDenyButton: true,
                confirmButtonText: 'Retry Payment',
                denyButtonText: 'Continue Shopping',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'pg-redirect.php';
                } else if (result.isDenied) {
                    window.location.href = 'index.php';
                }
            });
            </script>";
    ?>
    <?php 
    }
?>