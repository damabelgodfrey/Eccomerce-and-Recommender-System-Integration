
<ul class="nav navbar-nav navbar-right search_pos">
<li>

<button type="button" class="buttonsearch" id="buttonsearch">
    <i class="fa fa-search openclosesearch"></i>
    <i class="glyphicon glyphicon-remove openclosesearch" style="display:none"></i>
  </button>

    </li>
    </ul>
    <div class="container searchbardiv search_pos" id="formsearch">
				<form action="search" role="search" method="post" id="searchform"  >
					<div class="input-group">
						<input type="text" id="searchbox" class="form-control" name="searchProduct" id="s">
						<div class="input-group-btn">
							<button class="btn btn-default"  id="searchsubmit"  type="submit">
								<strong>Search</strong>
							</button>

						</div>
					</div>
				</form>

			</div>


    <style media="screen">
  .searchbardiv{
	display: block;
	position: fixed;
	background: lightgrey ;
	top: 100px;
	right: 0px;
	z-index: 1001;
	width: 100%;
	max-width: 100%;
	padding: 10px;
	margin: 0px;
}
.buttonsearch{
    line-height: 27px;
	background-color: transparent;
	border: 0px;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
}
.buttonsearch:hover{
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border: 0px;
  opacity: inherit;

}
.buttonsearch:focus{
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border: 0px;

}
#formsearch{
	display: none;
}
.glyphicon.glyphicon-search {
	font-size: 30px;
}
#searchbox {

	box-shadow: none;
	padding: 8px 14px;
}
#searchbox:hover {
	box-shadow: none;
}

.form-control:focus {
	border-color: #ccc;
	}



.navbar-toggle {
	border: none;
	background: transparent !important;
}
.navbar-toggle:hover {
	background: transparent !important;
}
.navbar-toggle .icon-bar {
	width: 22px;
	transition: all 0.2s;
}
.navbar-toggle .top-bar {
	transform: rotate(45deg);
	transform-origin: 10% 10%;
}
.navbar-toggle .middle-bar {
	opacity: 0;
}
.navbar-toggle .bottom-bar {
	transform: rotate(-45deg);
	transform-origin: 10% 90%;
}
.navbar-toggle.collapsed .top-bar {
	transform: rotate(0);
}
.navbar-toggle.collapsed .middle-bar {
	opacity: 1;
}
.navbar-toggle.collapsed .bottom-bar {
	transform: rotate(0);
}

    </style>
<script>
$('#buttonsearch').click(function(){
      $('#formsearch').slideToggle( "fast",function(){
         $( '#content' ).toggleClass( "moremargin" );
      } );
      $('#searchbox').focus()
      $('.openclosesearch').toggle();
  });
</script>
