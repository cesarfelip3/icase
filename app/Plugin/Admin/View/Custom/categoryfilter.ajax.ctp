<select onchange="categoryfilter_select(this);" name="category[<?php echo $level; ?>]">
    <option value=""> -Category- </option>
    <?php if (!empty($data)) : ?>
        <?php foreach ($data as $value) : $value = $value['Category']; ?>
            <option value="<?php echo $value['guid']; ?>" data-level="<?php echo $value['level'] + 1; ?>"><?php echo $value['name']; ?></option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>

<script>
    function categoryfilter_select(self)
    {
        var id = $(self).val();
        var level = $(self).find(":selected").data('level');
        level = parseInt (level);
        
        if (id == "") {
            return;
        }

        for (var i = 0; i < 100; ++i) {
            if ($(self).next() !== 'undefined') {
                $(self).next().remove();
            } else {
                break;
            }
        }
        level = parseInt(level);
        categoryfilter(id, level);
    }
</script>