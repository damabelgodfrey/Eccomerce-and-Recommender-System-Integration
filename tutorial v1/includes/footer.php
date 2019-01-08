<!--Footer Area -->
</div><br><br>
<div class="col-md-12 text-center">&copy; Copyright 2019 Ameritinz Supermart
</div>


<script>
jQuery(window).scroll(function(){
  var vscroll = jQuery(this).scrollTop();
  console.log(vscroll);
  jQuery('#logotext').css({
    "transform" : "translate(0px, "+vscroll/2+"px)"
 });

   var vscroll = jQuery(this).scrollTop();
   jQuery('#back-flower').css({
     "transform" : "translate("+vscroll/5+"px, -"+vscroll/12+"px)"
   });

  var vscroll = jQuery(this).scrollTop();
  jQuery('#fore-flower').css({
    "transform" : "translate(0px, -"+vscroll/2+"px)"
 });
});

function detailsmodal(id){
var data = {"id" : id};
jQuery.ajax({
  //url : <?=BASEURL;?>+'includes/detailsmodal.php', javascript and ajax is
  //on the client side
  url: '/tutorial/includes/detailsmodal.php', //from the client perspective this is the root
  method : "post",
  data : data,
  success: function(data){
    jQuery('body').append(data);
    jQuery('#details-modal').modal('toggle');
  },
  error : function(){
    alert("something went wrong!");
  }
});
}
</script>
</body>
</html>
