<style>
#ajaxloading{
  position: fixed;
  max-width: 400px;
  max-height: 400px;
  background-image: url(../ecommerce/images/headerlogo/Loadingmodal.gif);
  background-repeat: no-repeat;
  top:0;
  right:0;
  bottom: 0;
  left: 0;
  z-index: 10000;
margin: auto;
display: none;
  }
</style><div class ='ajaxloading' id ='ajaxloading'></div>
<!--Footer Area -->
</div><br>
<div class="col-md-15 text-center">
 <footer class="footer-distributed">
   <div class="footer-left">
     <h3><span><?=$globalsettings['company_name'];?></span></h3>
     <p class="footer-links">
       <a href="index">Home</a>
       ·
       <a href="#">Blog</a>
       ·
       <a href="about">About</a>
       ·
       <a href="faq">Faq</a>
       ·
       <a href="contact">Contact</a>
     </p>
     <p class="footer-company-name"><?=$globalsettings['company_name'];?> &copy; 2019</p>
   </div>
   <div class="footer-center">
     <div>
       <i class="fa fa-map-marker"></i>
       <p><span><?=$globalsettings['address'];?></span> <?=$globalsettings['city'];?>, <?=$globalsettings['country'];?></p>
     </div>
     <div>
       <i class="fa fa-phone"></i>
       <p><span><?=$globalsettings['tel'];?></span><span></span></p>
     </div>
     <div>
       <i class="fa fa-envelope"></i>
       <p><a href="mailto:<?=$globalsettings['email'];?>"><?=$globalsettings['email'];?></a></p>
     </div>
   </div>
   <div class="footer-right">
     <p class="footer-company-about">
       <span>About the company</span>
       <?=$globalsettings['about'];?>
     </p>
       <!-- The social media icon bar -->
       <div class="footer-icons" id = "socialHover">
         <?php if(isset($globalsettings['facebook_id']) && $globalsettings['facebook_id']){ ?>
         <a target="_blank" href="https://<?=$globalsettings['facebook_id'];?>" id = "facebook" class="facebook"><i class="fa fa-facebook"></i></a>
       <?php } ?>
       <?php if(isset($globalsettings['twitter_id']) && $globalsettings['twitter_id'] != ''){ ?>
         <a target="_blank" href="https://<?=$globalsettings['twitter_id'];?>" id = "twitter" class="twitter"><i class="fa fa-twitter"></i></a>
       <?php } ?>
         <?php if(isset($globalsettings['instagram_id']) && $globalsettings['instagram_id'] !=''){ ?>
         <a target="_blank" href="https://<?=$globalsettings['instagram_id'];?>" id = "instagram" class="google"><i class="fa fa-instagram"></i></a>
       <?php } ?>
         <?php if(isset($globalsettings['linkedin_id']) && $globalsettings['linkedin_id'] != ''){ ?>
         <a target="_blank" href="https://<?=$globalsettings['linkedin_id'];?>" id = "linkedin" class="linkedin"><i class="fa fa-linkedin"></i></a>
       <?php } ?>
         <!-- <a href="#" id = "youtube" class="youtube"><i class="fa fa-youtube"></i></a> -->
       </div>
       </div>
 </footer>
</div>

<div class="col-md-12 text-center designer">Designed and Powered By
 <a href="https://godfreydamabel.com/siteenquiry/" id = "designer"> Damabel Technologies.</a>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
var time = new Date().getTime();
$(document.body).bind("mousemove keypress", function(e) {
    time = new Date().getTime();
});

function refresh() {
    if(new Date().getTime() - time >= 3600000)// 3600000 reload page after every 1 hrs.
        window.location.reload(true);
    else
        setTimeout(refresh, 10000);
}

setTimeout(refresh, 10000);
  jQuery('document').ready(function(){
  $('#ajaxloading').hide();
  $(".navbar").css( 'background-color', '<?=$appearance['navB_color'];?>' );
  $(".navbar").css( 'color', '<?=$appearance['navT_color'];?>' );
  $(".dropdown-toggle").css( 'color', '<?=$appearance['navT_color'];?>' );
  $(".navWishicon").css( 'color', '<?=$appearance['navT_color'];?>' );
  $(".dropdown-menu").css( 'background-color', '<?=$appearance['navdropB_color'];?>' );
  $(".dropdown-menu").css( 'color', '<?=$appearance['navdropT_color'];?>' );
  $(".dropdown-headerlist").css( 'color', '<?=$appearance['navdropT_color'];?>' );
  $(".dropdown-header").css( 'color', '<?=$appearance['navdropheader_color'];?>' );
 var success = '';
 success += '<p class="text-success text-center"> Success Recorded! Thank You.</p>';
 jQuery('#success').html(success);
});

jQuery(window).scroll(function(){
 if($(this).scrollTop()> 0){
   $('.navbar-fixed-top').removeClass('head-room');
 }else{
   $('.navbar-fixed-top').addClass('head-room');
 }});

function detailsmodal(mode,id){
  jQuery('#details-modal').modal('hide');
  setTimeout(function(){
    jQuery('#details-modal').remove();
    jQuery('.modal.backdrop').remove();
  },5);
var data = {"mode": mode,"id" : id};
   $('#ajaxloading').show();
jQuery.ajax({
 //on the client side
 url: '/ecommerce/admin/parsers/detailsmodal.php', //from the client perspective this is the root
 method : "post",
 data : data,
 success: function(data){
   jQuery('#details-modal').show();
   jQuery('body').append(data);
   jQuery('#details-modal').modal('toggle');
   },
   complete: function(){
       $('#ajaxloading').hide();
     },
   error: function(){
     alert("something went wrong!");
       $('#ajaxloading').hide();
   }
 });
}
$('#details-modal').on('show', function () {
     $('.modal-body',this).css({width:'auto',height:'100%', 'max-height':'100%','max-width':'100%'});
});

function update_cart(mode,mycart_id,edit_id,edit_size,edit_quantity,edit_available){
 jQuery('#cart_errors').html("");
 $('.btn').prop('disabled', true);
 var update_data = {'mode' : mode, "edit_id" : edit_id, "edit_size" : edit_size,"edit_quantity" : edit_quantity,"edit_available":edit_available};
 var cartCheck = {'mode' : mode, "cart_id" : mycart_id};
 jQuery.ajax({
   url : '/ecommerce/admin/parsers/cart_check.php',
   method : 'POST',
   data : cartCheck,
   success : function(data){
     if(data != 'success'){
       jQuery('#cart_errors').html(data);
       alert("Something went wrong. This item has either expired or removed");
     }
     if(data == 'success'){
       jQuery('#cart_errors').html("");
         jQuery.ajax({
           url : '/ecommerce/admin/parsers/update_cart.php',
           method : "post",
           data : update_data,
           success : function(data){location.reload();jQuery('#cart_errors').html(data);},
           error : function(){alert("Something went wrong");},
         });
       }
     location.reload();
       },
       errors : function(){alert("Something Went Wrong! Cart update was unsuccessful");},
     });

}
</script>
</body>
</html>
