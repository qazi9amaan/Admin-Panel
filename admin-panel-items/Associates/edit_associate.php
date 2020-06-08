<?php
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Sanitize if you want
$associate_id = filter_input(INPUT_GET, 'associate_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
$db = getDbInstance();

// Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Get customer id form query string parameter.
    $associate_id = filter_input(INPUT_GET, 'associate_id', FILTER_SANITIZE_STRING);

    // Get input data
    $data_to_db = filter_input_array(INPUT_POST);




    $db = getDbInstance();
    $db->where('id', $associate_id);
    $stat = $db->update('associate_accounts', $data_to_db);

    if ($stat)
    {


        $_SESSION['success'] = 'Product updated successfully!';
        // Redirect to the listing page
        header('Location: associates.php');
        // Important! Don't execute the rest put the exit/die.
        exit();
    }
}

// If edit variable is set, we are performing the update operation.
if ($edit)
{
    $db->where('id', $associate_id);
    // Get data to pre-populate the form.
    $associate = $db->getOne('associate_accounts');
}
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header text-capitalize"><?php echo $associate['bussiness_name'];?></h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" action="" method="post" id="product_form" enctype="multipart/form-data">
        <?php include BASE_PATH.'/forms/associate_form.php'; ?>
    </form>
</div>
<?php include BASE_PATH.'/includes/footer.php'; ?>
