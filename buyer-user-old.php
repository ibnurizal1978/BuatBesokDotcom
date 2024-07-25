<?php 
require_once 'header.php';
//require_once 'components.php';
$id = $param[1];
$id = Encryption::decode($id);
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
                        <input type="hidden" name="id" value="<?php echo $id ?>" />
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
                                  <input type="hidden" name="id" value="<?php echo $id ?>" />
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
        $sql = "SELECT user_id,username,full_name,user_active_status,DATE_FORMAT(DATE_ADD(user_last_login,INTERVAL '".$_SESSION['selisih']."' HOUR), '%d/%m/%Y on %H:%i') as user_last_login FROM tbl_user WHERE (username LIKE '%$txt_search%' OR full_name LIKE '%$txt_search%') AND client_id = '".$id."' LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='1'){
        $sql = "SELECT user_id,username,full_name,user_active_status,DATE_FORMAT(DATE_ADD(user_last_login,INTERVAL '".$_SESSION['selisih']."' HOUR), '%d/%m/%Y on %H:%i') as user_last_login FROM tbl_user WHERE client_id = '".$id."' ORDER by full_name LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='2'){
        $sql = "SELECT user_id,username,full_name,user_active_status,DATE_FORMAT(DATE_ADD(user_last_login,INTERVAL '".$_SESSION['selisih']."' HOUR), '%d/%m/%Y on %H:%i') as user_last_login FROM tbl_user WHERE client_id = '".$id."' ORDER by full_name LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='3'){
        $sql = "SELECT user_id,username,full_name,user_active_status,DATE_FORMAT(DATE_ADD(user_last_login,INTERVAL '".$_SESSION['selisih']."' HOUR), '%d/%m/%Y on %H:%i') as user_last_login FROM tbl_user WHERE client_id = '".$id."' ORDER by user_active_status LIMIT $offset, $dataPerPage";      
      }else{
        $sql = "SELECT user_id,username,full_name,user_active_status,DATE_FORMAT(DATE_ADD(user_last_login,INTERVAL '".$_SESSION['selisih']."' HOUR), '%d/%m/%Y on %H:%i') as user_last_login FROM tbl_user WHERE client_id = '".$id."' LIMIT $offset, $dataPerPage";
      }
      echo $sql;
      $rs_result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($rs_result)==0) {
      ?>
        <div class="alert alert-info ks-solid text-center" role="alert">Oops, no data found</div>
    <?php } ?>    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">User <a data-toggle="modal" data-target="#modal-add" href="#">[add]</a> <a href="<?php echo $file.$ext ?>">[view all]</a></h3></h3>
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
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Last Login</th>
                            <th>Active?</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                        <tr>
                            <td><?php echo $row['username'] ?></td>
                            <td><?php echo $row['full_name'] ?></td>
                            <td><?php echo $row['user_last_login'] ?></td>
                            <td>
                                <?php if($row['user_active_status']==1) { ?>
                                    <span class="badge badge-success">active</span>
                                <?php }else{ ?>
                                    <span class="badge badge-danger">inactive</span>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal-edit<?php echo $row['user_id'] ?>" href="#">edit
                                    </a>
                                </div>
                            </td>
                            <!-- Compose Modal -->
                            <div class="modal fade" id="modal-edit<?php echo $row['user_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="block block-themed block-transparent mb-0">
                                            <div class="block-header">
                                                <h3 class="block-title">
                                                  <i class="fa fa-pencil mr-5"></i> Edit User
                                                </h3>
                                                <div class="block-options">
                                                  <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                      <i class="si si-close"></i>
                                                  </button>
                                                </div>
                                            </div>
                                            <div class="block-content">
                                                <form action="<?php echo $file.'-edit'.$ext ?>" method="POST">
                                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
                                                  <div class="row">
                                                    <div class="col-md-3">
                                                      <div class="form-group">
                                                        <label class="bmd-label-floating">Name</label>
                                                        <input type="text" class="form-control" name="full_name" autocomplete="off" value="<?php echo $row['full_name'] ?>" />
                                                      </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                      <div class="form-group">
                                                        <label class="bmd-label-floating">Username</label>
                                                        <input type="text" class="form-control" name="username" value="<?php echo $row['username'] ?>" />
                                                      </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                      <div class="form-group">
                                                        <label class="bmd-label-floating">Active Status</label>
                                                        <select class="form-control" required name="user_active_status">
                                                          <?php if($row['user_active_status']==1) { ?>
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
                                                <div class="row">                                        
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="bmd-label-floating">Password</label>
                                                        <input type="password" class="form-control" name="txt_password" autocomplete="off" />
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="bmd-label-floating">Confirm Password</label>
                                                        <input type="password" class="form-control" name="txt_password2" autocomplete="off" />
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
          $sql = "SELECT count(user_id) as jumData FROM tbl_user WHERE client_id = '".$id."' AND (username LIKE '%$txt_search%' OR full_name LIKE '%$txt_search%')";
        }elseif(@$_REQUEST['s']=='1') {           
          $sql = "SELECT count(user_id) as jumData FROM tbl_user WHERE client_id = '".$id."' ORDER by full_name";
        }elseif(@$_REQUEST['s']=='2') {           
          $sql = "SELECT count(user_id) as jumData FROM tbl_user WHERE client_id = '".$id."' ORDER by full_name";
        }elseif(@$_REQUEST['s']=='3') {           
          $sql = "SELECT count(user_id) as jumData FROM tbl_user WHERE client_id = '".$id."' ORDER by user_active_status";
        }else{            
          $sql = "SELECT count(user_id) as jumData FROM tbl_user WHERE client_id = '".$id."'";
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
                      <i class="fa fa-pencil mr-5"></i> Create New User
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
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="bmd-label-floating">Name</label>
                            <input type="text" class="form-control" name="full_name" autocomplete="off" />
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="bmd-label-floating">Username</label>
                            <input type="text" class="form-control" name="username" />
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="bmd-label-floating">Department</label>
                            <select class="form-control" required name="department_id">
                            <option value=""> -- Choose -- </option>
                            <?php
                            $sql  = "SELECT department_id,department_name FROM tbl_department WHERE client_id = '".$_SESSION['client_id']."'";
                            $h    = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($h)) {
                            ?>
                            <option value="<?php echo $row['department_id'] ?>"><?php echo $row['department_name'] ?></option>
                            <?php } ?>
                          </select>
                          </div>
                        </div>
                    </div>
                    <div class="row">                                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Password</label>
                            <input type="password" class="form-control" name="txt_password" autocomplete="off" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Confirm Password</label>
                            <input type="password" class="form-control" name="txt_password2" autocomplete="off" />
                          </div>
                        </div>                
                      </div>
                      <p>&nbsp;</p>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="bmd-label-floating">Module Access</label>
                            <br/>
                            <?php
                            $sql  = "SELECT * FROM tbl_nav_menu y  INNER JOIN tbl_nav_header b USING (nav_header_id) ORDER BY nav_header_name";
                            $h    = mysqli_query($conn,$sql);
                            while($row1 = mysqli_fetch_assoc($h)) {
                            ?> 
                            <input type="checkbox" name="nav_menu_id[]"  value="<?php echo $row1['nav_menu_id'] ?>"><i class="dark-white"></i> <?php echo $row1['nav_header_name'].' - '.$row1['nav_menu_name'] ?><br/>
                            <?php } ?>
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