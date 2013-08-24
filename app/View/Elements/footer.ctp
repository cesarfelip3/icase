<?php
$controller = $this->request->controller;
$action = $this->request->action;
//print_r ($this->params);

$slug = null;
if (isset($this->params['slug'])) {
    $slug = $this->params['slug'];
}
?>
<footer>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12 ">
                <!-- Copyright info and links -->
                <div class="row-fluid">
                    <div class="span4">
                        <div>
                            <nav class="navbar">
                                <div style="border-radius:0px 0px 0px 0px;background-image:none;background-color:#efefef;" class="navbar-inner">
                                    <div class="container">
                                        <!--mobile nav icon (hidden:CSS)-->
                                        <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar"> 
                                            menu
                                        </a><!--end btn-navbar-->
                                        <div class="nav-collapse">
                                            <ul id="top-navbar" class="nav">
                                                <li class="<?php
                                                if ($controller == "creator" && $action == "index")
                                                    echo "active";
                                                ?>">
                                                    <a href="<?php echo $this->Html->Url("/create", false); ?>">Create</a>
                                                </li>
                                                <?php if (!empty($_home_menu)) : ?>
                                                    <?php foreach ($_home_menu as $value) : ?>
                                                        <li class="<?php if ($slug == $value['Category']['slug']) echo 'active'; ?>">
                                                            <a href="<?php echo $this->Html->Url("/category/{$value['Category']['slug']}", false); ?>"><?php echo $value['Category']['name']; ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div><!-- end nav-collapse -->
                                    </div><!-- end container-->
                                </div><!-- end navbar-inner -->
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span12 contact-info">
                <span class="span9">beautahful creations<strong> Phone:</strong> 123 4567 890 • <a href="mailto:info@beautahfulcreations.com"> info@beautahfulcreations.com</a>
                </span>
                <ul class="span3 social-network">
                    <li><a href="javascript:void(0)"><i class="icon-linkedin-sign"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="icon-pinterest-sign"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="icon-twitter-sign"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="icon-facebook-sign"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="icon-google-plus-sign"></i></a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div><!-- end .row-fluid -->
    </div> <!-- end .container-fluid -->
</footer>
<!-- end footer -->

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

<!-- // online creator -->
<!-- bootstrap slider -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/bootstrapslider/css/slider.css">
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/bootstrapslider/js/bootstrap-slider.js"></script>
<!-- colorpicker -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/colorpicker2/css/bootstrap-colorpicker.css">
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/colorpicker2/js/bootstrap-colorpicker.js"></script>
<!-- bootstrap date-->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/datepicker/css/datepicker.css">
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo $this->webroot; ?>js/site/icase.shoppingcart.js"></script>
<script type="text/javascript">
    jQuery(document).ready(
            function() {
                $.shoppingcart.inituuid(uuid_init_callback);
                cart_init();
                window.prettyPrint && prettyPrint();
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
        cart_count();
    }

    function cart_count() {
        console.log($.shoppingcart.total());
        $("#cart-indicator-value").html("(" + $.shoppingcart.total() + ")");
    }

</script>

<div class="row hide" id="box-alert" style="position: fixed;top:0px;left:0px;z-index:1030;margin-bottom:0;">
    <div class="span4 offset4">
        <div style="background-color:white;border:1px #ccc solid;padding:5px; ">
            <p style="margin:0;padding:0px;color:blue"><strong><span class="body"></span></strong></p>
        </div>
    </div>
</div>

<script>

    function showAlert(message)
    {
        $("#box-alert .body").html(message);
        $("#box-alert").show();
        window.setTimeout(function() {
            $("#box-alert").hide(100)
        }, 5000);
    }

    function showAlert2(message)
    {
        $("#box-alert .body").html(message);
        $("#box-alert").show();
    }

    function hideAlert(message)
    {
        $("#box-alert").hide();
    }

</script>


</body>
</html>