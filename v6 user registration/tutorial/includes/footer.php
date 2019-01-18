<!--Footer Area -->
</div><br><br>
<div class="col-md-15 text-center">
  <footer class="footer-distributed">

    <div class="footer-left">

      <h3>Company<span>logo</span></h3>

      <p class="footer-links">
        <a href="index.php">Home</a>
        ·
        <a href="#">Blog</a>
        ·
        <a href="about.php">About</a>
        ·
        <a href="#">Faq</a>
        ·
        <a href="contact.php">Contact</a>
      </p>

      <p class="footer-company-name">AMERITINZ SUPERMART &copy; 2018</p>
    </div>

    <div class="footer-center">

      <div>
        <i class="fa fa-map-marker"></i>
        <p><span>32 Eligbam Road, Off Rumuola Road</span> PORTHARCOURT, NIGERIA</p>
      </div>

      <div>
        <i class="fa fa-phone"></i>
        <p>+234 9036593997,+2348080540412 </p>
      </div>

      <div>
        <i class="fa fa-envelope"></i>
        <p><a href="mailto:support@company.com">support@ameritinz.com</a></p>
      </div>

    </div>

    <div class="footer-right">

      <p class="footer-company-about">
        <span>About the company</span>
        In Ameritinz Supermart Originality is our signature...
      </p>
        <!-- The social media icon bar -->
        <div class="footer-icons" id = "socialHover">
          <a href="#" id = "facebook" class="facebook"><i class="fa fa-facebook"></i></a>
          <a href="#" id = "twitter" class="twitter"><i class="fa fa-twitter"></i></a>
          <a href="#" id = "instagram" class="google"><i class="fa fa-instagram"></i></a>
          <a href="#" id = "linkedin" class="linkedin"><i class="fa fa-linkedin"></i></a>
          <a href="#" id = "youtube" class="youtube"><i class="fa fa-youtube"></i></a>
        </div>


  </footer>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script>
jQuery(window).scroll(function(){
  var vscroll = jQuery(this).scrollTop();
  //console.log(vscroll);
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
  //on the client side
  url: '/tutorial/includes/detailsmodal.php', //from the client perspective this is the root
  method : "post",
  data : data,
  success: function(data){
    jQuery('body').append(data);
    jQuery('#details-modal').modal('toggle');
    },
    error: function(){
      alert("something went wrong!");
    }
  });
}

function cartmodal(id){
var data = {"id" : id};
jQuery.ajax({
  //on the client side
  url: '/tutorial/includes/cartmodal.php', //from the client perspective this is the root
  method : "post",
  data : data,
  success: function(data){
    jQuery('body').append(data);
    jQuery('#cart-modal').modal('toggle');
    },
    error: function(){
      alert("something went wrong!");
    }
  });
}
function update_cart(mode,edit_id,edit_size){
  var data = {'mode' : mode, "edit_id" : edit_id, "edit_size" : edit_size};
  jQuery.ajax({
    url : '/tutorial/admin/parsers/update_cart.php',
    method : "post",
    data : data,
    success : function(){location.reload();},
    error : function(){alert("Something went wrong");},
  });
}

function add_to_cart(){
  jQuery('#modal_errors').html("");
  var size = jQuery('#size').val();
  var quantity = jQuery('#quantity').val();
  var available = parseInt(jQuery('#available').val());
  var error = '';
  var data = jQuery('#add_product_form').serialize();
  if(size =='' || quantity =='' || quantity == 0){
    error += '<p class="text-danger text-center">Please choose a size and quantity!</p>';
    jQuery('#modal_errors').html(error);
    return;
  }else if(quantity > available){
    error += '<p class="text-danger text-center">You added quantity '+quantity+' but there are  '+available+' available in store.</p>';
    jQuery('#modal_errors').html(error);
    return;
  }else{
    jQuery.ajax({
      url : '/tutorial/admin/parsers/add_cart.php',
      method : 'post',
      data : data,
      success : function(){
        location.reload(); // allow page to refresh so cookie can be accessible
      },
      error : function(){alert("Something went wrong")}
    });
  }
}
</script>
</body>
</html>
