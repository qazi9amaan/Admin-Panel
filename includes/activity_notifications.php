<?php
$pagelimit = 100;
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}
$order_by = 'id';
$order_dir = 'Desc';
$db = getDbInstance();
$db->pageLimit = $pagelimit;
$order_rows = $db->orderBy('notification_id', $order_dir)->arraybuilder()->paginate('order_notifcations', $page);

$not_rows = $db->orderBy($order_by, $order_dir)->arraybuilder()->paginate('admin_notifications', $page);
$total_pages = $db->totalPages;
?>
    <?php if(!isset($show_clear_btn)|| $show_clear_btn ){ ?>
        <div id="clearAllNotifcations" style="padding-right:15px; padding-bottom:5px;" class="col-12 text-right">
            <?php if(sizeof($not_rows)){ ?>
            <a  href="/admin/includes/clear_notifications.php?all" class="btn btn-primary">Clear all</a>
            <?php }?>
        </div>
        <?php } ?>

   
            <div class="list-group">
            <?php foreach ($not_rows as $noti): ?>

                <?php 
                    $db = getDbInstance();

                    switch($noti['notification_type']){

                        case "new_associate":
                            $assocaite = $db->getValue ("associate_accounts", "bussiness_name");
                            $msg = '<strong>'.$assocaite."</strong> just created an assocaite account";
                            $icon ='fa fa-handshake-o fa-fw';
                            $class="";
                            $link ='/admin/admin-panel-items/Associates/view_associate.php?associate_id='.$noti['id'].'&operation=view';
                            break;

                        case "new_associate_product":
                            $details =$db->where('associate_products.id',$noti['id'])->join("associate_accounts", "associate_accounts.id=associate_products.product_owner", "INNER")->getOne("associate_products");
                            $msg = '<strong>'.$details['bussiness_name']."</strong> just added a new product <strong>".$details['product_name']."</strong>";
                            $icon ='fa fa-shopping-bag fa-fw';
                            $class="important-notification";
                            $link ='/admin/admin-panel-items/Associate-products/a_products.php';
                            break;
                       
                        case "product_resubmitted":
                            $details =$db->where('associate_products.id',$noti['id'])->join("associate_accounts", "associate_accounts.id=associate_products.product_owner", "INNER")->getOne("associate_products");
                            $msg = '&nbsp;<strong>'.$details['bussiness_name']."</strong> resubmitted product <strong>".$details['product_name']."</strong>";
                            $icon ='glyphicon glyphicon-repeat';
                            $class="important-notification";
                            $link ='/admin/admin-panel-items/Associate-products/r_products.php';
                            break;
                        
                        case "assocaite_order_accepted":
                            $notifi_details=$db->where('order_id',$noti['id'])->getOne("orders");
                            $assocaite=$db->where('id',$notifi_details['owner'])->getValue("associate_accounts","bussiness_name");
                            $product=$db->where('id',$notifi_details['product_id'])->getValue("products","product_name");
                            $user=$db->where('user',$notifi_details['user_id'])->getValue("user_profiles","full_name");
                            $msg = '&nbsp;<strong>'.$assocaite."</strong> accepted an order of <strong>".$product."</strong> from <strong> $user</strong>";
                            $icon ='fa fa-cart-plus';
                            $class="";
                            $link ='/admin/admin-panel-items/Orders/accepted_orders.php';
                            break;

                        case "assocaite_order_rejected":
                            $notifi_details=$db->where('order_id',$noti['id'])->getOne("orders");
                            $assocaite=$db->where('id',$notifi_details['owner'])->getValue("associate_accounts","bussiness_name");
                            $product=$db->where('id',$notifi_details['product_id'])->getValue("products","product_name");
                            $msg = '&nbsp;<strong>'.$assocaite."</strong> rejected an order of <strong>".$product."</strong> ";
                            $icon ='fa fa-times';
                            $class="active";
                            $link ='/admin/admin-panel-items/Orders/rejected_orders.php';
                            break;
                            
                        case "assocaite_order_completed":
                            $notifi_details=$db->where('order_id',$noti['id'])->getOne("orders");
                            $assocaite=$db->where('id',$notifi_details['owner'])->getValue("associate_accounts","bussiness_name");
                            $msg = '&nbsp;<strong>'.$assocaite."</strong> shipped the order successfully.";
                            $icon ='fa fa-truck';
                            $class="";
                            $link ='/admin/admin-panel-items/Orders/delivered_orders.php';
                            break;
                    }


                ?>
                  <a href="<?php echo $link ?>" class="<?php echo $class ?> list-group-item list-group-item-action notification_item">
                            <div>
                            <i class="<?php echo $icon ?>"></i>
                        
                        <span><?php echo $msg ?></span>
                            </div>
                              <span class="timestamp">
                                  <?php echo date( 'm/d/y g:i A', strtotime($noti['created-at'])); ?>
                              </span>
                          
                  </a>
             

            <?php endforeach; ?>

            </div>

       
            