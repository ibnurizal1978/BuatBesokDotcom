<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";
//require_once "access.php";

$help_id    = input_data(filter_var($_POST['help_id'],FILTER_SANITIZE_STRING));
$help_a  	= input_data(filter_var($_POST['help_a'],FILTER_SANITIZE_STRING));


if($help_id == "" || $help_a == "") {
  //echo "<script>";
  echo "alert('Please fill column'); window.location.href=history.back()";
  echo "</script>";
  exit();
}

$sql   = "UPDATE  tbl_help SET help_a = '".$help_a."', answer_date =  UTC_TIMESTAMP(), answer_by = '".$_SESSION['user_id']."' WHERE help_id =  '".$help_id."' LIMIT 1";
mysqli_query($conn,$sql);

echo "<script>";
echo "alert('Success'); window.location.href=history.back()";
echo "</script>";