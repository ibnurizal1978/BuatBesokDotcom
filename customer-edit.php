<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../config.php";
require_once "../check-session.php";
//require_once "access.php";

$customer_id              = input_data(filter_var($_POST['customer_id'],FILTER_SANITIZE_STRING));
$partner_key              = input_data(filter_var($_POST['partner_key'],FILTER_SANITIZE_STRING));
$customer_name            = input_data(filter_var($_POST['customer_name'],FILTER_SANITIZE_STRING));
$customer_address         = input_data(filter_var($_POST['customer_address'],FILTER_SANITIZE_STRING));
$customer_phone_number    = input_data(filter_var($_POST['customer_phone_number'],FILTER_SANITIZE_STRING));
$customer_email_address   = input_data(filter_var($_POST['customer_email_address'],FILTER_SANITIZE_STRING));
$customer_active_status   = input_data(filter_var($_POST['customer_active_status'],FILTER_SANITIZE_STRING));

if($customer_name == "" || $customer_phone_number == "") {
?>
<script type="text/javascript">
  Swal.fire({
      type: 'error',
      text: 'Please fill name and phone number'
  })
  </script>
<?php
  exit();
}

//apakah ada duplikat name utk client id ini?
$sql  = "SELECT customer_phone_number FROM tbl_customer WHERE customer_phone_number = '".$customer_phone_number."' AND partner_key = '".$partner_key."' AND customer_id <> '".$customer_id."' LIMIT 1";
$h    = mysqli_query($conn2,$sql);
if(mysqli_num_rows($h)>0) {
?>
  <script type="text/javascript">
  Swal.fire({
      type: 'error',
      text: 'Duplicate phone number'
  })
  </script>
<?php
  exit(); 
}


$sql2   = "UPDATE tbl_customer SET customer_name='".$customer_name."',customer_address='".$customer_address."',customer_phone_number = '".$customer_phone_number."',customer_email_address = '".$customer_email_address."', customer_active_status = '".$customer_active_status."' WHERE customer_id = '".$customer_id."' LIMIT 1";
mysqli_query($conn2,$sql2);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_id,created_date,user_log_notes,client_id) VALUES ('EDIT-CUSTOMER','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'edit customer_id: $customer_id','".$_SESSION['client_id']."')";
mysqli_query($conn2,$sql_log);
?>
<script type="text/javascript">
swal({title: "Success",text: "",type: "success"}).then(function() {window.location = "customer.php";});
</script>