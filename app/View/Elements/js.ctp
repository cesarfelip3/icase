<!--[if !lte IE 6]><!-->
<!-- Link to Google CDN jQuery + jQueryUI; fall back to local -->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery.min.js"><\/script>')</script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $this->webroot; ?>js/libs/jquery.min.js"><\/script>')</script>
<script src="http://code.jquery.com/ui/1.8.0/jquery-ui.min.js"></script>
<script>window.jQuery.ui || document.write('<script src="<?php echo $this->webroot; ?>js/libs/jquery.ui.min.js"><\/script>')</script>

<?php

$js_jquery_ui = array (
    "libs/jquery.ui.touch-punch.min.js",
    //"http://maps.google.com/maps/api/js?sensor=true",
    "menu/jquery.ct.3LevelAccordion.min.js",
    "slider/jquery.responsivethumbnailgallery.min.js",
    "slider/jquery.onebyone.min.js",
    "slider/jquery.touchwipe.min.js",
    "include/jquery.fitvids.min.js",
    "include/jquery.tweet.min.js",
    "include/jquery.equal-heights.min.js",
    "include/jquery.todo.min.js",
    "include/jquery.pubsub.min.js",
    "include/jquery.select2.min.js",
    "include/bootstrap.min.js",
    "config.js",
    "jquery.cookie.js",
    "json2.js",
    "jquery.storageapi.min.js",
);

?>

<!-- RECOMMENDED: For (IE6 - IE8) CSS3 pseudo-classes and attribute selectors -->
<!--[if lt IE 9]> 
   <script src="<?php echo $this->webroot; ?>js/include/selectivizr.min.js"></script>                   
<![endif]-->

<?php echo $this->Html->script($js_jquery_ui); ?>

<script type="text/javascript">
$(function() {
    $( "#slider" ).slider();
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

<!-- shopping cart -->
<script src="<?php echo $this->webroot; ?>js/shoppingcart/icase.shoppingcart.js"></script>
<div class="row-fluid" id="box-cart" style="position: fixed;top:0px;left:0px;z-index:1030;margin-bottom:0;">
    
</div>
