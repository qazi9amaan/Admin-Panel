<fieldset>
    <div class="form-group">
        <label for="product_name">Product Name *</label>
          <input type="text" name="product_name" value="<?php echo ($edit ? $customer['product_name'] : ''); ?>" placeholder="Product Name " class="form-control" required="required" id = "product_name">
    </div> 


    <div class="form-group">
        <label for="product_desc">Product Description</label>
          <textarea name="product_desc"  rows="15" placeholder="Product Description" class="form-control" id="product_desc"><?php echo htmlspecialchars(($edit) ? $customer['product_desc'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>
    

    <div class="form-group">
        <label>Category</label>
        <?php 
        $opt_arr = array();
        $sql = "SELECT category_name FROM categories";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                array_push($opt_arr, $row["category_name"]);
            }
        }else{
            $opt_arr = null;
        }?>

        <select name="product_category" class="form-control selectpicker" required>
            <option value=" ">Please choose a category</option>
            <?php
            foreach ($opt_arr as $opt) {
                if ($edit && $opt == $customer['product_category']) {
                    $sel = 'selected';
                } else {
                    $sel = '';
                }
                echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Product Quality</label>
        <input name="product_quality" value="<?php echo htmlspecialchars($edit ? $customer['product_quality'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Product Quality" class="form-control" type="text" ">
    </div>

    <div class="form-group">
        <label for="product_price">Actual Price</label>
        <input type="number" name="product_price" value="<?php echo htmlspecialchars($edit ? $customer['product_price'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Actual Price" class="form-control" id="product_price">
    </div>

    <div class="form-group">
        <label for="phone">Final Price</label>
        <input name="product_discount_price" value="<?php echo htmlspecialchars($edit ? $customer['product_discount_price'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Final Price" class="form-control"  type="text" id="product_discount_price">
    </div>
    
  
    <?php include BASE_PATH.'/includes/image_upload.php'; ?>

    <div class="form-group text-center">
        <label></label>
        <button id="upload_btn_product" type="submit" class="btn btn-success" >Upload </button>
    </div>
</fieldset>
                                                     

