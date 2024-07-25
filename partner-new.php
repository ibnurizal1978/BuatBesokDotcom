<?php 
require_once 'header.php';
?>

<!-- Main Container -->
<main id="main-container">
  <!-- Page Content -->
  <div class="content">
    <!--table-->   
    <div class="block table-responsive">
      <div class="block-header block-header-default">
        <h3 class="block-title">Create New Partner</h3>
        <div class="block-options">
          <div class="block-options-item">
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="side_overlay_toggle">
                <i class="fa fa-filter"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="block-content">
                
        <div class="card-body">
          <form id="form_simpan">
            <input type="hidden" name="partner_id" value="<?php echo $row['partner_id'] ?>">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Partner Name</label>
                  <input type="text" class="form-control" name="partner_name" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">IP Address</label>
                  <input type="email" class="form-control" name="partner_ip" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Key</label>
                  <input type="text" class="form-control" name="partner_key" />
                </div>
              </div>              
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Secret</label>
                  <input type="text" class="form-control" name="partner_secret" />
                </div>
              </div>
            </div>
            <div class="row"> 
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Deposit Type</label>
                  <input type="text" class="form-control" name="partner_deposit_type" />
                </div>
              </div>                                     
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Active Status</label>
                  <select class="form-control" required name="partner_active_status">
                      <option value="Y" selected="selected">Yes</option>
                      <option value="N">No</option>                      
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Contact Name</label>
                  <input type="text" class="form-control" name="partner_contact_name" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Contact Email</label>
                  <input type="text" class="form-control" name="partner_contact_email" />
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
  $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="partner.php"><i class="si si-arrow-left mr-5"></i>Back</a>');  
  $('#submit_data').click(function(){  
    $('#form_simpan').submit(); 
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');
  });  
  $('#form_simpan').on('submit', function(event){
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');  
    event.preventDefault();  
    $.ajax({  
      url:"partner-add.php",  
      method:"POST",  
      data:new FormData(this),  
      contentType:false,  
      processData:false,  
      success:function(data){ 
        $('#results').html(data);  
        $('#submit_data').val('');
        $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="partner.php"><i class="si si-arrow-left mr-5"></i>Back</a>');  
      }  
    });  
  });  
});  
</script>