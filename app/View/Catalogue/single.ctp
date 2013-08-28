
<div class="body-text">
    <div class="container-fluid">
        <!-- 2 columns -->
        <div class="row-fluid">
            <div class="span6">
                <p><img src="<?php echo $this->webroot . "uploads/product/" . str_replace (".", "_500.", $data['featured']['origin'][0]); ?> ?>"></p>
            </div>
            <div class="span6">
                <h3><strong><span style="text-transform: uppercase;"><?php echo $data['name']; ?></span></strong> </h3>
                <hr class="black">
                <p class="asking-price">$<?php echo $data['price']; ?></p>
                <hr class="black">
                <div data-lstyle="case_description" data-l="case_description" class="case-desc case_description" style="height:200px;overflow: auto;"><?php echo $data['description']; ?></div>
                <hr class="black"><br>

                <a class="btn btn-danger" id="btn-cart" data-guid="<?php echo $data['guid']; ?>" data-file="">Add To Cart</a>

                <div class="social_wrapper">
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style ">
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_pinterest_pinit"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <script type="text/javascript">var addthis_config = {"data_track_addressbar": true};</script>
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51937361798a0638"></script>
                    <!-- AddThis Button END -->
                </div>
                <div class="thumwrapper">
                    <?php if (!empty($data['featured']['150w'])) : ?>
                        <?php foreach ($data['featured']['150w'] as $image) : ?>
                            <img src="<?php echo $this->webroot . "uploads/product/" . $image; ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>			
        </div>
        <!--end 2 columns-->
        <!-- start row-rluid demo -->
        <div class="row-fluid demo">

            <!-- end .row-fluid -->	
        </div>
        <!-- end .row-fluid demo -->
    </div>
    <!-- end container-fluid-->
</div>
<!-- end body-text -->


<!-- /container -->

<script>
    $(document).ready(
            function() {
                jQuery("#btn-cart").click(
                        function() {
                            var orderId = null;
                            orderId = jQuery(this).data('guid');

                            $.shoppingcart.set(orderId);
                            
                            window.location.href = "<?php echo $this->webroot; ?>shop/checkout?action=cart";
                            //window.open("<?php echo $this->webroot; ?>shop/checkout?action=cart", "_self");
                            //window.focus();
                        });
            });


</script>