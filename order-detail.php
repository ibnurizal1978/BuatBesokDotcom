<?php 
require_once 'header.php';

$sql_status   = "SELECT order_status FROM tbl_order WHERE order_code = '".$param[1]."' LIMIT 1";
$h_status     = mysqli_query($conn, $sql_status);
$row_status   = mysqli_fetch_assoc($h_status);
?>

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content">

    <!-- Small Table -->
    <!--begin list data-->
    <?php
      @$page = @$_REQUEST['page'];
      $dataPerPage = 10;
      if(isset($_GET['page']))
      {
          $noPage = $_GET['page'];
      }
      else $noPage = 1;
      @$offset = ($noPage - 1) * $dataPerPage;
      //for total count data
      if(@$_REQUEST['s']=='1091vdf8ame151') {
        $txt_search   = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
        $sql = "SELECT  department_id, department_name FROM tbl_department WHERE (department_name LIKE '%$txt_search%') AND client_id = '".$_SESSION['client_id']."' LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='1'){
        $sql = "SELECT department_id, department_name FROM tbl_department WHERE client_id = '".$_SESSION['client_id']."' ORDER BY department_name LIMIT $offset, $dataPerPage";     
      }else{
        $sql = "SELECT product_id, order_code, product_price, sum(order_detail_qty) as qty, sum(order_detail_sub_total) as sub, product_name, product_unit, order_detail_sub_total FROM tbl_order_detail WHERE order_code = '".$param[1]."' GROUP BY product_id ORDER BY product_name  LIMIT $offset, $dataPerPage";
      }

      $sql_tot   = "SELECT sum(order_detail_sub_total) as total FROM tbl_order_detail WHERE order_code = '".$param[1]."' LIMIT 1";
      $h_tot     = mysqli_query($conn, $sql_tot);
      $row_tot   = mysqli_fetch_assoc($h_tot);

      $rs_result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($rs_result)==0) {
      ?>
        <div class="alert alert-info ks-solid text-center" role="alert">Belum ada pesanan. <a href="dashboard">Ayo order barang disini</a></div>
    <?php }else{ ?>    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Detil Pesanan <?php echo $param[1] ?></h3>
            </div>
            <div class="block-content">
                <table class="table table-vcenter table-borderless">
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                        <tr>  
                            <td width="60%"><b><?php echo $row['product_name'] ?></b>
                                <br/>pesan <?php echo $row['qty'].' '.$row['product_unit'] ?> x Rp. <?php echo number_format($row['product_price'],0,",",".") ?></td>                          
                            <td style="text-align:right"><?php echo 'Rp. '.number_format($row['sub'],0,",",".") ?></td>
                        </tr>
                        <?php } mysqli_free_result($rs_result); ?>
                        <tr>
                            <td style="text-align:right"><b class="text-success">TOTAL PESANAN:</b></td>
                            <td style="text-align:right"><b class="text-success"><?php echo 'Rp. '.number_format($row_tot['total'],0,",",".") ?></b></td>
                        </tr>                                                   
                    </tbody>
                </table>
                <div class="text-center">
                    <?php if($row_status['order_status']=='BARU') {?>
                        <a href="order-confirm?<?php echo $param[1] ?>?1" class="btn btn-alt-success" onclick="return confirm('Anda akan memproses pesanan ini (Kode pesanan <?php echo $param[1] ?>). Tekan OK jika sudah yakin');">PROSES PESANAN</a>
                    <?php }elseif($row_status['order_status']=='DIPROSES') {?>
                        <a href="order-confirm?<?php echo $param[1] ?>?2" class="btn btn-alt-success" onclick="return confirm('Anda akan mengirim pesanan ini (Kode pesanan <?php echo $param[1] ?>). Tekan OK jika sudah yakin');">KIRIM PESANAN</a>
                    <?php }elseif($row_status['order_status']=='DIKIRIM') {?>
                        <a href="order-confirm?<?php echo $param[1] ?>?2" class="btn btn-alt-success" onclick="return confirm('Anda akan mengirim pesanan ini (Kode pesanan <?php echo $param[1] ?>). Tekan OK jika sudah yakin');">TANDAI SAMPAI</a>                        
                    <?php }else{ ?>
                        <a type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal" href="#">UNGGAH TANDA TERIMA</a>
                    <?php } ?>
                </div>
                <br/>
            </div>
        </div>
        <!-- END Small Table -->
    <?php } ?>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>

<!-- Compose Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header">
                    <h3 class="block-title">
                      <i class="fa fa-pencil mr-5"></i> Unggah Tanda Terima
                    </h3>
                    <div class="block-options">
                      <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                          <i class="si si-close"></i>
                      </button>
                    </div>
                </div>
                <div class="block-content">
                    <form enctype="multipart/form-data" action="<?php echo $file.'-add-invoice'.$ext ?>" method="POST">
                      <input type="hidden" name="order_code" value="<?php echo $param[1]  ?>" />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Ambil Foto Tanda Terima</label>
                                    <input type="file" class="form-control" value="1" name="photo_file" autocomplete="off" />
                                </div>
                            </div>                                                       
                        </div>
                        <input type="submit" class="btn btn-success mr-5 mb-5" value="Save" /> <a class="btn btn-info mr-5 mb-5 text-white" data-dismiss="modal"><i class="si si-close"></i> Close</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end modal-->