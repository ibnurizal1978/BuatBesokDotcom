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
                    <form action="<?php echo $file.$ext ?>" method="get">
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
                    <form action="<?php echo $file.$ext ?>" method="get">
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
        $sql = "SELECT  discount_rate_id, discount_rate_name, discount_rate_amount,  date_format(discount_rate_start_date, '%d/%m/%Y') as discount_rate_start_date, date_format(discount_rate_end_date, '%d/%m/%Y') as discount_rate_end_date, full_name FROM tbl_discount_rate a INNER JOIN tbl_user b USING (user_id) WHERE (discount_rate_name LIKE '%$txt_search%') AND a.client_id = '".$_SESSION['client_id']."' LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='1'){
        $sql = "SELECT discount_rate_id, discount_rate_name, discount_rate_amount,  date_format(discount_rate_start_date, '%d/%m/%Y') as discount_rate_start_date, date_format(discount_rate_end_date, '%d/%m/%Y') as discount_rate_end_date, full_name FROM tbl_discount_rate a INNER JOIN tbl_user b USING (user_id) WHERE a.client_id = '".$_SESSION['client_id']."' ORDER BY discount_rate_name LIMIT $offset, $dataPerPage";     
      }else{
        $sql = "SELECT discount_rate_id, discount_rate_name, discount_rate_amount, date_format(discount_rate_start_date, '%d/%m/%Y') as discount_rate_start_date, date_format(discount_rate_end_date, '%d/%m/%Y') as discount_rate_end_date, full_name FROM tbl_discount_rate a INNER JOIN tbl_user b USING (user_id) WHERE a.client_id = '".$_SESSION['client_id']."' ORDER BY discount_rate_name LIMIT $offset, $dataPerPage";
      }
      $rs_result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($rs_result)==0) {
      ?>
        <div class="alert alert-info ks-solid text-center" role="alert">Oops, no data found</div>
    <?php } ?>    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Discount Rate <a data-toggle="modal" data-target="#modal-add" href="#">[add]</a> <a  href="<?php echo $file.$ext ?>">[view all]</a></h3>
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
                            <th>Discount Name</th>
                            <th>Amount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Created By</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                        <tr>
                            <td><?php echo $row['discount_rate_name'] ?></td>                            
                            <td><?php echo $row['discount_rate_amount'] ?>%</td>
                            <td><?php echo $row['discount_rate_start_date'] ?></td> 
                            <td><?php echo $row['discount_rate_end_date'] ?></td> 
                            <td><?php echo $row['full_name'] ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal-edit<?php echo $row['discount_rate_id'] ?>" href="#">edit
                                    </a>                                                                       
                                </div>
                            </td>
                            <!-- Compose Modal -->
                            <div class="modal fade" id="modal-edit<?php echo $row['discount_rate_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true"> 
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="block block-themed block-transparent mb-0">
                                            <div class="block-header">
                                                <h3 class="block-title">
                                                  <i class="fa fa-pencil mr-5"></i> Edit Discount Rate <?php echo $row['discount_rate_name'] ?>
                                                </h3>
                                                <div class="block-options">
                                                  <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                      <i class="si si-close"></i>
                                                  </button>
                                                </div>
                                            </div>
                                            <div class="block-content">
                                                <form action="<?php echo $file.'-edit'.$ext ?>" method="POST">
                                                    <input type="hidden" name="discount_rate_id" value="<?php echo $row['discount_rate_id'] ?>">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating">Discount Rate Name (max. 20 characters)</label>
                                                                <input type="text" class="form-control" name="discount_rate_name" value="<?php echo $row['discount_rate_name'] ?>" maxlength=20 autocomplete="off" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating">Amount (In %. Type number only)</label>
                                                                <input type="text" class="form-control" name="discount_rate_amount" value="<?php echo $row['discount_rate_amount'] ?>" autocomplete="off" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating">Start Date (dd/mm/yyyy)</label>
                                                                <input type="text" class="form-control" name="discount_rate_start_date"  id="discount_rate_start_date" value="<?php echo $row['discount_rate_start_date'] ?>" autocomplete="off" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating">End Date (dd/mm/yyyy)</label>
                                                                <input type="text" class="form-control" name="discount_rate_end_date" id="discount_rate_end_date" value="<?php echo $row['discount_rate_end_date'] ?>" autocomplete="off" />
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
          $sql = "SELECT count(discount_rate_id) as jumData FROM tbl_discount_rate a INNER JOIN tbl_user b USING (user_id)  WHERE a.client_id = '".$_SESSION['client_id']."' AND (discount_rate_name LIKE '%$txt_search%')";
        }elseif(@$_REQUEST['s']=='1') {           
          $sql = "SELECT count(discount_rate_id) as jumData FROM tbl_discount_rate a INNER JOIN tbl_user b USING (user_id) WHERE a.client_id = '".$_SESSION['client_id']."'";
        }else{            
          $sql = "SELECT count(discount_rate_id) as jumData FROM tbl_discount_rate a INNER JOIN tbl_user b USING (user_id)WHERE a.client_id = '".$_SESSION['client_id']."'";
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
                      <i class="fa fa-pencil mr-5"></i> Create New Discount Rate
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
                                    <label class="bmd-label-floating">Discount Rate Name (max. 20 characters)</label>
                                    <input type="text" class="form-control" name="discount_rate_name" maxlength=20 autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Amount (In %. Type number only)</label>
                                    <input type="text" class="form-control" name="discount_rate_amount" autocomplete="off" />
                                </div>
                            </div>                                                          
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Start Date (dd/mm/yyyy)</label>
                                    <input type="text" class="form-control" name="discount_rate_start_date" id="discount_rate_start_date" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">End Date (dd/mm/yyyy)</label>
                                    <input type="text" class="form-control" name="discount_rate_end_date" id="discount_rate_end_date"  autocomplete="off" />
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
<script type="text/javascript">
$(document).ready(function() {

  $("#discount_rate_start_date").attr("maxlength", 10);
  $("#discount_rate_start_date").keyup(function(){
      if ($(this).val().length == 2){
          $(this).val($(this).val() + "/");
      }else if ($(this).val().length == 5){
          $(this).val($(this).val() + "/");
      }
  });

  $("#discount_rate_end_date").attr("maxlength", 10);
  $("#discount_rate_end_date").keyup(function(){
      if ($(this).val().length == 2){
          $(this).val($(this).val() + "/");
      }else if ($(this).val().length == 5){
          $(this).val($(this).val() + "/");
      }
  });

});     
</script>