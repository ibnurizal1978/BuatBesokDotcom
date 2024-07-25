<?php
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";

$order_code			=	input_data(filter_var($param[1],FILTER_SANITIZE_STRING));

if($order_code == "") {
  	echo "<script>";
  	echo "alert('Mohon pilih kode pesanan yang mau dilanjutkan'); window.location.href=history.back()";
  	echo "</script>";
	exit();
}

if($param[2]==1) {
	$status = 'DIPROSES'; 
	$sql2 	= "UPDATE tbl_order SET order_status = '".$status."', process_date = UTC_TIMESTAMP(), process_by = '".$_SESSION['user_id']."' WHERE order_code = '".$order_code."'";

	//insert ke table track
	$sql3 	= "INSERT INTO tbl_order_track (order_code, created_date, order_status, order_notes, user_id) VALUES ('".$order_code."', UTC_TIMESTAMP(), '".$status."', 'Order sedang diproses', '".$_SESSION['user_id']."')";

	//kurangi stok di inventory_stock
	$sql_s1 = "SELECT stock_id,  product_id, warehouse_id, rack_id, qty_ready, qty_reject, qty_treshold, order_detail_qty FROM tbl_inventory_stock a INNER JOIN tbl_order_detail b USING (product_id) WHERE order_code = '".$order_code."'";
	$h1 	= mysqli_query($conn, $sql_s1);
	while($row_s1 = mysqli_fetch_assoc($h1)) {

		$sql_s2   = "UPDATE tbl_inventory_stock SET qty_ready = qty_ready - ".$row_s1['order_detail_qty']." WHERE product_id = '".$row_s1['product_id']."' LIMIT 1";
		mysqli_query($conn, $sql_s2);

		$selisih = $row_s1['qty_ready']-$row_s1['order_detail_qty'];
		$sql_ilog 	= "INSERT INTO tbl_inventory_log(stock_id, product_id, warehouse_id, rack_id, qty_ready, qty_reject, qty_treshold, old_qty_ready, old_qty_reject, old_qty_treshold, created_date, user_id, order_code) VALUES ('".$row_s1['stock_id']."', '".$row_s1['product_id']."', '".$row_s1['warehouse_id']."', '".$row_s1['rack_id']."', '".$selisih."', 0 , '".$row_s1['qty_treshold']."', '".$row_s1['qty_ready']."', '".$row_s1['qty_reject']."' , '".$row_s1['qty_treshold']."', UTC_TIMESTAMP(), '".$_SESSION['user_id']."', '".$order_code."')";
		mysqli_query($conn, $sql_ilog);
	}


}elseif($param[2]==2) {
	$status = 'DIKIRIM';
	$sql2 	= "UPDATE tbl_order SET order_status = '".$status."', delivery_date = UTC_TIMESTAMP(), delivery_by = '".$_SESSION['user_id']."' WHERE order_code = '".$order_code."'";

	//insert ke table track
	$sql3 	= "INSERT INTO tbl_order_track (order_code, created_date, order_status, order_notes, user_id) VALUES ('".$order_code."', UTC_TIMESTAMP(), '".$status."', 'Order dalam proses pengiriman', '".$_SESSION['user_id']."')";

}elseif($param[2]==3) {
	$status = 'SAMPAI';
	$sql2 	= "UPDATE tbl_order SET order_status = '".$status."', delivery_date = UTC_TIMESTAMP(), delivery_by = '".$_SESSION['user_id']."' WHERE order_code = '".$order_code."'";

	//insert ke table track
	$sql3 	= "INSERT INTO tbl_order_track (order_code, created_date, order_status, order_notes, user_id) VALUES ('".$order_code."', UTC_TIMESTAMP(), '".$status."', 'Order sudah sampai', '".$_SESSION['user_id']."')";

}else{
	$status = 'SAMPAI';
	$sql2 	= "UPDATE tbl_order SET order_status = '".$status."', delivered_date = UTC_TIMESTAMP(), delivered_by = '".$_SESSION['user_id']."' WHERE order_code = '".$order_code."'";

	//insert ke table track
	$sql3 	= "INSERT INTO tbl_order_track (order_code, created_date, order_status, order_notes, user_id) VALUES ('".$order_code."', UTC_TIMESTAMP(), '".$status."', 'Order telah diterima', '".$_SESSION['user_id']."')";	
}

$sql 	= "UPDATE tbl_order_detail SET order_detail_status = '".$status."' WHERE order_code = '".$order_code."'";

mysqli_query($conn,$sql);
mysqli_query($conn,$sql2);
mysqli_query($conn, $sql3);

echo "<script>";
echo "alert('Pesanan berhasil dilanjutkan'); window.location.href=history.back()";
echo "</script>";
exit();

?>