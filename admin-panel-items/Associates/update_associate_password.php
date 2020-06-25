<?php 
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$id = filter_input(INPUT_POST, 'id');
 $db = getDbInstance();


// Delete a user using user_id
if ($id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $data_to_db['password'] = password_hash('B#BeFEK4', PASSWORD_DEFAULT);
    $db->where('id', $id);
    $stat = $db->update('associate_accounts', $data_to_db);
    if ($stat) {
        $_SESSION['info'] = "Password reset successfully completed!";
        header('location: associates.php');
        exit;
    }
}