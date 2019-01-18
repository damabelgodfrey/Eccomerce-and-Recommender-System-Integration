<?php
  require_once 'core/init.php';
  include"includes/head.php";

?>
<div class="container">
  <div class="container-fluid">
<div class= "col-xs-12">
  <div id="my-slider" class="carousel slide" data-ride="carousel">
    <!-- indicators dot nov -->
    <ol class="carousel-indicators">
      <li data-target="#my-slider" data-slide-to="0" class="active"></li>
      <li data-target="#my-slider" data-slide-to="1"></li>
      <li data-target="#my-slider" data-slide-to="2"></li>
      <li data-target="#my-slider" data-slide-to="3"></li>
      <li data-target="#my-slider" data-slide-to="4"></li>
      <li data-target="#my-slider" data-slide-to="5"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <a href="http://www.google.com"><img src="/tutorial/images/products/70b47af3a9a4f65f268a7031bb1303ca.jpg"></a>
          <div class="carousel-caption">
            <a href="http://www.google.com"><h1 href="/Internet">Truespeed Internet Services</h1></a>
          </div>
      </div>
    <div class="item">
      <a href="index.php"><img src="/tutorial/images/products/cf438b1718297c80c484f174fbeb7ed0.jpg"></a>
        <div class="carousel-caption">
          <h1>Best instore promotion</h1>
        </div>
    </div>
    </div>
    <!-- Controls or next and prev buttons -->
    <a class="left carousel-control" href="#my-slider" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#my-slider" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>

  </div>
</div>
</div>
</div>
