<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../config.php";
require_once "../check-session.php";
//require_once "access.php";

$user_id            = input_data(filter_var($_POST['user_id'],FILTER_SANITIZE_STRING));
$username           = input_data(filter_var($_POST['username'],FILTER_SANITIZE_STRING));
$full_name          = input_data(filter_var($_POST['full_name'],FILTER_SANITIZE_STRING));
$user_active_status = input_data(filter_var($_POST['user_active_status'],FILTER_SANITIZE_STRING));
$txt_password       = input_data(filter_var($_POST['txt_password'],FILTER_SANITIZE_STRING));
$txt_password2      = input_data(filter_var($_POST['txt_password2'],FILTER_SANITIZE_STRING));

if($username == "" || $full_name == "") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

if (preg_match('/\s/',$username)) {
  echo "<script>";
  echo "alert('Username can only number and alphabet allowed'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

//apakah ada duplikat name utk client id ini?
$sql  = "SELECT username FROM tbl_user WHERE username = '".$username."' AND user_id <> '".$user_id."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  echo "<script>";
  echo "alert('Duplicate username'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

if($txt_password <> '') {
  function valid_pass($txt_password) {
      if (!preg_match_all('$\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\s*$', $txt_password))
          return FALSE;
      return TRUE;
  }

  if(!valid_pass($txt_password)) { 
    echo "<script>";
    echo "alert('Password must consist of number and alphabet'); window.location.href=history.back()";
    echo "</script>";
    exit();
  }


  if(strlen($txt_password)<6) {
    echo "<script>";
    echo "alert('Minimum password length is 6 characters'); window.location.href=history.back()";
    echo "</script>";
    exit();
  } 

  if($txt_password <> $txt_password2) {
    echo "<script>";
    echo "alert('Both of your password is not equal'); window.location.href=history.back()";
    echo "</script>";
    exit();
  }

  //generate new password
  $replacements = array('1' => '2',
                        '2' => '3', 
                        '3' => '4',
                        '4' => '5',
                        '5' => '6',
                        'a' => 'b',
                        'b' => 'c',
                        'c' => 'd',
                       );
  $capcay       = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxysABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
  $acak       = substr($capcay,0,6);
  $txt_password2    = $acak.md5($txt_password);
  $txt_new_password3  = strtr($txt_password2,$replacements);

  $sql   = "UPDATE tbl_user SET username = '".$username."', password = '".$txt_new_password3."', full_name = '".$full_name."', user_active_status = '".$user_active_status."' WHERE user_id = '".$user_id."' LIMIT 1";
}else{
  $sql   = "UPDATE tbl_user SET username = '".$username."', full_name = '".$full_name."', user_active_status = '".$user_active_status."' WHERE user_id = '".$user_id."' LIMIT 1";
}
mysqli_query($conn,$sql);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('EDIT','USER','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$username','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";