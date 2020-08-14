<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
var myMin = 0, myMax = 500;
$("#slider-range").slider({
  range: true,
  min: myMin,
  max: myMax,
  values: [75, 300],
  slide: function (event, ui) {
      $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
      var left = 100 * (ui.values[0] - myMin) / (myMax - myMin);
      var right = 100 * (ui.values[1] - myMin) / (myMax - myMin);
      $(this).css('background-image', '-webkit-linear-gradient(left, red ' + left + '%, blue ' + right + '%)');
  }
});

$("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
</script>

<p>
    <label for="amount">Price range:</label>
    <input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;" />
</p>
<div id="slider-range"></div>
