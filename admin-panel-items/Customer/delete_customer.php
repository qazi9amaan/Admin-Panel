<?php 
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	
    $customer_id = $del_id;

    $db = getDbInstance();
    $db->where('id', $customer_id);
    $status = $db->delete('auth_user_account');
    
    if ($status) 
    {
        $_SESSION['info'] = "Customer deleted successfully!";
        header('location: customers.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete customer";
    	header('location: customers.php');
        exit;

    }
    
}