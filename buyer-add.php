<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../config.php";
require_once "../check-session.php";
//require_once "access.php";

$client_business_name	=	input_data(filter_var($_POST['client_business_name'],FILTER_SANITIZE_STRING));
$client_address			=	input_data(filter_var($_POST['client_address'],FILTER_SANITIZE_STRING));
$client_address_detail	=	input_data(filter_var($_POST['client_address_detail'],FILTER_SANITIZE_STRING));
$client_email_address	=	input_data(filter_var($_POST['client_email_address'],FILTER_SANITIZE_STRING));
$client_phone			=	input_data(filter_var($_POST['client_phone'],FILTER_SANITIZE_STRING));
$region_id				=	input_data(filter_var($_POST['region_id'],FILTER_SANITIZE_STRING));
$client_discount_rate	=	input_data(filter_var($_POST['client_discount_rate'],FILTER_SANITIZE_STRING));
$client_credit_limit	=	input_data(filter_var($_POST['client_credit_limit'],FILTER_SANITIZE_STRING));
$country_id				=	input_data(filter_var($_POST['country_id'],FILTER_SANITIZE_STRING));

if($client_business_name=="" || $client_address == "") {
  echo "<script>";
  echo "alert('Please fill all column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

//check if there is a duplicate
$sql 	= "SELECT client_business_name FROM tbl_client WHERE owner_id = '".$_SESSION['client_id']."' AND client_business_name = '".$client_business_name."' LIMIT 1";
$h 		= mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  echo "<script>";
  echo "alert('Duplicate data'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

$client_credit_limit2 = str_replace(',', '', $client_credit_limit);

$sql2 	= "INSERT INTO tbl_client (client_business_name,client_address,client_address_detail,client_phone,client_email_address,region_id,client_discount_rate,client_credit_limit,client_top,created_date,country_id,owner_id,client_currency,client_type,client_timezone) VALUES ('".$client_business_name."','".$client_address."','".$client_address_detail."','".$client_phone."','".$client_email_address."','".$region_id."','".$client_discount_rate."','".$client_credit_limit2."',0,UTC_TIMESTAMP(),'".$country_id."','".$_SESSION['client_id']."','".$_SESSION['client_currency']."','BUYER','".$_SESSION['user_timezone']."')";
mysqli_query($conn,$sql2);
	
//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('ADD','BUYER','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$client_business_name','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";