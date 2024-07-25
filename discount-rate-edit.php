<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../config.php";
require_once "../check-session.php";
//require_once "access.php";

$discount_rate_id  			= input_data(filter_var($_POST['discount_rate_id'],FILTER_SANITIZE_STRING));
$discount_rate_name  		= input_data(filter_var($_POST['discount_rate_name'],FILTER_SANITIZE_STRING));
$discount_rate_amount  		= input_data(filter_var($_POST['discount_rate_amount'],FILTER_SANITIZE_STRING));
$discount_rate_start_date  	= input_data(filter_var($_POST['discount_rate_start_date'],FILTER_SANITIZE_STRING));
$discount_rate_end_date  	= input_data(filter_var($_POST['discount_rate_end_date'],FILTER_SANITIZE_STRING));

$discount_rate_start_date_y   = substr($discount_rate_start_date,6,4);
$discount_rate_start_date_m   = substr($discount_rate_start_date,3,2);
$discount_rate_start_date_d   = substr($discount_rate_start_date,0,2);
$discount_rate_start_date_f   = $discount_rate_start_date_y.'-'.$discount_rate_start_date_m.'-'.$discount_rate_start_date_d;

$discount_rate_end_date_y   = substr($discount_rate_end_date,6,4);
$discount_rate_end_date_m   = substr($discount_rate_end_date,3,2);
$discount_rate_end_date_d   = substr($discount_rate_end_date,0,2);
$discount_rate_end_date_f   = $discount_rate_end_date_y.'-'.$discount_rate_end_date_m.'-'.$discount_rate_end_date_d;

if($discount_rate_name == "" || $discount_rate_amount == "" || $discount_rate_start_date == "" || $discount_rate_end_date == "") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

if($discount_rate_amount >99) {
  echo "<script>";
  echo "alert('Are you sure about your discount amount?'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

if($discount_rate_start_date_f > $discount_rate_end_date_f) {
  echo "<script>";
  echo "alert('End date cannot be larger than start date'); window.location.href=history.back()";
  echo "</script>";
  exit();
}


//apakah ada duplikat?
$sql  = "SELECT discount_rate_name FROM tbl_discount_rate WHERE discount_rate_name = '".$discount_rate_name."' AND discount_rate_id <> '".$discount_rate_id."' AND client_id = '".$_SESSION['client_id']."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  echo "<script>";
  echo "alert('Duplicate data'); window.location.href=history.back()";
  echo "</script>";
  exit(); 
}

$sql2   = "UPDATE tbl_discount_rate SET discount_rate_name = '".$discount_rate_name."',discount_rate_amount = '".$discount_rate_amount."', discount_rate_start_date = '".$discount_rate_start_date_f."', discount_rate_end_date = '".$discount_rate_end_date_f."' WHERE client_id = '".$_SESSION['client_id']."' LIMIT 1";
mysqli_query($conn,$sql2);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('EDIT','DISCOUNT-RATE','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$discount_rate_name','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";