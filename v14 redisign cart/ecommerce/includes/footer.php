<!--Footer Area -->
</div><hr>
<div class="col-md-15 text-center">
  <footer class="footer-distributed">

    <div class="footer-left">

      <h3>Company<span>logo</span></h3>

      <p class="footer-links">
        <a href="index">Home</a>
        ·
        <a href="#">Blog</a>
        ·
        <a href="about">About</a>
        ·
        <a href="#">Faq</a>
        ·
        <a href="contact">Contact</a>
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
        <p><a href="mailto:hr@amaritinz.com">support@ameritinz.com</a></p>
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
</div>
<div class="col-md-15 text-center designer">
  <a href="https://godfreydamabel.com" id = "designer">Designed by Damabel Technologies.</a>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script>

$("#totalItem").load(location.href + " #totalItem>*", "");
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
var data = {"mode": mode,"id" : id};
jQuery.ajax({
  //on the client side
  url: '/ecommerce/includes/detailsmodal.php', //from the client perspective this is the root
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

</script>
</body>
</html>
