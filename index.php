<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Get DB instance. function is defined in config.php
$db = getDbInstance();

//Get Dashboard information
$numProducts = $db->getValue ("products", "count(*)");
$numCustomers = $db->getValue ("user_profiles", "count(*)");
$numAdminProducts = $db->where('product_belongs_to','owner')->getValue ("products", "count(*)");
$numCategories = $db->getValue ("categories", "count(*)");
$numDeliveredOrders = $db->where('orders.order_status', 'delivered')->join("products", "orders.product_id=products.id", "INNER")->getValue ("orders", "count(*)");
$numNewOrders = $db->where('orders.order_status', 'confirming')->where('products.product_belongs_to', 'owner')->join("products", "orders.product_id=products.id", "INNER")->getValue ("orders", "count(*)");
$rejectedOrders =$db->where('orders.order_status', 'rejected')->getValue ("orders", "count(*)");
$acceptedOrders =$db->where('orders.order_status', 'accepted')->getValue ("orders", "count(*)");
$deliveringOrders =$db->where('orders.order_status', 'delivering')->getValue ("orders", "count(*)");


$numAssociates = $db->getValue ("associate_accounts", "count(*)");
$numProductsUnderApproval = $db->where('product_status', 'Checking')->getValue ("associate_products", "count(*)");
$RejectedApproval = $db->where('product_status', 'Rechecking')->getValue ("associate_products", "count(*)");
$numAssociatesProducts = $db->where('product_belongs_to', 'associate')->getValue ("products", "count(*)");
$numAssociatesorders=$db->where('orders.order_status', 'confirming')->where('products.product_belongs_to', 'associate')->join("products", "orders.product_id=products.id", "INNER")->getValue ("orders", "count(*)");



include_once('includes/header.php');
include_once('includes/notification_drawer.php');

?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <div class="col-lg-4">
        <div class="page-action-links text-right">
                <a href="/admin/admin-panel-items/Products/add_product.php" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add a Product</a>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row ">
       <div class=" col-md-8 ">
       <div class="panel panel-chart-white">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-right">
                        <span>New Orders</span>
                        <?php include 'charts/orders_chart.php' ;?>
                        </div>
                    </div>
                </div>
                
            </div>
       </div>
       <div class="col-md-4">
       <div class="panel panel-chart-white">
           <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-right">
                        <span>Orders Details</span>
                        <?php include 'charts/order_details_chart.php' ;?>
                        </div>
                    </div>
                </div>
           </div>
       </div>
       
        <!-- /.col-lg-12 -->
    </div>
    <div class="row ">
    <div class="col-md-4">
           <div class="panel panel-chart-red">
                 <?php include 'includes/activities.php' ;?>
           </div>
       </div>
       <div class=" col-md-8 ">
        <div class="panel panel-chart-white">
                <div id="daily_progress"></div>
                </div>
        </div>
       
        
       
       
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numCustomers; ?></div>
                            <div>Customers</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Customer/customers.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa  fa-book fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numProducts;  ?></div>
                            <div>Total Products</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Products/products.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">

        <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-angle-double-right fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numAdminProducts;  ?></div>
                            <div>Admin products</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Admin/admin-products.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
        </div>
        </div>
        <div class="col-lg-3 col-md-6">
         <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numCategories;  ?></div>
                            <div>Categories</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Categories/categories.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        
       
        <div class="col-lg-4 col-md-6">
        <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numNewOrders;  ?></div>
                            <div>New Orders</div>
                        </div>
                    </div>
                </div>
                <a href="admin-panel-items/Orders/orders.php">
                    <div class="panel-footer">
                        <span class="pull-left">View New Orders</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-hourglass-half fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $acceptedOrders;  ?></div>
                            <div>Accepted Orders</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Orders/accepted_orders.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>

     
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-remove fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $rejectedOrders;  ?></div>
                            <div>Rejected Orders</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Orders/rejected_orders.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
     

    </div>
    <!-- /.ROW -->

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-thumbs-up fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $deliveringOrders;  ?></div>
                            <div>Orders to be delivered / Approved </div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Orders/delivering_orders.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
    <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-truck fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numDeliveredOrders;  ?></div>
                            <div>Delivered Orders</div>
                        </div>
                    </div>
                </div>
                <a href="admin-panel-items/Orders/delivered_orders.php">
                    <div class="panel-footer">
                        <span class="pull-left">View All Delivered Orders</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

    </div>
    <!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
    <div class="panel panel-grey">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-handshake-o fa-5x"></i>

                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">.</div>
                            <div>Associates</div>
                        </div>
                    </div>
                </div>
    </div>
    </div></div>
    <!-- ROW-->



    <div class="row">
        <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-handshake-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numAssociates; ?></div>
                            <div>Associates</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Associates/associates.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-filter fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numProductsUnderApproval; ?></div>
                            <div>Unapproved Products</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Associate-products/a_products.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-remove  fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $RejectedApproval; ?></div>
                            <div>Rejected Products</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Associate-products/r_products.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numAssociatesProducts; ?></div>
                            <div> Products</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Associate-products/all_products.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-12">
        <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart  fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numAssociatesorders; ?></div>
                            <div>New Orders</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/admin-panel-items/Orders/acc_orders.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        
        
      
    </div>
    <!-- /.ROW -->
  

</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>
