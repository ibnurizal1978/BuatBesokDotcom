<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['user_id']);
session_destroy();
if($_GET['s']=='e') {
	header("Location:/?p=e");
}elseif($_GET['s']=='session') {
	header("Location:/?p=s");
}else{
	header("Location:/");
}
?>