<!--[if !lte IE 6]><!-->
<!-- Link to Google CDN jQuery + jQueryUI; fall back to local -->

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $this->webroot; ?>js/libs/jquery.min.js"><\/script>')</script>
<script src="http://code.jquery.com/ui/1.8.0/jquery-ui.min.js"></script>
<script>window.jQuery.ui || document.write('<script src="<?php echo $this->webroot; ?>js/libs/jquery.ui.min.js"><\/script>')</script>
<script src="<?php echo $this->webroot; ?>js/jquery.cookie.js"></script>
<script src="<?php echo $this->webroot; ?>js/include/bootstrap.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(
            function() {
                var TEST_COOKIE = 'test_cookie';
                jQuery.cookie(TEST_COOKIE, true);
                if (jQuery.cookie(TEST_COOKIE))
                {

                }
                else
                {
                    jQuery("#box-message").show();
                    jQuery('.alert').alert();
                    jQuery('.alert').bind('closed', function() {
                        jQuery("#box-message").hide();
                    })
                }
            }
    )

</script>

<div class="row-fluid hide" id="box-message" style="position: fixed;top:0px;left:0px;z-index:1030;margin-bottom:0;">
    <div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Warning!</strong> We need "cookies enabled" to save your orders, seems your browser's cookies is disabled. See <a href="http://www.wikihow.com/Enable-Cookies-in-Your-Internet-Web-Browser" target="_blank">how to enable cookies in your browser</a>
    </div>
</div>

<?php
$js_themes = array(
    "libs/jquery.ui.touch-punch.min.js",
    //"http://maps.google.com/maps/api/js?sensor=true",
    "menu/jquery.ct.3LevelAccordion.min.js",
    //"slider/jquery.responsivethumbnailgallery.min.js",
    //"slider/jquery.onebyone.min.js",
    //"slider/jquery.touchwipe.min.js",
    "include/jquery.fitvids.min.js",
    "include/jquery.tweet.min.js",
    "include/jquery.equal-heights.min.js",
    //"include/jquery.todo.min.js",
    "include/jquery.pubsub.min.js",
    "include/jquery.select2.min.js",
    "jquery.storageapi.min.js",
    "config.js",
    "json2.js"
);
?>

<!-- RECOMMENDED: For (IE6 - IE8) CSS3 pseudo-classes and attribute selectors -->
<!--[if lt IE 9]> 
   <script src="<?php echo $this->webroot; ?>js/include/selectivizr.min.js"></script>                   
<![endif]-->

<?php echo $this->Html->script($js_themes); ?>

<script type="text/javascript">
    $(function() {
        $("#slider").slider();
    });
</script>   
<!-- DO NOT REMOVE: Contains major plugin initiations and functions -->
<!--<![endif]-->

<!-- bootstrap slider -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/bootstrapslider/css/slider.css">
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/bootstrapslider/js/bootstrap-slider.js"></script>
<!-- colorpicker -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/colorpicker2/css/bootstrap-colorpicker.css">
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/colorpicker2/js/bootstrap-colorpicker.js"></script>

<script src="<?php echo $this->webroot; ?>js/shoppingcart/icase.shoppingcart.js"></script>
<script type="text/javascript">
    jQuery(document).ready(
            function() {
                $.shoppingcart.inituuid(uuid_init_callback);
                cart_init();
            }
    )

    function uuid_init_callback()
    {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>user/guest?action=newuuid",
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            if (jQuery.trim(data) == "") {
                return;
            }

            if (data == null) {
                return;
            }
            $.shoppingcart.setuuid(data);

        }).fail(function() {

        });
    }
</script>

<?php if (isset($load_shop_cart) && $load_shop_cart) : ?>

    <!-- shopping cart -->
    <div class="row-fluid" id="box-cart" style="position: fixed;top:0px;left:0px;z-index:1030;margin-bottom:0;">

    </div>

    <script type="text/javascript">
        function cart_init() {
            $.shoppingcart.init();

        }

        function cart_config() {

            jQuery("#box-cart a").off('click');
            jQuery("#box-cart a").click(
                    function() {
                        var action = $(this).data('action');
                        var guid = $(this).data('guid');
                        var file = $(this).data('file');
                        var i = 0;
                        var price = 0;

                        switch (action) {
                            case 'close':
                                jQuery("#box-cart").hide(0);
                                break;
                            case 'plus' :
                                i = jQuery(this).next().text();
                                console.log(i);
                                i = parseInt(jQuery.trim(i));
                                i++;
                                jQuery(this).next().text(i);
                                if (file == "") {
                                    guid = guid;
                                } else {
                                    guid = guid + "-" + file;
                                }
                                $.shoppingcart.set(guid);
                                price = $(this).data('price');
                                price = parseFloat(price) * i;
                                $(this).parent().prev().text(price.toFixed(2));
                                break;
                            case 'minus' :
                                i = jQuery(this).prev().text();
                                console.log(i);
                                i = parseInt(jQuery.trim(i));
                                i--;
                                if (i <= 0) {
                                    $.shoppingcart.removeall(guid);
                                    cart_reload();
                                    break;
                                }
                                jQuery(this).prev().text(i);
                                if (file == "") {
                                    guid = guid;
                                } else {
                                    guid = guid + "-" + file;
                                }
                                $.shoppingcart.remove(guid);
                                price = $(this).data('price');
                                price = parseFloat(price) * i;
                                $(this).parent().prev().text(price.toFixed(2));
                                break;
                            case 'remove' :
                                if (file == "") {
                                    guid = guid;
                                } else {
                                    guid = guid + "-" + file;
                                }
                                $.shoppingcart.removeall(guid);
                                cart_reload();
                                break;
                        }
                    }
            )
        }

        function cart_reload() {
            jQuery.ajax({
                url: "<?php echo $this->webroot; ?>shop/cart",
                data: {"orders": $.shoppingcart.get(), "user": $.shoppingcart.getuuid()},
                type: "POST",
                beforeSend: function(xhr) {
                    console.log("working....");
                }
            }).done(function(data) {
                $("#box-cart").html(data);
                $("#box-cart").show();
                cart_config();
            }).fail(function() {

            });
        }
    </script>
<?php endif; ?>
