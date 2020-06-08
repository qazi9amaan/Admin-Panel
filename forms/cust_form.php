<fieldset>
    <div class="form-group">
        <label for="product_name">Full Name *</label>
        <input type="text" name="full_name"  value="<?php echo ($edit ? $customer['full_name'] : ''); ?>" class="form-control" placeholder="Full Name" required>

    </div> 
    <div class="form-group">
        <label for="product_desc">Email Adress</label>
        <input type="email" name="email_address"  value="<?php echo ($edit ? $customer['email_address'] : ''); ?>" class="form-control" placeholder="Email Address" required>
    </div>
    

    <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" pattern="[0-9]{10}" value="<?php echo ($edit ? $customer['phone'] : ''); ?>" class="form-control" placeholder="Phone " required>
    </div>

    <div class="form-group">
        <label for="product_price">Address</label>
        <input type="text" name="init_address"  value="<?php echo ($edit ? $customer['init_address'] : ''); ?>" class="form-control" placeholder="Flat, House no., Building, Company,Apartment" required>
    </div>

    <div class="form-group">
        <input type="text" name="final_address"  value="<?php echo ($edit ? $customer['final_address'] : ''); ?>" class="form-control" placeholder="Area, Colony, Street, Sector" required>
    </div>


    <div class="form-group">
        <label >Landmark</label>
        <input type="text" name="landmark"  value="<?php echo ($edit ? $customer['landmark'] : ''); ?>" class="form-control" placeholder="Landmark" required>
    </div>
    <div class="form-group">
        <label > Town</label>
        <input type="text" name="town"  value="<?php echo ($edit ? $customer['town'] : ''); ?>" class="form-control" placeholder="Town/City" required>
    </div>
    <div class="form-group">
        <label >Pincode</label>
        <input type="number" name="pincode" pattern="[0-9]{6}" value="<?php echo ($edit ? $customer['pincode'] : ''); ?>" class="form-control" placeholder="Pincode" required>
    </div>

    <div class="form-group">
        <label >State</label>
        <input type="text" name="state" value="<?php echo ($edit ? $customer['state'] : ''); ?>" class="form-control" placeholder="State" required>
    </div>
</fieldset>
