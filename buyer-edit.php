<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";

$partner_id			=	input_data(filter_var($_POST['partner_id'],FILTER_SANITIZE_STRING));
$partner_discount_rate=	input_data(filter_var($_POST['partner_discount_rate'],FILTER_SANITIZE_STRING));
$active_status		=	input_data(filter_var($_POST['active_status'],FILTER_SANITIZE_STRING));
$completed_status	=	input_data(filter_var($_POST['completed_status'],FILTER_SANITIZE_STRING));

if($partner_id=="" || $active_status == "" || $completed_status == "") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit(); 
}

$sql2 	= "UPDATE tbl_partner SET partner_discount_rate='".$partner_discount_rate."', active_status='".$active_status."', completed_status='".$completed_status."' WHERE partner_id = '".$partner_id."' LIMIT 1";
mysqli_query($conn,$sql2);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('EDIT','BUYER','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$partner_id','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back();";
echo "</script>";
?>