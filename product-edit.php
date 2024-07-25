<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$product_id 			= input_data(filter_var($_POST['product_id'],FILTER_SANITIZE_STRING));
$product_name  			= input_data(filter_var($_POST['product_name'],FILTER_SANITIZE_STRING));
$product_category_id  	= input_data(filter_var($_POST['product_category_id'],FILTER_SANITIZE_STRING));
$product_price  		= input_data(filter_var($_POST['product_price'],FILTER_SANITIZE_STRING));
$product_minimum_order  = input_data(filter_var($_POST['product_minimum_order'],FILTER_SANITIZE_STRING));
$product_unit_name  	= input_data(filter_var($_POST['product_unit_name'],FILTER_SANITIZE_STRING));
$product_price2    		= str_replace(',', '', $product_price);

if($product_name == "" || $product_price == "" || $product_category_id == "" || $product_minimum_order == "" || $product_unit_name == "") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}


//apakah ada duplikat?
$sql  = "SELECT product_name FROM tbl_product WHERE product_name = '".$product_name."' AND product_id <> '".$product_id."' AND client_id = '".$_SESSION['client_id']."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  //echo "<script>";
  echo "alert('Duplicate data'); window.location.href=history.back()";
  echo "</script>";
  exit(); 
}

$sql2   = "UPDATE tbl_product SET product_name = '".$product_name."', product_category_id = '".$product_category_id."', product_price = '".$product_price2."', product_category_id = '".$product_category_id."', product_unit_name = '".$product_unit_name."' WHERE product_id = '".$product_id."' AND client_id = '".$_SESSION['client_id']."' LIMIT 1";
mysqli_query($conn,$sql2);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('EDIT','PRODUCT','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$product_name','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";