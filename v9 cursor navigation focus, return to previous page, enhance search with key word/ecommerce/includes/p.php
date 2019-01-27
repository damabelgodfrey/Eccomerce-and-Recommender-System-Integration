<?php include 'head.php'; ?>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"  media="screen">
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

<div data-role="page">
  <div data-role="header">
    <h1>Range Slider</h1>
  </div>


    <form method="post" action="/action_page_post.php">
      <div data-role="rangeslider">
        <label for="price-min">Price:</label>
        <input type="range" name="price-min" id="price-min" value="200" min="0" max="1000">
        <label for="price-max">Price:</label>
        <input type="range" name="price-max" id="price-max" value="800" min="0" max="1000">
      </div>
        <input type="submit" data-inline="true" value="Submit">
        <p>The range slider can be useful for allowing users to select a specific price range when browsing products.</p>
      </form>
</div>
