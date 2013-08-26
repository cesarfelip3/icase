<div class="row-fluid hide">
    <?php if (isset($breadcrumbs)) : $n = count($breadcrumbs) - 1; ?>
        <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $key => $value): ?>
                <li <?php if ($key == $n) echo 'class="active"'; ?>>
                    <a 
                        href="<?php echo $this->webroot; ?>category/<?php echo $value['Category']['slug']; ?>"
                        style="text-transform:uppercase;"
                        >
                            <?php echo $value['Category']['name']; ?> 
                        <?php if ($key != $n) : ?><span class="divider" style="border:none;">/</span><?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<div class="row-fluid">
    <div class="span3">
        <!-- Upload image -->
        <div class="well" id="box-category" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding-top:5px">
        </div>
    </div>
    <div class="span9 category_right">
        <?php
        $i = 0;
        $j = 0;
        ?>
        <?php if (!empty($data)) : ?>
            <?php for ($i = 0; $i < count($data); $i += 3) : ?>
                <div class="row-fluid hotproperties" style='margin-top:20px;'>
                    <?php if (isset($data[$i])) : ?>
                        <div class="span4 set-equal-heights-js">
                            <div class="thumbnail">
                                <a class="thumimg" href="<?php echo $this->webroot; ?>product/<?php echo $data[$i]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i]['Product']['featured']['150w'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i]['Product']['slug']; ?>" class="prop-title" style="text-transform: uppercase"><?php echo $data[$i]['Product']['name']; ?></a>
                                    <p class="price">$<?php echo $data[$i]['Product']['price']; ?></p>
                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i]['Product']['slug']; ?>">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($data[$i + 1])) : ?>
                        <div class="span4 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i + 1]['Product']['featured']['150w'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>" class="prop-title" style="text-transform: uppercase"><?php echo $data[$i + 1]['Product']['name']; ?></a>
                                    <p class="price">$<?php echo $data[$i + 1]['Product']['price']; ?></p>
                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($data[$i + 2])) : ?>
                        <div class="span4 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i + 2]['Product']['featured']['150w'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>" class="prop-title" style="text-transform: uppercase"><?php echo $data[$i + 2]['Product']['name']; ?></a>
                                    <p class="price">$<?php echo $data[$i + 2]['Product']['price']; ?></p>
                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>">View Details</a></li>
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
            url: "<?php echo $this->webroot; ?>catalogue/categorylist/?id=<?php echo $category_groupguid; ?>&cur=<?php echo $category_guid; ?>",
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