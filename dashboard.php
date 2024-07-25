<?php 
require_once 'header.php';
//require_once 'components.php';
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
                    <form action="partners.php" method="post">
                        <input type="hidden" name="s" value="1091vdf8ame151">
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

            <!-- Profile -->
            <div class="block pull-r-l">
                <div class="block-header bg-body-light">
                    <h3 class="block-title">
                        <i class="fa fa-fw fa-pencil font-size-default mr-5"></i>Sort by
                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                    </div>
                </div>
                <div class="block-content">
                    <form action="partners.php" method="post">
                        <div class="form-group mb-15">
                            <div class="form-material floating">
                                <select class="form-control" id="material-select2" name="s">
                                    <option></option><!-- Empty value for demostrating material select box -->
                                    <option value="1">By Partner Name</option>
                                </select>
                                <label for="material-select2">Please Select</label>
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
            <!-- END filter -->
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
        $txt_search   = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
        $sql = "SELECT partner_id, partner_ip, partner_key, partner_secret, partner_name, partner_balance, partner_active_status FROM tbl_partner WHERE (partner_ip LIKE '%$txt_search%' OR partner_key LIKE '%$txt_search%' OR partner_name LIKE '%$txt_search%' OR partner_secret LIKE '%$txt_search%' OR partner_key LIKE '%$txt_search%') LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='1'){
        $sql = "SELECT customer_id, customer_account_id, customer_name, customer_address, customer_email_address, customer_phone_number, customer_active_status, ledger_master_amount, db_evoucher.tbl_partner.partner_name ,date_format(created_date, '%d/%m/%Y') as created_date FROM db_customer.tbl_customer INNER JOIN db_customer.tbl_ledger_master USING (customer_account_id) INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key ORDER BY customer_name LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='2'){
        $sql = "SELECT customer_id, customer_account_id, customer_name, customer_address, customer_email_address, customer_phone_number, customer_active_status, ledger_master_amount, db_evoucher.tbl_partner.partner_name ,date_format(created_date, '%d/%m/%Y') as created_date FROM db_customer.tbl_customer INNER JOIN db_customer.tbl_ledger_master USING (customer_account_id) INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key ORDER BY partner_name LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='3'){
        $sql = "SELECT customer_id, customer_account_id, customer_name, customer_address, customer_email_address, customer_phone_number, customer_active_status, ledger_master_amount, db_evoucher.tbl_partner.partner_name ,date_format(created_date, '%d/%m/%Y') as created_date FROM db_customer.tbl_customer INNER JOIN db_customer.tbl_ledger_master USING (customer_account_id) INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key ORDER BY customer_active_status LIMIT $offset, $dataPerPage";                        
      }else{
        $sql = "SELECT partner_id, partner_ip, partner_key, partner_secret, partner_name, partner_balance, partner_active_status, partner_deposit_type FROM tbl_partner LIMIT $offset, $dataPerPage";
      }
      $rs_result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($rs_result)==0) {
      ?>
        <div class="alert alert-info ks-solid text-center" role="alert">Oops, no data found</div>
      <?php  
      //exit(); 
      }
      ?>    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Partners</h3>
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
                            <th>Partner Name</th>
                            <th>IP Address</th>
                            <th>Key</th>
                            <th>Secret</th>
                            <th>Balance</th>
                            <th>Deposit Type</th>
                            <th>Active Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                        <tr>
                            <td><?php echo $row['partner_name'] ?></td>
                            <td><?php echo $row['partner_ip'] ?></td>
                            <td><?php echo $row['partner_key'] ?></td>
                            <td><?php echo $row['partner_secret'] ?></td>
                            <td><?php echo 'Rp. '.number_format($row['partner_balance'],0,",",".") ?></td>
                            <td><?php echo $row['partner_deposit_type'] ?></td>
                            <td>
                                <?php if($row['partner_active_status']=='Y') { ?>
                                    <span class="badge badge-success">active</span>
                                <?php }else{ ?>
                                    <span class="badge badge-danger">inactive</span>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="partner-detail.php?act=29dvi59&ntf=29dvi59-<?php echo $row["partner_id"]?>-94dfvj!sdf-349ffuaw">edit</a>&nbsp;|&nbsp;<a href="partner-history.php?act=29dvi59&ntf=29dvi59-<?php echo $row["partner_key"]?>-94dfvj!sdf-349ffuaw">history</a>
                                </div>
                            </td>
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
          $sql = "SELECT count(partner_id) as jumData FROM tbl_partner  WHERE (partner_ip LIKE '%$txt_search%' OR partner_key LIKE '%$txt_search%' OR partner_name LIKE '%$txt_search%' OR partner_secret LIKE '%$txt_search%' OR partner_key LIKE '%$txt_search%')";
        }elseif(@$_REQUEST['s']=='1') {           
          $sql = "SELECT count(customer_id) as jumData FROM db_customer.tbl_customer INNER JOIN db_customer.tbl_ledger_master USING (customer_account_id) INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key ORDER BY customer_name";
        }elseif(@$_REQUEST['s']=='2') {           
          $sql = "SELECT count(customer_id) as jumData FROM db_customer.tbl_customer INNER JOIN db_customer.tbl_ledger_master USING (customer_account_id) INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key ORDER BY partner_name";
        }elseif(@$_REQUEST['s']=='3') {           
          $sql = "SELECT count(customer_id) as jumData FROM db_customer.tbl_customer INNER JOIN db_customer.tbl_ledger_master USING (customer_account_id) INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key ORDER BY customer_active_status";                    
        }else{            
          $sql = "SELECT count(partner_id) as jumData FROM tbl_partner";
        }          

        $hasil  = mysqli_query($conn,$sql);
        $data     = mysqli_fetch_assoc($hasil);
        $jumData = $data['jumData'];
        $jumPage = ceil($jumData/$dataPerPage);

        if ($noPage > 1) echo  "<a class=hal href='".$_SERVER['PHP_SELF']."?s=".@$_REQUEST['s']."&client_id=".@$_REQUEST['client_id']."&txt_search=".@$_REQUEST['txt_search']."&page=".($noPage-1)."'><i class=\"fa fa-angle-left\"></i></a>";

        for($page = 1; $page <= $jumPage; $page++)
        {
            if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage))
            {
                if ((@$showPage == 1) && ($page != 2))  echo "...";
                if ((@$showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
                if ($page == $noPage) echo " <b>".$page."</b> ";
                else echo " <a class=hal href='".$_SERVER['PHP_SELF']."?s=".@$_REQUEST['s']."&client_id=".@$_REQUEST['client_id']."&txt_search=".@$_REQUEST['txt_search']."&page=".$page."'>".$page."</a> ";
                @$showPage = $page;
            }
        }

        if ($noPage < $jumPage) echo "<a class=hal href='".$_SERVER['PHP_SELF']."?s=".@$_REQUEST['s']."&client_id=".@$_REQUEST['client_id']."&txt_search=".@$_REQUEST['txt_search']."&page=".($noPage+1)."'><i class=\"fa fa-angle-right\"></i></a>";
        mysqli_free_result($hasil); 
        ?>

    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>
