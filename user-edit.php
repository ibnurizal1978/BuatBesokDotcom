<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$user_id            = input_data(filter_var($_POST['user_id'],FILTER_SANITIZE_STRING));
$username           = input_data(filter_var($_POST['username'],FILTER_SANITIZE_STRING));
$full_name          = input_data(filter_var($_POST['full_name'],FILTER_SANITIZE_STRING));
$department_id      = input_data(filter_var($_POST['department_id'],FILTER_SANITIZE_STRING));
$user_active_status = input_data(filter_var($_POST['user_active_status'],FILTER_SANITIZE_STRING));
$txt_password       = input_data(filter_var($_POST['txt_password'],FILTER_SANITIZE_STRING));
$txt_password2      = input_data(filter_var($_POST['txt_password2'],FILTER_SANITIZE_STRING));

if($username == "" || $full_name == "" || $department_id =="") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
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

  $sql   = "UPDATE tbl_user SET username = '".$username."', password = '".$txt_new_password3."', department_id = '".$department_id."', full_name = '".$full_name."', user_active_status = '".$user_active_status."' WHERE user_id = '".$user_id."' LIMIT 1";
}else{
  $sql   = "UPDATE tbl_user SET username = '".$username."', department_id = '".$department_id."', full_name = '".$full_name."', user_active_status = '".$user_active_status."' WHERE user_id = '".$user_id."' LIMIT 1";
}
mysqli_query($conn,$sql);

//hapus dulu akses modul yang ada utk user ini, baru masukin lagi
$sql_delete = "DELETE FROM tbl_nav_user WHERE user_id = '".$user_id."'";
mysqli_query($conn,$sql_delete);

$banyaknya = count(@$_POST['nav_menu_id']);
for ($i=0; $i<$banyaknya; $i++) {
  if(@$_POST['nav_menu_id'][$i]) {

      $sql_menu = "SELECT nav_menu_id from tbl_nav_menu WHERE nav_menu_id = '".@$_POST['nav_menu_id'][$i]."'";
      $h_menu   = mysqli_query($conn,$sql_menu);
      $row_menu = mysqli_fetch_assoc($h_menu);
      $sql_menu2  = "INSERT INTO tbl_nav_user(nav_menu_id,user_id,client_id) VALUES ('".$_POST['nav_menu_id'][$i]."','".$user_id."','".$_SESSION['client_id']."')";
      mysqli_query($conn,$sql_menu2);
  }
}

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('EDIT','USER','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$username','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";