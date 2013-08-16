
<div class="row-fluid">

    <div class="span3">
        <!-- Upload image -->
        <div class="well" id="box-category" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding-top:5px">

        </div>
    </div>
    <div class="span6 category_right">
        <?php
        $i = 0;
        $j = 0;
        ?>
        <?php if (!empty($data)) : ?>
                <?php for ($i = 0; $i < count($data); $i += 3) : ?>
                <div class="row-fluid" style='margin-top:20px;'>
        <?php if (isset($data[$i])) : ?>
                        <div class="span4 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="<?php echo $this->webroot;?>product/<?php echo $data[$i]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i]['Product']['featured'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot;?>product/<?php echo $data[$i]['Product']['slug']; ?>" class="prop-title" target="_blank" style="text-transform: uppercase"><?php echo $data[$i]['Product']['name']; ?></a>

                                    <p class="price">$<?php echo $data[$i]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot;?>product/<?php echo $data[$i]['Product']['slug']; ?>" target="_blank">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
        <?php if (isset($data[$i + 1])) : ?>
                        <div class="span4 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="<?php echo $this->webroot;?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i + 1]['Product']['featured'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot;?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>" class="prop-title" style="text-transform: uppercase"><?php echo $data[$i + 1]['Product']['name']; ?></a>

                                    <p class="price">$<?php echo $data[$i + 1]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot;?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>" target="_blank">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
        <?php if (isset($data[$i + 2])) : ?>
                        <div class="span4 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="<?php echo $this->webroot;?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i + 2]['Product']['featured'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot;?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>" class="prop-title" style="text-transform: uppercase"><?php echo $data[$i + 2]['Product']['name']; ?></a>

                                    <p class="price">$<?php echo $data[$i + 2]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot;?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>" target="_blank">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                <?php endif; ?>
                </div>
            <?php endfor; ?>
<?php endif; ?>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(
            function() {
                //alert ("hello");
                category_load();
            });

    function category_load() {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>catalogue/category/<?php echo $slug; ?>",
            type: "GET",
            beforeSend: function(xhr) {
                //showAlert2("Loading category data now......");
            }
        }).done(function(data) {
            //alert (data);
            //hideAlert();
            //alert(data);
            jQuery("#box-category").html(data);

        }).fail(function() {
            //hideAlert();
        });
    }
</script>