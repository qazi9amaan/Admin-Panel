<?php
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Sanitize if you want
$product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING); 
($operation == 'view') ? $edit = true : $edit = false;
$db = getDbInstance();


if ($edit)
{
    $db->where('id', $product_id);
    $product = $db->getOne('associate_products');
}
$p=$product;
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<?php $product = $p;?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header text-capitalize"><?php echo $product['product_name'];?></h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" action="" method="post" id="product_form" enctype="multipart/form-data">
        <?php include PARENT.'/associates/forms/product_form.php'; ?>
    </form>
</div>
<script>
$('input').prop('disabled', true);
$('textarea').prop('disabled', true);

</script>
<?php include BASE_PATH.'/includes/footer.php'; ?>
