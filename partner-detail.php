<?php 
require_once 'header.php';
$sql  = "SELECT partner_id, partner_ip, partner_key, partner_secret, partner_name, partner_balance, partner_active_status, partner_deposit_type, partner_contact_name, partner_contact_email FROM tbl_partner WHERE partner_id = '".$ntf[1]."' LIMIT 1";
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
        <h3 class="block-title">Partner Detail</h3>
      </div>
      <div class="block-content">
                
        <div class="card-body">
          <form id="form_simpan">
            <input type="hidden" name="partner_id" value="<?php echo $row['partner_id'] ?>">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Partner Name</label>
                  <input type="text" class="form-control" name="partner_name" value="<?php echo $row['partner_name'] ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">IP Address</label>
                  <input type="email" class="form-control" name="partner_ip" value="<?php echo $row['partner_ip'] ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Key</label>
                  <input type="text" class="form-control" name="partner_key" value="<?php echo $row['partner_key'] ?>">
                </div>
              </div>              
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Secret</label>
                  <input type="text" class="form-control" name="partner_secret" value="<?php echo $row['partner_secret'] ?>">
                </div>
              </div>
            </div>
            <div class="row"> 
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Deposit Type</label>
                  <input type="text" class="form-control" name="partner_deposit_type" value="<?php echo $row['partner_deposit_type'] ?>">
                </div>
              </div>                                     
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Active Status</label>
                  <select class="form-control" required name="partner_active_status">
                    <?php if($row['partner_active_status']=='Y') { ?>
                      <option value="Y" selected="selected">Yes</option>
                      <option value="N">No</option>
                    <?php }else{ ?>
                      <option value="Y">Yes</option>
                      <option value="N" selected="selected">No</option>
                    <?php } ?>                        
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Contact Name</label>
                  <input type="text" class="form-control" name="partner_contact_name" value="<?php echo $row['partner_contact_name'] ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Contact Email</label>
                  <input type="text" class="form-control" name="partner_contact_email" value="<?php echo $row['partner_contact_email'] ?>">
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
  $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="partner.php"><i class="si si-arrow-left mr-5"></i>Back</a> <a href="partner-history.php?act=29dvi59&ntf=29dvi59-<?php echo $row["partner_key"]?>-94dfvj!sdf-349ffuaw" class="btn btn-warning mr-5 mb-5"><i class="fa fa-dollar mr-5"></i>History</a>');  
  $('#submit_data').click(function(){  
    $('#form_simpan').submit(); 
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');
  });  
  $('#form_simpan').on('submit', function(event){
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');  
    event.preventDefault();  
    $.ajax({  
      url:"partner-edit.php",  
      method:"POST",  
      data:new FormData(this),  
      contentType:false,  
      processData:false,  
      success:function(data){ 
        $('#results').html(data);  
        $('#submit_data').val('');
        $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="partner.php"><i class="si si-arrow-left mr-5"></i>Back</a> <a href="partner-history.php?act=29dvi59&ntf=29dvi59-<?php echo $row["partner_key"]?>-94dfvj!sdf-349ffuaw" class="btn btn-warning mr-5 mb-5"><i class="fa fa-dollar mr-5"></i>History</a>');  
      }  
    });  
  });  
});  
</script>