
<?php 
 require_once '/var/www/html/admin/config/config.php';
 require_once BASE_PATH . '/includes/auth_validate.php';

 $db = getDbInstance();
 $db->groupBy("ordered_at");
 $result =  $db->get('orders ',null,'ordered_at,order_status,count(*)');
 
 $data_new_orders = array();
 $data_accepted_orders  = array();

 $categories = array();
 foreach ($result as $row):
    switch($row['order_status']){
      case "confirming":
        $data_new_orders[] =$row['count(*)'];
        $data_accepted_orders[] =0;
        $data_delivered_orders[] =0;

      break;
      case "accepted":
        $data_accepted_orders[] =$row['count(*)'];
        $data_new_orders[]=0;
        $data_delivered_orders[]=0;
      break;
     
    }
    $categories[] =$row['ordered_at'];
 endforeach;
 
 
?>
     <div id="chart"></div>
