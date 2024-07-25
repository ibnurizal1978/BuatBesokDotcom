<?php 
require_once 'header.php';
if($ntf[1]<>'') {
    $partner_key = $ntf[1];
}else{
    $partner_key = @$_REQUEST['partner_key'];
}

$sql1   = "SELECT partner_name FROM tbl_partner WHERE partner_key = '".$partner_key."' LIMIT 1";
$h1     = mysqli_query($conn, $sql1);
$row1   = mysqli_fetch_assoc($h1);
?>

<!-- Side Overlay-->
<aside id="side-overlay">
    <!-- Side Overlay Scroll Container -->
    <div id="side-overlay-scroll">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow">
            <div class="content-header-section align-parent">
                <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                    <i class="fa fa-times text-danger"></i>
                </button>

                <div class="content-header-item">
                    <a class="align-middle link-effect text-primary-dark font-w600" href="#">Filter</a>
                </div>
                <!-- END User Info -->
            </div>
        </div>
        <!-- END Side filter -->

        <!-- side kanan -->
        <div class="content-side">
            <!-- Search -->
            <div class="block pull-t pull-r-l">
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <form action="partner-history.php" method="post">
                        <input type="hidden" name="s" value="1091vdf8ame151">
                        <input type="hidden" name="partner_key" value="<?php echo $partner_key ?>">
                        <div class="input-group">
                            <input type="text" class="form-control" id="side-overlay-search" name="txt_search" placeholder="Search..">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary px-10">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Search -->

            <!-- Display ledger type -->
            <div class="block pull-r-l">
                <div class="block-header bg-body-light">
                    <h3 class="block-title">
                        <i class="fa fa-fw fa-pencil font-size-default mr-5"></i>View by Date
                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                    </div>
                </div>
                <div class="block-content">
                    <form action="partner-history.php" method="post">
                        <input type="hidden" name="s" value="1">
                        <input type="hidden" name="partner_key" value="<?php echo $partner_key ?>" />
                        <div class="form-group mb-15">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="created_date" name="created_date" />
                                <label for="material-select2">Input date (dd/mm/yyyy)</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-block btn-alt-primary">
                                    <i class="fa fa-refresh mr-5"></i> View
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Display ledger type -->


        </div>
        <!-- END Side filter -->
    </div>
    <!-- END Side Overlay Scroll Container -->
</aside>
<!-- END Side Overlay -->

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content">
    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Transaction History: <?php echo $row1['partner_name'] ?></h3>
                <div class="block-options">
                    <div class="block-options-item">
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="block-content">
                  <?php
                  @$page = @$_REQUEST['page'];
                  $dataPerPage = 30;
                  if(isset($_GET['page']))
                  {
                      $noPage = $_GET['page'];
                  }
                  else $noPage = 1;
                  @$offset = ($noPage - 1) * $dataPerPage;
                  //for total count data
                    if(@$_REQUEST['s']=='1091vdf8ame151') {
                        $txt_search         = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
                        $partner_key        = input_data(filter_var($_REQUEST['partner_key'],FILTER_SANITIZE_STRING));
                        $sql = "SELECT trx_id, trx_type, partner_key, customer_phone_number, trx_amount, DATE_FORMAT(DATE_ADD(created_date,INTERVAL '7' HOUR), '%d/%m/%Y on %H:%i') as created_date, merchant_name, payment_channel, trx_purchase_item, sn_client, sn_trx FROM tbl_trx INNER JOIN tbl_merchant_code USING (merchant_code)  WHERE partner_key = '".$partner_key."' AND (trx_type LIKE '%$txt_search%' OR customer_phone_number LIKE '%$txt_search%' OR sn_trx LIKE '%$txt_search%' OR sn_client LIKE '%$txt_search%' OR merchant_name LIKE '%$txt_search%' OR payment_channel LIKE '%$txt_search%') LIMIT $offset, $dataPerPage";
                    }elseif (@$_REQUEST['s']=='1'){
                        $txt_search         = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
                        $partner_key        = input_data(filter_var($_REQUEST['partner_key'],FILTER_SANITIZE_STRING));
                        $created_date       = input_data(filter_var($_REQUEST['created_date'],FILTER_SANITIZE_STRING));
                        $created_date_y     = substr($created_date,6,4);
                        $created_date_m     = substr($created_date,3,2);
                        $created_date_d     = substr($created_date,0,2);
                        $created_date_f     = $created_date_y.'-'.$created_date_m.'-'.$created_date_d;

                        $sql  = "SELECT trx_id, trx_type, partner_key, customer_phone_number, trx_amount, DATE_FORMAT(DATE_ADD(created_date,INTERVAL '7' HOUR), '%d/%m/%Y on %H:%i') as created_date, merchant_name, payment_channel, trx_purchase_item, sn_client, sn_trx FROM tbl_trx INNER JOIN tbl_merchant_code USING (merchant_code)  WHERE partner_key = '".$partner_key."' AND date(created_date) = '".$created_date_f."' LIMIT $offset, $dataPerPage";
                    }else{
                        $sql = "SELECT trx_id, trx_type, partner_key, customer_phone_number, trx_amount, DATE_FORMAT(DATE_ADD(created_date,INTERVAL '7' HOUR), '%d/%m/%Y on %H:%i') as created_date, merchant_name, payment_channel, trx_purchase_item, sn_client, sn_trx FROM tbl_trx INNER JOIN tbl_merchant_code USING (merchant_code)  WHERE partner_key = '".$partner_key."' LIMIT $offset, $dataPerPage";
                    }
                  $rs_result = mysqli_query($conn, $sql);
                  if(mysqli_num_rows($rs_result)==0) {
                  ?>
                    <div class="alert alert-info ks-solid text-center" role="alert">Oops, no data found</div>
                  <?php  
                  //exit(); 
                  }
                  ?>                
                <table class="table table-sm table-vcenter">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Trx Type</th>
                            <th>Account ID</th>
                            <th>Amount</th>
                            <th>Merchant Code</th>
                            <th>Payment Channel</th>
                            <th>Purchase Item</th>
                            <th>SN Client</th>
                            <th>SN Trx</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                        <tr>
                            <td><?php echo $row['created_date'] ?></td>
                            <td><?php echo $row['trx_type'] ?></td>
                            <td><?php echo $row['customer_phone_number'] ?></td>
                            <td><?php 'Rp. '.number_format($row['trx_amount'],0,",",".") ?></td>
                            <td><?php echo $row['merchant_name'] ?></td>
                            <td><?php echo $row['payment_channel'] ?></td>
                            <td><?php echo $row['trx_purchase_item'] ?></td>
                            <td><?php echo $row['sn_client'] ?></td>
                            <td><?php echo $row['sn_trx'] ?></td>
                        </tr>
                        <?php } mysqli_free_result($rs_result); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Small Table -->

        <?php
        // COUNT TOTAL NUMBER OF ROWS IN TABLE
        if(@$_REQUEST['s']=='1091vdf8ame151') {
            $txt_search            = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
            $partner_key   = input_data(filter_var($_REQUEST['partner_key'],FILTER_SANITIZE_STRING));                   
          $sql = "SELECT count(trx_id) as jumData FROM tbl_trx INNER JOIN tbl_merchant_code USING (merchant_code)  WHERE partner_key = '".$partner_key."' AND (trx_type LIKE '%$txt_search%' OR customer_phone_number LIKE '%$txt_search%' OR sn_trx LIKE '%$txt_search%' OR sn_client LIKE '%$txt_search%' OR merchant_name LIKE '%$txt_search%' OR payment_channel LIKE '%$txt_search%')";
        }elseif(@$_REQUEST['s']=='1') {
            $txt_search            = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
            $partner_key   = input_data(filter_var($_REQUEST['partner_key'],FILTER_SANITIZE_STRING));
            $ledger_date           = input_data(filter_var($_REQUEST['ledger_date'],FILTER_SANITIZE_STRING));
            $ledger_date_y   = substr($ledger_date,6,4);
            $ledger_date_m   = substr($ledger_date,3,2);
            $ledger_date_d   = substr($ledger_date,0,2);
            $ledger_date_f   = $ledger_date_y.'-'.$ledger_date_m.'-'.$ledger_date_d;

          $sql = "SELECT count(trx_id) as jumData FROM tbl_trx WHERE partner_key = '".$partner_key."' AND date(created_date) = '".$created_date_f."'";                    
        }else{            
          $sql = "SELECT count(trx_id) as jumData FROM tbl_trx FROM tbl_trx  WHERE partner_key = '".$partner_key."'";
        }          

        $hasil  = mysqli_query($conn,$sql);
        $data     = mysqli_fetch_assoc($hasil);
        $jumData = $data['jumData'];
        $jumPage = ceil($jumData/$dataPerPage);

        if ($noPage > 1) echo  "<a class=hal href='".$_SERVER['PHP_SELF']."?s=".@$_REQUEST['s']."&partner_key=".@$_REQUEST['partner_key']."&ledger_date=".@$_REQUEST['ledger_date']."&txt_search=".@$_REQUEST['txt_search']."&page=".($noPage-1)."'><i class=\"fa fa-angle-left\"></i></a>";

        for($page = 1; $page <= $jumPage; $page++)
        {
            if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage))
            {
                if ((@$showPage == 1) && ($page != 2))  echo "...";
                if ((@$showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
                if ($page == $noPage) echo " <b>".$page."</b> ";
                else echo " <a class=hal href='".$_SERVER['PHP_SELF']."?s=".@$_REQUEST['s']."&partner_key=".@$_REQUEST['partner_key']."&ledger_date=".@$_REQUEST['ledger_date']."&txt_search=".@$_REQUEST['txt_search']."&page=".$page."'>".$page."</a> ";
                @$showPage = $page;
            }
        }

        if ($noPage < $jumPage) echo "<a class=hal href='".$_SERVER['PHP_SELF']."?s=".@$_REQUEST['s']."&partner_key=".@$_REQUEST['partner_key']."&ledger_date=".@$_REQUEST['ledger_date']."&txt_search=".@$_REQUEST['txt_search']."&page=".($noPage+1)."'><i class=\"fa fa-angle-right\"></i></a>";
        mysqli_free_result($hasil); 
        ?>

    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>

<script type="text/javascript">
$(document).ready(function() {
  $("#created_date").attr("maxlength", 10);
  $("#created_date").keyup(function(){
      if ($(this).val().length == 2){
          $(this).val($(this).val() + "/");
      }else if ($(this).val().length == 5){
          $(this).val($(this).val() + "/");
      }
  });
});    
</script>
