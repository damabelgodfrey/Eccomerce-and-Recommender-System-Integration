<style>
@import url(https://fonts.googleapis.com/css?family=Lato:100,300,400,700);
@import url(https://raw.github.com/FortAwesome/Font-Awesome/master/docs/assets/css/font-awesome.min.css);


#wrap {
  margin: 1px 200px;
  display: inline-block;
  position: absolute;
  height: 50px;
  float: left;
  padding: 0;
}

input[id="search"] {
  height: 55px;
  font-size: 18px;
  display: inline-block;
  font-family: "Lato";
  font-weight: 800;
  border: none;
  outline: none;
  color: white;
  padding: 3px;
  padding-right: 60px;
  width: 0px;
  position: absolute;
  top: 0;
  right: 0;
  background: none;
  z-index: 3;
  transition: width .4s cubic-bezier(0.000, 0.795, 0.000, 1.000);
  cursor: pointer;
}

input[id="search"]:focus:hover {
  border-bottom: 1px solid #BBB;
}

input[id="search"]:focus {
  width: 500px;
  z-index: 1;
  border-bottom: 1px solid #BBB;
  cursor: text;
  background: darkblue;
  opacity: 1.5;

}
input[id="search_submit"] {
  height: 55px;
  width: 60px;
  display: inline-block;
  color:white;
  float: left;
  background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAADNQTFRFU1NT9fX1lJSUXl5e1dXVfn5+c3Nz6urqv7+/tLS0iYmJqampn5+fysrK39/faWlp////Vi4ZywAAABF0Uk5T/////////////////////wAlrZliAAABLklEQVR42rSWWRbDIAhFHeOUtN3/ags1zaA4cHrKZ8JFRHwoXkwTvwGP1Qo0bYObAPwiLmbNAHBWFBZlD9j0JxflDViIObNHG/Do8PRHTJk0TezAhv7qloK0JJEBh+F8+U/hopIELOWfiZUCDOZD1RADOQKA75oq4cvVkcT+OdHnqqpQCITWAjnWVgGQUWz12lJuGwGoaWgBKzRVBcCypgUkOAoWgBX/L0CmxN40u6xwcIJ1cOzWYDffp3axsQOyvdkXiH9FKRFwPRHYZUaXMgPLeiW7QhbDRciyLXJaKheCuLbiVoqx1DVRyH26yb0hsuoOFEPsoz+BVE0MRlZNjGZcRQyHYkmMp2hBTIzdkzCTc/pLqOnBrk7/yZdAOq/q5NPBH1f7x7fGP4C3AAMAQrhzX9zhcGsAAAAASUVORK5CYII=) center center no-repeat;
  text-indent: -10000px;
  border: none;
  position: absolute;
  top: 0;
  right: 0;
  z-index: 2;
  cursor: pointer;
  opacity: 0.4;
  cursor: pointer;
  transition: opacity .4s ease;
  background-color: white;
}

input[id="search_submit"]:hover {
  opacity: 0.9;
}

</style><div class="nav-top">
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
<nav class="navbar navbar-toggleable-md navbar-expand-md navbar-light">
<div class="container-fluid">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" id= "brand" href="index">
        <p></p>AMERITINZ
    </a>
  </div>
  <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
    <!--  <li><a class="fa fa-fw fa-home href="index">Home</a></li> -->
      <?php while($parent = mysqli_fetch_assoc($pquery)): ?>
      <?php
       $parent_id =$parent['id'];
       $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id' AND active = 1";
       $cquery = $db->query($sql2);
       ?>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $parent['category']; ?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php while($child = mysqli_fetch_assoc($cquery)): ?>
            <li><a href="category?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
          <?php endwhile; ?>
        </ul>
      </li>
      <?php endwhile;
      ?>
    </ul>





    <!--
    <form class="navbar-form navbar-left" action="search" method="post">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search Product.." name="searchProduct" required>
      </div>
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
    </form> -->
    <ul class="nav navbar-nav navbar-right">
      <li><form action="search" method="post" autocomplete="on">
      <input id="search" name="searchProduct" type="text" placeholder="Input Search Item and Press Enter" required>
      <input id="search_submit" value="" type="submit">
      </form></li>

      <li><a href="cart"><span class="glyphicon glyphicon-shopping-cart"></span><span  id="cartCount"><?=$total_item;?></span></a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=(isset($user_data['first'])?'Hello '. $user_data['first']:'Account');?><span class="caret"></span></a>
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
</div>
</nav>
<div class="panel panel-default">
<div class="panel-body body-top">
</div>
</div>
<div class="container-fluid">
