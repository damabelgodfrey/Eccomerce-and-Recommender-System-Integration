<?php
  require_once 'core/init.php';
  include "includes/head.php";
  include "includes/navigation.php";
  //include"includes/headerpartial.php";
  $_SESSION['rdrurl'] = $_SERVER['REQUEST_URI'];
?>
<style media="screen">
.filterbtn {
  position: absolute;
  z-index: 1000;
  top: 131px;
  left: 0;
  padding: 8px 13px;
  background-color: grey;

}
</style>
<button onclick="openNav()" type="button" class=" filterbtn btn btn-info btn-md pull-right">
        <span class="glyphicon glyphicon-sort"></span> Sort Item
</button>
<div class="bodycontainer-fluid indexannouncement">
  <?php include '../ecommerce/includes/widgets/myannouncement.php'; ?>
  <p></p><p></p>
</div>
<?php  include '../ecommerce/includes/widgets/filters.php';?>

    <?php include '../ecommerce/includes/slidefrontpage.php'; ?><p></p><p></p>

    <?php include '../ecommerce/includes/browseBycategory.php'; ?><p></p><p></p>

  <div >
    <?php include '../ecommerce/includes/trendingProduct.php'; ?><p></p><p></p>
  </div>
  <?php include '../ecommerce/includes/featured.php'; ?><p></p><p></p>
<?php


if (isset($instagram_feed_data['items'])) {
  $username = 'emilewiscarroll';
  $json = file_get_contents('https://www.instagram.com/'.$username);
  $instagram_feed_data = json_decode($json, true);
  var_dump($instagram_feed_data);
    foreach ($instagram_feed_data['items'] as $item) {
        $link = $item['link'];
        $img_url = $item['images']['low_resolution']['url'];
        $caption = isset($item['caption']) ? $item['caption']['text'] : '';

        ?>
        <a href="<?= $link; ?>" target="_blank" class="instagram-post">
            <img src="<?= $img_url; ?>">
            <div class="caption"><?= $caption; ?></div>
        </a>
        <?php
    }
}
include "includes/footer.php";
  ?>

<script type="text/javascript">
/*

dependencies:
*/
//cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js
//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js
//cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js



$(".carousel").swipe({

swipe: function(event, direction, distance, duration, fingerCount, fingerData) {

  if (direction == 'left') $(this).carousel('next');
  if (direction == 'right') $(this).carousel('prev');

},
allowPageScroll:"vertical"

});
</script>
