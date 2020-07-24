<?php require_once '../core/staff-init.php';
if(!is_staff_logged_in()){
  login_error_redirect();
}
?>
<style>

.wrapper {
  display: block;
      /* margin: 30px 2px; */
      border: 1px solid #555;
      width: auto;
      height: auto;;
      position: relative;
      padding: 5px;
      background-color: #313348
}
p{text-align:center;}
.label {
  height: 1em;
  padding: .3em;
  background: rgba(255, 255, 255, .8);
  position: absolute;
  display: none;
  color:#333;

}
.admin img{
  height: 150px;
  width: 150px;
}
.charts{
  color: white;
}
@media (min-width: 992px) {
  .admin img{
    height: 120px;
  }
}

</style>
<?php
include 'includes/head.php'; include 'includes/navigation.php';
?>  <?php  $selected_yr1 = (int)date("Y");
?>  <?php  $selected_yr2 = (int)date("Y")-1;
$dmonth = sanitize(isset($_POST['month']) ?  $_POST['month'] : date('m'));
$dtL = DateTime::createFromFormat('!m',$dmonth);
$monthL = sanitize(isset($_POST['monthlabel']) ?  $_POST['monthlabel'] : $dtL->format("F"));
$year1YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr1}'");
$year2YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr2}'");

$year1 = array();
$year_arr1 = array();
$year1Total = 0;
while($x = mysqli_fetch_assoc($year1YrQ)){
  $month1 = (int)date("m",strtotime($x['txn_date']));
  //add grand total to the month if that month is already in array with a grand total
  //add next grand total to previous grand total.
    if(!array_key_exists($month1,$year1)){
      $year1[(int)$month1] = $x['grand_total'];
    }else{
      $year1[(int)$month1] += $x['grand_total'];
    }
  //$year1[(int)$month1] += $x['grand_total'];
  $year1Total += $x['grand_total'];
}
for($i = 1; $i <= 12; $i++){
  if(!array_key_exists($i,$year1)){
      if($i > (int)date('m')){
         $year_arr1[$i] = '';
         $_year_arr1[$i] = 0;
      }else{
    $year_arr1[(int)$i] = 0;
     $_year_arr1[$i] = 0;

    }
  }else{
    $year_arr1[(int)$i] = $year1[$i];
    $_year_arr1[(int)$i] = $year1[$i];

  }
}
$m1 = $year_arr1[1];
$_m1 = $_year_arr1[1];

$m2 =$year_arr1[2];
$_m2 =$_year_arr1[2];
$m3 =$year_arr1[3];
$_m3 =$_year_arr1[3];
$m4 =$year_arr1[4];
$_m4 =$_year_arr1[4];
$m5 =$year_arr1[5];
$_m5 =$_year_arr1[5];
$m6 =  $year_arr1[6];
$_m6 =  $_year_arr1[6];
$m7 =$year_arr1[7];
$_m7 =$_year_arr1[7];
$m8 =$year_arr1[8];
$_m8 =$_year_arr1[8];
$m9 =$year_arr1[9];
$_m9 =$_year_arr1[9];
$m10 =$year_arr1[10];
$_m10 =$_year_arr1[10];
$m11 =$year_arr1[11];
$_m11 =$_year_arr1[11];
$m12 =$year_arr1[12];
$_m12 =$_year_arr1[12];

$year2 = array();
$year_arr2 = array();
$year2Total = 0;
while($x = mysqli_fetch_assoc($year2YrQ)){
  $month2 = (int)date("m",strtotime($x['txn_date']));
  //add grand total to the month if that month is already in array with a grand total
  //add next grand total to previous grand total.
    if(!array_key_exists($month2,$year2)){
      $year2[(int)$month2] = $x['grand_total'];
    }else{
      $year2[(int)$month2] += $x['grand_total'];
    }
  //$year1[(int)$month1] += $x['grand_total'];
  $year2Total += $x['grand_total'];
}
for($i = 1; $i <= 12; $i++){
  if(!array_key_exists($i,$year2)){
    $year_arr2[(int)$i] = 0;
  }else{
    $year_arr2[(int)$i] = $year2[$i];
  }
}
$mm1 = $year_arr2[1];
$mm2 =$year_arr2[2];
$mm3 =$year_arr2[3];
$mm4 =$year_arr2[4];
$mm5 =$year_arr2[5];
$mm6 =  $year_arr2[6];
$mm7 =$year_arr2[7];
$mm8 =$year_arr2[8];
$mm9 =$year_arr2[9];
$mm10 =$year_arr2[10];
$mm11 =$year_arr2[11];
$mm12 =$year_arr2[12];

//cash transactions
$cashT = 'cash';
$c_year1YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr1}' AND txn_type = '{$cashT}'");

$c_year1 = array();
$c_year_arr1 = array();
$c_year1Total = 0;
while($c_x = mysqli_fetch_assoc($c_year1YrQ)){
  $c_month1 = (int)date("m",strtotime($c_x['txn_date']));
  //add grand total to the month if that month is already in array with a grand total
  //add next grand total to previous grand total.
    if(!array_key_exists($c_month1,$c_year1)){
      $c_year1[(int)$c_month1] = $c_x['grand_total'];
    }else{
      $c_year1[(int)$c_month1] += $c_x['grand_total'];
    }
  //$year1[(int)$month1] += $x['grand_total'];
  $c_year1Total += $c_x['grand_total'];
}
for($i = 1; $i <= 12; $i++){
  if(!array_key_exists($i,$c_year1)){
    $c_year_arr1[(int)$i] = 0;
  }else{
    $c_year_arr1[(int)$i] = $c_year1[$i];
  }
}
$c_m1 = $c_year_arr1[1];
$c_m2 =$c_year_arr1[2];
$c_m3 =$c_year_arr1[3];
$c_m4 =$c_year_arr1[4];
$c_m5 =$c_year_arr1[5];
$c_m6 =  $c_year_arr1[6];
$c_m7 =$c_year_arr1[7];
$c_m8 =$c_year_arr1[8];
$c_m9 =$c_year_arr1[9];
$c_m10 =$c_year_arr1[10];
$c_m11 =$c_year_arr1[11];
$c_m12 =$c_year_arr1[12];

//pos Transactions
$posT = 'pos';
$p_year1YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr1}' AND txn_type = '{$posT}'");

$p_year1 = array();
$p_year_arr1 = array();
$p_year1Total = 0;
while($p_x = mysqli_fetch_assoc($p_year1YrQ)){
  $p_month1 = (int)date("m",strtotime($p_x['txn_date']));
  //add grand total to the month if that month is already in array with a grand total
  //add next grand total to previous grand total.
    if(!array_key_exists($p_month1,$p_year1)){
      $p_year1[(int)$p_month1] = $p_x['grand_total'];
    }else{
      $p_year1[(int)$p_month1] += $p_x['grand_total'];
    }
  //$year1[(int)$month1] += $x['grand_total'];
  $p_year1Total += $p_x['grand_total'];
}
for($i = 1; $i <= 12; $i++){
  if(!array_key_exists($i,$p_year1)){
    $p_year_arr1[(int)$i] = 0;
  }else{
    $p_year_arr1[(int)$i] = $p_year1[$i];
  }
}
$p_m1 = $p_year_arr1[1];
$p_m2 =$p_year_arr1[2];
$p_m3 =$p_year_arr1[3];
$p_m4 =$p_year_arr1[4];
$p_m5 =$p_year_arr1[5];
$p_m6 =  $p_year_arr1[6];
$p_m7 =$p_year_arr1[7];
$p_m8 =$p_year_arr1[8];
$p_m9 =$p_year_arr1[9];
$p_m10 =$p_year_arr1[10];
$p_m11 =$p_year_arr1[11];
$p_m12 =$p_year_arr1[12];

//online charge Transactions
$onlineT = 'charge';
$on_year1YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr1}' AND txn_type = '{$onlineT}'");

$on_year1 = array();
$on_year_arr1 = array();
$on_year1Total = 0;
while($on_x = mysqli_fetch_assoc($on_year1YrQ)){
  $on_month1 = (int)date("m",strtotime($on_x['txn_date']));
  //add grand total to the month if that month is already in array with a grand total
  //add next grand total to previous grand total.
    if(!array_key_exists($on_month1,$on_year1)){
      $on_year1[(int)$on_month1] = $on_x['grand_total'];
    }else{
      $on_year1[(int)$on_month1] += $on_x['grand_total'];
    }
  //$year1[(int)$month1] += $x['grand_total'];
  $on_year1Total += $on_x['grand_total'];
}
for($i = 1; $i <= 12; $i++){
  if(!array_key_exists($i,$on_year1)){
    $on_year_arr1[(int)$i] = 0;
  }else{
    $on_year_arr1[(int)$i] = $on_year1[$i];
  }
}
$on_m1 = $on_year_arr1[1];
$on_m2 =$on_year_arr1[2];
$on_m3 =$on_year_arr1[3];
$on_m4 =$on_year_arr1[4];
$on_m5 =$on_year_arr1[5];
$on_m6 =  $on_year_arr1[6];
$on_m7 =$on_year_arr1[7];
$on_m8 =$on_year_arr1[8];
$on_m9 =$on_year_arr1[9];
$on_m10 =$on_year_arr1[10];
$on_m11 =$on_year_arr1[11];
$on_m12 =$on_year_arr1[12];
   ?>
      <div class="welcome">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="content">
                <h2>Welcome to Dashboard</h2>
                <p>Manage product and website front-end appearance on the go</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <section class="statistics">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">
              <div class="box">
                <i class="fa fa-envelope fa-fw bg-primary"></i>
                <div class="info highlight">
                  <h3>1,245</h3> <span>Emails</span>
                  <p>Lorem ipsum dolor sit amet</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box">
                <i class="fa fa-file fa-fw danger"></i>
                <div class="info highlight">
                  <h3><?=$product_count?>/<?=$defective_product?></h3> <a href="products">Product(s)</a> <h3><?=$product_archive_count?></h3> <a href="archiveproducts"><span>Archived</span></a>
                  <p>Products Available in store</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box">
                <i class="fa fa-users fa-fw success"></i>
                <div class="info highlight">
                  <h3><?=$customer_count?></h3> <a href="customer_account">Customers</a> <h3><?=$staff_count?></h3> <a href="staff_account">Staffs</a>
                  <p>Customers and Staffs</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="charts">
        <div class="container-fluid">
          <div class="row">
            <!--<div class="col-md-6">
              <div class="chart-container">
                <h4 class="text-center">
                  <a href="exploresales"><?=$monthL;?> <?=$selected_yr1;?></a>
                </h4>
                    <div class="wrapper">
                      <canvas id='c'></canvas>
                  </div>
              </div>
            </div> -->
            <div class="col-md-6">
              <div class="chart-container">
                <h4 class="text-center">
                  <a href="exploresales">Sales for <?=$selected_yr2;?> and <?=$selected_yr1;?></a>
                </h4>
                <div class="wrapper">
                <canvas id="myChart"></canvas>
              </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="chart-container">
                <h4 class="text-center">
                <a href="exploresales">Sales for <?=$selected_yr1;?> By Cash, POS and Online</a>
              </h4>
              <div class="wrapper">
                <canvas id="myChart2"></canvas>
              </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="admins">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <h3>Admins and Editors:</h3>
                <?php $staff_Q = $db->query("SELECT * FROM staffs");
                 $max =0;
                      while($staff_data = mysqli_fetch_assoc($staff_Q)){
                        if(check_staff_permission_mult('editor',$staff_data['permissions'])){ $max++;?>

                <div class="admin">
                  <div class="img">
                    <img  class="img-responsive"src="<?=$staff_data['photo'];?>" alt="admin"/>
                  </div>
                  <div class="info text-center">
                    <h3 class="pull-left"><?=$staff_data['full_name'];?></h3><?=$staff_data['rank'];?>
                    <p><?=$staff_data['phone'];?> <a href="staff_account?edit=<?=$staff_data['id'];?>"><?=$staff_data['email'];?></p></a>
                  </div>
                </div>
              <?php  }
              if($max > 10){
                ?>
                <h3><a href="staff_account">more.......</a></h3>

                <?php break;
              }
              }?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box">
                <h3>Staffs:</h3>

                <?php $max2 =0;
                $staff_Q2 = $db->query("SELECT * FROM staffs");

                     while($staff_data2 = mysqli_fetch_assoc($staff_Q2)){
                       if(!check_staff_permission_mult('editor',$staff_data2['permissions'])){ $max2++;
                         ?>
               <div class="admin">
                 <div class="img">
                   <img  class="img-responsive"src="<?=$staff_data2['photo'];?>" alt="admin"/>
                 </div>
                 <div class="info text-center">
                   <h3 class="pull-left"><?=$staff_data2['full_name'];?></h3><?=$staff_data2['rank'];?>
                   <p><?=$staff_data2['phone'];?> <a href="staff_account?edit=<?=$staff_data2['id'];?>"><?=$staff_data2['email'];?></p></a>
                 </div>
               </div>
             <?php  }
             if($max2 > 10){
               ?>
               <h3><a href="staff_account">more.......</a></h3>
               <?php break;
             }
             }?>

              </div>
            </div>
          </div>
          </section>
        <section class='statis text-center'>
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="box bg-primary">
                  <i class="fa fa-eye"></i>
                  <h3>5,154</h3>
                  <p class="lead">Page views</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="box danger">
                  <i class="fa fa-user-o"></i>
                  <h3><?=$onsale;?>/<?=$onfeatured;?></h3>
                  <p class="lead">Product on Sales/Featured</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="box warning">
                  <i class="fa fa-shopping-cart"></i>
                   <a href="products" style="color:white">
                     <h3><?=$total_item_count?> <?= ($total_item_count > 1)?'Qtys':'Qty';?>
                      of <?=$unique_item_count?> Unique </h3>
                 </a>
                  <p class="lead">Product Sold</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="box success">
                  <i class="fa fa-handshake-o"></i>
                  <a href="exploresales" style="color:white">
                  <h3><?=$noofTrans?>=> [<?=money($monthTotal)?>]</h3></a>
                  <p class="lead">Month Transactions</p>
                </div>
              </div>
            </div>
          </div>
        </section>
      </section><p></p>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/ecommerce/admin/parsers/graphscript.php';
include 'includes/footer.php'; ?>
<script type="text/javascript">
// Start chart

var chart = document.getElementById('myChart');
Chart.defaults.global.animation.duration = 2000; // Animation duration
Chart.defaults.global.title.display = false; // Remove title
Chart.defaults.global.title.text = "Chart"; // Title
Chart.defaults.global.title.position = 'bottom'; // Title position
Chart.defaults.global.defaultFontColor = 'white'; // Font color
Chart.defaults.global.defaultFontSize = 12; // Font size for every label

// Chart.defaults.global.tooltips.backgroundColor = '#FFF'; // Tooltips background color
Chart.defaults.global.tooltips.borderColor = 'white'; // Tooltips border color
Chart.defaults.global.legend.labels.padding = 5;
Chart.defaults.scale.ticks.beginAtZero = false;
Chart.defaults.scale.gridLines.zeroLineColor = 'rgba(255, 255, 255, 0.1)';
Chart.defaults.scale.gridLines.color = 'rgba(255, 255, 255, 0.02)';

Chart.defaults.global.legend.display = true;

var myChart = new Chart(chart, {
type: 'line',
data: {
labels: ["January", "February", "March", "April", "May", 'June',"July", "August", "September", "October", "November", 'December'],
datasets: [{
label: "<?php echo $selected_yr1; ?>",
fill: true,
lineTension: 0.4,
data: [<?php echo $m1; ?>,<?php echo $m2; ?>,<?php echo $m3; ?>,<?php echo $m4; ?>,<?php echo $m5; ?>,<?php echo $m6; ?>,<?php echo $m7; ?>,
<?php echo $m8; ?>,<?php echo $m9; ?>,<?php echo $m10; ?>,<?php echo $m11; ?>,<?php echo $m12; ?>, ],
pointBorderColor: "#4bc0c0",
borderColor: '#4bc0c0',
borderWidth: 2,
showLine: true,

}, {
label: "<?php echo $selected_yr2; ?>",
fill: true,
lineTension: 0.4,
startAngle: 2,
data: [<?php echo $mm1; ?>,<?php echo $mm2; ?>,<?php echo $mm3; ?>,<?php echo $mm4; ?>,<?php echo $mm5; ?>,<?php echo $mm6; ?>,<?php echo $mm7; ?>,
<?php echo $mm8; ?>,<?php echo $mm9; ?>,<?php echo $mm10; ?>,<?php echo $mm11; ?>,<?php echo $mm12; ?>, ],
// , '#ff6384', '#4bc0c0', '#ffcd56', '#457ba1'
backgroundColor: "transparent",
pointBorderColor: "#ff6384",
borderColor: '#ff6384',
borderWidth: 2,
showLine: true,
}]
},
});
//  Chart ( 2 )


var Chart2 = document.getElementById('myChart2').getContext('2d');
var chart = new Chart(Chart2, {
type: 'bar',
data: {
labels: ["January", "February", "March", "April", "May", 'June',"July", "August", "September", "October", "November", 'December'],
datasets: [{
label: "Cash",
backgroundColor: 'transparent',
borderColor: 'rgb(255, 79, 116)',
borderWidth: 2,
pointBorderColor: false,
data: [<?php echo $c_m1; ?>,<?php echo $c_m2; ?>,<?php echo $c_m3; ?>,<?php echo $c_m4; ?>,<?php echo $c_m5; ?>,<?php echo $c_m6; ?>,<?php echo $c_m7; ?>,
<?php echo $c_m8; ?>,<?php echo $c_m9; ?>,<?php echo $c_m10; ?>,<?php echo $c_m11; ?>,<?php echo $c_m12; ?>, ],
fill: false,
lineTension: .4,
}, {
label: "POS",
fill: false,
lineTension: .4,
startAngle: 2,
data: [<?php echo $p_m1; ?>,<?php echo $p_m2; ?>,<?php echo $p_m3; ?>,<?php echo $p_m4; ?>,<?php echo $p_m5; ?>,<?php echo $p_m6; ?>,<?php echo $p_m7; ?>,
<?php echo $p_m8; ?>,<?php echo $p_m9; ?>,<?php echo $p_m10; ?>,<?php echo $p_m11; ?>,<?php echo $p_m12; ?>, ],
// , '#ff6384', '#4bc0c0', '#ffcd56', '#457ba1'
backgroundColor: "transparent",
pointBorderColor: "#4bc0c0",
borderColor: '#4bc0c0',
borderWidth: 2,
showLine: true,
}, {
label: "Online",
fill: false,
lineTension: .4,
startAngle: 2,
data: [<?php echo $on_m1; ?>,<?php echo $on_m2; ?>,<?php echo $on_m3; ?>,<?php echo $on_m4; ?>,<?php echo $on_m5; ?>,<?php echo $on_m6; ?>,<?php echo $on_m7; ?>,
<?php echo $on_m8; ?>,<?php echo $on_m9; ?>,<?php echo $on_m10; ?>,<?php echo $on_m11; ?>,<?php echo $on_m12; ?>, ],
// , '#ff6384', '#4bc0c0', '#ffcd56', '#457ba1'
backgroundColor: "transparent",
pointBorderColor: "#ffcd56",
borderColor: '#ffcd56',
borderWidth: 2,
showLine: true,
}]
},

// Configuration options
options: {
title: {
display: false
}
}
});


console.log(Chart.defaults.global);

var chart = document.getElementById('chart3');
var myChart = new Chart(chart, {
type: 'line',
data: {
labels: ["One", "Two", "Three", "Four", "Five", 'Six', "Seven", "Eight"],
datasets: [{
label: "Lost",
fill: false,
lineTension: .5,
pointBorderColor: "transparent",
pointColor: "white",
borderColor: '#d9534f',
borderWidth: 0,
showLine: true,
data: [0, 40, 10, 30, 10, 20, 15, 20],
pointBackgroundColor: 'transparent',
},{
label: "Lost",
fill: false,
lineTension: .5,
pointColor: "white",
borderColor: '#5cb85c',
borderWidth: 0,
showLine: true,
data: [40, 0, 20, 10, 25, 15, 30, 0],
pointBackgroundColor: 'transparent',
},
         {
           label: "Lost",
           fill: false,
           lineTension: .5,
           pointColor: "white",
           borderColor: '#f0ad4e',
           borderWidth: 0,
           showLine: true,
           data: [10, 40, 20, 5, 35, 15, 35, 0],
           pointBackgroundColor: 'transparent',
         },
         {
           label: "Lost",
           fill: false,
           lineTension: .5,
           pointColor: "white",
           borderColor: '#337ab7',
           borderWidth: 0,
           showLine: true,
           data: [0, 30, 10, 25, 10, 40, 20, 0],
           pointBackgroundColor: 'transparent',
         }]
},
});
</script>
