<?php
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Sanitize if you want
$customer_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING); 
$edit = true;
$db = getDbInstance();


// If edit variable is set, we are performing the update operation.
if ($edit)
{
    $db->where('id', $customer_id);
    // Get data to pre-populate the form.
    $product = $db->getOne('products');
}
?><?php include BASE_PATH . '/includes/header.php'; ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header"><?php echo $product['product_name']?></h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" action="" method="post" id="product_form" enctype="multipart/form-data">
        <?php include PARENT.'/associates/forms/product_form.php'; ?>
    </form>
</div>

<?php if($operation == 'view') {?>
<script>
$('input').prop('disabled', true);
$('textarea').prop('disabled', true);
$('select').prop('disabled', true);
</script>
<?php } ?>

<script>
$('#product_price').prop('disabled', true);

</script>
<?php include BASE_PATH . '/includes/footer.php'; ?>

