
<button type="button" class="d_buttonsearch">
    <i class="fa fa-percent openclosediscount" aria-hidden="true"> Add Coupon Discount</i>
    <i class="glyphicon glyphicon-remove openclosediscount" style="display:none"></i>
  </button>
    <div class="container discountbardiv discountsearch">
      <div class="input-group-btn positn">
        <a type="button" class="d_buttonsearch" >
            <i class="glyphicon glyphicon-remove openclosediscount" style="display:none"></i>
          </a>
      </div>
				<form action="cart" role="search" method="post" id="searchform"  >
					<div class="input-group">
						<input type="text" class="form-control discountbox" name="searchdiscount" id="s">
						<div class="input-group-btn">
							<button class="btn btn-default"  id="searchsubmit"  type="submit">
								<strong>Add Discount</strong>
							</button>
						</div>
					</div>
				</form>
			</div>

      <?php
      $mydiscount =0;
       if(isset($_POST['searchdiscount'])){
        $discount_code = $_POST['searchdiscount'];
        $discount_status =1;
        $discQ = $db->query("SELECT * FROM discount WHERE disc_code = '{$discount_code}' AND status ='{$discount_status}'");
        if(mysqli_num_rows($discQ) > 0){
        $disc = mysqli_fetch_assoc($discQ);
        if (strtotime((new DateTime())->format("Y-m-d H:i:s")) > strtotime($disc['expiry'])) {
          ?><div class="text-danger"><?php
          echo 'expired coupon code';
          ?></div><?php
      }else{
        $_SESSION["my_discount"] =$disc['disc_percent'];
        $mydiscount =$disc['disc_percent']/100;
          $_SESSION["discount"] = $mydiscount;
          $message = 'Discount added successfully.';
          succes_redirect('cart',$message);

      }
    }else {
      ?><div class="text-danger"><?php
      echo 'invalid coupon code';
      ?></div><?php
    }
   }?>
    <style media="screen">

  .discountbardiv{
    padding-top: 5px;
        background: #404361;
        border: 1px solid #42464b;
        border-radius: 6px;
        margin: 20px auto 0;
        width: 450px;
        position: fixed;
        margin: auto;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        box-shadow: 5px 7px 10px grey;
        font-size: 16px;
        height: 46px;
        z-index: 100;
        padding-left: 20px;
        float: left;
}
.positn a{
  /* padding-top: 5px; */
  padding-top: 5px;
  /* background: #404361; */
  /* border: 1px solid #42464b; */
  /* border-radius: 6px; */
  /* margin: 20px auto 0; */
  /* width: 450px; */
  position: absolute;
  /* margin-left: 10px; */
  top: 0;
  right: 0;
  bottom: 0;
  /* left: 0; */
  /* box-shadow: 5px 7px 10px grey; */
  font-size: 18px;
  color: red;
  z-index: 100;
  /* height: 25px; */
  cursor: pointer;
}
.d_buttonsearch{
    line-height: 27px;
	background-color: transparent;
	border: 0px;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
}
.d_buttonsearch:hover{
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border: 0px;
  opacity: inherit;

}
.d_buttonsearch:focus{
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border: 0px;

}
.discountsearch{
	display: none;
}
.glyphicon.glyphicon-search {
	font-size: 30px;
}
.discountbox {

	box-shadow: none;
	padding: 8px 14px;
}
.discountbox:hover {
	box-shadow: none;
}

.form-control:focus {
	border-color: #ccc;
	}



    </style>
<script>
$('.d_buttonsearch').click(function(){
      $('.discountsearch').slideToggle( "fast",function(){
         $( '#content' ).toggleClass( "moremargin" );
      } );
      $('.discountbox').focus()
      $('.openclosediscount').toggle();
  });
</script>
