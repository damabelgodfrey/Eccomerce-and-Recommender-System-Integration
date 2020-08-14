<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
 ?>

<style>
body {
  background-color: #ede1ce
}

.container {
  width: 80%;
  margin: 2em auto;
}

hr {
  color: coral;
}

input {
  display: none;
}

h1 {
  font-size: 2em;
  font-family: "Trebuchet MS", Helvetica, sans-serif
}

h3 {
  margin: auto;
  font-size: 2em;
  color: dimgrey;
  float: left;
  margin-right: 0.3em;
}

h5 {
  text-align: center
}

p {
  clear: both;
}

label > i {
  float: right;
  margin: 0.3em;
  font-size: large;
  transition: all 0.3s linear;
}

input:checked + label > i {
  transform: rotate(-180deg);
}

label + p {
  line-height: 0%;
  color: darkslategray;
  transform: rotateX(90deg);
  transition: all 0.3s linear;
}

input:checked + label + p {
  transform: rotateX(0);
  line-height: 100%;
  line-height: auto;
}

input[type="checkbox"] {
    cursor: pointer;
}

input[type=checkbox]:not(:checked) {
}

input[type=checkbox]:checked {
    background-color: red;
    cursor: pointer;
}
</style>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="container">
 <h1>FAQ</h1>

 <hr>
 <input type="checkbox" id="faq0">
 <label for="faq0"><h3>Question</h3><i class="material-icons">keyboard_arrow_down</i></label>
 <p>Answer</p>

 <hr>
 <input type="checkbox" id="faq1">
 <label for="faq1"><h3>How old is Donald Tusk?</h3><i class="material-icons">keyboard_arrow_down</i></label>
 <p>Donald Tusk is 61 years old</p>

 <hr>
 <input type="checkbox" id="faq2">
 <label for="faq2"><h3>What is polyamory?</h3><i class="material-icons">keyboard_arrow_down</i></label>
 <p>Polyamory is the practice of, or desire for, intimate relationships with more than one partner, with the knowledge of all partners involved. It has been described as "consensual, ethical, and responsible non-monogamy." People who identify as polyamorous reject the view that sexual and relational exclusivity are necessary for deep, committed, long-term loving relationships.</p>

 <hr>
 <input type="checkbox" id="faq3">
 <label for="faq3"><h3>What are placeholders?</h3><i class="material-icons">keyboard_arrow_down</i></label>
 <p>Placeholder names are words that can refer to objects or people whose names are temporarily forgotten, irrelevant, or unknown in the context in which they are being discussed.</p>
 <hr>

 <h5>Anwsers borrowed from wikipedia</h5>
</div>
<script>
var clics = 0;

$(document).ready(function() {

  $('.respuesta').hide();
  $('#cerrartodas').hide();

  $('h3').click(function() {

    $(this).next('.respuesta').toggle(function() {

      $(this).next('.respuesta');

    }, function() {

      $(this).next('.respuesta').fadeIn('fast');

    });

    if ($(this).hasClass('cerrar')) {
      $(this).removeClass('cerrar');
    } else {
      $(this).addClass('cerrar');
    };

    if ($('.cerrar').length >= 3) {

      $('#cerrartodas').fadeIn('fast');

    } else {
      $('#cerrartodas').hide();
      var abiertas = $('.cerrar').length
      console.log(abiertas);
    }
  }); //Close Function Click

}); //Close Function Ready

$('#cerrartodas').click(function() {
  $('.respuesta').fadeOut(200);
  $('h3').removeClass('cerrar');
  $('#cerrartodas').fadeOut('fast');
});
</script>
