<?php 
session_start();
require_once '/var/www/html/admin/config/config.php';

$id = filter_input(INPUT_POST, 'order_id');
$delivery_medium = filter_input(INPUT_POST, 'delivery_medium');
$delivery_tracking_number = filter_input(INPUT_POST, 'delivery_tracking_number');

$db = getDbInstance();
if ($id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $db->where('order_id', $id);
    $data_to_db['order_status'] = 'delivered';
    $data_to_db['order_updated_on'] =date('Y-m-d H:i:s');
    $data_to_db['order_status_reason'] = "Your order has been shipped!";
    $data_to_db['delivery_medium'] =$delivery_medium;
    $data_to_db['delivery_tracking_number'] =$delivery_tracking_number;


    $stat=$db->update('orders', $data_to_db);
    
    if($stat){
        $db = getDbInstance();
        $db->where('order_id',$id)->delete('order_notifcations');

        $_SESSION['success'] = "Product accepted successfully!";
        header('Location:orders.php');
        exit;
    }
   
    
}