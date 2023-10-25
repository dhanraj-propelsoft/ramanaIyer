<div class="span3">
	<div class="sidebar">


		<ul class="widget widget-menu unstyled">
			<li>
				<a class="<?php if (($actmenu == "orders") || ($actmenu == "pending") || ($actmenu == "delivered") || ($actmenu == "itemwise")) {
								echo "act-menu-icon";
							} else {
								echo "collapsed";
							} ?>" data-toggle="collapse" href="#togglePages">
					<i class="menu-icon icon-shopping-cart"></i>
					<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Order Management
				</a>
				<ul id="togglePages" class="<?php if (($actmenu == "orders") || ($actmenu == "pending") || ($actmenu == "delivered") || ($actmenu == "itemwise")) {
												echo "in ";
											} ?>collapse unstyled">
					<li>
						<a href="todays-orders.php" class="<?php if ($actmenu == "orders") {
																echo "act-menu-icon";
															} ?>">
							<i class="icon-circle-blank"></i>
							Today's Orders
							<?php
							$f1 = "00:00:00";
							$from = date('Y-m-d') . " " . $f1;
							$t1 = "23:59:59";
							$to = date('Y-m-d') . " " . $t1;
							$todayDate = date('Y-m-d');
							$result = mysqli_query($con, "SELECT * FROM orders where dtSupply IS NOT NULL AND DATE(orders.dtSupply) = '$todayDate'AND orderStatus !='Delivered'");
							$num_rows1 = mysqli_num_rows($result); {
							?>
								<b class="label orange pull-right">
									<?php echo htmlentities($num_rows1); ?>
								</b>
							<?php } ?>
						</a>
					</li>
					<li>
						<a href="pending-orders.php" class="<?php if ($actmenu == "pending") {
																echo "act-menu-icon";
															} ?>">
							<i class="icon-circle"></i>
							Order Request
							<?php
							$status = 'Delivered';
							$ret = mysqli_query($con, "SELECT * FROM orders where paymentMethod IS NOT NULL AND (orderStatus!='$status' OR orderStatus is null)");
							$num = mysqli_num_rows($ret); { ?><b class="label orange pull-right">
									<?php echo htmlentities($num); ?>
								</b>
							<?php } ?>
						</a>
					</li>
					<li>
						<a href="delivered-orders.php" class="<?php if ($actmenu == "delivered") {
																	echo "act-menu-icon";
																} ?>">
							<i class="icon-check"></i>
							Delivered Orders
							<?php
							$status = 'Delivered';
							$rt = mysqli_query($con, "SELECT * FROM orders where orderStatus='$status'");
							$num1 = mysqli_num_rows($rt); { ?><b class="label green pull-right">
									<?php echo htmlentities($num1); ?>
								</b>
							<?php } ?>

						</a>
					</li>
					<li>
						<a href="itemwise.php" class="<?php if ($actmenu == "itemwise") {
															echo "act-menu-icon";
														} ?>">
							<i class="icon-check"></i>
							Itemwise Order
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="manage-users.php" class="<?php if ($actmenu == "allusers") {
														echo "act-menu-icon";
													} ?>">
					<i class="menu-icon icon-group"></i>All Customers
				</a>
			</li>

			<li><a href="user-logs.php" class="<?php if ($actmenu == "userlog") {
													echo "act-menu-icon";
												} ?>"><i class="menu-icon icon-cloud"></i>Customer login log </a></li>


		</ul>


		<ul class="widget widget-menu unstyled">
			<li><a href="category.php" class="<?php if ($actmenu == "category") {
													echo "act-menu-icon";
												} ?>"><i class="menu-icon icon-tasks"></i>Create Category </a></li>
			<li><a href="subcategory.php" class="<?php if ($actmenu == "subcategory") {
														echo "act-menu-icon";
													} ?>"><i class="menu-icon icon-tasks"></i>Sub Category </a></li>
			<li><a href="product-avail.php" class="<?php if ($actmenu == "prod_avail") {
														echo "act-menu-icon";
													} ?>"><i class="menu-icon icon-tag"></i>Manage Product</a></li>
			<li><a href="manage-combos.php" class="<?php if ($actmenu == "ins_combo") {
														echo "act-menu-icon";
													} ?>"><i class="menu-icon icon-tags"></i>Combo Offer</a></li>
			<li><a href="manage-products.php" class="<?php if ($actmenu == "all_product") {
															echo "act-menu-icon";
														} ?>"><i class="menu-icon icon-tag"></i>Products</a></li>

		</ul><!--/.widget-nav-->

		<ul class="widget widget-menu unstyled">
			<li>
				<a href="logout.php">
					<i class="menu-icon icon-signout"></i>
					Logout
				</a>
			</li>
		</ul>

	</div><!--/.sidebar-->
</div><!--/.span3-->