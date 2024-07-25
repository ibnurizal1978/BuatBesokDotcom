<?php 
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../config.php";
require_once "../check-session.php";

$user_id			=	input_data(filter_var($_POST['user_id'],FILTER_SANITIZE_STRING));
$txt_password		=	input_data(filter_var($_POST['txt_password'],FILTER_SANITIZE_STRING));
$txt_password2		=	input_data(filter_var($_POST['txt_password2'],FILTER_SANITIZE_STRING));
$int    = input_data(filter_var($_POST['int'],FILTER_SANITIZE_STRING));


if($user_id=="" || $txt_password == "" || $txt_password2 == "") {
	//header('location:'.$base_url.$seller_url.'user.php?act=29dvi59&ntf=r827aop-'.$user_id.'-89t4hf34675dfoitrj!fn98s3#p');
?>
<script type="text/javascript">
Swal.fire({
    type: 'error',
    text: 'Please fill all forms'
})
</script>
<?php	
exit();
}

if(strlen($txt_password)<6) {
	//header('location:user.php?act=29dvi59&ntf=ado67od7p-'.$user_id.'-89t4hf34675dfoitrj!fn98s3#p');
?>
<script type="text/javascript">
Swal.fire({
    type: 'error',
    text: 'Minimum length for password is 6 characters, consist of minimum one uppercase, one number and alphabet'
})
</script>
<?php	
exit();	
} 

if($txt_password <> $txt_password2) {
//	header('location:user.php?act=29dvi59&ntf=qgzrts2dk733p-'.$user_id.'-89t4hf34675dfoitrj!fn98s3#p');
?>
<script type="text/javascript">
Swal.fire({
    type: 'error',
    text: 'Both of passwords does not equal'
})
</script>
<?php
exit();
}

$txt_new_password3  = hash("sha256", $txt_password2);

$sql2 	= "UPDATE tbl_user SET password='".$txt_new_password3."' WHERE user_id = '".$user_id."' LIMIT 1";
mysqli_query($conn2,$sql2);

//insert ke table log user
$sql_log   = "INSERT INTO tbl_user_log (user_log_action,user_id,created_date,user_log_notes,client_id) VALUES ('CHANGE-PASSWORD','".$_SESSION['user_id']."',UTC_TIMESTAMP(),'change password for user_id: $user_id','".$_SESSION['client_id']."')";
mysqli_query($conn2,$sql_log);
?>
<script type="text/javascript">
swal({title: "Success",text: "",type: "success"}).then(function() {window.location = "user.php";});
</script>