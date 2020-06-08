<?php 
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$block_id = filter_input(INPUT_POST, 'block_id');
$block_reason = filter_input(INPUT_POST, 'account_status');
 $db = getDbInstance();


// Delete a user using user_id
if ($block_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $db->where('id', $block_id);
    $data_to_db['account_status'] = $block_reason;
    $stat = $db->update('associate_accounts', $data_to_db);
    if ($stat) {
        $_SESSION['info'] = "Associate banned successfully!";
        header('location: associates.php');
        exit;
    }
}