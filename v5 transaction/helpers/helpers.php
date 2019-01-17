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
  return '₦'.number_format($number,2); //format money to 2 decimal, place add money sign (N)
}

function login($user_id){
  $_SESSION['SBUser'] = $user_id; //set user session on Login
  global $db; //make database object a global variable
  $date = date("Y-m-d H:i:s"); //this is the date format of the Database
  $db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
  $_SESSION['success_flash'] = 'you are now logged in!';
  header('Location:index.php');
}

function is_logged_in(){
  if(isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0){
    return true;
  }
  return false;
}

function login_error_redirect($url = 'login.php'){
  $_SESSION['error_flash'] = 'You must be logged in to access that page';
  header('Location:'.$url);
}

function permission_error_redirect($url = 'login.php'){
  $_SESSION['error_flash'] = 'You do not have permission to access that page';
  header('Location:'.$url);
}

function permission_ungranted($url){
  $_SESSION['error_flash'] = 'You do not have permission to perform that action';
  header('Location:'.$url);
}

function has_pro_permission($permission = 'pro'){
  global $user_data;
  $permissions = explode(',', $user_data['permissions']); //check user data permissions
  if(in_array($permission,$permissions,true)){
    return true;
  }
  return false;
}

function has_admin_permission($permission = 'admin'){
  global $user_data;
  $permissions = explode(',', $user_data['permissions']); //check user data permissions
  if(in_array($permission,$permissions,true)){
    return true;
  }
  return false;
}

function has_editor_permission($permission = 'editor'){
  global $user_data;
  $permissions = explode(',', $user_data['permissions']); //check user data permissions
  if(in_array($permission,$permissions,true)){
    return true;
  }
  return false;
}

function has_staff_permission($permission = 'staff'){
  global $user_data;
  $permissions = explode(',', $user_data['permissions']); //check user data permissions
  if(in_array($permission,$permissions,true)){
    return true;
  }
  return false;
}

// format of date to be displayed
function my_dateFormat($date){
  return date("M d, Y h:i A",strtotime($date));
}


function is_valid_password($password) {
    if(preg_match_all('$S*(?=S{6,})(?=S*[a-z])(?=S*[A-Z])(?=S*[d])(?=S*[W])S*$', $password)){
      return true;
    }
    return false;
}
function is_accept_password($password){
  if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password)){
    return true;
  }
  return false;
}
function get_category($child_id){
  global $db;
  $id=sanitize($child_id);
  $sql = "SELECT p.id AS 'pid', p.category AS 'parent', c.id AS 'cid', c.category AS 'child'
          FROM categories c
          INNER JOIN categories p
          ON c.parent = p.id
          WHERE c.id = '$id'";
  $query = $db->query($sql);
  $category = mysqli_fetch_assoc($query);
  return $category;

}
