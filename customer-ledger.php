<?php 
require_once 'header.php';
if($ntf[1]<>'') {
    $customer_account_id = $ntf[1];
}else{
    $customer_account_id = @$_REQUEST['customer_account_id'];
}
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
                    <form action="customer-ledger.php" method="post">
                        <input type="hidden" name="s" value="1091vdf8ame151">
                        <input type="hidden" name="customer_account_id" value="<?php echo $customer_account_id ?>">
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
                    <form action="customer-ledger.php" method="post">
                        <input type="hidden" name="s" value="1">
                        <input type="hidden" name="customer_account_id" value="<?php echo $customer_account_id ?>" />
                        <div class="form-group mb-15">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="ledger_date" name="ledger_date" />
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

    <!-- Small Table -->
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
            $txt_search            = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
            $customer_account_id   = input_data(filter_var($_REQUEST['customer_account_id'],FILTER_SANITIZE_STRING));
            $sql = "SELECT  ledger_type, DATE_FORMAT(DATE_ADD(ledger_date,INTERVAL '".$_SESSION['selisih']."' HOUR), '%d/%m/%Y on %H:%i') as ledger_date, ledger_description, ledger_amount, customer_account_id, ledger_source, sn_client, sn_trx FROM tbl_ledger WHERE customer_account_id = '".$customer_account_id."' AND (ledger_type LIKE '%$txt_search%' OR ledger_description LIKE '%$txt_search%' OR sn_trx LIKE '%$txt_search%' OR sn_client LIKE '%$txt_search%' OR ledger_source LIKE '%$txt_search%') LIMIT $offset, $dataPerPage";
        }elseif (@$_REQUEST['s']=='1'){
            $txt_search            = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
            $customer_account_id   = input_data(filter_var($_REQUEST['customer_account_id'],FILTER_SANITIZE_STRING));
            $ledger_date           = input_data(filter_var($_REQUEST['ledger_date'],FILTER_SANITIZE_STRING));
            $ledger_date_y   = substr($ledger_date,6,4);
            $ledger_date_m   = substr($ledger_date,3,2);
            $ledger_date_d   = substr($ledger_date,0,2);
            $ledger_date_f   = $ledger_date_y.'-'.$ledger_date_m.'-'.$ledger_date_d;

            $sql  = "SELECT ledger_type, DATE_FORMAT(DATE_ADD(ledger_date,INTERVAL '".$_SESSION['selisih']."' HOUR), '%d/%m/%Y on %H:%i') as ledger_date, ledger_description, ledger_amount, customer_account_id, ledger_source, sn_client, sn_trx FROM tbl_ledger WHERE customer_account_id = '".$customer_account_id."' AND date(ledger_date) = '".$ledger_date_f."' LIMIT $offset, $dataPerPage";
        }else{
            $sql = "SELECT ledger_type, DATE_FORMAT(DATE_ADD(ledger_date,INTERVAL '".$_SESSION['selisih']."' HOUR), '%d/%m/%Y on %H:%i') as ledger_date, ledger_description, ledger_amount, customer_account_id, ledger_source, sn_client, sn_trx FROM tbl_ledger WHERE customer_account_id = '".$customer_account_id."' LIMIT $offset, $dataPerPage";
        }
      $rs_result = mysqli_query($conn2, $sql);
      if(mysqli_num_rows($rs_result)==0) {
      ?>
        <div class="alert alert-info ks-solid text-center" role="alert">Oops, no data found</div>
      <?php  
      //exit(); 
      }
      ?>    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Ledger</h3>
                <div class="block-options">
                    <div class="block-options-item">
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-sm table-vcenter">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Ledger Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Source</th>
                            <th>SN Client</th>
                            <th>SN Trx</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                        <tr>
                            <td><?php echo $row['ledger_date'] ?></td>
                            <td><?php echo $row['ledger_type'] ?></td>
                            <td><?php echo $row['ledger_description'] ?></td>
                            <td><?php 'Rp. '.number_format($row['ledger_amount'],0,",",".") ?></td>
                            <td><?php echo $row['ledger_source'] ?></td>
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
            $customer_account_id   = input_data(filter_var($_REQUEST['customer_account_id'],FILTER_SANITIZE_STRING));                   
          $sql = "SELECT count(ledger_id) as jumData FROM tbl_ledger WHERE customer_account_id = '".$customer_account_id."' AND (ledger_type LIKE '%$txt_search%' OR ledger_description LIKE '%$txt_search%' OR sn_trx LIKE '%$txt_search%' OR sn_client LIKE '%$txt_search%' OR ledger_source LIKE '%$txt_search%')";
        }elseif(@$_REQUEST['s']=='1') {
            $txt_search            = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
            $customer_account_id   = input_data(filter_var($_REQUEST['customer_account_id'],FILTER_SANITIZE_STRING));
            $ledger_date           = input_data(filter_var($_REQUEST['ledger_date'],FILTER_SANITIZE_STRING));
            $ledger_date_y   = substr($ledger_date,6,4);
            $ledger_date_m   = substr($ledger_date,3,2);
            $ledger_date_d   = substr($ledger_date,0,2);
            $ledger_date_f   = $ledger_date_y.'-'.$ledger_date_m.'-'.$ledger_date_d;

          $sql = "SELECT count(customer_id) as jumData FROM tbl_ledger WHERE customer_account_id = '".$customer_account_id."' AND date(ledger_date) = '".$ledger_date_f."'";                    
        }else{            
          $sql = "SELECT count(ledger_id) as jumData FROM tbl_ledger WHERE customer_account_id = '".$customer_account_id."'";
        }          

        $hasil  = mysqli_query($conn,$sql);
        $data     = mysqli_fetch_assoc($hasil);
        $jumData = $data['jumData'];
        $jumPage = ceil($jumData/$dataPerPage);

        if ($noPage > 1) echo  "<a class=hal href='".$_SERVER['PHP_SELF']."?s=".@$_REQUEST['s']."&customer_account_id=".@$_REQUEST['customer_account_id']."&ledger_date=".@$_REQUEST['ledger_date']."&txt_search=".@$_REQUEST['txt_search']."&page=".($noPage-1)."'><i class=\"fa fa-angle-left\"></i></a>";

        for($page = 1; $page <= $jumPage; $page++)
        {
            if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage))
            {
                if ((@$showPage == 1) && ($page != 2))  echo "...";
                if ((@$showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
                if ($page == $noPage) echo " <b>".$page."</b> ";
                else echo " <a class=hal href='".$_SERVER['PHP_SELF']."?s=".@$_REQUEST['s']."&customer_account_id=".@$_REQUEST['customer_account_id']."&ledger_date=".@$_REQUEST['ledger_date']."&txt_search=".@$_REQUEST['txt_search']."&page=".$page."'>".$page."</a> ";
                @$showPage = $page;
            }
        }

        if ($noPage < $jumPage) echo "<a class=hal href='".$_SERVER['PHP_SELF']."?s=".@$_REQUEST['s']."&customer_account_id=".@$_REQUEST['customer_account_id']."&ledger_date=".@$_REQUEST['ledger_date']."&txt_search=".@$_REQUEST['txt_search']."&page=".($noPage+1)."'><i class=\"fa fa-angle-right\"></i></a>";
        mysqli_free_result($hasil); 
        ?>

    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>

<script type="text/javascript">
$(document).ready(function() {
  $("#ledger_date").attr("maxlength", 10);
  $("#ledger_date").keyup(function(){
      if ($(this).val().length == 2){
          $(this).val($(this).val() + "/");
      }else if ($(this).val().length == 5){
          $(this).val($(this).val() + "/");
      }
  });
});    
</script>
