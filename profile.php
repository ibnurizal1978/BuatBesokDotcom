<?php 
require_once 'header.php';
//require_once 'components.php';
$sql  = "SELECT a.client_id, client_business_name, client_address, client_address_detail, client_phone, client_email_address, region_name, region_id, client_currency, currency_id, client_timezone FROM tbl_client a INNER JOIN tbl_region b USING (region_id) INNER JOIN tbl_currency c USING (currency_id) INNER JOIN tbl_timezone d ON a.client_timezone = d.timezone WHERE a.client_id = '".$_SESSION['client_id']."' LIMIT 1";
$h    = mysqli_query($conn, $sql);
$row  = mysqli_fetch_assoc($h);

$sql2 = "SELECT * FROM tbl_bank_account WHERE client_id = '".$_SESSION['client_id']."' LIMIT 1";
$h2   = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($h2);
?>

<!-- Main Container -->
<main id="main-container">
  <div class="bg-body-light hero-bubbles">
                    <div class="row no-gutters justify-content-center">
                        <div class="hero-static col-lg-10">
                            <div class="content content-full overflow-hidden">
                                <!-- Header -->
                                <div class="py-50 text-center">
                                    <h1 class="h4 font-w700 mt-30 mb-10">Setup your company information</h1>
                                    <h2 class="h5 font-w400 text-muted mb-0">Information below will be use for certain modules. So let's setup now</h2>
                                </div>
                                <!-- END Header -->

                                    <div class="block block-rounded block-shadow">
                                        <!-- Database section -->
                                      <form action="<?php echo $file.'-edit'.$ext ?>" method="POST">
                                        <input type="hidden" name="t" value="1" />
                                        <div class="block-content block-content-full">
                                            <h2 class="content-heading text-black pt-20">Your Business Profile</h2>
                                            <div class="row items-push">
                                                <div class="col-lg-10">
                                                    <p class="text-muted">
                                                        This information will be use on Purchase Order and Invoice section
                                                    </p>
                                                </div>
                                                <div class="col-lg-10 offset-lg-1">
                                                  <div class="form-group">
                                                      <label for="install-db-name">Business Name</label>
                                                      <input type="text" class="form-control form-control-lg" name="client_business_name" value="<?php echo $row['client_business_name'] ?>" />
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="install-db-host">Address</label>
                                                      <input type="text" class="form-control form-control-lg" name="client_address"  value="<?php echo $row['client_address'] ?>" />
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="install-db-prefix">Detail Address</label>
                                                      <input type="text" class="form-control form-control-lg" name="client_address_detail"  value="<?php echo $row['client_address_detail'] ?>" />
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="install-db-prefix">Country</label>
                                                      <select class="form-control form-control-lg" required name="country_id">
                                                        <?php
                                                        $sql1  = "SELECT * FROM tbl_country ORDER BY country_name";
                                                        $h1    = mysqli_query($conn,$sql1);
                                                        while($row1 = mysqli_fetch_assoc($h1)) {
                                                            if($row1['country_id']==$row['country_id']) {
                                                        ?> 
                                                        <option value="<?php echo $row1['country_id'] ?>" selected="selected"><?php echo $row1['country_name'] ?></option>
                                                        <?php }else{ ?>
                                                        <option value="<?php echo $row1['country_id'] ?>"><?php echo $row1['country_name'] ?></option>
                                                        <?php }} ?>
                                                      </select>                
                                                  </div>                                                  
                                                </div>
                                                <div class="col-lg-4 offset-lg-1">
                                                  <div class="form-group">
                                                      <label for="install-db-username">Phone</label>
                                                      <input type="text" class="form-control form-control-lg" name="client_phone"  value="<?php echo $row['client_phone'] ?>" />
                                                  </div>
                                                </div>
                                                <div class="col-lg-4 offset-lg-1">
                                                  <div class="form-group">
                                                      <label for="install-db-password">Email</label>
                                                      <input type="text" class="form-control form-control-lg" name="client_email_address"  value="<?php echo $row['client_email_address'] ?>" />
                                                  </div>
                                                </div>
                                                <div class="col-lg-4 offset-lg-1">
                                                  <div class="form-group">
                                                      <label for="install-db-username">Currency</label>
                                                      <select class="form-control form-control-lg" required name="currency_id">
                                                        <?php
                                                        $sql1  = "SELECT * FROM tbl_currency ORDER BY currency_name";
                                                        $h1    = mysqli_query($conn,$sql1);
                                                        while($row1 = mysqli_fetch_assoc($h1)) {
                                                            if($row1['currency_id']==$row['currency_id']) {
                                                        ?> 
                                                        <option value="<?php echo $row1['currency_id'] ?>" selected="selected"><?php echo $row1['currency_name'] ?></option>
                                                        <?php }else{ ?>
                                                        <option value="<?php echo $row1['currency_id'] ?>"><?php echo $row1['currency_name'] ?></option>
                                                        <?php }} ?>
                                                      </select>
                                                  </div>
                                                </div>
                                                <div class="col-lg-4 offset-lg-1">
                                                  <div class="form-group">
                                                      <label for="install-db-password">Timezone</label>
                                                      <select class="form-control form-control-lg" required name="timezone_id">
                                                        <?php
                                                        $sql1  = "SELECT * FROM tbl_timezone ORDER BY timezone";
                                                        $h1    = mysqli_query($conn,$sql1);
                                                        while($row1 = mysqli_fetch_assoc($h1)) {
                                                            if($row1['timezone_id']==$row['timezone_id']) {
                                                        ?> 
                                                        <option value="<?php echo $row1['timezone_id'] ?>" selected="selected"><?php echo $row1['timezone'] ?></option>
                                                        <?php }else{ ?>
                                                        <option value="<?php echo $row1['timezone_id'] ?>"><?php echo $row1['timezone'] ?></option>
                                                        <?php }} ?>
                                                      </select>
                                                  </div>
                                                </div>
                                              <div class="col-lg-4 offset-lg-1">
                                                <div class="form-group">
                                                  <input type="submit" class="btn btn-hero btn-alt-success min-width-150 mb-10" value="Save" />
                                                </div>
                                              </div>                                                                                                
                                            </div>
                                        </div>
                                      </form>
                                        <!-- END Database section -->

                                        <!-- Bank section -->
                                      <form action="<?php echo $file.'-edit'.$ext ?>" method="POST">
                                        <input type="hidden" name="t" value="2" />
                                        <div class="block-content block-content-full">
                                          <h2 class="content-heading text-black pt-20">Bank Account</h2>
                                          <div class="row items-push">
                                              <div class="col-lg-12">
                                                  <p class="text-muted">
                                                      This information will be show on Invoice.
                                                  </p>
                                              </div>
                                              <div class="col-lg-4 offset-lg-1">
                                                <div class="form-group">
                                                    <label for="install-admin-email">Bank Name</label>
                                                    <input type="text" class="form-control form-control-lg" name="bank_account_name" value="<?php echo $row2['bank_account_name'] ?>" />
                                                </div>
                                              </div>
                                              <div class="col-lg-4 offset-lg-1">
                                                <div class="form-group">
                                                    <label for="install-admin-email">Branch Location</label>
                                                    <input type="text" class="form-control form-control-lg" name="bank_account_branch_location" value="<?php echo $row2['bank_account_branch_location'] ?>" />
                                                </div>
                                              </div>
                                              <div class="col-lg-4 offset-lg-1">                  
                                                <div class="form-group">
                                                    <label for="install-admin-password">Beneficiary Name</label>
                                                    <input type="text" class="form-control form-control-lg"  name="bank_account_beneficiary" value="<?php echo $row2['bank_account_beneficiary'] ?>" />
                                                </div>
                                              </div>
                                              <div class="col-lg-4 offset-lg-1">
                                                <div class="form-group">
                                                    <label for="install-admin-password-confirm">Account Number</label>
                                                    <input type="text" class="form-control form-control-lg" name="bank_account_no" value="<?php echo $row2['bank_account_no'] ?>" />
                                                </div>
                                              </div>
                                              <div class="col-lg-4 offset-lg-1">
                                                <div class="form-group">
                                                  <input type="submit" class="btn btn-hero btn-alt-success min-width-150 mb-10" value="Save" />
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </form>
                                        <!-- END bank section -->                                        

                                    </div>
                                <!-- END Installation Form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>
