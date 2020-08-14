<style media="screen">
#navbar a:hover{
  background-color: lightgrey;
  color: white;
}
.navbar{
  min-height: 80px;
  font-size: 14px;
}
.navbar-nav > li > a {
  /* (80px - line-height of 27px) / 2 = 26.5px */
  padding-top: 26.5px;
  padding-bottom: 26.5px;
  line-height: 27px;
}
ul.nav li.sales a {
    background-color: red !important;
    color:white;
    opacity: 0.7;
}
/* Trigger bootstrap navbar collapse pada viewport <= 900px */
@media (max-width: 900px) {
  .navbar .navbar-brand {
  background: url(../ecommerce/images/headerlogo/3d.jpg) center / contain no-repeat;
  width: 100px;
  height: 80px;
  left: 45%;
  position: absolute;

  }
  .loginPos{
    right: 0%;
  }
  .navbar-toggle {
  /* (80px - button height 34px) / 2 = 23px */
  margin-top: 23px;
  padding: 9px 10px !important;
  float: left;
  margin-left:10px;
  margin-right: 10px;
}
.navbar-header {
        float: none;
    }

    .navbar-left,
    .navbar-right {
        float: none !important;
    }

    .navbar-toggle {
        display: block;
    }

    .navbar-collapse {
        border-top: 1px solid transparent;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
    }

    .navbar-fixed-top {
        top: 0;
        border-width: 0 0 1px;
    }

    .navbar-collapse.collapse {
        display: none!important;
    }

    .navbar-nav {
        float: none!important;
        margin-top: 7.5px;
    }

    .navbar-nav>li {
        float: none;

    }

    .navbar-nav>li>a {
        padding-top: 10px;
        padding-bottom: 10px;

    }

    .collapse.in{
        display:block !important;
    }


    /* Hapus gap 15px pada .navbar-collapse */
    .navbar .navbar-nav {
      margin-left: -15px;
      margin-right: -15px;
    }

    /* Merapihkan dropdown menu: Warna, posisi dll */
    .navbar-nav .open .dropdown-menu {
        position: static;
        float: none;
        width: auto;
        margin-top: 0;
        background-color: transparent;
        border: 0;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .navbar-default .navbar-nav .open .dropdown-menu > li > a {
        color: rgb(119, 119, 119);
        padding: 5px 15px 5px 25px;
    }
}

@media screen and (min-width: 900px) {
    /* Rubah behaviour .container */
    .navbar .navbar-brand {
    background: url(../ecommerce/images/headerlogo/3d.jpg) center / contain no-repeat;
    width: 100px;
    height: 80px;
    left: 10%;
    position: relative;
    margin-right:20px;

    }
    .navbar .container {
    margin-left: auto;
    margin-right: auto;
    padding: 0;
    max-width: 2500px;
    width: initial;
  }

  .navbar-toggle {
  /* (80px - button height 34px) / 2 = 23px */
  margin-top: 23px;
  padding: 9px 10px !important;
}
  .navbar > .container .navbar-brand {
    margin-left: 0;
  }

  .navbar .container .navbar-header {
    margin-left: 0;
    margin-right: 0;
  }
}

.navbar-brand {
  padding: 0 15px;
  height: 80px;
  line-height: 80px;
}


.cart{
  border: none;
  position: absolute;
  right: 17%;
  z-index: 2;
  height: 80px;
}
.loginPos{
  border: none;
  position: absolute;
  right: 10px;
  z-index:3;
  height: 80px;
}

/*
search bar
*/
#content {
  position: absolute;
  height: 50px;
  width: 300px;
  margin-left: 170px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.mysearch{
  position: absolute;
  right: 35%;
  z-index: 2;
  height: 80px;
}
#content.on {
  -webkit-animation-name: in-out;
  animation-name: in-out;
  -webkit-animation-duration: 0.7s;
  animation-duration: 0.7s;
  -webkit-animation-timing-function: linear;
  animation-timing-function: linear;
  -webkit-animation-iteration-count: 1;
  animation-iteration-count: 1;
}

.myinput {
  box-sizing: border-box;
  width: 50px;
  height: 50px;
  border: 3px solid darkgrey;
  border-radius: 50%;
  background: none;
  color: black;
  font-size: 16px;
  font-weight: 400;
  font-family: Roboto;
  outline: 0;
  -webkit-transition: width 0.4s ease-in-out, border-radius 0.8s ease-in-out, padding 0.2s;
  transition: width 0.4s ease-in-out, border-radius 0.8s ease-in-out, padding 0.2s;
  -webkit-transition-delay: 0.4s;
  transition-delay: 0.4s;
  -webkit-transform: translate(-100%, -50%);
  -ms-transform: translate(-100%, -50%);
  transform: translate(-100%, -50%);
}

.mysearch {
  background: none;
  position: absolute;
  top: 0px;
  left: 0;
  height: 50px;
  width: 50px;
  padding: 0;
  border-radius: 100%;
  outline: 0;
  border: 0;
  color: inherit;
  cursor: pointer;
  -webkit-transition: 0.2s ease-in-out;
  transition: 0.2s ease-in-out;
  -webkit-transform: translate(-100%, -50%);
  -ms-transform: translate(-100%, -50%);
  transform: translate(-100%, -50%);
}

.mysearch:before {
  content: "";
  position: absolute;
  width: 20px;
  height: 4px;
  background-color: darkgrey;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
  margin-top: 26px;
  margin-left: 17px;
  -webkit-transition: 0.2s ease-in-out;
  transition: 0.2s ease-in-out;
}

.myclose {
  -webkit-transition: 0.4s ease-in-out;
  transition: 0.4s ease-in-out;
  -webkit-transition-delay: 0.4s;
  transition-delay: 0.4s;
}

.myclose:before {
  content: "";
  position: absolute;
  width: 27px;
  height: 4px;
  margin-top: -1px;
  margin-left: -13px;
  background-color: white;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
  -webkit-transition: 0.2s ease-in-out;
  transition: 0.2s ease-in-out;
}

.myclose:after {
  content: "";
  position: absolute;
  width: 27px;
  height: 4px;
  background-color: white;
  margin-top: -1px;
  margin-left: -13px;
  cursor: pointer;
  -webkit-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  transform: rotate(-45deg);
}

.square {
  box-sizing: border-box;
  padding: 0 40px 0 10px;
  width: 300px;
  height: 50px;
  border: 3px solid darkgrey;
  border-radius: 0;
  background: grey;
  color: white;
  font-family: Roboto;
  font-size: 16px;
  font-weight: 400;
  outline: 0;
  -webkit-transition: width 0.4s ease-in-out, border-radius 0.4s ease-in-out, padding 0.2s;
  transition: width 0.4s ease-in-out, border-radius 0.4s ease-in-out, padding 0.2s;
  -webkit-transition-delay: 0.4s, 0s, 0.4s;
  transition-delay: 0.4s, 0s, 0.4s;
  -webkit-transform: translate(-100%, -50%);
  -ms-transform: translate(-100%, -50%);
  transform: translate(-100%, -50%);
}
</style>
<div class="nav-top">
  <div class="">
        <p></p><div class="pull-right"><a href="sales" class="btn btn-sm btn-danger">Click here to shop Ameritinz sales up to 50% off now..</a>  </div>
        <p></p><div class="pull-left"><a href="sales" class="btn btn-sm btn-primary">SHOP TRENDING..click here >></a>  </div>
  </div>
</div>

<?php
if(isset($_SESSION['total_item_ordered'])){
  $total_item= $_SESSION['total_item_ordered'];
}else{
  $total_item ='';
}
$sql ="SELECT * FROM categories WHERE parent = 0 AND active = 1";
$pquery = $db->query($sql); ?>
<nav id="navbar" class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed " data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <ul class="nav navbar-nav cart">


      </ul>
      <a class="navbar-brand text-hide mybrand" href="index">Brand</a>
      <ul class="nav navbar-nav cart">
        <li><a href="cart"><span class="glyphicon glyphicon-shopping-cart"></span><span  id="cartCount"><?=$total_item;?></span></a></li>

      </ul>
      <ul class="nav navbar-nav loginPos">

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=(isset($user_data['first'])?'Hello '. $user_data['first']:'Account');?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php  if(isset($user_data['first'])){ ?>
             <li><a href="account">Manage Account</a></li>
             <?php if(check_permission('staff')): ?>
              <li><a href="../ecommerce/admin/index">Login Admin</a></li>
           <?php endif; ?>

             <li><a href="change_password">Change Password</a></li>
             <li><a href="logout">Log Out</a></li>
            <?php  }else{ ?>
              <li><a href="register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
              <li><a href="login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
             <?php } ?>
          </ul>
        </li>
      </ul>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li id="sales" class="sales"><a href="sales">Sales <span class="sr-only">(current)</span></a></li>
        <?php while($parent = mysqli_fetch_assoc($pquery)): ?>
        <?php
         $parent_id =$parent['id'];
         $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id' AND active = 1";
         $cquery = $db->query($sql2);
         ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $parent['category']; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php while($child = mysqli_fetch_assoc($cquery)): ?>
               <li> <a href="category?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a>  <li>
            <?php endwhile; ?>
          </ul>
        </li>
      <?php endwhile;
      ?>
      </ul>

  </div><!-- /.container-fluid -->

</div><!-- /.navbar-collapse -->
</nav>
<script type="text/javascript">
function expand() {
$(".mysearch").toggleClass("myclose");
$(".myinput").toggleClass("square");
if ($('.mysearch').hasClass('myclose')) {
  $('.myinput').focus();
} else {
  $('.myinput').blur();
}
}
$('.mybutton').on('click', expand);
</script>
<div class="container-fluid">
