<?php
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Sanitize if you want
$cust_id = filter_input(INPUT_GET, 'customer_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING); 
($operation == 'view') ? $edit = true : $edit = false;
$db = getDbInstance();


if ($edit)
{
    $db->where('user', $cust_id);
    // Get data to pre-populate the form.
   $customer = $db->getOne('user_profiles');
}
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header text-capitalize"><?php echo $customer['full_name'];?></h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" action="" method="post" enctype="multipart/form-data">
        <?php include BASE_PATH.'/forms/cust_form.php'; ?>
    </form>
</div>
<script>
$('input').prop('disabled', true);
$('textarea').prop('disabled', true);

</script>
<?php include BASE_PATH.'/includes/footer.php'; ?>
