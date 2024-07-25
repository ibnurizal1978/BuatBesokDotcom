<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../config.php";
require_once "../check-session.php";
//require_once "access.php";

$region_id  		= input_data(filter_var($_POST['region_id'],FILTER_SANITIZE_STRING));
$region_name  		= input_data(filter_var($_POST['region_name'],FILTER_SANITIZE_STRING));
$region_description = input_data(filter_var($_POST['region_description'],FILTER_SANITIZE_STRING));
$country_id  		= input_data(filter_var($_POST['country_id'],FILTER_SANITIZE_STRING));

if($region_name == "") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}


//apakah ada duplikat?
$sql  = "SELECT region_name FROM tbl_region WHERE region_name = '".$region_name."' AND region_id <> '".$region_id."' AND client_id = '".$_SESSION['client_id']."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  echo "<script>";
  echo "alert('Duplicate data'); window.location.href=history.back()";
  echo "</script>";
  exit(); 
}

$sql2   = "UPDATE tbl_region SET region_name = '".$region_name."', region_description = '".$region_description."', country_id = '".$country_id."' WHERE region_id = '".$region_id."' AND client_id = '".$_SESSION['client_id']."' LIMIT 1";
mysqli_query($conn,$sql2);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('EDIT','REGION','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$region_name','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";