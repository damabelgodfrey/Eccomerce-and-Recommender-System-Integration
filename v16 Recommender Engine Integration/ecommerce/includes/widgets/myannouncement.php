<?php
$announcementQ = $db->query("SELECT * FROM announcement WHERE status = 1");
$announcement = mysqli_num_rows($announcementQ);
$announcements = array();
  if($announcement > 0){
  $announcement = mysqli_fetch_assoc($announcementQ);
  ?>
  <div class="nav-top text-center" style="background-color:<?=$announcement['bcolor'];?>  ;">
          <p></p>
         <marquee behavior="scroll" align="middle" direction="left" scrollamount="4" onmouseover="this.stop()" onmouseout="this.start()" style="color: <?=$announcement['tcolor'];?>;">

           <?php foreach ($announcementQ as $announcementR):
           ?>
           <a href="<?=$announcementR['url'];?>" style="color: <?=$announcementR['tcolor'];?>;"  class=""> <?=$announcementR['announcement'];?></a>&nbsp&nbsp&nbsp&nbsp
           <?php
           endforeach;
       ?>
       </marquee>
   </div>
  <?php  }else{ ?>
    <div class="nav-top text-center" style="background-color:grey;?>  ;">
      <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
        <div class=" col-md-12" style="color: white;?>">
         <p>
           <a href="sales" class="btn btn-sm btn-block">Click here to shop sales up to 50% off now..</a>
         </p>
       </div>
     </marquee>
 </div>
  <?php }?>
  
