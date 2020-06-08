<?php
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Orders/Orders.php';
$costumers = new Orders();

// Get Input data from query string
$order_by	= filter_input(INPUT_GET, 'order_by');
$order_dir	= filter_input(INPUT_GET, 'order_dir');
$search_str	= filter_input(INPUT_GET, 'search_str');

// Per page limit for pagination
$pagelimit = 15;

// Get current page
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

if (!$order_by) {
	$order_by = 'o.order_id';
}
if (!$order_dir) {
	$order_dir = 'Desc';
}

// Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();

// Start building query according to input parameters
// If search string
if ($search_str) {
	$db->where('product_name', '%' . $search_str . '%', 'like');
	$db->orwhere('product_category', '%' . $search_str . '%', 'like');
}
// If order direction option selected
if ($order_dir) {
	$db->orderBy($order_by, $order_dir);
}

// Set pagination limit
$db->pageLimit = $pagelimit;
$db->where('o.order_status', 'delivered');
$db->join("products p", "o.product_id=p.id", "INNER");
$db->join("user_profiles u", "u.user=o.user_id", "INNER");

// Get result of the query
$rows = $db->arraybuilder()->paginate('orders o', $page);
$total_pages = $db->totalPages;

?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
        <h1 class="page-header">Delivered Orders</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
            </div>
        </div>
    </div>

    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_str" value="<?php echo htmlspecialchars($search_str, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="input_order">Order By</label>
            <select name="order_by" class="form-control">
                <?php
                foreach ($costumers->setOrderingValues() as $opt_value => $opt_name):
                    ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                    echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
                endforeach;
                ?>
                            </select>
                            <select name="order_dir" class="form-control" id="input_order">
                                <option value="Asc" <?php
                if ($order_dir == 'Asc') {
                    echo 'selected';
                }
                ?> >Asc</option>
                                <option value="Desc" <?php
                if ($order_dir == 'Desc') {
                    echo 'selected';
                }
                ?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
        
    </div>
    <hr>
    <!-- //Filters -->

    <!-- Table -->
     <!-- Table -->
     <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="8%">Order ID</th>
                <th width="12%">Product </th>
                <th width="12%">Seller </th>

                <th width="12%">Buyer</th>

                <th width="8%"> Price</th>
                <th width="8%"> Payment Type</th>
                <th width="9%"> Ordered At</th>
                <th width="8%">Delivery Medium</th>
                <th width="8%">Tracking Number</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
           
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><a target="_blank_" href="../Products/view_product.php?product_id=<?php echo $row['product_id'];  ?>&operation=view"><?php echo htmlspecialchars($row['product_name']); ?></a></td>
                <?php 
                    if($row['product_belongs_to']== 'associate'){
                       
                        $db = getDbInstance();
                        $db->where('id', $row['product_owner']);
                        $b_name= $db->getValue ("associate_accounts", "bussiness_name");
                        $by = '<a href="../Associates/view_associate.php?associate_id='.$row['product_owner'].'&operation=view" >'.$b_name.'</a>';

                    }else{
                        $by ="Admin";
                    }
                
                ?>
                <td><?php echo $by; ?></td>
                <td><a target="_blank_" href="../Customer/view_customer.php?customer_id=<?php echo $row['user_id'];  ?>&operation=view"><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['amount']); ?></td>
                <td><?php echo htmlspecialchars($row['payment_type']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td><?php echo htmlspecialchars($row['delivery_medium']); ?></td>
                <td><?php echo htmlspecialchars($row['delivery_tracking_number']); ?></td>
            </tr>
          
            
           
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
    	<?php echo paginationLinks($page, $total_pages, 'orders.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
