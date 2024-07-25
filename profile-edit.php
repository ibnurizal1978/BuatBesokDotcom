<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../../config.php";
require_once "../check-session.php";
//require_once "access.php";

$partner_id		=	input_data(filter_var($_POST['partner_id'],FILTER_SANITIZE_STRING));
$partner_name	=	input_data(filter_var($_POST['partner_name'],FILTER_SANITIZE_STRING));
$partner_address=	input_data(filter_var($_POST['partner_address'],FILTER_SANITIZE_STRING));
$province_id	=	input_data(filter_var($_POST['province_id'],FILTER_SANITIZE_STRING));
$kabupaten_id	=	input_data(filter_var($_POST['kabupaten_id'],FILTER_SANITIZE_STRING));
$kecamatan_id	=	input_data(filter_var($_POST['kecamatan_id'],FILTER_SANITIZE_STRING));

if($partner_name=="" || $partner_address == "" || $province_id == "" || $kabupaten_id == "" || $kecamatan_id == "") {
  echo "<script>";
  echo "alert('Mohon lengkapi data pada form'); window.location.href=history.back()";
  echo "</script>";
  exit(); 
}

$sql2 	= "UPDATE tbl_partner SET partner_name='".$partner_name."',partner_address='".$partner_address."',province_id='".$province_id."',kabupaten_id='".$kabupaten_id."',kecamatan_id='".$kecamatan_id."'  WHERE partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
mysqli_query($conn,$sql2);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('EDIT','PROFILE','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$partner_id','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Data sukses diubah'); window.location.href=history.back();";
echo "</script>";
?>