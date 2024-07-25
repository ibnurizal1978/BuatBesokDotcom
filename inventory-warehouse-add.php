<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$warehouse_name     = input_data(filter_var($_POST['warehouse_name'],FILTER_SANITIZE_STRING));
$warehouse_location = input_data(filter_var($_POST['warehouse_location'],FILTER_SANITIZE_STRING));

if($warehouse_name == "" || $warehouse_location == "") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

//apakah ada duplikat?
$sql  = "SELECT warehouse_name FROM tbl_inventory_warehouse WHERE warehouse_name = '".$warehouse_name."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  echo "<script>";
  echo "alert('Duplicate name'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

$sql   = "INSERT INTO tbl_inventory_warehouse (warehouse_name,warehouse_location,created_date) VALUES ('".$warehouse_name."','".$warehouse_location."', UTC_TIMESTAMP())";
mysqli_query($conn,$sql);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('WAREHOUSE-ADD','WAREHOUSE','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'add new Warehouse Data','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);
echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";