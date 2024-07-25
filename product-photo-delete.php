<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$product_photo_id  = Encryption::decode($param[1]);

$query = "DELETE FROM tbl_product_photo WHERE product_photo_id = '".$product_photo_id."' AND client_id ='".$_SESSION['client_id']."' LIMIT 1";
mysqli_query($conn,$query);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('DELETE','PRODUCT PHOTO','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";