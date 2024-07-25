<?php 
require_once 'header.php';
$sql  = "SELECT customer_id, customer_account_id, customer_name, customer_address, customer_email_address, customer_phone_number, customer_active_status, db_evoucher.tbl_partner.partner_name, DATE_FORMAT(DATE_ADD(created_date,INTERVAL '".$_SESSION['selisih']."' HOUR), '%d/%m/%Y on %H:%i') as created_date FROM db_customer.tbl_customer INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key WHERE customer_account_id = '".$ntf[1]."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
$row  = mysqli_fetch_assoc($h);
?>

<!-- Main Container -->
<main id="main-container">
  <!-- Page Content -->
  <div class="content">
    <!--table-->   
    <div class="block table-responsive">
      <div class="block-header block-header-default">
        <h3 class="block-title">Client Detail</h3>
      </div>
      <div class="block-content">
                
        <div class="card-body">
          <form id="form_simpan">
            <input type="hidden" name="customer_id" value="<?php echo $row['customer_id'] ?>">
            <input type="hidden" name="partner_key" value="<?php echo $row['partner_key'] ?>">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Customer Name</label>
                  <input type="text" class="form-control" name="customer_name" value="<?php echo $row['customer_name'] ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Address</label>
                  <input type="email" class="form-control" name="customer_address" value="<?php echo $row['customer_address'] ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Phone</label>
                  <input type="text" class="form-control" name="customer_phone_number" value="<?php echo $row['customer_phone_number'] ?>">
                </div>
              </div>              
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Email Address</label>
                  <input type="text" class="form-control" name="customer_email_address" value="<?php echo $row['customer_email_address'] ?>">
                </div>
              </div>
            </div>
            <div class="row"> 
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Account ID</label>
                  <input type="text" class="form-control" value="<?php echo $row['customer_account_id'] ?>">
                </div>
              </div>                       
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Active Status</label>
                  <select class="form-control" required name="customer_active_status">
                    <?php if($row['customer_active_status']==1) { ?>
                      <option value="1" selected="selected">Yes</option>
                      <option value="0">No</option>
                    <?php }else{ ?>
                      <option value="1">Yes</option>
                      <option value="0" selected="selected">No</option>
                    <?php } ?>                        
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Created Date</label>
                  <input type="text" class="form-control" value="<?php echo $row['created_date'] ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Partner Name</label>
                  <input type="text" class="form-control" value="<?php echo $row['partner_name'] ?>">
                </div>
              </div>                                                            
            </div>
            <div id="results"></div><div id="button"></div>
            <div class="clearfix"></div>
          </form>
        </div>
      </div>
    </div>
    <!-- END Small Table -->

    <!-- END Page Content -->
  </div>
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>
<script>  
$(document).ready(function(){
  $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="customer.php"><i class="si si-arrow-left mr-5"></i>Back</a> <a href="customer-ledger.php?act=29dvi59&ntf=29dvi59-<?php echo $row["customer_account_id"]?>-94dfvj!sdf-349ffuaw" class="btn btn-warning mr-5 mb-5"><i class="fa fa-dollar mr-5"></i>Ledger</a>');  
  $('#submit_data').click(function(){  
    $('#form_simpan').submit(); 
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');
  });  
  $('#form_simpan').on('submit', function(event){
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');  
    event.preventDefault();  
    $.ajax({  
      url:"customer-edit.php",  
      method:"POST",  
      data:new FormData(this),  
      contentType:false,  
      processData:false,  
      success:function(data){ 
        $('#results').html(data);  
        $('#submit_data').val('');
        $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="customer.php"><i class="si si-arrow-left mr-5"></i>Back</a> <a href="customer-ledger.php?act=29dvi59&ntf=29dvi59-<?php echo $row["customer_account_id"]?>-94dfvj!sdf-349ffuaw" class="btn btn-warning mr-5 mb-5"><i class="fa fa-dollar mr-5"></i>Ledger</a>');  
      }  
    });  
  });  
});  
</script>