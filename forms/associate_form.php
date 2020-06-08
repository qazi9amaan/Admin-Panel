<fieldset>
    <div class="form-group">
        <label for="name"> Name *</label>
          <input type="text" name="name" value="<?php echo  $associate['name']; ?>" placeholder="Product Name " class="form-control" required="required" id = "name">
    </div> 

    <div class="form-group">
        <label for="bussiness_name"> Bussiness Name *</label>
          <input type="text" name="bussiness_name" value="<?php echo  $associate['bussiness_name']; ?>" placeholder="Bussiness Name " class="form-control" required="required" id = "bussiness_name">
    </div> 

    <div class="form-group">
        <label for="address">Bussiness Address</label>
          <textarea name="address"  rows="7" placeholder="Product Description" class="form-control" id="address"><?php echo  $associate['address'] ; ?></textarea>
    </div>

    
    <div class="form-group">
        <label>Email Address</label>
        <input name="email_address" value="<?php echo  $associate['email_address'] ; ?>" placeholder="Product Quality" class="form-control" type="email" >
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="number" name="phone" value="<?php echo  $associate['phone'] ; ?>" placeholder="Actual Price" class="form-control" id="phone">
    </div>
    <div class="form-group">
        <label for="created_at">Registration Date</label>
        <input type="text"  disabled name="created_at" value="<?php echo  $associate['created_at'] ; ?>"  class="form-control" id="created_at">
    </div>
    
    <?php if($associate['account_status']!= "" || $associate['account_status'] != null){?>
    <div class="form-group ">
        <label for="account_status">Account Status</label>
        <input type="text"  disabled  value="<?php echo  $associate['account_status'] ; ?>"  class="form-control " id="account_status">
    </div>
    
    <?php }?>
   
   <?php 
    if($edit){
?>
 <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-success" >Upload </button>
        <a href="/admin/admin-panel-items/Associates/associates.php" class="btn btn-primary" >Home </a>
    </div>
  
    <?php }?>
</fieldset>
