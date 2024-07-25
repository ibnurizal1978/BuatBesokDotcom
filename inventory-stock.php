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
                    <form action="inventory-parts-stock.php" method="post">
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
                    <form action="inventory-parts-stock.php" method="post">
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

      <?php if(@$ntf[0]=="r827ao") {?>
        <div class="alert alert-danger ks-solid text-center" role="alert">Please fill all forms</div>
      <?php } ?> 
      <?php if(@$ntf[0]=="dpk739a") {?>
        <div class="alert alert-danger ks-solid text-center" role="alert">Duplicate parts name</div>
      <?php } ?>
      <?php if(@$ntf[0]=="r1029wkw") {?>
        <div class="alert alert-success ks-solid text-center" role="alert">Data successfully updated</div>
      <?php } ?>
      <?php if(@$ntf[0]=="r1029wkwedt") {?>
        <div class="alert alert-success ks-solid text-center" role="alert">Data successfully updated</div>
      <?php } ?>
      <?php if($ntf[0]=="phr827ao") {?>
          <div class="alert alert-danger ks-solid text-center" role="alert">Please choose photo from your file</div>
      <?php } ?> 
      <?php if($ntf[0]=="phs1s34plod") {?>
          <div class="alert alert-danger ks-solid text-center" role="alert">Maximum file size is 1 MB</div>
      <?php } ?>
      <?php if($ntf[0]=="phty3f1l3") {?>
          <div class="alert alert-success ks-solid text-center" role="alert">Maximum file size is 1 MB</div>
      <?php } ?>
      <?php if($ntf[0]=="phr1029wkwedt") {?>
          <div class="alert alert-success ks-solid text-center" role="alert">Photo successfully added</div>
      <?php } ?>
      <?php if(@$ntf[0]=="29dvi59") {?>
          <div class="alert alert-success ks-solid text-center" role="alert">Photo successfully deleted</div>
      <?php } ?> 


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
        $sql = "SELECT parts_rack_location_id,parts_id,parts_name,parts_treshold,parts_code,location_name,warehouse_name,date_format(parts_created_date,'%d-%m-%Y') AS parts_created_date, parts_stock,parts_broken,parts_replacement,parts_ready_to_use FROM tbl_parts a INNER JOIN tbl_location b USING (location_id) INNER JOIN tbl_warehouse c USING (warehouse_id) WHERE (parts_name LIKE '%$txt_search%' OR parts_code LIKE '%$txt_search%') AND a.client_id = '".$_SESSION['client_id']."' ORDER BY parts_name ASC LIMIT $offset, $dataPerPage";
      }elseif (@$_REQUEST['s']=='1'){
        $sql = "SELECT parts_rack_location_id,parts_id,parts_name,parts_treshold,parts_code,parts_rack_location_name,parts_warehouse_name FROM tbl_parts a INNER JOIN tbl_parts_rack_location b USING (parts_rack_location_id) INNER JOIN tbl_parts_warehouse c USING (parts_warehouse_id) WHERE a.client_id = '".$_SESSION['client_id']."' ORDER by parts_name LIMIT $offset, $dataPerPage";      
      }else{
        $sql = "SELECT a.product_id, a.warehouse_id, a.rack_id, stock_id,warehouse_name, rack_name, product_name, qty_ready, qty_reject, qty_treshold FROM tbl_inventory_stock a INNER JOIN  tbl_inventory_warehouse b USING (warehouse_id) INNER JOIN tbl_inventory_rack c USING (rack_id) INNER JOIN tbl_product d USING (product_id) ORDER BY product_name ASC LIMIT $offset, $dataPerPage";
      }
      $rs_result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($rs_result)==0) {
      ?>
        <div class="alert alert-info ks-solid text-center" role="alert">Oops, no data found</div>
    <?php } ?>    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Stock <a data-toggle="modal" data-target="#modal-add" href="#">[add]</a> <a  href="<?php echo $file.$ext ?>">[view all]</a></h3>
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
                          <th>Product</th>
                          <th>Warehouse</th>
                          <th>Rack</th>
                          <th>Ready</th>
                          <th>Reject</th>
                          <th>Treshold</th>
                          <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rs_result)) { ?>
                        <tr>
                          <td><?php echo $row["product_name"]; ?></td> 
                          <td><?php echo $row["warehouse_name"]; ?></td>  
                          <td><?php echo $row["rack_name"]; ?></td>
                          <td><?php echo $row["qty_ready"]; ?></td>
                          <td><?php echo $row["qty_reject"]; ?></td>                            
                          <td>
                            <?php 
                            if($row['qty_ready']<$row['qty_treshold']) {
                              echo "<font color=ff0000>".$row['qty_treshold']."</font>";
                            }else{
                              echo $row['qty_treshold'];
                            } 
                            ?>
                          </td>
                          <td class="text-center">
                            <div class="btn-group">
                              <a data-toggle="modal" data-target="#add-<?php echo $row['stock_id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                              <a href="inventory-stock-log.php?act=8328x8!ak__atu3nw1kx5&ntf=1v3sk6dv3___-<?php echo $row['stock_id'] ?>-Avlw_____ak4oAUh82sH_8vm!s83kkzl3-ij5A7!alcl6sj-<?php echo date('sidsH') ?>" class="btn btn-sm btn-secondary">History</a>
                            </div>

                            <!-- .modal -->
                            <form ui-jp="parsley" method="POST" action="<?php echo $file.'-edit'.$ext ?>">
                              <input type="hidden" name="stock_id" value="<?php echo $row['stock_id'] ?>" />
                              <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>" />
                              <input type="hidden" name="warehouse_id" value="<?php echo $row['warehouse_id'] ?>" />
                              <input type="hidden" name="old_qty_ready" value="<?php echo $row['qty_ready'] ?>" />
                              <input type="hidden" name="old_qty_treshold" value="<?php echo $row['qty_treshold'] ?>" />
                              <input type="hidden" name="old_qty_reject" value="<?php echo $row['qty_reject'] ?>" />
                              <input type="hidden" name="rack_id" value="<?php echo $row['rack_id'] ?>" />
                              <input type="hidden" name="t" value="1" />
                              <div id="add-<?php echo $row['stock_id'] ?>" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Add New Qty for <?php echo $row['product_name'] ?></h5>
                                    </div>
                                    <div class="modal-body text-center p-lg">
                                    <!--begin isi modal-->             
                                      <div class="box">
                                        <div class="box-body">
                    
                                          <div class="row m-b">
                                            <div class="col-sm-6">
                                              <label>New Qty</label>
                                              <input type="number" class="form-control" name="qty_ready" placeholder="Type qty" required>
                                            </div>
                                            <div class="col-sm-6">
                                              <label>Change Type</label>
                                              <select class="form-control" name="qty_type" required>
                                                <option value="">--Choose--</option>
                                                <option value="1">Add Qty</option>
                                                <option value="2">Reject</option>
                                              </select>
                                            </div>                                            
                                          </div>
                                          <p>&nbsp;</p>
                                          <div class="row m-b">
                                            <div class="col-sm-12">
                                              <label>Qty Treshold (leave if no change)</label>
                                              <input type="number" class="form-control" name="qty_treshold" value="<?php echo $row['qty_treshold'] ?>" required>
                                            </div>                                            
                                          </div>

                                        </div>
                                      </div>
                                      <!--end isi modal-->
                                    </div>
                                    <div class="modal-footer">
                                      <input type="submit" class="btn btn-success mr-5 mb-5" value="Submit" onclick="return confirm('Are you sure this quantity is correct?');" /> <button type="button" class="btn info p-x-md" data-dismiss="modal">Close</button>
                                    </div>
                                  </div><!-- /.modal-content -->
                                </div>
                              </div>
                            </form>
                            <!-- / .modal -->

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
          $sql = "SELECT count(parts_id) as jumData FROM tbl_parts a INNER JOIN tbl_parts_rack_location b USING (parts_rack_location_id) INNER JOIN tbl_parts_warehouse c USING (parts_warehouse_id)  WHERE a.client_id = '".$_SESSION['client_id']."' AND (parts_rack_location_name LIKE '%$txt_search%')";
        }elseif(@$_REQUEST['s']=='1') {           
          $sql = "SELECT count(parts_id) as jumData FROM tbl_parts a INNER JOIN tbl_parts_rack_location b USING (parts_rack_location_id) INNER JOIN tbl_parts_warehouse c USING (parts_warehouse_id) WHERE a.client_id = '".$_SESSION['client_id']."' ORDER by parts_rack_location_name";
        }else{            
          $sql = "SELECT count(stock_id) as jumData FROM FROM tbl_inventory_stock a INNER JOIN  tbl_inventory_warehouse b USING (warehouse_id) INNER JOIN tbl_inventory_rack c USING (rack_id) INNER JOIN tbl_product d USING (product_id)";
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

<!-- Compose Modal -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header">
                    <h3 class="block-title">
                      <i class="fa fa-pencil mr-5"></i> Add New Stock
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
                                    <label class="bmd-label-floating">Product Name</label>
                                    <select class="form-control" required name="product_id">
                                    <option value=""> -- Choose -- </option>
                                    <?php
                                    $sql1  = "SELECT product_id, product_name FROM tbl_product ORDER by product_name";
                                    $h1    = mysqli_query($conn,$sql1);
                                    while($row1 = mysqli_fetch_assoc($h1)) {
                                    ?>
                                    <option value="<?php echo $row1['product_id'] ?>"><?php echo $row1['product_name'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">New Qty</label>
                                    <input type="text" class="form-control" name="qty_ready" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Treshold</label>
                                    <input type="text" class="form-control" name="qty_treshold" autocomplete="off" />
                                </div>
                            </div>                                                         
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Warehouse</label>
                                    <select class="form-control" required name="warehouse_id">
                                    <option value=""> -- Choose -- </option>
                                    <?php
                                    $sql1  = "SELECT * FROM tbl_inventory_warehouse ORDER by warehouse_name";
                                    $h1    = mysqli_query($conn,$sql1);
                                    while($row1 = mysqli_fetch_assoc($h1)) {
                                    ?>
                                    <option value="<?php echo $row1['warehouse_id'] ?>"><?php echo $row1['warehouse_name'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Rack</label>
                                    <select class="form-control" required name="rack_id">
                                    <option value=""> -- Choose -- </option>
                                    <?php
                                    $sql1  = "SELECT * FROM tbl_inventory_rack ORDER by rack_name";
                                    $h1    = mysqli_query($conn,$sql1);
                                    while($row1 = mysqli_fetch_assoc($h1)) {
                                    ?>
                                    <option value="<?php echo $row1['rack_id'] ?>"><?php echo $row1['rack_name'] ?></option>
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
