<?php
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Associate/Associate.php';
$costumers = new Associate();

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
$select = array('id', 'name', 'bussiness_name', 'address','account_status' ,'email_address','phone','created_at');

// Start building query according to input parameters
// If search string
if ($search_str) {
	$db->where('bussiness_name', '%' . $search_str . '%', 'like');
	$db->orwhere('name', '%' . $search_str . '%', 'like');
    $db->orwhere('phone', '%' . $search_str . '%', 'like');

}
// If order direction option selected
if ($order_dir) {
	$db->orderBy($order_by, $order_dir);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query
$rows = $db->arraybuilder()->paginate('associate_accounts', $page, $select);
$total_pages = $db->totalPages;
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Associates</h1>
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
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Owner Name</th>
                <th width="15%">Bussiness Name</th>
                <th width="30%"> Address</th>
                <th width="7%"> Email</th>
                <th width="8%">Phone</th>
                <th width="20%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr <?php if($row['account_status']!= "" || $row['account_status'] != null){ ?> class="danger" <?php }?>>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['bussiness_name']); ?></td>
            <td><?php echo substr(htmlspecialchars($row['address']),0,90); ?>...</td>

                <td><?php echo htmlspecialchars($row['email_address']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td>
                    <a href="view_associate.php?associate_id=<?php echo $row['id']; ?>&operation=view" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                    <a href="edit_associate.php?associate_id=<?php echo $row['id']; ?>&operation=edit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <?php if($row['account_status']!= "" || $row['account_status'] != null){ ?> 
                        <a href="#" class="btn  btn-success"data-toggle="modal" data-target="#unblock-account-<?php echo $row['id']; ?>"><i class="fa  fa-check-circle"></i></a>
                     <?php }else{?>
                        <a href="#" class="btn  btn-danger"data-toggle="modal" data-target="#block-account-<?php echo $row['id']; ?>"><i class="fa fa-ban"></i></a>
                        <?php }?>
                    <a href="#"  class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                                    <a href="#"  class="btn btn-warning" data-toggle="modal" data-target="#change-password-<?php echo $row['id']; ?>"><i class="fa fa-lock"></i></a>
                  

                </td>
            </tr>
        
        
            <div class="modal fade" id="change-password-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="update_associate_password.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Reset Password</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to reset the associate's password? The default password 
                                is <strong> B#BeFEK4</strong> please ask the assocaite to change it once they get access. </p>

                                <div class="form-row">
                                    <label for="password">Default Password</label>
                                    <input type="text" class="form-control" diabled value="B#BeFEK4">
                                </div>
                                <br>
                                <p class="mt-4"><strong>Disclaimer!</strong> Dear admin the password will be changed to the default strong password. Please dont try to change it!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit"  class="btn btn-default pull-left">Reset Password</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_associate.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to delete this associate?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id ="delete_the_product" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->

 <!-- Delete Confirmation Modal -->
 <div class="modal fade" id="unblock-account-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="unblock_associate.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Restart Associate Account</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to remove the ban on this associate account?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id ="delete_the_product" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->


            <!-- BLOCK Confirmation Modal -->
            <div class="modal fade" id="block-account-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="block_associate.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="block_id" id="block_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to ban this associate?</p>
                                <textarea name="account_status"  rows="5" placeholder="Please provide the reason?" class="form-control"></textarea>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" id ="delete_the_product"  class="btn btn-default pull-left">Ban</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //BLOCK Confirmation Modal -->
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
    	<?php echo paginationLinks($page, $total_pages, 'associates.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<script>

</script>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
