<select name="filter_subcategory" id="filter_subcategory" class="input-small" style="margin-left:5px;">
    <option value=""> -- Size -- </option>
    <?php foreach ($data as $value) : $value = $value['Category'];?>
    <option value="<?php echo $value['guid']; ?>"><?php echo $value['name']; ?></option>
    <?php endforeach; ?>
</select>