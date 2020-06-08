<fieldset>
    <div class="form-group">
        <label for="category_base">Category Type *</label>
          <input type="text" name="category_base" value="<?php echo htmlspecialchars($edit ? $customer['category_base'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Category Type " class="form-control" required="required" id = "category_base">
    </div> 

    <div class="form-group">
        <label for="category_name">Category Name *</label>
          <input type="text" name="category_name" value="<?php echo htmlspecialchars($edit ? $customer['category_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Category Name " class="form-control" required="required" id = "category_name">
    </div> 

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-success" >Add </button>
    </div>
</fieldset>
