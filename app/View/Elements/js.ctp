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
<!-- bootstrap date-->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/datepicker/css/datepicker.css">
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo $this->webroot; ?>js/shoppingcart/icase.shoppingcart.js"></script>
<script type="text/javascript">
    jQuery(document).ready(
            function() {
                $.shoppingcart.inituuid(uuid_init_callback);
                cart_init();
                window.prettyPrint && prettyPrint();
                jQuery(".datepicker").datepicker({format: 'yyyy-mm-dd'});
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
    
    function cart_init() {
        $.shoppingcart.init();

    }

</script>

    <div class="row hide" id="box-alert" style="position: fixed;top:0px;left:0px;z-index:1030;margin-bottom:0;">
        <div class="span4 offset4">
            <div style="background-color:yellow;min-height:30px;border:1px black solid; ">
                <p style="margin-top:5px;margin-left:20px;"><strong><span class="body"></span></strong></p>
            </div>
        </div>
    </div>
    
    <script>
        
        function showAlert (message)
        {
            $("#box-alert .body").html(message);
            $("#box-alert").show ();
            window.setTimeout(function () {$("#box-alert").hide(100)}, 5000);
        }
        
        function showAlert2 (message) 
        {
            $("#box-alert .body").html(message);
            $("#box-alert").show ();
        }
        
        function hideAlert (message)
        {
            $("#box-alert").hide ();
        }
        
    </script>
