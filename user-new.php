<?php 
require_once 'header.php';
?>


<!-- Main Container -->
<main id="main-container">
  <!-- Page Content -->
  <div class="content">   
    <div class="block table-responsive">
      <div class="block-header block-header-default">
        <h3 class="block-title">User</h3>
      </div>
      <div class="block-content">
                
        <div class="card-body">
           <form id="form_simpan">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="bmd-label-floating">Name</label>
                    <input type="text" class="form-control" name="full_name" autocomplete="off" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="bmd-label-floating">Username</label>
                    <input type="text" class="form-control" name="username" />
                  </div>
                </div>                
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="bmd-label-floating">Password</label>
                    <input type="password" class="form-control" name="txt_password" autocomplete="off" />
                  </div>
                </div>
                <div class="col-md-3">
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
                    $h    = mysqli_query($conn2,$sql);
                    while($row1 = mysqli_fetch_assoc($h)) {
                    ?> 
                    <input type="checkbox" name="nav_menu_id[]"  value="<?php echo $row1['nav_menu_id'] ?>"><i class="dark-white"></i> <?php echo $row1['nav_header_name'].' - '.$row1['nav_menu_name'] ?><br/>
                    <?php } ?>
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
      url:"user-add.php",  
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
