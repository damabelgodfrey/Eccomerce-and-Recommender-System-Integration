
<?php
require_once '../core/staff-init.php';
//is_staff_logged_in function is in helper file
//check if user is logged in on any of the pages
if(!is_staff_logged_in()){
  header('Location:Login.php');

}

include 'includes/head1.php';
include 'includes/navigation1.php';
include_once 'includes/Pagination.class.php';
$_SESSION['staff_rdrurl'] = $_SERVER['REQUEST_URI'];
// Sets the top option to be the current year. (IE. the option that is chosen by default).
$currently_selected1 = date('Y');
$currently_selected2 = date('Y');
// Year to start available options at
$earliest_year = 2017;
$latest_year = date('Y');
$selected_yr2 = (int)((isset($_POST['year']))?sanitize($_POST['year']):date("Y"));
$selected_yr1 =(int)((isset($_POST['yearholder']))?sanitize($_POST['yearholder']):$selected_yr2-1);
?>
<hr><br>
<div class="box">
<form action="exploresales" method="post">
    <div class="form-group col-md-3">
       <label for="Year">Year 1</label>
       <select class="form-control" name="myYear1" placeholder="Choose Year" required>
          <option value="">Choose Year</option>
         <?php foreach ( range( $latest_year, $earliest_year ) as $i ) { ?>
                 <option value="<?=$i;?>"<?=(($i === $currently_selected1)? ' selected' : '');?>> <?=$i;?></option>
         <<?php } ?>
       </select>
    </div>
    <div class="form-group col-md-3">
       <label for="Year">Year 2</label>
       <select class="form-control" name="myYear2" placeholder="Choose Year" required>
         <option value="">Choose Year</option>
       <?php foreach(range( $latest_year, $earliest_year ) as $i ) { ?>
               <option value="<?=$i;?>"<?=(($i === $currently_selected2)? 'selected' : '');?>> <?=$i;?></option>
       <?php } ?>
       </select>
    </div>
    <div class="form-group col-md-12">
        <input type="submit" name="submit" class="btn btn-success" value="Fetch Monthly Sale" />
      <div id = "errors"class=""></div>
    </div><div class="clearfix"></div>
</form>
</div>
<?php
if(isset($_POST['submit'])){
  $selected_yr1 = (int)((isset($_POST['myYear1']))?sanitize($_POST['myYear1']):'');
  $selected_yr2 = (int)((isset($_POST['myYear2']))?sanitize($_POST['myYear2']):'');
  if ($selected_yr1===$selected_yr2) {
    ?> <script>
    var error = '';
    error += '<p class="text-warning bg-danger text-center">Plz note both year chosen is similar!</p>';
    jQuery('#errors').html(error);
    </script><?php
  }
  $year1YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr1}'");
  $year2YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr2}'");
  }else{
    $year1YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr1}'");
    $year2YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$selected_yr2}'");
  }
$year1 = array();
$year2 = array();
$year_arr1 = array();
$year_arr2 = array();
$year1Total = 0;
$year2Total = 0;
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
    $year_arr1[(int)$i] = 0;
  }else{
    $year_arr1[(int)$i] = $year1[$i];
  }
}

while($y = mysqli_fetch_assoc($year2YrQ)){
  $month2 = (int)date("m",strtotime($y['txn_date']));
    if(!array_key_exists($month2,$year2)){
      $year2[(int)$month2] = $y['grand_total'];
    }else{
      $year2[(int)$month2] += $y['grand_total'];
    }
  $year2Total += $y['grand_total'];
}
for($i = 1; $i <= 12; $i++){
  if(!array_key_exists($i,$year2)){
    $year_arr2[(int)$i] = 0;
  }else{
    $year_arr2[(int)$i] = $year2[$i];
  }
}
?>
<p></p>
<div class="row">
<div class="col-md-12">
<div class ="col-md-6 box">
<h3 class="text-center">Sales By Month</h3>
  <table class="table table-condensed table-striped table-bordered">
  <thead>
  <th>Month</th>
  <th><?=$selected_yr1;?></th>
  <th><?=$selected_yr2;?></th>
  </thead>
      <tbody>
      <?php for($i = 1; $i <= 12; $i++):
             $dt = DateTime::createFromFormat('!m',$i);
             $futureMonth1 =  (date("m") < $i && $selected_yr1 >=(int)date("Y"))?'':money(0); //mark future month with no sale
             $futureMonth2 =  (date("m") < $i && $selected_yr2 >=(int)date("Y"))?'':money(0);
       ?>
        <tr>
          <td class="info"><?=$dt->format("F");?></td>
          <td <?=(date("m")==$i && date("Y")==$selected_yr1)?' class="warning"':'';?>>
            <?php if(array_key_exists($i,$year1)){?>
               <form action="exploresales" method="post">
                   <input type="hidden" name="year" value="<?=$selected_yr1;?>">
                   <input type="hidden" name="yearholder" value="<?=$selected_yr2;?>">
                   <input type="hidden" name="month" value="<?= $i; ?>">
                   <button type="submit" class="btn btn-xs btn-default"><?=money($year1[$i]) ;?></button>
               </form>
             <?php }else{ ?>
               <?=$futureMonth1;?>
             <?php } ?>
          </td>
          <td <?=(date("m")==$i && date("Y") == $selected_yr2)?' class="danger"':'';?>>
            <?php if(array_key_exists($i,$year2)){?>
             <form action="exploresales" method="post">
                 <input type="hidden" name="year" value="<?=$selected_yr2;?>">
                 <input type="hidden" name="yearholder" value="<?=$selected_yr1;?>">
                 <input type="hidden" name="month" value="<?= $i; ?>">
                 <button type="submit" class="btn btn-xs btn-default"><?=money($year2[$i]) ;?></button>
             </form>
         <?php }else{ ?>
           <?=$futureMonth2;?>
         <?php } ?>
          </td>
        </tr>
      <?php endfor; ?>
        <tr>
         <td class= "bg-primary">Total</td>
         <td class= "bg-primary">
           <button type ="button" class="btn btn-xs btn-default" onclick="exSaleModalgraph(<?=$selected_yr1;?>,<?=$year_arr1[1];?>,<?=$year_arr1[2];?>,
             <?=$year_arr1[3];?>,<?=$year_arr1[4];?>,<?=$year_arr1[5];?>,<?=$year_arr1[6];?>,<?=$year_arr1[7];?>,<?=$year_arr1[8];?>,
             <?=$year_arr1[9];?>,<?=$year_arr1[10];?>,<?=$year_arr1[11];?>,<?=$year_arr1[12];?>,)">
             <?=money($year1Total);?></button>
         </td>
         <td class= "bg-primary">
           <button type ="button" class="btn btn-xs btn-default" onclick="exSaleModalgraph(<?=$selected_yr2;?>,<?=$year_arr2[1];?>,<?=$year_arr2[2];?>,
             <?=$year_arr2[3];?>,<?=$year_arr2[4];?>,<?=$year_arr2[5];?>,<?=$year_arr2[6];?>,<?=$year_arr2[7];?>,<?=$year_arr2[8];?>,
             <?=$year_arr2[9];?>,<?=$year_arr2[10];?>,<?=$year_arr2[11];?>,<?=$year_arr2[12];?>,)">
             <?=money($year2Total);?></button>

         </td>
        </tr>
      </tbody>
  </table>
</div>
<div class="col-md-6 box">
  <?php
  $dyear = sanitize(isset($_POST['year']) ?  $_POST['year'] : date('Y'));
  $dmonth = sanitize(isset($_POST['month']) ?  $_POST['month'] : date('m'));
  $dtL = DateTime::createFromFormat('!m',$dmonth);
  $monthL = sanitize(isset($_POST['monthlabel']) ?  $_POST['monthlabel'] : $dtL->format("F"));
  $year1YrQ = $db->query("SELECT grand_total,txn_date FROM transactions WHERE YEAR(txn_date) = '{$dyear}' AND MONTH(txn_date)= '{$dmonth}'");
  $monthDailSale = array();
  $monthTotal = 0;
  while($x = mysqli_fetch_assoc($year1YrQ)){
    $day = (int)date("d",strtotime($x['txn_date']));
    //add grand total to the month if that month is already in array with a grand total
    //add next grand total to previous grand total.
      if(!array_key_exists($day,$monthDailSale)){
        $monthDailSale[(int)$day] = $x['grand_total'];
      }else{
        $monthDailSale[(int)$day] += $x['grand_total'];
      }
    $monthTotal += $x['grand_total'];
  }
  ?>
  <!--Product Details light Box -->
          <h3 class=" text-center"><?=$monthL;?> <?=$dyear;?> => [<?=money($monthTotal);?>]</h3>
          <div class"container-fluid ">
            <?php
                $y = (int)$dyear;
                $m = (int)$dmonth;
                //months array just like Jan,Feb,Mar,Apr in short format
                $m_array = array('1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec');
                $d_array = array('1'=>31, '2'=>28, '3'=>31, '4'=>30, '5'=>31, '6'=>30, '7'=>31, '8'=>31, '9'=>30, '10'=>31, '11'=>30, '12'=>31);
                $d_m = ($m==2 && $y%4==0)?29:$d_array[$m];
                echo '<table class="table table-condensed table-striped table-bordered"><tr></tr><tr>';
                //days array
                $days_array = array('1'=>'Mon', '2'=>'Tue', '3'=>'Wed', '4'=>'Thu', '5'=>'Fri', '6'=>'Sat', '7'=>'Sun');
                //display days
                foreach ($days_array as $key=>$val){
                    echo '<th>'.$val.'</th>';
                }
                echo "</tr></tr>";
                $date = $y.'-'.$m.'-01';
                //find start day of the month
                $startday = array_search(date('D',strtotime($date)), $days_array);
                //display month dates
                for($i=0; $i<($d_m+$startday); $i++){
                    $day = ($i-$startday+1<=9)?'0'.($i-$startday+1):$i-$startday+1;
                    $days = (int)$day;
                    if(array_key_exists($days,$monthDailSale)){
                      $moneyT = $monthDailSale[$days];
                      $style ='style = "text-align:center"';
                    }else{
                      $futureDay =  (date("d") < $days && $dmonth >=(int)date("m") && (int)date("Y")==$dyear)?'-':money(0);
                      $moneyT= $futureDay;
                      $style = 'style = "text-align:center;color:grey"';
                      }
                      if((int)date("d")==$days && (int)date("m")==$dmonth && (int)date("Y")==$dyear){
                        $todayMarker =' class="danger"';
                      }else{
                          $todayMarker ='';
                      }
                      if($i<$startday){ ?>
                        <td></td>
                <?php }else{ ?>
                        <td <?= $todayMarker;?>>
                          <sup> <?=$day?></sup>
                          <div <?=$style;?> >
                          <?php if($moneyT == money(0) || $moneyT =='-') {?>
                          <?=$moneyT;?>
                        <?php }else{ ?>
                          <button type ="button" class="btn btn-xs btn-default" onclick="exSaleModal(<?=$dyear;?>,<?=$dmonth;?>,<?= $days; ?>,'<?=$dt->format("F");?>')"><?=money($moneyT);?></button>
                        <?php } ?>
                        </div>
                      </td>
                    <?php }
                    echo ($i%7==0)?'</tr><tr>':'';
                }
            ?>
        </div>
</div></div></div><p></p>
<script>
function exSaleModal(year,month,day,monthlabel){
var data = {"year": year,"month" : month, "day" : day,"monthlabel" : monthlabel};
jQuery.ajax({
  //on the client side
  url: '/ecommerce/admin/parsers/exploresalemodal.php',
  method : "post",
  data : data,
  success: function(data){
    jQuery('body').append(data);
    jQuery('#details-modal').modal('toggle');
    },
    error: function(data){
      alert("something went wrong!");
    }
  });
}
function exSaleModalgraph(dyear,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12){
var data = {"dyear": dyear,"m1": m1,"m2": m2,"m3": m3,"m4": m4,"m5": m5,"m6": m6,"m7": m7,"m8": m8,"m9": m9,"m10": m10,"m11": m11,"m12": m12};
jQuery.ajax({
  //on the client side
  url: '/ecommerce/admin/parsers/exploresalemodalgraph.php',
  method : "post",
  data : data,
  success: function(data){
    jQuery('body').append(data);
    jQuery('#graph-modal').modal('toggle');
    },
    error: function(data){
      alert("something went wrong!");
    }
  });
}
;(function($){

  /**
   * Store scroll position for and set it after reload
   *
   * @return {boolean} [loacalStorage is available]
   */
  $.fn.scrollPosReaload = function(){
      if (localStorage) {
          var posReader = localStorage["posStorage"];
          if (posReader) {
              $(window).scrollTop(posReader);
              localStorage.removeItem("posStorage");
          }
          $(this).click(function(e) {
              localStorage["posStorage"] = $(window).scrollTop();
          });

          return true;
      }

      return false;
  }

  /* ================================================== */

  $(document).ready(function() {
      // Feel free to set it for any element who trigger the reload
      $('select').scrollPosReaload();
  });

}(jQuery));
</script>
