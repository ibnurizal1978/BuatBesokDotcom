<?php
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");

$txt_username = input_data(filter_var($_POST['txt_username'],FILTER_SANITIZE_STRING));
$txt_password = input_data(filter_var($_POST['txt_password'],FILTER_SANITIZE_STRING));

if($txt_username=='' || $txt_password == '') {
  echo "<script>";
  echo "alert('Mohon isi form'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

$txt_new_password     = hash("sha256", $txt_password);
$sql          = "select user_id,user_photo,username,full_name,client_id,user_timezone,user_type,owner_id from tbl_user where username = '".$txt_username."' AND password = '".$txt_new_password."' AND user_active_status = 1 LIMIT 1";
$h            = mysqli_query($conn,$sql) or die(mysqli_error());
if(mysqli_num_rows($h)==0) {
  echo "<script>";
  echo "alert('Invalid login'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

$row        = mysqli_fetch_assoc($h);
$user_id      = $row['user_id'];
$username       = $row['username'];
$full_name     = $row['full_name'];
$client_id      = $row['client_id'];
$user_photo     = $row['user_photo'];
$user_timezone    = $row['user_timezone'];
$user_type      = $row['user_type'];
$owner_id  = $row['owner_id'];
$sql    = "update tbl_user SET user_last_login = UTC_TIMESTAMP() where user_id='".$user_id."' limit 1";
$h2     = mysqli_query($conn,$sql);

//cara nampilin time berdasarkan timezone
//date_default_timezone_set($row['user_timezone']);
//echo 'date and time is ' . date('Y-m-d H:i:s');


$sql2   = "insert into tbl_user_log('".$user_id."','LOGIN',UTC_TIMESTAMP()";
$h2     = mysqli_query($conn,$sql2);

$_SESSION['user_id']      = $user_id;
$_SESSION['full_name']     = $full_name;
$_SESSION['username']     = $username;
$_SESSION['client_id']      = $client_id;
$_SESSION['user_photo']     = $user_photo;
$_SESSION['user_timezone']    = $user_timezone;
$_SESSION['user_type']      = $user_type;
$_SESSION['owner_id']  = $owner_id;

$sql3   = "SELECT * FROM tbl_client INNER JOIN tbl_currency using (currency_id) INNER JOIN tbl_country using (country_id) WHERE client_id = '".$_SESSION['client_id']."' limit 1";
$h3   = mysqli_query($conn,$sql3);
$row3   = mysqli_fetch_assoc($h3);
$_SESSION['client_business_name'] = $row3['client_business_name'];
$_SESSION['client_address']     = $row3['client_address'];
$_SESSION['client_address_detail']  = $row3['client_address_detail'];
$_SESSION['client_phone']     = $row3['client_phone'];
$_SESSION['client_email_address'] = $row3['client_email_address'];
$_SESSION['client_discount_rate'] = $row3['client_discount_rate'];
$_SESSION['client_credit_limit']  = $row3['client_credit_limit'];
$_SESSION['client_top']       = $row3['client_top'];
$_SESSION['country_name']     = $row3['country_name'];
$_SESSION['currency_name']      = $row3['currency_name'];
$_SESSION['client_currency']    = $row3['client_currency'];
$_SESSION['client_timezone']    = $row3['client_timezone'];
$_SESSION['owner_id']       = $row3['owner_id'];
$_SESSION['client_logo']      = $row3['client_logo'];
$_SESSION['client_tax']       = $row3['client_tax'];
$_SESSION['region_id']        = $row3['region_id'];

//timezone
$serverTimezoneOffset  = (date("O") / 100 * 60 * 60);
$clientTimezoneOffset  = $_POST["timezoneoffset"];
$serverTime      = time();
$serverClientTimeDifference = $clientTimezoneOffset-$serverTimezoneOffset;
$clientTime      = $serverTime+$serverClientTimeDifference;
$_SESSION['selisih']   = ($serverClientTimeDifference/(60*60));
  
  
//tampilkan menu berdasarkan level
$sql_nav_header = "SELECT nav_header_id,nav_header_icon,nav_header_name FROM tbl_nav_user a INNER JOIN tbl_nav_menu b using (nav_menu_id) INNER JOIN tbl_nav_header USING (nav_header_id) WHERE user_id = '".$user_id."' GROUP BY nav_header_id ORDER by nav_menu_name";
$h_nav_header = mysqli_query($conn,$sql_nav_header);

while($row_menu_header = mysqli_fetch_assoc($h_nav_header)) {
  $_SESSION['nav_header'][]= array('header_id' => $row_menu_header['nav_header_id'],'header_icon' => $row_menu_header['nav_header_icon'],'header_name' => $row_menu_header['nav_header_name']);

  $sql_menu   = "SELECT nav_header_id,nav_menu_name, nav_menu_url FROM tbl_nav_user a INNER JOIN tbl_nav_menu b using (nav_menu_id) WHERE user_id = '".$user_id."' AND nav_header_id = '".$row_menu_header['nav_header_id']."' ORDER by nav_menu_name";

  $h_menu   = mysqli_query($conn,$sql_menu);
  while($row_menu = mysqli_fetch_assoc($h_menu)) {
    $_SESSION['nav_items'][]= array('url' => $row_menu['nav_menu_url'], 'name' => $row_menu['nav_menu_name'],'nav_header_id' => $row_menu['nav_header_id']);
  }
}
header('location:order');
?>