<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$stock_id     	= input_data(filter_var($_POST['stock_id'],FILTER_SANITIZE_STRING));
$qty_ready  	= input_data(filter_var($_POST['qty_ready'],FILTER_SANITIZE_STRING));
$qty_treshold  	= input_data(filter_var($_POST['qty_treshold'],FILTER_SANITIZE_STRING));
$qty_type  		= input_data(filter_var($_POST['qty_type'],FILTER_SANITIZE_STRING));
$product_id  	= input_data(filter_var($_POST['product_id'],FILTER_SANITIZE_STRING));
$warehouse_id  	= input_data(filter_var($_POST['warehouse_id'],FILTER_SANITIZE_STRING));
$rack_id  		= input_data(filter_var($_POST['rack_id'],FILTER_SANITIZE_STRING));
$old_qty_ready  		= input_data(filter_var($_POST['old_qty_ready'],FILTER_SANITIZE_STRING));
$old_qty_reject  		= input_data(filter_var($_POST['old_qty_reject'],FILTER_SANITIZE_STRING));
$old_qty_treshold  		= input_data(filter_var($_POST['old_qty_treshold'],FILTER_SANITIZE_STRING));

if($stock_id == "" || $qty_ready == "") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}
if($qty_type ==1) {
$sql   = "UPDATE tbl_inventory_stock SET qty_ready = qty_ready + ".$qty_ready.", qty_treshold = '".$qty_treshold."' WHERE stock_id = '".$stock_id."' LIMIT 1";

$sql_ilog 	= "INSERT INTO tbl_inventory_log(stock_id, product_id, warehouse_id, rack_id, qty_ready, qty_reject, qty_treshold, old_qty_ready, old_qty_reject, old_qty_treshold, created_date, user_id) VALUES ('".$stock_id."', '".$product_id."', '".$warehouse_id."', '".$rack_id."', '".$qty_ready."', 0 , '".$qty_treshold."',  '".$old_qty_ready."', '".$old_qty_reject."' , '".$old_qty_treshold."', UTC_TIMESTAMP(), '".$_SESSION['user_id']."')";
}else{
$sql   = "UPDATE tbl_inventory_stock SET qty_ready = qty_ready - ".$qty_ready.", qty_reject = '".$qty_ready."',  qty_treshold = '".$qty_treshold."' WHERE stock_id = '".$stock_id."' LIMIT 1";

$sql_ilog 	= "INSERT INTO tbl_inventory_log(stock_id, product_id, warehouse_id, rack_id, qty_ready, qty_reject, qty_treshold, old_qty_ready, old_qty_reject, old_qty_treshold, created_date, user_id) VALUES ('".$stock_id."', '".$product_id."', '".$warehouse_id."', '".$rack_id."', 0, '".$qty_ready."' , '".$qty_treshold."',  '".$old_qty_ready."', '".$old_qty_reject."' , '".$old_qty_treshold."', UTC_TIMESTAMP(), '".$_SESSION['user_id']."')";
}
mysqli_query($conn,$sql);
mysqli_query($conn, $sql_ilog);


//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes) VALUES ('STOCK-EDIT','STOCK','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'add new stock')";
mysqli_query($conn,$sql_log);
echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";