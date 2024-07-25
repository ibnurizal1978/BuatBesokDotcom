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
        $sql = "SELECT product_id, order_code, product_price, sum(order_detail_qty) as qty, sum(order_detail_sub_total) as sub, product_name, product_unit, order_detail_sub_total FROM tbl_order_detail WHERE order_detail_status = 'BARU' GROUP BY product_id ORDER BY product_name";
      }

      $sql_tot   = "SELECT sum(order_detail_sub_total) as total FROM tbl_order_detail WHERE order_detail_status = 'BARU' LIMIT 1";
      $h_tot     = mysqli_query($conn, $sql_tot);
      $row_tot   = mysqli_fetch_assoc($h_tot);

      $rs_result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($rs_result)==0) {
      ?>
        <div class="alert alert-info ks-solid text-center" role="alert">Belum ada pesanan</div>
    <?php }else{ ?>    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Pesanan Baru | <a href="order">Ke Daftar Order</a></h3>
            </div>
            <div class="block-content">
                <table class="table table-sm table-vcenter">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Qty (KG)</th>
                            <th>Harga</th>
                            <th style="text-align:right">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                        <tr>  
                            <td width="60%"><?php echo $row['product_name'] ?></td>
                            <td><?php echo $row['qty'].' '.$row['product_unit'] ?></td>
                            <td><?php echo number_format($row['product_price'],0,",",".") ?></td>
                            <td style="text-align:right"><?php echo 'Rp. '.number_format($row['sub'],0,",",".") ?></td>
                        </tr>
                        <?php } mysqli_free_result($rs_result); ?>
                        <tr>
                            <td style="text-align:right" colspan="3"><b class="text-success">TOTAL PESANAN:</b></td>
                            <td style="text-align:right"><b class="text-success"><?php echo 'Rp. '.number_format($row_tot['total'],0,",",".") ?></b></td>
                        </tr>                                                    
                    </tbody>
                </table>
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