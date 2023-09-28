<div class="span3">
	<div class="sidebar">


		<ul class="widget widget-menu unstyled">
			<li>
				<a class="<?php if (($actmenu == "orders") || ($actmenu == "pending") || ($actmenu == "delivered")) {
					echo "act-menu-icon";
				} else {
					echo "collapsed";
				} ?>"
					data-toggle="collapse" href="#togglePages">
					<i class="menu-icon icon-cog"></i>
					<i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
					Order Management
				</a>
				<ul id="togglePages"
					class="<?php if (($actmenu == "orders") || ($actmenu == "pending") || ($actmenu == "delivered")) {
						echo "in ";
					} ?>collapse unstyled">
					<li>
						<a href="todays-orders.php" class="<?php if ($actmenu == "orders") {
							echo "act-menu-icon";
						} ?>">
							<i class="icon-tasks"></i>
							Today's Orders
							<?php
							$f1 = "00:00:00";
							$from = date('Y-m-d') . " " . $f1;
							$t1 = "23:59:59";
							$to = date('Y-m-d') . " " . $t1;
							$result = mysqli_query($con, "SELECT * FROM orders where paymentMethod IS NOT NULL AND orderDate Between '$from' and '$to'");
							$num_rows1 = mysqli_num_rows($result); {
								?>
								<b class="label orange pull-right">
									<?php echo htmlentities($num_rows1); ?>
								</b>
							<?php } ?>
						</a>
					</li>
					<li>
						<a href="pending-orders.php"
							class="<?php if ($actmenu == "pending") {
								echo "act-menu-icon";
							} ?>">
							<i class="icon-tasks"></i>
							Pending Orders
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
						<a href="delivered-orders.php"
							class="<?php if ($actmenu == "delivered") {
								echo "act-menu-icon";
							} ?>">
							<i class="icon-inbox"></i>
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
				</ul>
			</li>
			<li>
				<a href="manage-users.php" class="<?php if ($actmenu == "allusers") {
					echo "act-menu-icon";
				} ?>">
					<i class="menu-icon icon-group"></i>
					All Users
				</a>
			</li>

			<li><a href="user-logs.php" class="<?php if ($actmenu == "userlog") {
				echo "act-menu-icon";
			} ?>"><i
						class="menu-icon icon-tasks"></i>User Login Log </a></li>


		</ul>


		<ul class="widget widget-menu unstyled">
			<li><a href="category.php" class="<?php if ($actmenu == "category") {
				echo "act-menu-icon";
			} ?>"><i
						class="menu-icon icon-tasks"></i> Create Category </a></li>
			<li><a href="subcategory.php" class="<?php if ($actmenu == "subcategory") {
				echo "act-menu-icon";
			} ?>"><i
						class="menu-icon icon-tasks"></i>Sub Category </a></li>
			<li><a href="insert-product.php" class="<?php if ($actmenu == "ins_product") {
				echo "act-menu-icon";
			} ?>"><i
						class="menu-icon icon-paste"></i>Insert Product </a></li>
			<li><a href="manage-products.php"
					class="<?php if ($actmenu == "all_product") {
						echo "act-menu-icon";
					} ?>"><i
						class="menu-icon icon-table"></i>Manage Products </a></li>

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