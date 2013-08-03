<!--<ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider">/</span></li>
    <li><a href="#">Gallery</a> <span class="divider">/</span></li>
    <li class="active">Category</li>
</ul>-->
<div class="row-fluid">

    <div class="span3">
        <!-- Upload image -->
        <div style="visibility: visible; box-shadow: none;" class="qbox creator-parts">


            <div class="tools" id="box-category">
            </div>
            <!-- end zone alert -->
            <!-- add text -->

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
                                <a href="property.html"><img src="<?php echo $this->webroot; ?>uploads/<?php echo $data[$i]['Product']['featured'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="property.html" class="prop-title"><?php echo $data[$i]['Product']['name']; ?></a>

                                    <p class="price"><?php echo $data[$i]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><button class="btn btn-small btn-inverse colwhite"><a href="" class="btn btn-small btn-inverse colwhite">View Details</a></button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
        <?php if (isset($data[$i + 1])) : ?>
                        <div class="span4 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="property.html"><img src="<?php echo $this->webroot; ?>uploads/<?php echo $data[$i + 1]['Product']['featured'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="property.html" class="prop-title"><?php echo $data[$i + 1]['Product']['name']; ?></a>

                                    <p class="price"><?php echo $data[$i + 1]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><button class="btn btn-small btn-inverse colwhite"><a href="" class="btn btn-small btn-inverse colwhite">View Details</a></button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
        <?php if (isset($data[$i + 2])) : ?>
                        <div class="span4 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="property.html"><img src="<?php echo $this->webroot; ?>uploads/<?php echo $data[$i + 2]['Product']['featured'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="property.html" class="prop-title"><?php echo $data[$i + 2]['Product']['name']; ?></a>

                                    <p class="price"><?php echo $data[$i + 2]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><button class="btn btn-small btn-inverse colwhite"><a href="" class="btn btn-small btn-inverse colwhite">View Details</a></button></li>
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
            url: "<?php echo $this->webroot; ?>shop/category/<?php echo $slug; ?>",
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