<?php
// function to pass in an array of errors style in bootstrap for errors
function display_errors($errors){
  $display = '<ul class="bg-danger">';
  foreach($errors as $error) {
    //class text danger make the font red
    $display .='<li class="text-danger">'.$error.'</li>';
  }
  $display .= '</ul>';
  return $display;
}

function display_success($successes){
  $s_display = '<ul class="bg-success">';
  foreach($successes as $success) {
    //class text danger make the font red
    $s_display .='<li class="text-success">'.$success.'</li>';
  }
  $s_display .= '</ul>';
  return $s_display;
}

// Sanitize html entities and bad code not to run in your database
function sanitize($dirty){
  return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}

function money($number){
  return 'N'.number_format($number,2); //format money to 2 decimal, place add money sign (N)
}
