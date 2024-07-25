<?php 
require_once 'header.php';
//require_once 'components.php';

//total mitra aktif
$sql1   = "SELECT count(partner_id) as total FROM tbl_partner LIMIT 1";
$h1     = mysqli_query($conn, $sql1);
$r1     = mysqli_fetch_assoc($h1);

//total penjualan minggu ini (Rp.)
$sql2   = "SELECT sum(order_detail_sub_total) as total FROM tbl_order_detail WHERE order_detail_status = 'SAMPAI' ANDcreated_date > DATE_SUB(NOW(), INTERVAL 1 WEEK) LIMIT 1";
$h2     = mysqli_query($conn, $sql2);
$r2     = mysqli_fetch_assoc($h2);

//total penjualan (Rp.)
$sql3   = "SELECT sum(order_detail_sub_total) as total FROM tbl_order_detail WHERE order_detail_status = 'SAMPAI' LIMIT 1";
$h3     = mysqli_query($conn, $sql3);
$r3     = mysqli_fetch_assoc($h3);

//total produk
$sql4   = "SELECT count(product_id) as total FROM tbl_product LIMIT 1";
$h4     = mysqli_query($conn, $sql4);
$r4     = mysqli_fetch_assoc($h4);
?>

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content">

        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            <div class="col-6 col-xl-3">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-users fa-2x text-elegance-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-primary" data-toggle="countTo" data-speed="1000" data-to="1500"><?php echo number_format($r1['total'],0,",",".") ?></div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Mitra Aktif</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-wallet fa-2x text-elegance-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-earth">Rp. <span data-toggle="countTo" data-speed="1000" data-to="780"><?php echo number_format($r2['total'],0,",",".") ?></span></div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Sales Minggu Ini</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-wallet fa-2x text-elegance-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-earth">Rp. <span data-toggle="countTo" data-speed="1000" data-to="780"><?php echo number_format($r3['total'],0,",",".") ?></span></div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Total Sales</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-bag fa-2x text-elegance-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-earth-light" data-toggle="countTo" data-speed="1000" data-to="4252"><?php echo number_format($r4['total'],0,",",".") ?></div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Total Produk</div>
                    </div>
                </a>
            </div>
            <!-- END Row #1 -->
        </div>

        <div class="row invisible" data-toggle="appear">
            <!-- Row #3 -->
            <div class="col-md-6">
                <div class="block block-rounded block-bordered">
                    <div class="block-header block-header-default border-b">
                        <h3 class="block-title">10 Mitra Penjualan Tertinggi</h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th width="62%" class="text-earth">Mitra</th>
                                    <th class="text-right text-earth">Total Sales (Rp.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql   = "SELECT sum(order_detail_sub_total) as total, partner_name FROM tbl_order_detail a INNER JOIN tbl_partner b USING (partner_id) WHERE order_detail_status = 'SAMPAI' GROUP BY partner_id ORDER BY total DESC  LIMIT 10";
                                $h     = mysqli_query($conn, $sql);
                                while($r     = mysqli_fetch_assoc($h)) {
                                ?>                                
                                <tr>
                                    <td><?php echo $r['partner_name'] ?></td>
                                    <td class="text-right">
                                        <span class="text-black"><?php echo number_format($r['total'],0,",",".") ?></span>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block block-rounded block-bordered">
                    <div class="block-header block-header-default border-b">
                        <h3 class="block-title">10 Produk Paling Laku</h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th width="62%" class="text-earth">Produk</th>
                                    <th class="text-right text-earth">Total Sales (Rp.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql   = "SELECT sum(order_detail_sub_total) as total, product_name FROM tbl_order_detail WHERE order_detail_status = 'SAMPAI' GROUP BY product_id ORDER BY total DESC  LIMIT 10";
                                $h     = mysqli_query($conn, $sql);
                                while($r     = mysqli_fetch_assoc($h)) {
                                ?>                                
                                <tr>
                                    <td><?php echo $r['product_name'] ?></td>
                                    <td class="text-right">
                                        <span class="text-black"><?php echo number_format($r['total'],0,",",".") ?></span>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        


<?php

$sql   = "SELECT sum(order_detail_qty) as total, product_name FROM tbl_order_detail WHERE order_detail_status = 'SAMPAI' GROUP BY partner_id ORDER BY total DESC LIMIT 10";
$h     = mysqli_query($conn, $sql);
$dataPoints = array();
$product_name   = "";
$total          = "";

while($r     = mysqli_fetch_assoc($h)) {
 $arr = array();
  $arr['y'] = $row['amount'];
 $arr['label'] = $row['bulan'];
}

$product_name   = substr($product_name,0,-1);
$total          = substr($total,0,-1);
$dataPoints     = array_push($arr,$dataPoints);

/*
$dataPoints = array(
    array("y" => 25, "label" => "Sunday"),
    array("y" => 15, "label" => "Monday"),
    array("y" => 25, "label" => "Tuesday")
);*/
 
?>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
    title: {
        text: "Grafik Penjualan Ikan (dalam kg)"
    },
    axisY: {
        title: "Kg"
    },
    data: [{
        type: "line",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
 
}
</script>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


    </div>

</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>