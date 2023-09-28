<?php 
    session_start();
    error_reporting(0);
    include('includes/config.php');
    include('includes/header.php');
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
    <div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="home.html">Home</a></li>
					<li class='active'>Payment Status</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
            <h1>Oops!!! Your Last Payment has been cancelled. Please retry the payment to checkout the order.</h1>
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->
    <?php 
    include('includes/footer.php');
?>