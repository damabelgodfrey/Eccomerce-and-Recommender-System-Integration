<script src='http://code.jquery.com/jquery-latest.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
</body>
<div class="col-md-12 text-center">&copy; Copyright 2019 <?=$globalsettings['company_name'];?></div>
</html>
<script type="text/javascript">
$(document).ready(function(){
    $(".side-nav").hide();

});
$(function () {

'use strict';

(function () {

var aside = $('.side-nav'),

showAsideBtn = $('.show-side-btn'),

contents = $('#contents');
showAsideBtn.on("click", function () {
$("#" + $(this).data('show')).toggleClass('show-side-nav');
$(".side-nav").show();
contents.toggleClass('margin');
});

if ($(window).width() <= 767) {

aside.addClass('show-size-nav');

}
$(window).on('resize', function () {

if ($(window).width() > 767) {

aside.removeClass('show-size-nav');

}

});

// dropdown menu in the side nav
var slideNavDropdown = $('.side-nav-dropdown');

$('.side-nav .categories li').on('click', function () {

$(this).toggleClass('opend').siblings().removeClass('opend');

if ($(this).hasClass('opend')) {

$(this).find('.side-nav-dropdown').slideToggle('fast');

$(this).siblings().find('.side-nav-dropdown').slideUp('fast');

} else {

$(this).find('.side-nav-dropdown').slideUp('fast');

}

});

$('.side-nav .close-aside').on('click', function () {

$('#' + $(this).data('close')).addClass('show-side-nav');

contents.removeClass('margin');

});

}());

});
</script>
