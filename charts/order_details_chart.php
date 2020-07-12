<?php 
 require_once '/var/www/html/admin/config/config.php';
 require_once BASE_PATH . '/includes/auth_validate.php';

 $db = getDbInstance();
 $db->groupBy("ordered_at");
 $result =  $db->get('orders ',null,'ordered_at,order_status,count(*)');
 
 $data_new_orders = array();
 $data_accepted_orders  = array();
$data_approved_orders = array();
 $categories = array();
 foreach ($result as $row):
    switch($row['order_status']){
      case "rejected":
        $data_new_orders[] =$row['count(*)'];
        $data_accepted_orders[] =0;
        $data_delivered_orders[] =0;

      break;
      case "delivered":
        $data_accepted_orders[] =$row['count(*)'];
        $data_new_orders[]=0;
        $data_delivered_orders[]=0;
      break;
      case "delivering":
        $data_approved_orders[] =$row['count(*)'];
        $data_accepted_orders[] =0;
        $data_new_orders[]=0;
        $data_delivered_orders[]=0;
      break;
     
    }
    $categories[] =$row['ordered_at'];
 endforeach;
 
// ORDER DETAILS
$db = getDbInstance();
$data_assocaite_orders = 0;


$db2 = getDbInstance();
$orders_accepted =  $db2->where('order_status','rejected')->getValue('orders','count(*)');
$orders_delievered =  $db2->where('order_status','delivered')->getValue('orders','count(*)');
$orders_delivering =  $db2->where('order_status','delivering')->getValue('orders','count(*)');

$total_orders =  $db2->getValue('orders','count(*)');
$data_assocaite_orders = $db2->where('owner')->getValue('orders','count(*)');
$data_owner_orders =$total_orders-$data_assocaite_orders;


$data_users = $db2->groupBy('MONTH("created_at")')->get('auth_user_account',null,'count(*),MONTH(created_at)');
$data_associates_accounts = $db2->groupBy('MONTH("created_at")')->get('associate_accounts',null,'count(*),MONTH(created_at)');
$data_orders = $db2->groupBy('MONTH("ordered_at")')->get('orders',null,'count(*),MONTH(ordered_at)');

$data_customers  = array();
$data_associates  = array();
$data_orders_trend  = array();

for ($x = 0; $x < 12; $x++) {
  $data_customers[$x] =0;
  $data_associates[$x] =0;
  $data_orders_trend[$x] =0;

} 
foreach ($data_users as $row):
    $data_customers[$row['MONTH(created_at)']]=$row['count(*)'];
endforeach;
 
foreach ($data_associates_accounts as $row):
  $data_associates[$row['MONTH(created_at)']]=$row['count(*)'];
endforeach;

foreach ($data_orders as $row):
  $data_orders_trend[$row['MONTH(ordered_at)']]=$row['count(*)'];
endforeach;

?>
     <script>
    window.onload = function () {
        
        // indiviual_orders
        var options = {
          series: [<?php echo $data_owner_orders;?>, 
          <?php echo $data_assocaite_orders?>, 
          <?php echo $orders_accepted ?> ,
          <?php echo $orders_delievered ?>,
          <?php echo $orders_delivering?>,],

          chart: {
          height: 265,
          type: 'radialBar',
          },
          plotOptions: {
            radialBar: {
              dataLabels: {
                name: {
                  fontSize: '22px',
                },
                value: {
                  fontSize: '16px',
                },
                total: {
                  show: true,
                  label: 'Total',
                  formatter: function (w) {
                    // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                    return <?php echo $total_orders ;?>;
                  }
                }
              }
            }
          },
          labels: ['Admin', 'Associate', 'Rejected','Delivered','Delivering'],
        };
        var chart = new ApexCharts(document.querySelector("#customers_chart"), options);
        chart.render();

        // Orders
        var options = {
            series: [
          {
            name: 'New Orders',
            data: <?php echo json_encode($data_approved_orders) ;?>
          },
          {
            name: 'Delivered Orders',
            data: <?php echo json_encode($data_accepted_orders) ;?>
          },{
            name: 'Rejected Orders',
            data: <?php echo json_encode($data_new_orders) ;?>
          }
          
          ],
            chart: {
            height: 250,
            type: 'area'
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: 'smooth'
          },
          xaxis: {
            type: 'date',
            categories: <?php echo json_encode($categories) ;?>,
            format: {
                year: 'yyyy',
                month: "MMM 'yy",
                day: 'dd MMM',
            },
            formatter: undefined,
            dateUTC: true,
            dateFormatter: {
                year: 'yyyy',
                month: "MMM 'yy",
                day: 'dd MMM',
            },
          },
          tooltip: {
            x: {
              format: 'dd-MMM-yy '
            },
          },
        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();

    

       
        

      
   
        //DETAILS

      
        var options = {
          series: [{
            name: "Customers",
            data: <?php echo json_encode($data_customers) ;?>
        },
        {
            name: "Associates",
            data: <?php echo json_encode($data_associates) ;?>
        },{
            name: "Orders",
            data: <?php echo json_encode($data_orders_trend) ;?>
        }
        
        
        ],
          chart: {
          height: 290,
          type: 'area',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Trends by Months',
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

        var chart = new ApexCharts(document.querySelector("#daily_progress"), options);
        chart.render();
      
      
    

      

}
     </script>
     <div id="customers_chart"></div>
