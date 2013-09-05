
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
                        <div class="span4">
                            <div class="thumbnail" style="background-image:none;background-color:white;">
                                <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i]['Product']['slug']; ?>">
                                    <img src="<?php echo $data[$i]['Product']['image']; ?>" alt="<?php echo $data[$i]['Product']['name']; ?>" style="width:100%;">
                                </a>
                                <div class="caption">
                                    <div style="height:70px">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i]['Product']['slug']; ?>" style="text-transform: uppercase"><?php echo $data[$i]['Product']['name']; ?></a>
                                    <p class="price">$<?php echo $data[$i]['Product']['price']; ?></p>
                                    </div>
                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i]['Product']['slug']; ?>">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($data[$i + 1])) : ?>
                        <div class="span4">
                            <div class="thumbnail" style="background-image:none;background-color:white;">
                                <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>"><img src="<?php echo $data[$i + 1]['Product']['image']; ?>" alt="<?php echo $data[$i + 1]['Product']['name']; ?>"  style="width:100%;"></a>
                                <div class="caption">
                                    <div style="height:70px">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>" style="text-transform: uppercase"><?php echo $data[$i + 1]['Product']['name']; ?></a>
                                    <p class="price">$<?php echo $data[$i + 1]['Product']['price']; ?></p>
                                    </div>
                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($data[$i + 2])) : ?>
                        <div class="span4">
                            <div class="thumbnail" style="background-image:none;background-color:white;">
                                <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>">
                                    <img src="<?php echo $data[$i + 2]['Product']['image']; ?>" alt="<?php echo $data[$i + 2]['Product']['name']; ?>"  style="">
                                </a>
                                <div class="caption">
                                    <div style="height:70px">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>" style="text-transform: uppercase"><?php echo $data[$i + 2]['Product']['name']; ?></a>
                                    <p class="price">$<?php echo $data[$i + 2]['Product']['price']; ?></p>
                                    </div>
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
<div class="row-fluid">
    <div class="span11">
        <div class="pagination pull-right">
            <ul>
                <li><a href="<?php echo $this->webroot . "category/$slug?page=" . ($page > 1 ? $page - 1 : 0); ?>">Prev</a></li>
                <?php $min = $page - 5; $max = $page + 5; ?>
                <?php $min = $min < 0 ? 0 : $min; $max = $max > $pages ? $pages : $max; ?>
                <?php for ($i = $min; $i < $max; ++$i) : ?>
                    <li <?php if ($i == $page) echo 'class="active"'; ?>><a href="<?php echo $this->webroot . "category/$slug?page=$i"; ?>"><?php echo $i + 1; ?></a></li>
                <?php endfor; ?>
                <li><a href="<?php echo $this->webroot . "category/$slug?page=" . ($page < $pages - 1 ? $page + 1 : $pages - 1); ?>">Next</a></li>
            </ul>
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