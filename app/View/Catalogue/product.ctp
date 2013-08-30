<?php
$checkout_cart_url = $this->webroot . "shop/checkout/?action=cart";
?>
<div class="body-text">
    <div class="container-fluid">
        <!-- 2 columns -->
        <div class="row-fluid">
            <div class="span6">
                <div style="background-color:white;border-radius: 5px;border:1px solid #ccc;padding:10px;"><img src="<?php echo $this->webroot . "uploads/product/" . pathinfo($data['featured']['origin'][0], PATHINFO_FILENAME) . "_500.png"; ?>" ></div>
            </div>
            <div class="span6">
                <h3><strong><span style="text-transform: uppercase;"><?php echo $data['name']; ?></span></strong> </h3>
                <hr class="black">
                <p class="asking-price">$<?php echo $data['price']; ?></p>
                <hr />
                <div data-lstyle="case_description" data-l="case_description" class="case-desc case_description" style="height:200px;overflow: auto;"><?php echo $data['description']; ?></div>
                <hr />
                <input type="text" value="1" class="input-mini" id="product-quantity" />
                <span class="label label-warning"><?php if ($data['quantity'] != 65535) echo $data['quantity']; else echo "UNLIMITED"; ?> LEFT</span><br/>
                <a class="btn btn-warning" id="btn-cart" data-guid="<?php echo $data['guid']; ?>" data-file="" data-max="<?php echo $data['quantity']; ?>">Add To Cart</a>

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

                            var count = $("#product-quantity").val();
                            count = $.trim (count);
                            console.log (count);
                            
                            if (count.match(/^[1-9][0-9]{0,}$/)) {
                                count = parseInt(count);
                                
                                if (count > parseInt($(this).data('max'))) {
                                    alert("Sorry, we don't have enough products in stock")
                                    return;
                                }
                                console.log (count);
                                $.shoppingcart.set(orderId, count);
                                console.log ($.shoppingcart.get());
                            } else {
                                alert("Please input a valid quantity");
                                return false;
                            }

                            window.location.href = "<?php echo $checkout_cart_url; ?>";
                        });
            });


</script>