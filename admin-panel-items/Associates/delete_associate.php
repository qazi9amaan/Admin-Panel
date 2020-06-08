<?php 
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$del_id = filter_input(INPUT_POST, 'del_id');
 $db = getDbInstance();


// Delete a user using user_id
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $db->where('id', $del_id);
    $stat = $db->delete('associate_accounts');
    if ($stat) {
        $_SESSION['info'] = "Associate deleted successfully!";
        header('location: associates.php');
        exit;
    }
}