<div class="container-fluid">
            <h3 class="orders-title">Orders</h3>
            <div class="list-group">
            <?php foreach ($order_rows as $order): ?>

                <?php 
                    $db2 = getDbInstance();

                    switch($order['notification_type']){

                        case "confirming-payment":
                            $product = $db2->where('id',$order['product_id'])->getOne("products");
                            $name= $db2->where('user',$order['user_id'])->getOne("user_profiles");

                            if($order['owner']== NULL)
                            {
                                $link ='/admin/admin-panel-items/Orders/confirm_payment.php';
                                $msg =  "<strong>" .$name['full_name'].'</strong> brought your product <strong>'.$product['product_name']."</strong>, please confirm his payment?";
                            }else{
                                $assocaite = $db2->where('id',$order['owner'])->getValue("associate_accounts","bussiness_name");
                                $msg =  "<strong>" .$name['full_name'].'</strong> wants to buy a product <strong>'.$product['product_name']."</strong> from <strong> $assocaite </strong> please confirm his payment?";
                                $link ='/admin/admin-panel-items/Orders/confirm_payment.php';

                            }
                            $icon ='fa fa-shopping-cart fa-fw';
                            $class="";
                            break;
                       
                    case "delivering":
                            $product = $db2->where('id',$order['product_id'])->getOne("products");
                            $name= $db2->where('user',$order['user_id'])->getOne("user_profiles");

                            if($order['owner']== NULL)
                            {
                                $link ='/admin/admin-panel-items/Orders/delivering_orders.php';
                                $msg =  "<strong>" .$name['full_name'].'</strong> brought your product <strong>'.$product['product_name']."</strong>, The payment is confirmed, please deliver it";
                            }else{
                                $assocaite = $db2->where('id',$order['owner'])->getValue("associate_accounts","bussiness_name");
                                $msg =  "<strong>" .$name['full_name'].'</strong> wants to buy a product <strong>'.$product['product_name']."</strong> from <strong> $assocaite </strong> The payment is confirmed, please deliver it";
                                $link ='/admin/admin-panel-items/Orders/delivering_orders.php';

                            }
                            $icon ='fa fa-shopping-cart fa-fw';
                            $class="";
                            break;
                    case "accepted":
                            $product = $db2->where('id',$order['product_id'])->getOne("products");
                            $name= $db2->where('user',$order['user_id'])->getOne("user_profiles");

                            if($order['owner']== NULL)
                            {
                                $link ='/admin/admin-panel-items/Orders/delivering_orders.php';
                                $msg =  "<strong>" .$name['full_name'].'</strong> booked your product <strong>'.$product['product_name']."</strong>,please wait while customer chooses the payment mode.";
                            }else{
                                $assocaite = $db2->where('id',$order['owner'])->getValue("associate_accounts","bussiness_name");
                                $msg =  "<strong>" .$name['full_name'].'</strong> wants to booked a product <strong>'.$product['product_name']."</strong> from <strong> $assocaite </strong> please wait while customer chooses the payment mode?";
                                $link ='/admin/admin-panel-items/Orders/accepted_orders.php';

                            }
                            $icon ='fa fa-shopping-cart fa-fw';
                            $class="";
                            break;
                       
                        
                            case "user_approved_order":
                                $product = $db2->where('id',$order['product_id'])->getOne("products");
                                $name= $db2->where('user',$order['user_id'])->getOne("user_profiles");
    
                                if($order['owner']== NULL)
                                {
                                    $msg =  "<strong>" .$name['full_name'].'</strong>  has successfully approved the payment method for your <strong>'.$product['product_name']."</strong>, please proceed ahead.";
                                }else{
                                    $assocaite = $db2->where('id',$order['owner'])->getValue("associate_accounts","bussiness_name");
                                    $msg =  "<strong>" .$name['full_name'].'</strong> has successfully approved the payment method for <strong>'.$product['product_name']."</strong> from <strong> $assocaite </strong> please proceed ahead";
    
                                }
                                $link ='/admin/admin-panel-items/Orders/delivering_orders.php';
                                $icon ='fa fa-thumbs-up fa-fw';
                                $class="";
                                break;
                           
                    }



                ?>
                  <a href="<?php echo $link ?>" class="<?php echo $class ?> list-group-item list-group-item-action notification_item">
                            <div>
                            <i class="<?php echo $icon ?>"></i>
                        
                        <span><?php echo $msg ?></span>
                            </div>
                              <span class="timestamp">
                                  <?php echo date( 'm/d/y', strtotime($order['created_at'])); ?>
                              </span>
                          
                  </a>
             

            <?php endforeach; ?>

            </div>

            </div>