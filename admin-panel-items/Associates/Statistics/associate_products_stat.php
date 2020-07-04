<?php
session_start();
require_once '/var/www/html/admin/config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

require_once BASE_PATH . '/lib/Associate/Associate.php';

$costumers = new Associate();
$order_by	= filter_input(INPUT_GET, 'order_by');
$order_dir	= filter_input(INPUT_GET, 'order_dir');
$search_str	= filter_input(INPUT_GET, 'search_str');

$pagelimit = 15;

$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

if (!$order_by) {
	$order_by = 'id';
}
if (!$order_dir) {
	$order_dir = 'Desc';
}
$db = getDbInstance();
$select = array('id', 'name', 'bussiness_name', 'address','account_status' ,'email_address','phone','created_at');

if ($search_str) {
	$db->where('bussiness_name', '%' . $search_str . '%', 'like');
	$db->orwhere('name', '%' . $search_str . '%', 'like');

}

if ($order_dir) {
	$db->orderBy($order_by, $order_dir);
}
$db->pageLimit = $pagelimit;

$rows = $db->arraybuilder()->paginate('associate_accounts', $page, $select);
$total_pages = $db->totalPages;
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Associates Statistics</h1>
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
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <!-- //Filters -->
    <div style="padding:5px;" class="panel panel-chart-white">
         <div id="chart"></div>
    </div>
   <div class="table-responsive">
    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th >#</th>
                <th >Owner Name</th>
                <th >Bussiness Name</th>
                <th > Waiting </th>
                <th > Approved</th>
                <th > <?php echo date('M'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $counter =1; ?>
            <?php foreach ($rows as $row): ?>
            <tr >
                <td><?php echo $counter; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['bussiness_name']); ?></td>
                <td><?php echo  $db->where('product_owner',$row['id'])->getValue('associate_products','count(*)')?></td>
                <td><?php echo  $db->where('product_owner',$row['id'])->getValue('products','count(*)')?></td>
                <td><?php echo  $db->where('product_owner',$row['id'])->where('MONTH(created_at)',date('m'))->getValue('products','count(*)')?></td>
            </tr>
            <?php $counter = $counter+1; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->
   </div>

    <!-- Pagination -->
    <div class="text-center">
    	<?php echo paginationLinks($page, $total_pages, 'associates_products_stat.php'); ?>
    </div>
    <!-- //Pagination -->
</div>

<?php 

$db2 = getDbInstance();
$data_all_products_raw = $db2->groupBy('MONTH("created_at")')->get('products',null,'count(*),MONTH(created_at)');
$data_products_raw = $db2->where('product_belongs_to','owner')->groupBy('MONTH("created_at")')->get('products',null,'count(*),MONTH(created_at)');
$data_associate_products_raw = $db2->where('product_belongs_to','associate')->groupBy('MONTH("created_at")')->get('products',null,'count(*),MONTH(created_at)');

$data_products  = array();
$data_associates  = array();
$data  = array();

for ($x = 1; $x <= 12; $x++) {
  $data_products[$x] =0;
  $data_associates[$x] =0;
 $data[$x] =0;


} 
foreach ($data_products_raw as $row):
    $data_products[$row['MONTH(created_at)']]=$row['count(*)'];
endforeach;
 
foreach ($data_associate_products_raw as $row):
  $data_associates[$row['MONTH(created_at)']]=$row['count(*)'];
endforeach;
foreach ($data_all_products_raw as $row):
  $data[$row['MONTH(created_at)']]=$row['count(*)'];
endforeach;

?>


<script>
var data_admin_obj = <?php echo json_encode($data_products) ;?>;
var data_admin = Object.keys(data_admin_obj).map(function (key) { return data_admin_obj[key]; });

var data_associate_obj = <?php echo json_encode($data_associates) ;?>;
var data_associate = Object.keys(data_associate_obj).map(function (key) { return data_associate_obj[key]; });

var data_all_obj = <?php echo json_encode($data) ;?>;
var data_all = Object.keys(data_all_obj).map(function (key) { return data_all_obj[key]; });

$(document).ready(function(){

    var options = {
          series: [{
            name: "Admin",
            data:  data_admin
        },{
            name: "Associate",
            data:  data_associate
        },{
            name: "Total",
            data:  data_all
        }
         
        
        ],
          chart: {
          height: 350,
          type: 'area',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        title: {
          text: 'Product Trends by Month',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec'],
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      
})
</script>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>