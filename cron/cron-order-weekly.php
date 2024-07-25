<?php
ini_set('display_errors',1);  error_reporting(E_ALL);
date_default_timezone_set('Asia/Jakarta');
require_once '../components.php';
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");

$sql 	= "SELECT WEEK(created_date) weeks, date_format(created_date, '%d-%m-%Y') as created_date, sum(order_detail_qty) as qty, sum(order_detail_sub_total) as sub, product_name, product_unit, product_price FROM tbl_order_detail WHERE created_date > DATE_SUB(NOW(), INTERVAL 5 WEEK) AND order_detail_status = 'BARU' GROUP BY WEEK(created_date) ORDER BY created_date";
$h 		= mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($h)) {
	echo '<h3>PESANAN BARU MINGGU INI: '.$row['qty'].' '.$row['product_unit'].' (senilai Rp. '.number_format($row['sub'],0,",",".").')</h3>';
}

$sql = "SELECT date_format(order_date, '%d-%m-%Y') as order_date, order_code, order_status, partner_name, partner_address, invoice_file FROM tbl_order a INNER JOIN tbl_partner b USING (partner_id) WHERE order_status = 'BARU' AND a.created_date > DATE_SUB(NOW(), INTERVAL 5 WEEK)";
$rs_result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($rs_result)==0) {
?>
<div class="alert alert-info ks-solid text-center" role="alert">Belum ada pesanan</div>
<?php }else{ ?>    
    <div class="block table-responsive">
        <div class="block-header block-header-default">
            <h3 class="block-title">Daftar Pesanan Per-Mitra</h3>
        </div>
        <div class="block-content">
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table-responsive table table-bordered" width="100%">
                        	<?php 
                        	while ($row = mysqli_fetch_assoc($rs_result)) { 

								//order total kg group by nama mitra
								$sql1 	= "SELECT sum(order_detail_qty) as total_kg, product_unit FROM tbl_order_detail WHERE order_code = '".$row['order_code']."' LIMIT 1";
								$h1 	= mysqli_query($conn, $sql1);
								$row1 	= mysqli_fetch_assoc($h1);
                        	?>
                            <tr>
                                <td><b>Nama</b><br/><?php echo $row['partner_name'] ?><br/>(order tgl <?php echo $row['order_date'] ?>)<br/><i>Total Order: <?php echo $row1['total_kg'].' '.$row1['product_unit'] ?></i></td>
                                <td><b>Pesanan:</b><br/>
                                    <?php
                                     $sql2   = "SELECT product_id, order_code, product_price, sum(order_detail_qty) as qty, sum(order_detail_sub_total) as sub, product_name, product_unit, order_detail_sub_total FROM tbl_order_detail WHERE order_code = '".$row['order_code']."' GROUP BY product_id ORDER BY product_name";
                                    $h2      = mysqli_query($conn, $sql2);
                                    while($row2 = mysqli_fetch_assoc($h2)) {
                                        echo $row2['product_name'].' ('.$row2['qty'].' '.$row2['product_unit'].')<br/>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        	<?php } mysqli_free_result($rs_result);?>
                        </table>
                    </div>
                </div>
        </div>
    </div>


    <div class="block table-responsive">
        <div class="block-header block-header-default">
            <h3 class="block-title">Daftar Pesanan Per-Produk</h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table-responsive table table-bordered" width="100%">
                        <tr>
                            <td><b>Produk:</b><br/>
                                <?php
                                 $sql2   = "SELECT product_name, sum(order_detail_qty) as qty, product_unit FROM tbl_order_detail WHERE created_date > DATE_SUB(NOW(), INTERVAL 5 WEEK) AND order_detail_status = 'BARU' GROUP BY product_name ORDER BY product_name";
                                $h2      = mysqli_query($conn, $sql2);
                                while($row2 = mysqli_fetch_assoc($h2)) {
                                    echo $row2['product_name'].' ('.$row2['qty'].' '.$row2['product_unit'].')<br/>';
                                }
                                ?>
                            </td>
                        </tr>
                    	<?php mysqli_free_result($h2);?>
                    </table>
                </div>
            </div>
        </div>
    </div> 

<?php } ?>