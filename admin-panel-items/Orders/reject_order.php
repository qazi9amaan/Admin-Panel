<?php 
session_start();


require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';


$block_id = filter_input(INPUT_POST, 'block_id');
$block_reason = filter_input(INPUT_POST, 'account_status');
$db = getDbInstance();


// Delete a user using user_id
if ($block_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $db->where('order_id', $block_id);
    $data_to_db['order_status'] = 'rejected';
    $data_to_db['order_status_reason'] = $block_reason;
    $data_to_db['order_updated_on'] =date('Y-m-d H:i:s');

    $stat = $db->update('orders', $data_to_db);
    if ($stat) {
        $last_id = $db->where('order_id',$block_id)->delete('order_notifcations');
        if ($stat) {
            $_SESSION['info'] = "Product rejected successfully!";
            header('Location: accepted_orders.php');
            exit;
        }
    }
}