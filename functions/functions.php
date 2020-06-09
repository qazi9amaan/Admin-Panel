<?php
session_start();

require_once '/var/www/html/admin/config/config.php';

if(isset($_GET['deleteimages']))
{
  
    $images = explode(",",$_GET['images']);
    foreach ($images as &$image)
    {
        $imageURL = '/var/www/html/admin/uploads/'.$image;
        
        if (file_exists($imageURL)) {
            unlink($imageURL);
         
        }
    }
}

if(isset($_POST['saveproduct']))
{
  
    $data_to_db = filter_input_array(INPUT_POST);
    $db = getDbInstance();

    $db->where('id', $data_to_db['id']);
	$product=$db->getOne('associate_products');

	if ($product)
	{
        $data['product_name']=$product['product_name'];
        $data['product_desc']=$product['product_desc'];
        $data['product_category']= $product['product_category'];
        $data['file_name']= $product['file_name'];
        $data['product_cost_price']= $product['product_price'];
        $data['product_belongs_to']= "associate";

        $data['product_price']= $data_to_db['fp'];
        $data['product_discount_price']=  $data_to_db['sp'];
        $data['product_owner']=$product['product_owner'];

        $data['product_quality']= $product['product_quality'];
        $data['created_by'] = $_SESSION['user_id'];
        $data['created_at'] = date('Y-m-d H:i:s');

        $db = getDbInstance();
        $last_id =$db->insert('products', $data);
        if ($last_id)
        {

            $db->where('id',$data_to_db['id']);
            $status = $db->delete('associate_products');
            if ($status) 
            {   
                $notification['associate_id'] = $data['product_owner'];
                $notification['notification_type'] = "product_accepted";
                $notification['id'] = $last_id;

                $db = getDbInstance();
                $last_id = $db->insert('associate_notifications', $notification);


                if ($last_id) {
                        $_SESSION['success'] = "Product added successfully!";
                        exit;
                }
            }else{
                $_SESSION['failure'] = 'Failed' .$db->getLastError();;
                exit;
            }
            
        }else
        {
            echo 'Insert failed: ' . $db->getLastError();
            exit();
        }
    

    }else{
        $_SESSION['failure'] = 'No product found';
		exit;
    }
    

    
}

if(isset($_POST['changepaymenttocod']))
{
    $order_id= $_POST['order_id'];    
    $data_to_db['order_status'] = 'delivering';
    $data_to_db['payment_type'] = 'Cash On Delivery';
    $db = getDbInstance();
    $db->where('order_id', $order_id);
    $stat = $db->update('orders', $data_to_db);
    if($stat)
    {
        echo 'success';
    }else{
        echo 'failure';
    }
}

if(isset($_POST['changepaymenttoonline']))
{
    $order_id= $_POST['order_id'];    
    $data_to_db['order_status'] = 'delivering';
    $data_to_db['payment_type'] = 'Online';
    $data_to_db['payment_id'] = $_POST['payment_id'];

    $db = getDbInstance();
    $db->where('order_id', $order_id);
    $stat = $db->update('orders', $data_to_db);
    if($stat)
    {
        $db = getDbInstance();
        $db->where('order_id', $order_id);
        $order= $db->getOne('orders');

        $notification['notification_type']="user_approved_order";
        $notification['owner']= $order["owner"];
        $notification['order_id']=$order_id;
        $notification['product_id']=$order["product_id"];
        $notification['user_id']=$order["user_id"];
        $last_id = $db->insert('order_notifcations', $notification);
        if($last_id){
            echo 'success';
        }

    }else{
        echo 'failure';
    }
}
?>
