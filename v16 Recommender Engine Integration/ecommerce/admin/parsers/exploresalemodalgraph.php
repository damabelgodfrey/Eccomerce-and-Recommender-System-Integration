<style>
#graphbody {
  margin: 0;
  overflow: hidden;
  background: #152B39;
  font-family: Courier, monospace;
  font-size: 14px;
  color:#ccc;
}

.wrapper {
  display: block;
  margin: 5em auto;
  border: 1px solid #555;
  width: 700px;
  height: 350px;
  position: relative;
  padding:10px;
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
</style><?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
$dyear = sanitize(isset($_POST['dyear']) ?  $_POST['dyear'] : date('Y'));
$m1 = sanitize(isset($_POST['m1']) ?  $_POST['m1'] : date('m'));
$m2 = sanitize(isset($_POST['m2']) ?  $_POST['m2'] : date('m'));
$m3 = sanitize(isset($_POST['m3']) ?  $_POST['m3'] : date('m'));
$m4 = sanitize(isset($_POST['m4']) ?  $_POST['m4'] : date('m'));
$m5 = sanitize(isset($_POST['m5']) ?  $_POST['m5'] : date('m'));
$m6 = sanitize(isset($_POST['m6']) ?  $_POST['m6'] : date('m'));
$m7 = sanitize(isset($_POST['m7']) ?  $_POST['m7'] : date('m'));
$m8 = sanitize(isset($_POST['m8']) ?  $_POST['m8'] : date('m'));
$m9 = sanitize(isset($_POST['m9']) ?  $_POST['m9'] : date('m'));
$m10 = sanitize(isset($_POST['m10']) ?  $_POST['m10'] : date('m'));
$m11 = sanitize(isset($_POST['m11']) ?  $_POST['m11'] : date('m'));
$m12 = sanitize(isset($_POST['m12']) ?  $_POST['m12'] : date('m'));
?>
<!--Product Details light Box -->
<?php ob_start(); ?>
<div class="modal fade details-1" id="graph-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-header">
        <button id="closemyModal"class="close " type="button" onclick = "closeModal()" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title text-center"><?=$dyear;?></h2>
      </div>
      <div class="modal-body"  id="graphbody">
        <div class"container-fluid">
          <div class="wrapper">
            <canvas id='c'></canvas>
            <div class="label">text</div>
        </div>
       <p>Please mouse over the dots</p>
      </div>
      <!--footer of the product detail pop up-->
    </div>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/ecommerce/admin/parsers/graphscript.php';
 ?>
<script>
$("#graph-modal").draggable({
    handle: ".modal-header"
});
function closeModal(){
  jQuery('#graph-modal').modal('hide');
  setTimeout(function(){
    jQuery('#graph-modal').remove();
    jQuery('.modal.backdrop').remove();
  },500);
}
$('#graph-modal').on('show', function () {
      $('.modal-body',this).css({width:'auto',height:'auto', 'max-height':'100%','max-width':'100%'});
});
</script>
<?php echo ob_get_clean(); ?>
