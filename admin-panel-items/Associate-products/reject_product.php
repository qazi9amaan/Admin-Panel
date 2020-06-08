<?php 
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$block_id = filter_input(INPUT_POST, 'block_id');
$associate=filter_input(INPUT_POST, 'associate_id');
$block_reason = filter_input(INPUT_POST, 'account_status');
 $db = getDbInstance();


// Delete a user using user_id
if ($block_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $db->where('id', $block_id);
    $data_to_db['product_status'] = 'rejected';
    $data_to_db['product_status_reason'] = $block_reason;

    $stat = $db->update('associate_products', $data_to_db);
    if ($stat) {

        $notification['associate_id'] = $associate;
        $notification['notification_type'] = "product_rejected";
        $notification['id'] = $block_id;

        $db = getDbInstance();
        $last_id = $db->insert('associate_notifications', $notification);


        if ($last_id) {
        $_SESSION['info'] = "Product rejected successfully!";
        header('location: a_products.php');
        exit;
        }
    }
}