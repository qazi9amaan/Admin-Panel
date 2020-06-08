<?php 
session_start();


require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';


$db = getDbInstance();

if ($db->delete('admin_notifications')) {
    header('Location: /admin/index.php');
    exit;
}

