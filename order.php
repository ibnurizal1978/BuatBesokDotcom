<?php 
require_once 'header.php';
//require_once 'components.php';
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
        $sql = "SELECT date_format(order_date, '%d-%m-%Y') as order_date, order_code, order_status, partner_name, partner_address, invoice_file FROM tbl_order a INNER JOIN tbl_partner b USING (partner_id) WHERE order_status <> 'PENDING' ORDER BY order_id DESC LIMIT $offset, $dataPerPage";
        //$sql = "SELECT date_format(order_date, '%d-%m-%Y') as order_date, order_code, order_status, partner_name, partner_address, invoice_file FROM tbl_order a INNER JOIN tbl_partner b USING (partner_id) WHERE order_status <> 'PENDING' AND order_date >= DATE_ADD(order_date, INTERVAL 1 WEEK) ORDER BY order_id DESC LIMIT $offset, $dataPerPage";
      }
      $rs_result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($rs_result)==0) {
      ?>
        <div class="alert alert-info ks-solid text-center" role="alert">Belum ada pesanan</div>
    <?php }else{ ?>    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Daftar Pesanan</h3>
            </div>
            <div class="block-content">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table-responsive table table-bordered" border="1">
                                <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                                <tr>
                                    <td>Tanggal<br/><?php echo $row['order_date'] ?><br/>Kode order:<br/><?php echo $row['order_code'] ?></td>
                                    <td>
                                        <?php 
                                        echo '<b>'.$row['partner_name'].'</b><br/>';
                                         $sql2   = "SELECT product_id, order_code, product_price, sum(order_detail_qty) as qty, sum(order_detail_sub_total) as sub, product_name, product_unit, order_detail_sub_total FROM tbl_order_detail WHERE order_code = '".$row['order_code']."' GROUP BY product_id ORDER BY product_name";
                                        $h2      = mysqli_query($conn, $sql2);
                                        while($row2 = mysqli_fetch_assoc($h2)) {
                                            echo $row2['product_name'].' ('.$row2['qty'].' '.$row2['product_unit'].')<br/>';
                                        }
                                        ?>
                                    <br/>Status order: 
                                        <?php if($row['order_status']=='PENDING') { ?>
                                        <span class="badge badge-secondary"><?php echo $row['order_status'] ?></span>
                                        <?php }elseif ($row['order_status']=='BARU') { ?>
                                        <span class="badge badge-warning"><?php echo $row['order_status'] ?></span>
                                        <?php }elseif ($row['order_status']=='DIPROSES') { ?>
                                        <span class="badge badge-primary"><?php echo $row['order_status'] ?></span>
                                        <?php }elseif ($row['order_status']=='DIKIRIM') { ?>
                                        <span class="badge badge-info"><?php echo $row['order_status'] ?></span>
                                        <?php }else{ ?>
                                        <span class="badge badge-success"><?php echo $row['order_status'] ?></span>
                                        <?php } ?>
                                    <br/>                                                   
                                        <?php if($row['order_status']=='BARU') {?>
                                            <a href="order-confirm?<?php echo $row['order_code'] ?>?1" class="btn btn-alt-success" onclick="return confirm('Anda akan memproses pesanan ini (Kode pesanan <?php echo $row['order_code'] ?>). Tekan OK jika sudah yakin');">PROSES PESANAN</a>
                                        <?php }elseif($row['order_status']=='DIPROSES') {?>
                                            <a href="order-confirm?<?php echo $row['order_code'] ?>?2" class="btn btn-alt-success" onclick="return confirm('Anda akan mengirim pesanan ini (Kode pesanan <?php echo $row['order_code'] ?>). Tekan OK jika sudah yakin');">KIRIM PESANAN</a>
                                        <?php }elseif($row['order_status']=='DIKIRIM') {?>
                                            <a href="order-confirm?<?php echo $row['order_code'] ?>?3" class="btn btn-alt-success" onclick="return confirm('Anda akan mengirim pesanan ini (Kode pesanan <?php echo $row['order_code'] ?>). Tekan OK jika sudah yakin');">TANDAI SAMPAI</a>                        
                                        <?php }elseif($row['invoice_file']=='') { ?>
                                            <a type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal<?php echo $row['order_code'] ?>" href="#">UNGGAH TANDA TERIMA</a>
                                        <?php }else{ ?>
                                            <a href="<?php echo $img_url.'inv/'.$row['invoice_file'] ?>" target="_blank"><img src="<?php echo $img_url.'inv/'.$row['invoice_file'] ?>" width=50 /></a>
                                        <?php } ?>
                                        <!-- Compose Modal -->
                                            <div class="modal fade" id="modal<?php echo $row['order_code'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
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
                                                                <form enctype="multipart/form-data" action="<?php echo $file.'-detail-add-invoice'.$ext ?>" method="POST">
                                                                  <input type="hidden" name="order_code" value="<?php echo $row['order_code']  ?>" />
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating">Ambil Foto Tanda Terima (kode order: <?php echo $row['order_code'] ?></label>
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
                                    </td>     
                                </tr> 
                                <?php } mysqli_free_result($rs_result);?> 
                            </table>
                        </div>
                    </div>
            </div>
        </div>
        <!-- END Small Table -->

        <?php
        // COUNT TOTAL NUMBER OF ROWS IN TABLE
        if(@$_REQUEST['s']=='1091vdf8ame151') {           
          $sql = "SELECT count(department_id) as jumData FROM tbl_department WHERE client_id = '".$_SESSION['client_id']."' AND (department_name LIKE '%$txt_search%')";
        }elseif(@$_REQUEST['s']=='1') {           
          $sql = "SELECT count(department_id) as jumData FROM  tbl_department WHERE client_id = '".$_SESSION['client_id']."'";
        }else{            
          $sql = "SELECT count(order_code) as jumData FROM  tbl_order WHERE partner_id = '".$_SESSION['partner_id']."'";
        }          

        $hasil  = mysqli_query($conn,$sql);
        $data     = mysqli_fetch_assoc($hasil);
        $jumData = $data['jumData'];
        $jumPage = ceil($jumData/$dataPerPage);

        if ($noPage > 1) echo  "<a class=hal href='".$file.$ext."?s=".@$_REQUEST['s']."&client_id=".@$_REQUEST['client_id']."&txt_search=".@$_REQUEST['txt_search']."&page=".($noPage-1)."'><i class=\"fa fa-angle-left\"></i></a>";

        for($page = 1; $page <= $jumPage; $page++)
        {
            if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage))
            {
                if ((@$showPage == 1) && ($page != 2))  echo "...";
                if ((@$showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
                if ($page == $noPage) echo " <b>".$page."</b> ";
                else echo " <a class=hal href='".$file.$ext."?s=".@$_REQUEST['s']."&client_id=".@$_REQUEST['client_id']."&txt_search=".@$_REQUEST['txt_search']."&page=".$page."'>".$page."</a> ";
                @$showPage = $page;
            }
        }

        if ($noPage < $jumPage) echo "<a class=hal href='".$file.$ext."?s=".@$_REQUEST['s']."&client_id=".@$_REQUEST['client_id']."&txt_search=".@$_REQUEST['txt_search']."&page=".($noPage+1)."'><i class=\"fa fa-angle-right\"></i></a>";
        mysqli_free_result($hasil); 
        ?>

    </div>
    <!-- END Page Content -->
    <?php } ?>
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>