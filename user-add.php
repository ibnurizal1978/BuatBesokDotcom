<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$username           = input_data(filter_var($_POST['username'],FILTER_SANITIZE_STRING));
$full_name          = input_data(filter_var($_POST['full_name'],FILTER_SANITIZE_STRING));
$department_id      = input_data(filter_var($_POST['department_id'],FILTER_SANITIZE_STRING));
$txt_password       = input_data(filter_var($_POST['txt_password'],FILTER_SANITIZE_STRING));
$txt_password2      = input_data(filter_var($_POST['txt_password2'],FILTER_SANITIZE_STRING));

if($username == "" || $full_name == "" || $department_id =="" || $txt_password == "" || $txt_password2 == "") {
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

$txt_new_password3  = hash("sha256", $txt_password2);

//apakah ada duplikat name utk client id ini?
$sql  = "SELECT username FROM tbl_user WHERE username = '".$username."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  echo "<script>";
  echo "alert('Duplicate username'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

$sql2   = "INSERT INTO tbl_user (client_id,username,password,department_id,full_name,created_date,user_active_status,user_timezone, owner_id) VALUES ('".$_SESSION['client_id']."','".$username."','".$txt_new_password3."','".$department_id."','".$full_name."',UTC_TIMESTAMP(),1,'".$_SESSION['user_timezone']."','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql2);
$last_id = mysqli_insert_id($conn);

$banyaknya = count(@$_POST['nav_menu_id']);
for ($i=0; $i<$banyaknya; $i++) {
  if(@$_POST['nav_menu_id'][$i]) {
    $sql_menu = "SELECT nav_menu_id from tbl_nav_menu WHERE nav_menu_id = '".@$_POST['menu_id'][$i]."'";
    $h_menu   = mysqli_query($conn,$sql_menu);
    $row_menu = mysqli_fetch_assoc($h_menu);
  $sql_menu2  = "INSERT INTO tbl_nav_user(nav_menu_id,user_id,client_id) VALUES ('".@$_POST['nav_menu_id'][$i]."','".$last_id."','".$_SESSION['client_id']."')";
  mysqli_query($conn,$sql_menu2);
  //echo $sql_menu2.'<br/>';
  }
}

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('ADD','USER','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$username','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";