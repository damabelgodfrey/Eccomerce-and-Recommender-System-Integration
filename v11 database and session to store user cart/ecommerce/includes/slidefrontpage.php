<?php
//  require_once 'core/init.php';
  $slideQ = $db->query("SELECT * FROM slide WHERE status = 1 ORDER BY id LIMIT 6");
  $arrayR[] = array();
  while($row = mysqli_fetch_assoc($slideQ)){
    $arrayR[] =$row['title'].'??$'.$row['caption'].'??$'.$row['image'].'??$'.$row['url'];

  }

  if(isset($arrayR[1])){
    $slide =explode('??$',$arrayR[1]);
    $slideTitle1 = $slide[0];
    $slideCaption1 = $slide[1];
    $slideImage1 = $slide[2];
    $slideUrl1 = $slide[3];
  }
  if(isset($arrayR[2])){
    $slide =explode('??$',$arrayR[2]);
    $slideTitle2 = $slide[0];
    $slideCaption2 = $slide[1];
    $slideImage2 = $slide[2];
    $slideUrl2 = $slide[3];
  }

  if(isset($arrayR[3])){
    $slide =explode('??$',$arrayR[3]);
    $slideTitle3 = $slide[0];
    $slideCaption3 = $slide[1];
    $slideImage3 = $slide[2];
    $slideUrl3 = $slide[3];
  }

  if(isset($arrayR[4])){
    $slide =explode('??$',$arrayR[4]);
    $slideTitle4 = $slide[0];
    $slideCaption4 = $slide[1];
    $slideImage4 = $slide[2];
    $slisdeUrl4 = $slide[3];
  }
  if(isset($arrayR[5])){
    $slide =explode('??$',$arrayR[5]);
    $slideTitle5 = $slide[0];
    $slideCaption5 = $slide[1];
    $slideImage5 = $slide[2];
    $slideUrll5 = $slide[3];
  }
  if(isset($arrayR[6])){
  $slide =explode('??$',$arrayR[6]);
  $slideTitle6 = $slide[0];
  $slideCaption6 = $slide[1];
  $slideImage6 = $slide[2];
  $slideUrl6 = $slide[3];
}



//var_dump($slideTitle2);var_dump($url); die();
  ?>
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
    <div class="carousel-inner" role="listbox" id="myCarousalIndex">
      <?php if (isset($arrayR[1])): ?>
        <div class="item active">
          <a href="<?=(isset($arrayR[1])?$slideUrl1:'');?>"><img src="<?=(isset($arrayR[1])?$slideImage1:'');?>"></a>
            <div class="carousel-caption">
              <h1><?=(isset($arrayR[1])?$slideCaption1:'');?></h1>
              <a href="<?=(isset($arrayR[1])?$slideUrl1:'');?>" target="_blank"><button type="button" class="btn btn-lg btn-secondary">View Details >></button></a>
            </div>
        </div>
      <?php endif; ?>
      <?php if(isset($arrayR[2])): ?>
        <div class="item">
        <a href="<?=(isset($arrayR[2])?$slideUrl2:'');?>"><img src="<?=(isset($arrayR[2])?$slideImage2:'');?>"></a>
          <div class="carousel-caption">
            <h1><?=(isset($arrayR[2])?$slideCaption2:'');?></h1>
            <a href="<?=(isset($arrayR[2])?$slideUrl2:'');?>" target="_blank"><button type="button" class="btn btn-lg btn-secondary">View Details >></button></a>
          </div>
        </div>
      <?php endif; ?>

      <?php if (isset($arrayR[3])): ?>
        <div class="item">
        <a href="<?=(isset($arrayR[3])?$slideUrl3:'');?>"><img src="<?=(isset($arrayR[3])?$slideImage3:'');?>"></a>
          <div class="carousel-caption">
            <h1><?=(isset($arrayR[3])?$slideCaption3:'');?></h1>
            <a href="<?=(isset($arrayR[3])?$slideUrl3:'');?>" target="_blank"><button type="button" class="btn btn-lg btn-secondary">View Details >></button></a>
          </div>
      </div>
      <?php endif; ?>

      <?php if (isset($arrayR[4])): ?>
        <div class="item">
        <a href="<?=(isset($arrayR[4])?$slideUrl4:'');?>"><img src="<?=(isset($arrayR[4])?$slideImage4:'');?>"></a>
          <div class="carousel-caption">
            <h1><?=(isset($arrayR[4])?$slideCaption4:'');?></h1>

            <a href="<?=(isset($arrayR[4])?$slisdeUrl4:'');?>" target="_blank"><button type="button" class="btn btn-lg btn-secondary">View Details >></button></a>
          </div>
        </div>
      <?php endif; ?>

      <?php if (isset($arrayR[5])): ?>
        <div class="item">
        <a href="<?=(isset($arrayR[5])?$slideUrl5:'');?>"><img src="<?=(isset($arrayR[5])?$slideImage5:'');?>"></a>
          <div class="carousel-caption">
            <h1><?=(isset($arrayR[5])?$slideCaption5:'');?></h1>
            <a href="<?=(isset($arrayR[5])?$slideUrl5:'');?>" target="_blank"><button type="button" class="btn btn-lg btn-secondary">View Details >></button></a>
          </div>
        </div>
      <?php endif; ?>

      <?php if (isset($arrayR[6])): ?>
        <div class="item">
        <a href="<?=(isset($arrayR[6])?$slideUrl6:'');?>"><img src="<?=(isset($arrayR[6])?$slideImage6:'');?>"></a>
          <div class="carousel-caption">
            <h1><?=(isset($arrayR[6])?$slideCaption6:'');?></h1>
            <a href="<?=(isset($arrayR[6])?$slideUrl6:'');?>" target="_blank"><button type="button" class="btn btn-lg btn-secondary">View Details >></button></a>
          </div>
        </div>
      <?php endif; ?>

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
