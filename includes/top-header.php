<?php 
//session_start();

?>

<div class="top-bar animate-dropdown">
	<div class="container">
		<div class="header-top-inner">
			<div class="cnt-account">
				<ul class="list-unstyled">

<?php if(strlen($_SESSION['login']))
    {   ?>
				<li><a href="#"><i class="icon fa fa-user white-icon"></i>Welcome - <?php echo htmlentities($_SESSION['username']);?></a></li>
				<?php } ?>

					<li><a href="my-account.php"><i class="icon fa fa-user white-icon"></i>My Account</a></li>
					<li><a href="my-wishlist.php"><i class="icon fa fa-heart white-icon"></i>Wishlist</a></li>
					<li><a href="my-cart.php"><i class="icon fa fa-shopping-cart white-icon"></i>My Cart</a></li>
					<li><a href="track-orders.php"><i class="icon fa fa-truck white-icon"></i>Track Order</a></li>
					<?php if(strlen($_SESSION['login'])==0)
    {   ?>
<li><a href="login.php"><i class="icon fa fa-sign-in white-icon"></i>Login</a></li>
<?php }
else{ ?>
	
				<li><a href="logout.php"><i class="icon fa fa-sign-out white-icon"></i>Logout</a></li>
				<?php } ?>	
				</ul>
			</div><!-- /.cnt-account -->

			<div class="cnt-block">
				
            
				<a href="https://www.facebook.com/profile.php?id=100086171762349" target="_blank"><i class="icon fa fa-facebook fa-lg white-icon soc-med-icon"></i></a>&nbsp;
				<a href="https://www.instagram.com/ramana_trichy/" target="_blank"><i class="icon fa fa-instagram fa-lg white-icon soc-med-icon"></i></a>&nbsp;
				<a href="https://www.youtube.com/channel/UCmgDqJymEAzk5Tuz2eOlJyw" target="_blank"><i class="icon fa fa-youtube fa-lg white-icon soc-med-icon"></i></a>&nbsp;
        
       
			</div>
			
			<div class="clearfix"></div>
		</div><!-- /.header-top-inner -->
	</div><!-- /.container -->
</div><!-- /.header-top -->