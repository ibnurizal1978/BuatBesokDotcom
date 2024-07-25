<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$product_id  = input_data(filter_var($_POST['product_id'],FILTER_SANITIZE_STRING));


if($_FILES['photo_file']=="") {
  echo "<script>";
  echo "alert('Please choose photo'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

if ($_FILES['photo_file']['size'] > 1000000) {
  echo "<script>";
  echo "alert('Maximum photo file size is 1 MB'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

$temp 				= explode(".", $_FILES["photo_file"]["name"]);
$name 				= $_FILES['photo_file']['name'];
$target_dir 		= "../im7/";
$permitted_chars 	= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$newfilename 		= substr(str_shuffle($permitted_chars), 0, 16).'.'.end($temp);
$target_file 		= $target_dir.$newfilename;
$imageFileType 		= strtolower($temp[1]);
//echo '<br/>-'.$temp[0];
//echo '<br/>--'.$temp[1];
//echo '<br/>target file :'.$target_file;
//echo '<br/>newfilename :'.$newfilename;
//echo '<br/>=='.$imageFileType;
// Valid file extensions
$extensions_arr 	= array("jpg","jpeg","png","gif");

// Check extension
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "pdf" && $imageFileType != "gif" && $imageFileType != "jpeg") {
  echo "<script>";
  echo "alert('File type must JPG, PNG or GIF'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

function compressImage($source_image, $compress_image) {
$image_info = getimagesize($source_image);
if ($image_info['mime'] == 'image/jpeg') {
  $source_image = imagecreatefromjpeg($source_image);
  imagejpeg($source_image, $compress_image, 50);
} elseif ($image_info['mime'] == 'image/gif') {
  $source_image = imagecreatefromgif($source_image);
  imagegif($source_image, $compress_image, 50);
} elseif ($image_info['mime'] == 'image/png') {
  $source_image = imagecreatefrompng($source_image);
  imagepng($source_image, $compress_image, 5);
}
return $compress_image;
}

move_uploaded_file($_FILES["photo_file"]["tmp_name"], $target_file);
$source_image = $target_file;
$image_destination = $target_dir.$newfilename;
compressImage($source_image, $image_destination);

// Insert record
$query = "INSERT INTO tbl_product_photo (product_id, product_photo_name, client_id) VALUES ('".$product_id."', '".$newfilename."', '".$_SESSION['client_id']."')";
mysqli_query($conn,$query);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_log_module,user_id,user_log_date,user_log_notes,client_id) VALUES ('ADD','PRODUCT PHOTO','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'$product_id','".$_SESSION['client_id']."')";
mysqli_query($conn,$sql_log);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";