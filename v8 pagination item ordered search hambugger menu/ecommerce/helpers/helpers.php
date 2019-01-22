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
//  var_dump($successes); die();
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

function loginCustomer($user_id){
  $_SESSION['SBUser'] = $user_id; //set user session on Login
  global $db; //make database object a global variable
  $date = date("Y-m-d H:i:s"); //this is the date format of the Database
  $db->query("UPDATE customer_user SET last_login = '$date' WHERE id = '$user_id'");
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

function error_redirect($url,$message){
  $_SESSION['error_flash'] = $message;
  header('Location:'.$url);
}

function redirect($url,$message){
  $_SESSION['error_flash'] = $message;
  header('Location:'.$url);
}

function permission_error_redirect($url = 'login.php'){
  $_SESSION['error_flash'] = 'You do not have permission to access that page';
  header('Location:'.$url);
}

function permission_ungranted($url,$message){
  $_SESSION['error_flash'] = $message;
  header('Location:'.$url);
}

function check_staff_permission($level){
  $Clearance_level = $level;
  $C_permission = explode(',',$Clearance_level);
  global $user_data;
  $C_permissions = explode(',', $user_data['permissions']); //check user data permissions
    if (count(array_intersect($C_permission, $C_permissions)) === 0) {
    return false;
    }else{
      return true;
    }
 }

function check_permission($level){
  $Clearance_level = $level;
  $C_permission = explode(',',$Clearance_level);
  global $customer_data;
  $C_permissions = explode(',', $customer_data['permissions']); //check user data permissions
    if (count(array_intersect($C_permission, $C_permissions)) === 0) {
    return false;
    }else{
      return true;
    }
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

//   turn size quantity string into an array [medium:10,large:66]
function sizesToArray($string){
  $sizesArray = explode(',',$string);
  $returnArray = array();
  foreach($sizesArray as $size){
    $s =explode(':',$size);
    $returnArray[] = array('size'=> $s[0], 'quantity' => $s[1],'threshold' => $s[2]);
  }
  return $returnArray;
}

function sizesToString($sizes){
  $sizeString = '';
  foreach($sizes as $size){
    $sizeString .= $size['size'].':'.$size['quantity'].':'.$size['threshold'].',';
  }
  $trimmed =rtrim($sizeString,',');
  return $trimmed;
}
