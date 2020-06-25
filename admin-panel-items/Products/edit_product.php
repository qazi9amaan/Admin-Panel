<?php
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Sanitize if you want
$customer_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
$db = getDbInstance();

// Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Get customer id form query string parameter.

    // Get input data
    $data_to_db = filter_input_array(INPUT_POST);

    // Insert user and timestamp
    $data_to_db['updated_by'] = $_SESSION['user_id'];
    $data_to_db['updated_at'] = date('Y-m-d H:i:s');

    $db = getDbInstance();
    $db->where('id', $customer_id);
    $stat = $db->update('products', $data_to_db);

    if ($stat)
    {

       // File upload configuration 
       $targetDir = "/var/www/html/admin/uploads/"; 
       $allowTypes = array('jpg','png','jpeg','gif'); 
        
       $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
       $fileNames = array_filter($_FILES['files']['name']); 
       if(!empty($fileNames)){ 
           foreach($_FILES['files']['name'] as $key=>$val){ 
               // File upload path 
               $fileName = basename($_FILES['files']['name'][$key]); 
               $targetFilePath = $targetDir . $fileName; 
                
               // Check whether file type is valid 
               $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
               if(in_array($fileType, $allowTypes)){ 
                   // Upload file to server 
                   if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){ 
                       // Image db insert sql 
                       $insertValuesSQL .= "".$fileName.","; 
                   }else{ 
                       $errorUpload .= $_FILES['files']['name'][$key].' | '; 
                   } 
               }else{ 
                   $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
               } 
           } 
            
           if(!empty($insertValuesSQL)){ 
               $insertValuesSQL = trim($insertValuesSQL, ','); 
               $data_to_db['file_name'] = $insertValuesSQL;
               $db->where('id', $customer_id);
               $stat = $db->update('products', $data_to_db);
               $_SESSION['success'] = 'Product updated successfully!';


           } 
           }

        $_SESSION['success'] = 'Product updated successfully!';
        // Redirect to the listing page
        header('Location: products.php');
        // Important! Don't execute the rest put the exit/die.
        exit();
    }
}

// If edit variable is set, we are performing the update operation.
if ($edit)
{
    $db->where('id', $customer_id);
    // Get data to pre-populate the form.
    $customer = $db->getOne('products');
}
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Update Product</h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" method="post" id="product_form" enctype="multipart/form-data">
	 <?php include BASE_PATH.'/forms/product_form.php'; ?>
    </form>
</div>
<?php include BASE_PATH.'/includes/footer.php'; ?>
