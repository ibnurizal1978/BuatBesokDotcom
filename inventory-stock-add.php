<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$product_id     = input_data(filter_var($_POST['product_id'],FILTER_SANITIZE_STRING));
$qty_ready  	= input_data(filter_var($_POST['qty_ready'],FILTER_SANITIZE_STRING));
$qty_treshold  	= input_data(filter_var($_POST['qty_treshold'],FILTER_SANITIZE_STRING));
$warehouse_id  	= input_data(filter_var($_POST['warehouse_id'],FILTER_SANITIZE_STRING));
$rack_id  		= input_data(filter_var($_POST['rack_id'],FILTER_SANITIZE_STRING));

if($product_id == "" || $qty_ready == "" || $qty_treshold == "" || $warehouse_id == "" || $rack_id == "") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

//apakah ada duplikat?
$sql  = "SELECT product_id FROM tbl_inventory_stock WHERE product_id = '".$product_id."' AND warehouse_id = '".$warehouse_id."' AND rack_id = '".$rack_id."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  echo "<script>";
  echo "alert('Duplicate data'); window.location.href=history.back()";
  echo "</script>";
  exit(); 
}

$sql   = "INSERT INTO tbl_inventory_stock (product_id, warehouse_id, rack_id, qty_ready, qty_treshold, created_date) VALUES ('".$product_id."', '".$warehouse_id."', '".$rack_id."', '".$qty_ready."', '".$qty_treshold."', UTC_TIMESTAMP())";
mysqli_query($conn,$sql);
$last_id = mysqli_insert_id($conn);

$sql_ilog 	= "INSERT INTO tbl_inventory_log(stock_id, product_id, warehouse_id, rack_id, qty_ready, qty_reject, qty_treshold, old_qty_ready, old_qty_reject, old_qty_treshold, created_date, user_id) VALUES ('".$last_id."','".$product_id."', '".$warehouse_id."', '".$rack_id."', '".$qty_ready."', 0 , '".$qty_treshold."',  0, 0 , 0, UTC_TIMESTAMP(), '".$_SESSION['user_id']."')";
mysqli_query($conn, $sql_ilog);


//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('STOCK-ADD','STOCK','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'add new stock','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);
echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";
