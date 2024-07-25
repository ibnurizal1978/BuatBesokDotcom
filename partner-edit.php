<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../config.php";
require_once "../check-session.php";
//require_once "access.php";

$partner_id             = input_data(filter_var($_POST['partner_id'],FILTER_SANITIZE_STRING));
$partner_ip             = input_data(filter_var($_POST['partner_ip'],FILTER_SANITIZE_STRING));
$partner_key            = input_data(filter_var($_POST['partner_key'],FILTER_SANITIZE_STRING));
$partner_secret         = input_data(filter_var($_POST['partner_secret'],FILTER_SANITIZE_STRING));
$partner_name           = input_data(filter_var($_POST['partner_name'],FILTER_SANITIZE_STRING));
$partner_active_status  = input_data(filter_var($_POST['partner_active_status'],FILTER_SANITIZE_STRING));
$partner_deposit_type   = input_data(filter_var($_POST['partner_deposit_type'],FILTER_SANITIZE_STRING));
$partner_contact_name   = input_data(filter_var($_POST['partner_contact_name'],FILTER_SANITIZE_STRING));
$partner_contact_email  = input_data(filter_var($_POST['partner_contact_email'],FILTER_SANITIZE_STRING));

if($partner_name == "" || $partner_key == "" || $partner_secret == "") {
?>
<script type="text/javascript">
  Swal.fire({
      type: 'error',
      text: 'Please fill name, key and secret'
  })
  </script>
<?php
  exit();
}

//apakah ada duplikat name utk key?
$sql  = "SELECT partner_key FROM tbl_partner WHERE partner_key = '".$partner_key."' AND partner_id <> '".$partner_id."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
?>
  <script type="text/javascript">
  Swal.fire({
      type: 'error',
      text: 'Duplicate partner key'
  })
  </script>
<?php
  exit(); 
}

//apakah ada duplikat name utk secret?
$sql  = "SELECT partner_secret FROM tbl_partner WHERE partner_secret = '".$partner_secret."' AND partner_id <> '".$partner_id."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
?>
  <script type="text/javascript">
  Swal.fire({
      type: 'error',
      text: 'Duplicate partner secret'
  })
  </script>
<?php
  exit(); 
}


$sql2   = "UPDATE tbl_partner SET partner_name='".$partner_name."',partner_ip='".$partner_ip."',partner_key = '".$partner_key."',partner_secret = '".$partner_secret."', partner_active_status = '".$partner_active_status."', partner_deposit_type = '".$partner_deposit_type."', partner_contact_name = '".$partner_contact_name."', partner_contact_email = '".$partner_contact_email."' WHERE partner_id = '".$partner_id."' LIMIT 1";
mysqli_query($conn,$sql2);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_id,created_date,user_log_notes,client_id) VALUES ('EDIT-PARTNER','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'edit partner_id: $partner_id','".$_SESSION['client_id']."')";
mysqli_query($conn2,$sql_log);
?>
<script type="text/javascript">
swal({title: "Success",text: "",type: "success"}).then(function() {window.location = "partner.php";});
</script>