<?php 
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$id = filter_input(INPUT_POST, 'order_id');
$block_reason = filter_input(INPUT_POST, 'account_status');
$db = getDbInstance();


// Delete a user using user_id
if ($id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $db->where('order_id', $id);
    $data_to_db['order_status'] = 'delivering';
    $stat = $db->update('orders', $data_to_db);
    if ($stat) {
   		 $db = getDbInstance();
        $data['notification_type']='delivering';
        $db->where('order_id',$id)->update('order_notifcations',$data);
        if ($stat) {
            $_SESSION['info'] = "Order Payment Confirmed successfully!";
            header('Location: confirm_payment.php');
            exit;
        }
    }
}