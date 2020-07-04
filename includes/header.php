<?php

$db = getDbInstance();
$numActivities = $db->getValue ("admin_notifications", "count(*)");
$numOrders = $db->getValue ("order_notifcations", "count(*)");
$numNotifications=$numActivities+$numOrders;

?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Brooks Fashion deals in all kind of branded products.This is also the best platform to boost your online business">
	<meta name="keywords" content="online store,online business,ecom,ecommerce website,
shopping cart,e business,what is ecommerce,ecomerce,Fashion,Kashmir ecom,Brooks,Affiliates,affiliate marketing,online money,how to, free shopping,branded clothes, clothing,earning,earning">

        <title>Brooks Administration</title>

        <link  rel="stylesheet" href="/admin/assets/css/bootstrap.min.css"/>
        <link href="/admin/assets/js/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="/admin/assets/css/sb-admin-2.css" rel="stylesheet">
        <link href="/admin/assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <script src="/admin/assets/js/jquery.min.js" type="text/javascript"></script>
        <link href="/admin/assets/css/style.css" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </head>
       
    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php if (isset($_SESSION['admin_user_logged_in']) && $_SESSION['admin_user_logged_in'] == true): ?>
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                   
                
                <div class="">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="d-flex justify-content-between">
                        <a class="navbar-brand" href="">Administrator</a>
                        <ul class="nav navbar-top-links text-right mr-0 navbar-right">
                            <!-- /.dropdown -->

                            <li id="notification_btn">
                            <div style="background:#f8f8f8;">
                            <span style="margin-right: -17px;margin-top: -2px;" class="badge badge-primary"><?php echo $numNotifications; ?></span>
                            <a onclick="openNav()" href="#"><i class="fa fa-bell fa-fw"></i></a>
                            
                            </div>
                            </li>

                       

                            <!-- /.dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i></a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="/admin/admin-panel-items/Admin/edit_admin.php?admin_user_id=<?php echo $_SESSION['user_id']; ?>&operation=edit"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/admin/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                            <!-- /.dropdown -->
                        </ul>
                        </div>
                    </div>
                    <!-- /.navbar-header -->

                  
                    <!-- /.navbar-top-links -->

                    <div class="navbar-default sidebar" role="navigation">
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
                                <li><a href="/admin/index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                              
                                <li<?php echo (CURRENT_PAGE == 'customers.php' || CURRENT_PAGE == 'add_customer.php') ? ' class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-user-circle fa-fw"></i> Customers<i class="fa arrow"></i></a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="/admin/admin-panel-items/Customer/customers.php"><i class="fa fa-list fa-fw"></i> List all</a></li>
                                        <li><a href="/admin/admin-panel-items/Customer/add_customer.php"><i class="fa fa-plus fa-fw"></i> Add New</a></li>
                                    </ul>
                                </li>

                                <li<?php echo (CURRENT_PAGE == 'products.php' || CURRENT_PAGE == 'associate_products_stat.php' || CURRENT_PAGE == 'add_product.php?operation=create') ? ' class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Products<i class="fa arrow"></i></a>

                                    <ul class="nav nav-second-level">
                                        <li>                                    <a href="/admin/admin-panel-items/Associates/Statistics/associate_products_stat.php"><i class="fa fa-line-chart fa-fw"></i> Stats<i class="fa arrow"></i></a></li>
                                        <li><a href="/admin/admin-panel-items/Products/products.php"><i class="fa fa-list fa-fw"></i> List all</a></li>
                                        <li><a href="/admin/admin-panel-items/Products/add_product.php"><i class="fa fa-plus fa-fw"></i> Add New</a></li>
                                    </ul>
                                </li>

                                <li<?php echo (CURRENT_PAGE == 'categories.php' || CURRENT_PAGE == 'add_category.php?operation=create') ? ' class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-tasks fa-fw"></i> Categories<i class="fa arrow"></i></a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="/admin/admin-panel-items/Categories/categories.php"><i class="fa fa-list fa-fw"></i> List all</a></li>
                                        <li><a href="/admin/admin-panel-items/Categories/add_category.php"><i class="fa fa-plus fa-fw"></i> Add New</a></li>
                                    </ul>
                                </li>

                                <li<?php echo (CURRENT_PAGE == 'associates.php' || CURRENT_PAGE == 'a_products.php' ||CURRENT_PAGE == 'r_products.php' ) ? ' class="active"' : ''; ?>>
                                        <a href="#"><i class="fa fa-handshake-o fa-fw"></i> Associates<i class="fa arrow"></i></a>
                                        <ul class="nav nav-second-level">
                                            <li><a href="/admin/admin-panel-items/Associates/associates.php"><i class="fa fa-user fa-fw"></i>All Associates</a></li>
                                            
                                            <li<?php echo (CURRENT_PAGE == 'a_products.php' || CURRENT_PAGE == 'r_products.php') ? ' class="active"' : ''; ?>>
                                                <a href="#"><i class="fa fa-tasks fa-fw"></i> Products<i class="fa arrow"></i></a>
                                                <ul class="nav nav-third-level">
                                                    <li><a href="/admin/admin-panel-items/Associate-products/a_products.php"><i class="fa fa-filter fa-fw"></i> Unapproved Products</a></li>
                                                    <li><a href="/admin/admin-panel-items/Associate-products/r_products.php"><i class="fa fa-remove fa-fw"></i> Rejected Products</a></li>
                                                    <li><a href="/admin/admin-panel-items/Associate-products/all_products.php"><i class="fa fa-list fa-fw"></i> All Products</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                </li>
                                <li<?php echo (CURRENT_PAGE == 'orders.php' || CURRENT_PAGE == 'acc_orders.php' ||CURRENT_PAGE == 'delivering_orders.php' ||CURRENT_PAGE == 'accepted_orders.php'||CURRENT_PAGE == 'rejected_orders.php'||CURRENT_PAGE == 'delivered_orders.php' ) ? ' class="active"' : ''; ?>>
                                        <a href="#"><i class="fa fa-shopping-bag fa-fw"></i> Orders<i class="fa arrow"></i></a>
                                        <ul class="nav nav-second-level">
                                            <li><a href="/admin/admin-panel-items/Orders/orders.php"><i class="fa fa-user fa-fw"></i> Admin Orders</a></li>
                                            <li><a href="/admin/admin-panel-items/Orders/acc_orders.php"><i class="fa  fa-handshake-o fa-fw"></i> Associate Orders</a></li>
                                            <li><a href="/admin/admin-panel-items/Orders/accepted_orders.php"><i class="fa  fa-check fa-fw"></i>  Accepted Orders</a></li>
                                            <li><a href="/admin/admin-panel-items/Orders/rejected_orders.php"><i class="fa  fa-remove fa-fw"></i> Rejected Orders</a></li>
                                            <li><a href="/admin/admin-panel-items/Orders/delivering_orders.php"><i class="fa fa-thumbs-up fa-fw"></i> Orders to be delivered</a></li>
                                            <li><a href="/admin/admin-panel-items/Orders/delivered_orders.php"><i class="fa  fa-truck fa-fw"></i> Delievered Orders</a></li>


                                         
                                        </ul>
                                </li>
                               

                                <li><a href="/admin/admin-panel-items/Admin/admin_users.php"><i class="fa fa-users fa-fw"></i> Admins</a></li>
                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                    
                </nav>

            <?php endif; ?>
            <?php include "notification_drawer.php" ?>

            <!-- The End of the Header -->
