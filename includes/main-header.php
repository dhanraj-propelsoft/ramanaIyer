<?php 


 if(isset($_Get['action'])){
		if(!empty($_SESSION['product'])){
			foreach($_POST['pQuantity'] as $key => $val){
				if($val==0){
					unset($_SESSION['product'][$key]);
				}else{
					$_SESSION['product'][$key]['quantity']=$val;
				}
			}
		}
		if(!empty($_SESSION['combo'])){
			foreach($_POST['cQuantity'] as $key => $val){
				if($val==0){
					unset($_SESSION['combo'][$key]);
				}else{
					$_SESSION['combo'][$key]['quantity']=$val;
				}
			}
		}
	}
?>
	<div class="main-header">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-3 logo-holder" align="center">
					<!-- ============================================================= LOGO ============================================================= -->
					<div class="logo">
						<a href="index.php">
							<img src="assets/images/ramana-logo.jpg" style="max-height: 65px; width: auto" alt="">
						</a>
					</div>		
				</div>
				<div class="col-xs-12 col-sm-4 col-md-6 top-search-holder top-search-row">
					<div class="search-area">
						<form id="searchform" name="search" method="post" action="search-result.php">
							<div class="input-group">
								<input id="product" class="form-control" required="required" name="product" placeholder="Search here...">
								<span onclick="document.forms['search'].submit();" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
							</div>
						</form>
					</div><!-- /.search-area -->
				</div>
<!-- ============================================================= SEARCH AREA : END ============================================================= -->				

				<div id="cartRefreshDiv" class="col-xs-12 col-sm-4 col-md-3 animate-dropdown top-cart-row">
					<!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
<?php
$totalprice=0;
if((!empty($_SESSION['product'])) || (!empty($_SESSION['combo']))){
	?>
	<div class="dropdown dropdown-cart">
		<ul class="dropdown-menu">
		
		 <?php 
			if(isset($_SESSION['product'])){
		 
		 	$sql = "SELECT * FROM products WHERE id IN(";
			foreach($_SESSION['product'] as $id => $value){
			$sql .=$id. ",";
			}
			$sql=substr($sql,0,-1) . ") ORDER BY id ASC";
			$query = mysqli_query($con, $sql);
			
			$totalqunty=0;
			if(!empty($query)){
			while($row = mysqli_fetch_array($query)){
				$quantity=$_SESSION['product'][$row['id']]['quantity'];
				$subtotal= (int)$_SESSION['product'][$row['id']]['quantity'] * (int)$row['productPrice'] + (int)$row['shippingCharge'];
				$totalprice += $subtotal;
				$_SESSION['qnty'] = $totalqunty += (int)$quantity;

	?>
		
		
			<li>
				<div class="cart-item product-summary">
					<div class="row">
						<div class="col-xs-4">
							<div class="image">
								<a href="product-details.php?pid=<?php echo $row['id'];?>"><img  src="admin/productimages/<?php echo $row['id'];?>/<?php echo $row['productImage1'];?>" width="35" height="auto" style="max-height: 50px;" alt=""></a>
							</div>
						</div>
						<div class="col-xs-7">
							
							<h3 class="name"><a href="product-details.php?pid=<?php echo $row['id'];?>"><?php echo $row['productName']; ?></a></h3>
							<div class="price">Rs.<?php echo ($row['productPrice']+$row['shippingCharge']); ?>*<?php echo $_SESSION['product'][$row['id']]['quantity']; ?></div>
						</div>
						
					</div>
				</div><!-- /.cart-item -->
			
				<?php } } }?>
				<?php 
				if(isset($_SESSION['combo'])){
					$sql1 = "SELECT * FROM combo WHERE id IN(";
					foreach($_SESSION['combo'] as $id => $value){
					$sql1 .=$id. ",";
					}
					$sql1=substr($sql1,0,-1) . ") ORDER BY id ASC";
					$query1 = mysqli_query($con, $sql1);
					
					$cTotalqunty=0;
					if(!empty($query1)){
					while($row1 = mysqli_fetch_array($query1)){
						$cQuantity=$_SESSION['combo'][$row1['id']]['quantity'];
						$cSubtotal= (int)$_SESSION['combo'][$row1['id']]['quantity'] * (int)$row1['comboPrice'] + (int)$row1['shippingCharge'];
						$totalprice += $cSubtotal;
						$_SESSION['qnty'] = $cTotalqunty += (int)$cQuantity;

			?>
		
		
			<li>
				<div class="cart-item product-summary">
					<div class="row">
						<div class="col-xs-4">
							<div class="image">
								<a href="combo-details.php?pid=<?php echo $row1['id'];?>"><img  src="admin/comboimages/<?php echo $row1['id'];?>/<?php echo $row1['comboImage1'];?>" width="35" height="auto" style="max-height: 50px;" alt=""></a>
							</div>
						</div>
						<div class="col-xs-7">
							
							<h3 class="name"><a href="combo-details.php?pid=<?php echo $row1['id'];?>"><?php echo $row1['comboName']; ?></a></h3>
							<div class="price">Rs.<?php echo ($row1['comboPrice']+$row1['shippingCharge']); ?>*<?php echo $_SESSION['combo'][$row1['id']]['quantity']; ?></div>
						</div>
						
					</div>
				</div><!-- /.cart-item -->
			
				<?php } } }?>
				<div class="clearfix"></div>
			<hr>
		
			<div class="clearfix cart-total">
				<div class="pull-right">
					
						<span class="text">Total :</span><span class='price'>Rs.<?php echo $_SESSION['tp']="$totalprice". ".00"; ?></span>
						
				</div>
			
				<div class="clearfix"></div>
					
				<a href="my-cart.php" class="btn btn-upper btn-primary btn-block m-t-20">My Cart</a>	
			</div><!-- /.cart-total-->
					
				
		</li>
		</ul><!-- /.dropdown-menu-->
		<a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
			<div class="items-cart-inner">
				<div class="total-price-basket">
					<span class="lbl">cart -</span>
					<span class="total-price">
						<span class="sign">Rs.</span>
						<span class="value"><?php echo $_SESSION['tp']; ?></span>
					</span>
				</div>
				<div class="basket">
					<i class="glyphicon glyphicon-shopping-cart"></i>
				</div>
				<div class="basket-item-count"><span class="count"><?php echo $_SESSION['qnty'];?></span></div>
			
		    </div>
		</a>
		
	</div><!-- /.dropdown-cart -->
<?php } else { ?>
<div class="dropdown dropdown-cart">
		<a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
			<div class="items-cart-inner">
				<div class="total-price-basket">
					<span class="lbl">cart -</span>
					<span class="total-price">
						<span class="sign">Rs.</span>
						<span class="value">00.00</span>
					</span>
				</div>
				<div class="basket">
					<i class="glyphicon glyphicon-shopping-cart"></i>
				</div>
				<div class="basket-item-count"><span class="count">0</span></div>
			
		    </div>
		</a>
		<ul class="dropdown-menu">
		
	
		
		
			<li>
				<div class="cart-item product-summary">
					<div class="row">
						<div class="col-xs-12">
							Your Shopping Cart is Empty.
						</div>
						
						
					</div>
				</div><!-- /.cart-item -->
			
				
			<hr>
		
			<div class="clearfix cart-total">
				
				<div class="clearfix"></div>
					
				<a href="index.php" class="btn btn-upper btn-primary btn-block m-t-20">Continue Shooping</a>	
			</div><!-- /.cart-total-->
					
				
		</li>
		</ul><!-- /.dropdown-menu-->
		
	</div>
	<?php }?>


	</div>


<!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->				</div><!-- /.top-cart-row -->
			</div><!-- /.row -->

		</div><!-- /.container -->
