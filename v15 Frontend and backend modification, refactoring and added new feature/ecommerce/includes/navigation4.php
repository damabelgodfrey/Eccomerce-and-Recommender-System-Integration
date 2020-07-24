<style>
.navbar-toggle .middlebar {
	  top: 1px;
}

.navbar-toggle .bottombar {
  	top: 2px;
}

.navbar-toggle .icon-bar {
	  position: relative;
	  transition: all 500ms ease-in-out;
}

.navbar-toggle.active .topbar {
	  top: 6px;
	  transform: rotate(45deg);
}

.navbar-toggle.active .middlebar {
	  background-color: transparent;
}

.navbar-toggle.active .bottombar {
	  top: -6px;
	  transform: rotate(-45deg);
}
</style>
<script>
$(document).ready(function () {
			  $(".navbar-toggle").on("click", function () {
				    $(this).toggleClass("active");
			  });
		});
</script>

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="icon-bar topbar"></span>
      <span class="icon-bar middlebar"></span>
      <span class="icon-bar bottombar"></span>
    </button>
    <a class="navbar-brand" href="#">Animated Burger, Bootstrap</a>
  </div>
  <div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
					      <li class="active"><a href="#">Home</a>
      </li>
				    </ul>
  </div>
</div>
