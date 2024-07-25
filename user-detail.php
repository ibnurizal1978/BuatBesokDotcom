<?php 
require_once 'header.php';
$sql  = "SELECT * FROM tbl_user WHERE user_id = '".$ntf[1]."' LIMIT 1";
$h    = mysqli_query($conn2,$sql);
$row  = mysqli_fetch_assoc($h); 
?>

<!-- Main Container -->
<main id="main-container">
  <!-- Page Content -->
  <div class="content">
    <!--table-->   
    <div class="block table-responsive">
      <div class="block-header block-header-default">
        <h3 class="block-title">User</h3>
      </div>
      <div class="block-content">
                
        <div class="card-body">
          <form id="form_simpan">
            <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Name</label>
                  <input type="text" class="form-control" name="full_name" value="<?php echo $row['full_name'] ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Username</label>
                  <input type="text" class="form-control" name="username" value="<?php echo $row['username'] ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Active Status</label>
                    <select class="btn-primary" required name="user_active_status" style="padding-left: 5px; padding-right: 5px">
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
              <div class="col-md-3">
                <div class="form-group">
                  <label class="bmd-label-floating">Module Access</label>
                  <br/>
                  <?php
                    $sql2  =" SELECT *, (SELECT count(*) FROM tbl_nav_user x WHERE x.nav_menu_id = y.nav_menu_id AND user_id = '".$row['user_id']."') AS ada FROM tbl_nav_menu y  INNER JOIN tbl_nav_header b USING (nav_header_id) ORDER BY nav_header_name ";
                    $h2    = mysqli_query($conn2,$sql2);
                    while($row2 = mysqli_fetch_assoc($h2)) {
                      if($row2['ada']>0){
                    ?> 
                    <input type="checkbox" name="nav_menu_id[]" checked value="<?php echo $row2['nav_menu_id'] ?>"><i class="dark-white"></i> <?php echo $row2['nav_header_name'].' - '.$row2['nav_menu_name'] ?><br/>
                    <?php }else{ ?>
                    <input type="checkbox" name="nav_menu_id[]" value="<?php echo $row2['nav_menu_id'] ?>"><i class="dark-white"></i> <?php echo $row2['nav_header_name'].' - '.$row2['nav_menu_name'] ?><br/>
                    <?php }} ?>
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


        
    <div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="block">
          <div class="block-header block-header-default">
            <h3 class="block-title">Change Password</h3>
          </div>
          <div class="block-content">
            <p>
              <form id="form_simpan2">
                <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
                <input type="hidden" name="int" value="1">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Input New Password</label>
                      <input type="password" class="form-control" name="txt_password" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">Confirm New Password</label>
                      <input type="password" class="form-control" name="txt_password2" />
                    </div>
                  </div>
                </div>
                <div id="results2"></div><div id="button2"></div>
                <div class="clearfix"></div>
              </form>
            </p>
          </div>
        </div>
      </div>
    </div>


    <!-- END Page Content -->
  </div>
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>
<script>  
$(document).ready(function(){
  $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="user.php"><i class="si si-arrow-left mr-5"></i>Back</a>');  
  $('#submit_data').click(function(){  
    $('#form_simpan').submit(); 
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');
    $("#button").html('<button type="submit" class="btn btn-success pull-right" id="submit_data">Loading...</button>'); 
  });  
  $('#form_simpan').on('submit', function(event){
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');
    $("#button").html('<button type="submit" class="btn btn-success pull-right" id="submit_data">Loading...</button>');   
    event.preventDefault();  
    $.ajax({  
      url:"user-edit.php",  
      method:"POST",  
      data:new FormData(this),  
      contentType:false,  
      processData:false,  
      success:function(data){ 
        $('#results').html(data);  
        $('#submit_data').val('');
        $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="user.php"><i class="si si-arrow-left mr-5"></i>Back</a>');  
      }  
    });  
  });  
});

//change password
$(document).ready(function(){
  $("#button2").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data2"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="user.php"><i class="si si-arrow-left mr-5"></i>Back</a>');  
  $('#submit_data2').click(function(){  
    $('#form_simpan2').submit(); 
    $("#results2").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');
    $("#button2").html('<button type="submit" class="btn btn-success pull-right" id="submit_data2">Loading...</button>'); 
  });  
  $('#form_simpan2').on('submit', function(event){  
    event.preventDefault();  
    $.ajax({  
      url:"user-change-password.php",  
      method:"POST",  
      data:new FormData(this),  
      contentType:false,  
      processData:false,  
      success:function(data){ 
        $('#results2').html(data);  
        $('#submit_data2').val('');
        $("#button2").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data2"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="user.php"><i class="si si-arrow-left mr-5"></i>Back</a>');  
      }  
    });  
  });
});  

//upload foto profil
$(document).ready(function(){  
  $('#upload_user_photo').change(function(){  
    $('#export_user_photo').submit(); 
    $("#results_user_photo").html('<img width=50 src=<?php echo $base_url ?>assets/img/loading.gif> Uploading...'); 
  });  
  $('#export_user_photo').on('submit', function(event){  
    event.preventDefault();  
    $.ajax({  
      url:"user-upload-photo.php",  
      method:"POST",  
      data:new FormData(this),  
      contentType:false,  
      processData:false,  
      success:function(data){ 
        $('#results_user_photo').html(data);  
        $('#upload_user_photo').val('');  
      }  
    });  
  });  
});  

//date format
$(document).ready(function() {
  $("#user_birth_date").attr("maxlength", 10);

  $("#user_birth_date").keyup(function(){
      if ($(this).val().length == 2){
          $(this).val($(this).val() + "/");
      }else if ($(this).val().length == 5){
          $(this).val($(this).val() + "/");
      }
  });

});
</script>
