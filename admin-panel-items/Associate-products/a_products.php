<?php
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$commission =200;
$raise =100;
// Costumers class
require_once BASE_PATH . '/lib/Associate/Associate.php';
$costumers = new Products();

// Get Input data from query string
$order_by	= filter_input(INPUT_GET, 'order_by');
$order_dir	= filter_input(INPUT_GET, 'order_dir');
$search_str	= filter_input(INPUT_GET, 'search_str');

// Per page limit for pagination
$pagelimit = 15;

// Get current pagecostumers
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$order_by) {
	$order_by = 'id';
}
if (!$order_dir) {
	$order_dir = 'Desc';
}


// Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('p.id', 'p.product_name', 'p.product_desc','p.product_owner' ,'p.product_category', 'p.file_name','p.product_price', 'p.product_status', 'p.product_quality','p.created_at', 'p.updated_at','u.bussiness_name');

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

// Get result of the query

$db->join("associate_accounts u", "p.product_owner=u.id", "LEFT");
$db->where('product_status', 'Checking');
$rows = $db->arraybuilder()->paginate('associate_products p', $page, $select);
$total_pages = $db->totalPages;
?>
<?php include BASE_PATH . '/includes/header.php'; ?>

<script>
function calculate_final(id,com, price)
{
    $('#final-price-'+id).html(price+com);
    $('#raised-price-'+id).html(price+com+parseInt($('#raise-price').val()))
}

function calculate_other_pices(id,com, price)
{
    $('#com-'+id).html(parseInt($('#final-price-'+id).html())-price);
    $('#raised-price-'+id).html(parseInt($('#final-price-'+id).html())+parseInt($('#raise-price').val()))

}
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-10">
            <h1 class="page-header">Products Under Approval</h1>
        </div>
        <div class="col-lg-1 ">
            <div class="page-action-links   ">
            <label for="commission-price">Commission</label>
            <input id ="commission-price" type="text"  class="form-control" value="<?php echo $commission; ?>" placeholder="Rate">
            </div>
        </div>
        <div class="col-lg-1 ">
            <div class="page-action-links   ">
            <label for="raise-price">Raise</label>
            <input id ="raise-price" type="text"  class="form-control" value="<?php echo $raise; ?>" placeholder="Rate">
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
    
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th >ID</th>
                <th >Associate</th>
                <th>Product Name</th>
                <th > Category</th>
                <th >Quality</th>
                <th > Actual Price</th>
                <th > Commission</th>
                <th > Selling Price</th>
                <th > Raised Price</th>                 
 					<th > Picture</th>
                <th >Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                
                <td id="product"><?php echo $row['id']; ?></td>
                <td><a target="_blank_" href="../Associates/view_associate.php?associate_id=<?php echo $row['product_owner'];  ?>&operation=view"><?php echo htmlspecialchars($row['bussiness_name']); ?></a></td>
                <td><a target="_blank_" href="view_product.php?product_id=<?php echo $row['id'];  ?>&operation=view"><?php echo htmlspecialchars($row['product_name']); ?></a></td>
                <td><?php echo htmlspecialchars($row['product_category']); ?></td>
                <td><?php echo htmlspecialchars($row['product_quality']); ?></td>
                <td><?php echo htmlspecialchars($row['product_price']); ?></td>
                <td id="com-<?php echo $row['id']; ?>"  onkeyup ="calculate_final(<?php echo $row['id']; ?>,parseInt($('#com-<?php echo $row['id']; ?>').html()), <?php echo $row['product_price']; ?>);" contenteditable="true" class="commission-show"></td>
                <td class="final" data-price ="<?php echo $row['product_price']; ?>" id="final-price-<?php echo $row['id']; ?>" contenteditable="true"  onkeyup ="calculate_other_pices(<?php echo $row['id']; ?>,parseInt($('#com-<?php echo $row['id']; ?>').html()), <?php echo $row['product_price']; ?>);">
                <td data-id="c" class="raise-price" id="raised-price-<?php echo $row['id']; ?>" contenteditable="true" class="raised-show"></td>

                </td>
    
    <td> <?php echo $row['file_name'] == 'null'? '<span class="badge badge-pill badge-danger">Not Uploaded</span>' :'<span class="badge badge-pill bg-danger text-white badge-success">Uploaded</span>' ; ?> </td>
                <script>
                $('.commission-show').html($('#commission-price').val());
                calculate_final(<?php echo $row['id']; ?>,parseInt($('#com-<?php echo $row['id']; ?>').html()), <?php echo $row['product_price']; ?>);
                </script>
                <td>
                    <a href="#" id="save_product" data-id ="<?php echo $row['id']; ?>" class="btn btn-success"><i class="fa fa-check"></i></a> 
                    <a href="#"  class="btn btn-danger delete_btn" data-toggle="modal" data-target="#block-product-<?php echo $row['id']; ?>"><i class="fa fa-ban"></i></a>
                </td>
                
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="block-product-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="reject_product.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="block_id" id="block_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="associate_id"  value="<?php echo $row['product_owner']; ?>">

                                <p>Are you sure you want to reject this associate?</p>
                                <textarea name="account_status"  rows="5" placeholder="Please provide the reason?" class="form-control"></textarea>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" id ="delete_the_product"  class="btn btn-default pull-left">Reject</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
    	<?php echo paginationLinks($page, $total_pages, 'products.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<script>



function change_prices(){
   

    $('.commission-show').html($('#commission-price').val());
    comm = $('#commission-price').val();
    $('.final').each(function(index, item) {
        item.innerHTML =  parseInt(item.attributes[1].value)+parseInt(comm)
        $('#raised-price-'+index).html(parseInt(item.attributes[1].value)+parseInt(comm)+parseInt($('#raise-price').val()))
    } );

    raise = $('#raise-price').val();
    $('.raise-price').each(function(index, item) {
        console.log(item.attributes[0].value)
        item.innerHTML =  parseInt($('#final-price-'+item.attributes[0].value).html())+parseInt(raise)
    } );
}
$('#raise-price').change(function(){
    change_prices()
});
$('#commission-price').change(function(){
    change_prices()
    
});

$(document).on('click', '#save_product', function(){ 
  
  var id = $(this).data('id');
  var sp= $('#final-price-'+id).html()
  var f_price = $('#raised-price-'+id).html()
  add_associate_product(id,sp,f_price);

 })


</script>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
