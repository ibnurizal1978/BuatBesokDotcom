<?php
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../config.php";
require_once "../check-session.php";

$parts_id			=	input_data(filter_var($_POST['parts_id'],FILTER_SANITIZE_STRING));
$parts_name			=	input_data(filter_var($_POST['parts_name'],FILTER_SANITIZE_STRING));
$parts_code			=	input_data(filter_var($_POST['parts_code'],FILTER_SANITIZE_STRING));
$parts_treshold		=	input_data(filter_var($_POST['parts_treshold'],FILTER_SANITIZE_STRING));
$parts_rack_location_id	=	input_data(filter_var($_POST['parts_rack_location_id'],FILTER_SANITIZE_STRING));

if($parts_name=="" ) {
	header('location:inventory-parts.php?ntf=r827ao-89t4hf34675dfoitrj!fn98s3');
  exit();
}

//check duplikat data
$sql 	= "SELECT parts_name,parts_code FROM tbl_parts WHERE client_id = '".$_SESSION['client_id']."' AND parts_name = '".$parts_name."' AND parts_rack_location_id = '".$parts_rack_location_id."' AND parts_id <> '".$parts_id."' LIMIT 1";
$h 		= mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
	header('location:inventory-parts.php?ntf=dpk739a-89t4hf34675dfoitrj!fn98s3');
	exit();	
}

$sql = "UPDATE tbl_parts SET parts_name = '".$parts_name."',parts_code = '".$parts_code."',parts_treshold = '".$parts_treshold."',parts_rack_location_id = '".$parts_rack_location_id."' WHERE parts_id = '".$parts_id."' AND client_id = '".$_SESSION['client_id']."' LIMIT 1";
mysqli_query($conn,$sql);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('PARTS-UPDATE','PARTS','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'update parts Data','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);
header('location:inventory-parts.php?ntf=r1029wkw-89t4hf34675dfoitrj!fn98s3');
?>