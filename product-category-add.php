<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$product_category_name  = input_data(filter_var($_POST['product_category_name'],FILTER_SANITIZE_STRING));

if($product_category_name == "") {
  echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}


//apakah ada duplikat?
$sql  = "SELECT product_category_name FROM tbl_product_category WHERE product_category_name = '".$product_category_name."' AND client_id = '".$_SESSION['client_id']."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  echo "<script>";
  echo "alert('Duplicate data'); window.location.href=history.back()";
  echo "</script>";
  exit(); 
}

$sql2   = "INSERT INTO tbl_product_category (product_category_name,client_id) VALUES ('".$product_category_name."','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql2);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('ADD','PRODUCT CATEGORY','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$product_category_name','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";