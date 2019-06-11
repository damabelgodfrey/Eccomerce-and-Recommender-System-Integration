<script>
</script>

<style>
.button1{
border:none;
border-radius:5px;
color:white;
margin:15px;
background-color:red ;
    padding: 20px 20px;
    font-size: 18px; //change this to your desired size
    line-height: normal;
    -webkit-border-radius: 8px;
       -moz-border-radius: 8px;
            border-radius: 8px;
}
.dropmenu-content{
margin:2px;
}
.dropmenu-content a{
text-decoration:none;
color:white;
border:solid 3px darkblue;
align-items:center;
justify-content: center;
}
#cartegorycontainer {
  display: flex;
  align-items:center;
  justify-content: center;
}
</style>
<div class="container bar-top">
  <h3 class="text-center">⇩Shop By Category⇩</h3>
<div id="cartegorycontainer" class="col-md-7 container-fluid">
  <div class="row">

  <?php $sql ="SELECT * FROM categories WHERE parent = 0";
  $pquery = $db->query($sql); ?>
        <?php while($parent = mysqli_fetch_assoc($pquery)): ?>
          <div class="col-xs-6 col-sm-4 col-md-3">
        <?php
         $parent_id =$parent['id'];
         $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
         $cquery = $db->query($sql2);
         ?>
         <div class="dropmenu ">
          <button onclick="myFunction('<?php echo $parent['category']; ?>')" class="btn button1"><?php echo $parent['category']; ?></button>
          <div id="<?php echo $parent['category']; ?>" style='display:none;' class="dropmenu-content ">
          <ul class="list-inline">
              <?php while($child = mysqli_fetch_assoc($cquery)): ?>
            <li><a class="btn btn-lg"href="category?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
            <?php endwhile; ?></ul>
          </div>
       </div>
        </div>
       <?php endwhile; ?>
   </div>
</div>
</div>
<script type="text/javascript">
function myFunction(dr){

var x = document.getElementById(dr);
if (x.style.display === "none") {
    x.style.display = "block";
} else {
    x.style.display = "none";
}
}
</script>
