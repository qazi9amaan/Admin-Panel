<?php 
session_start();
require_once '/var/www/html/admin/config/config.php';

$id = filter_input(INPUT_POST, 'order_id');
$db = getDbInstance();
if ($id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $db->where('order_id', $id);
    $data_to_db['order_status'] = 'accepted';
    $data_to_db['order_updated_on'] =date('Y-m-d H:i:s');
    $data_to_db['order_status_reason'] = "Your order has been accepted!";
    $stat=$db->update('orders', $data_to_db);
    
    if($stat){
        $last_id = $db->where('order_id',$id)->delete('order_notifcations');
        if($last_id){
            $_SESSION['success'] = "Order accepted accepted!";
            header('Location:orders.php');
        exit;
        }
    }
   
    
}