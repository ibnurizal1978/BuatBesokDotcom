<?php 
require_once 'header.php';
//require_once 'components.php';
?>
<!--separator credit limit-->
<script type='text/javascript'>
function Comma(Num)
 {
       Num += '';
       Num = Num.replace(/,/g, '');
       x = Num.split('.');
       x1 = x[0];
       x2 = x.length > 1 ? '.' + x[1] : '';

         var rgx = /(\d)((\d{3}?)+)$/;

       while (rgx.test(x1))
       x1 = x1.replace(rgx, '$1' + ',' + '$2');    
       return x1 + x2;              
 }
  </script>
<!--end separator credit limit-->

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
                    <form action="<?php echo $file.$ext ?>" method="GET">
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
                    <form action="<?php echo $file.$ext ?>" method="GET">
                        <div class="form-group mb-15">
                            <div class="form-material floating">
                                <select class="form-control" id="material-select2" name="s">
                                    <option></option><!-- Empty value for demostrating material select box -->
                                    <option value="1">By Name A-Z</option>
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
    <!--begin list data-->
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
        $sql = "SELECT a.country_id, a.region_id, b.region_name,a.client_id,a.client_business_name,a.client_address,a.client_address_detail,a.client_email_address,a.client_phone,a.client_discount_rate,a.client_credit_limit,a.client_top,a.client_active_status,a.client_currency,a.currency_id,a.client_type,b.region_name,c.country_name FROM tbl_client a INNER JOIN tbl_region b ON a.region_id = b.region_id INNER JOIN tbl_country c ON a.country_id = c.country_id WHERE (client_business_name LIKE '%$txt_search%' OR client_address LIKE '%$txt_search%') AND owner_id = '".$_SESSION['client_id']."' ORDER BY client_business_name LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='1'){
        $sql = "SELECT a.country_id, a.region_id, c.region_name,a.client_id,a.client_business_name,a.client_address,a.client_address_detail,a.client_email_address,a.client_phone,a.client_discount_rate,a.client_credit_limit,a.client_top,a.client_active_status,a.client_currency,b.country_name FROM tbl_client a INNER JOIN tbl_country b USING (country_id) INNER JOIN tbl_region c USING (region_id) WHERE owner_id = '".$_SESSION['client_id']."' ORDER BY client_business_name LIMIT $offset, $dataPerPage";     
      }else{
        $sql = "SELECT partner_id, partner_name, partner_key, partner_phone_number, partner_email_address, partner_discount_rate, active_status, partner_photo, partner_ktp, partner_photo_ktp, completed_status FROM tbl_partner a ORDER BY partner_name LIMIT $offset, $dataPerPage";
      }
      $rs_result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($rs_result)==0) {
      ?>
        <div class="alert alert-info ks-solid text-center" role="alert">Oops, no data found</div>
    <?php } ?>    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Mitra <!--<a data-toggle="modal" data-target="#modal-add" href="#">[add]</a>--> <a  href="<?php echo $file.$ext ?>">[view all]</a></h3>
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
                            <th>Name</th>  
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th class="text-center">Selfie Photo?</th>
                            <th class="text-center">ID Card Photo?</th>
                            <th class="text-center">Selfie + ID Card Photo?</th>
                            <th class="text-center">Approved Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                        <tr>                            
                            <td><?php echo $row["partner_name"]; ?></td>  
                            <td><?php echo $row['partner_address'] ?></td>
                            <td><?php echo $row['partner_email_address'] ?></td>
                            <td><?php echo $row['partner_phone_number'] ?></td>
                            <td class="text-center">
                              <?php if($row['partner_photo']<>'') { ?>
                                <a target="_blank" href="<?php echo $img_url.$row['partner_photo'] ?>"><img src="<?php echo $img_url.$row['partner_photo'] ?>" width=80 /></a>
                              <?php } ?>
                            </td>
                            <td class="text-center">
                              <?php if($row['partner_ktp']<>'') { ?>
                                <a target="_blank" href="<?php echo $img_url.$row['partner_ktp'] ?>"><img src="<?php echo $img_url.$row['partner_ktp'] ?>" width=80 /></a>
                              <?php } ?>
                            </td>
                            <td class="text-center">
                              <?php if($row['partner_photo_ktp']<>'') { ?>
                                <a target="_blank" href="<?php echo $img_url.$row['partner_photo_ktp'] ?>"><img src="<?php echo $img_url.$row['partner_photo_ktp'] ?>" width=80 /></a>
                              <?php } ?>
                            </td>                                                        
                            <td class="text-center">
                                <?php if($row['completed_status']==1) { ?>
                                    <span class="badge badge-success">approved</span>
                                <?php }else{ ?>
                                    <span class="badge badge-danger">not yet</span>
                                <?php } ?>                                
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal-edit<?php echo $row['partner_id'] ?>" href="#">edit
                                    </a>                                                                       
                                </div>
                            </td>
                            <!-- Compose Modal -->
                            <div class="modal fade" id="modal-edit<?php echo $row['partner_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true"> 
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="block block-themed block-transparent mb-0">
                                            <div class="block-header">
                                                <h3 class="block-title">
                                                  <i class="fa fa-pencil mr-5"></i> Edit Mitra <?php echo $row['partner_name'] ?>
                                                </h3>
                                                <div class="block-options">
                                                  <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                      <i class="si si-close"></i>
                                                  </button>
                                                </div>
                                            </div>
                                            <div class="block-content">
                                                <form action="<?php echo $file.'-edit'.$ext ?>" method="POST">
                                                    <input type="hidden" name="partner_id" value="<?php echo $row['partner_id'] ?>">

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                              <label>Discount Rate</label>
                                                              <input type="text" class="form-control" name="partner_discount_rate" value="0" value="<?php echo $row['partner_discount_rate'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                              <label>Approved Status</label>
                                                              <select class="form-control" required name="completed_status">
                                                                <?php if($row['completed_status']==1) {?>
                                                                <option value="1" selected="selected">Approve</option>
                                                                <option value="0">No</option>
                                                                <?php }else{ ?>
                                                                <option value="1">Approve</option>
                                                                <option value="0" selected="selected">No</option>
                                                                <?php } ?>
                                                              </select>
                                                            </div>
                                                        </div>                                                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                              <label>Active Status</label>
                                                              <select class="form-control" required name="active_status">
                                                                <?php if($row['active_status']==1) {?>
                                                                <option value="1" selected="selected">Yes</option>
                                                                <option value="0">No</option>
                                                                <?php }else{ ?>
                                                                <option value="1">Yes</option>
                                                                <option value="0" selected="selected">No</option>
                                                                <?php } ?>
                                                              </select>
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
          $sql = "SELECT count(a.client_id) as jumData FROM tbl_client a INNER JOIN tbl_country b USING (country_id) INNER JOIN tbl_region c USING (region_id) WHERE (client_business_name LIKE '%$txt_search%' OR client_address LIKE '%$txt_search%') AND a.owner_id = '".$_SESSION['client_id']."'";
        }elseif(@$_REQUEST['s']=='1') {           
          $sql = "SELECT count(a.client_id) as jumData FROM  tbl_client a INNER JOIN tbl_country b USING (country_id) INNER JOIN tbl_region c USING (region_id) WHERE a.owner_id = '".$_SESSION['client_id']."'";
        }else{            
          $sql = "SELECT count(a.client_id) as jumData FROM  tbl_client a INNER JOIN tbl_country b USING (country_id) INNER JOIN tbl_region c USING (region_id) WHERE a.owner_id = '".$_SESSION['client_id']."'";
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
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>

<!-- Compose Modal -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header">
                    <h3 class="block-title">
                      <i class="fa fa-pencil mr-5"></i> Create New Mitra
                    </h3>
                    <div class="block-options">
                      <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                          <i class="si si-close"></i>
                      </button>
                    </div>
                </div>
                <div class="block-content">
                    <form action="<?php echo $file.'-add'.$ext ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">                        
                                <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" class="form-control" required name="client_business_name">
                                </div>
                            </div>
                            
                            <div class="col-md-6"> 
                                <div class="form-group">
                                  <label>Email</label>
                                  <input type="email" class="form-control" name="client_email_address">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>Address</label>
                                  <input type="text" class="form-control" name="client_address">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>Address Detail</label>
                                  <input type="text" class="form-control"  name="client_address_detail">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Phone</label>
                                  <input type="text" class="form-control" name="client_phone">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Discount Rate</label>
                                  <input type="text" class="form-control" name="client_discount_rate" value="0">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Credit Limit (<?php echo $_SESSION['client_currency'] ?>)</label>
                                  <input type="text" class="form-control" name="client_credit_limit" onkeyup="javascript:this.value=Comma(this.value);">
                                </div>
                            </div>                                
                        </div>

                        <div class="row">
                            <div class="col-md-4">                            
                                <div class="form-group">
                                  <label>Country</label>
                                  <select class="form-control" required name="country_id">
                                    <?php
                                    $sql  = "SELECT * FROM tbl_country ORDER BY country_name";
                                    $h    = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($h)) {
                                    ?> 
                                    <option value="<?php echo $row['country_id'] ?>"><?php echo $row['country_name'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Region</label>
                                  <select class="form-control" required name="region_id">
                                    <?php
                                    $sql  = "SELECT * FROM tbl_region WHERE client_id = '".$_SESSION['client_id']."' ORDER BY region_name";
                                    $h    = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($h)) {
                                    ?> 
                                    <option value="<?php echo $row['region_id'] ?>"><?php echo $row['region_name'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Active Status </label>
                                  <select class="form-control" required name="client_active_status">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                  </select>
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