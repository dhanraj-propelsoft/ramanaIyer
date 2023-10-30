<div class="span3">
	<div class="sidebar">


		<ul class="widget widget-menu unstyled">
			<li>
				<a class="<?php if (($actmenu == "orders") || ($actmenu == "pending") || ($actmenu == "delivered") || ($actmenu == "itemwise") ||($actmenu == "orderwise")) {
								echo "act-menu-icon";
							} else {
								echo "collapsed";
							} ?>" data-toggle="collapse" href="#togglePages">
					<i class="menu-icon icon-shopping-cart"></i>
					<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Order Management
				</a>
				<ul id="togglePages" class="<?php if (($actmenu == "orders") || ($actmenu == "pending") || ($actmenu == "delivered") || ($actmenu == "itemwise") || ($actmenu == "orderwise")) {
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
							$result = mysqli_query($con, "SELECT orders.id FROM orders JOIN users ON orders.userId=users.id JOIN products ON products.id=orders.productId WHERE orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND DATE(orders.dtSupply) LIKE '%$todayDate%' AND (orders.orderStatus!='Delivered' OR orders.orderStatus IS NULL) UNION SELECT orders.id FROM orders JOIN users ON orders.userId=users.id JOIN combo ON combo.id=orders.comboId WHERE orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND DATE(orders.dtSupply) LIKE '%$todayDate%' AND (orders.orderStatus!='Delivered' OR orders.orderStatus IS NULL)");
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
							$ret = mysqli_query($con, "SELECT orders.id FROM orders JOIN users ON orders.userId=users.id JOIN products ON products.id=orders.productId WHERE orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND (orders.orderStatus!='$status' OR orders.orderStatus IS NULL) UNION SELECT orders.id FROM orders JOIN users ON orders.userId=users.id JOIN combo ON combo.id=orders.comboId WHERE orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND (orders.orderStatus!='$status' OR orders.orderStatus IS NULL)");
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
							$rt = mysqli_query($con, "SELECT orders.id FROM orders join users on orders.userId=users.id join products on products.id=orders.productId where orders.orderId IS NOT NULL AND orders.orderStatus='$status' UNION SELECT orders.id FROM orders join users on orders.userId=users.id join combo on combo.id=orders.comboId where orders.orderId IS NOT NULL AND orders.orderStatus='$status'");
							$num1 = mysqli_num_rows($rt); { ?><b class="label green pull-right">
									<?php echo htmlentities($num1); ?>
								</b>
							<?php } ?>

						</a>
					</li>
					<li>
						<a href="orderwise.php" class="<?php if ($actmenu == "orderwise") {
															echo "act-menu-icon";
														} ?>">
							<i class="icon-check-empty"></i>
							Order Wise
							<?php
							$status = 'Delivered';
							$rt2 = mysqli_query($con, "SELECT orders.orderId AS orderId FROM orders JOIN users ON  orders.userId=users.id WHERE orders.paymentMethod IS NOT NULL AND orders.orderId IS NOT NULL AND (orders.orderStatus!='$status' OR orders.orderStatus IS NULL) GROUP BY orderId");
							$num2 = mysqli_num_rows($rt2); { ?><b class="label green pull-right">
									<?php echo htmlentities($num2); ?>
								</b>
							<?php } ?>
						</a>
					</li>
					<li>
						<a href="itemwise.php" class="<?php if ($actmenu == "itemwise") {
															echo "act-menu-icon";
														} ?>">
							<i class="icon-sign-blank"></i>
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
			<li><a href="manage-combos.php" class="<?php if ($actmenu == "ins_combo") {
														echo "act-menu-icon";
													} ?>"><i class="menu-icon icon-tags"></i>Combo Offer</a></li>
			<li><a href="manage-products.php" class="<?php if ($actmenu == "all_product") {
															echo "act-menu-icon";
														} ?>"><i class="menu-icon icon-tag"></i>Products</a></li>
			<li><a href="product-avail.php" class="<?php if ($actmenu == "prod_avail") {
														echo "act-menu-icon";
													} ?>"><i class="menu-icon icon-th-large"></i>Manage Products</a></li>
			
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