<style>
    .tools a {text-decoration:none;}
</style>
<section id="main">
    <div class="body-text">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3 hidden-phone">
                    <!-- Upload image -->
                    <div class="qbox creator-parts" style="visibility: hidden;box-shadow:none;">
                        <h3></i>IMAGE TOOLS</h3>

                        <div class="tools">
                            <div id="uploader" style="padding:0px;margin:0px;">
                                <div id="filelist" style="display:none;padding:0px;margin:0px;"></div>
                                <a href="javascript:" id="pickfiles" class="btn btn-block">Upload From Computer</a> 
                                <a href="javascript:" id="" class="btn btn-block">Upload From Photo Service</a>
                            </div>
                            <hr/>
                            <p>
                                <a href="javascript:" data-action="new" title="remove"><i class="icon-remove-sign icon-3x"></i> clear canvas</a>&nbsp;&nbsp;
                                <a href="javascript:" data-action="preview" title="remove"><i class="icon-eye-open icon-3x"></i> preview</a>
                                <!--<input id="canvas-background-color" type="text" readonly="readonly" class="input-mini" placeholder="#ffffff"/>-->
                            </p>
                        </div>
                    </div>
                    <!-- end zone alert -->
                    <!-- add text -->
                    <div class="qbox creator-parts" style="visibility: hidden;box-shadow:none;">
                        <!--<h3>BASIC TOOLS</h3>-->
                        <!--<button id="singlebutton" name="singlebutton" class="btn btn-default">Enter Drawing mode</button>-->
                        <div style="padding-top:5px;" class="tools">
                            <p>
                                <a href="javascript:" data-action="backward" title="backward"><i class="icon-chevron-down icon-3x"></i></a>&nbsp;&nbsp;
                                <a href="javascript:" data-action="forward" title="forward"><i class="icon-chevron-up icon-3x"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:" data-action="back" title="bottom"><i class="icon-circle-arrow-down icon-3x"></i></a>&nbsp;&nbsp;
                                <a href="javascript:" data-action="front" title="top"><i class="icon-circle-arrow-up icon-3x"></i></a>
                            </p>
                            <p style="margin-top:15px;display:block;"><a href="javascript:" data-action="flipx"><i class="icon-resize-horizontal icon-2x"></i> <b>flip horizontal</b></a><a href="javascript:" data-action="flipy" style="margin-left:10px;"><i class="icon-resize-vertical icon-2x"></i> <b>flip vertical</b></a></p>
                            <hr/>
                            <p>
                                <a href="javascript:" data-action="remove" title="remove"><i class="icon-remove-sign icon-3x"></i> remove</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:" data-action="group" title="group"><i class="icon-resize-small icon-3x"></i> group</a>&nbsp;&nbsp;
                            </p>
                            <p style="margin-top:15px;display:block;">
                                <a href="javascript:" data-action="newtext" title="remove"><i class="icon-font icon-3x"></i> new text</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:" data-action="draw" title="remove"><i class="icon-pencil icon-3x"></i> draw</a>
                            </p>
                        </div><!-- tools -->
                    </div>
                </div>
                <div class="span6 listing-js">

                    <!--start Canvas-->
                    <div>
                        <div class="progress" style="height:2px"><div class="bar bar-warning" id="progress-bar" style="width: 0%; height:2px;"></div></div>
                        <div class="ajax-loading-indicator" style="position: absolute;"><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading Canvas...</a></div>
                        <canvas class="upper-canvas " style="border: 1px solid rgb(170, 170, 170); -moz-user-select: none; cursor: crosshair;" width="450" height="450" id="c1"></canvas>				   </div>
                    <!--end Canvas-->
                    <div class="row-fluid text-editor hide editor" style="width:100%;border:1px solid #ccc;background-color:white;margin-top:10px;padding:5px;">
                        <div class="span12">
                            <form class="form-inline">
                                <input type="text" class="input-medium" id="text-text" placeholder="text" />
                                <input id="text-fill" type="text" class="input-mini" readonly="readonly" placeholder="font color" />
                                <select id="text-font-family" style="width:auto !important;margin-top:1px;">
                                    <option value="Impact">Impact</option>
                                    <option value="Helvitica">Helvitica</option>
                                    <option value="Arial">Arial</option>
                                    <option value="Verdana">Verdana</option>
                                </select>
                                <a href="javascript:" class="btn btn-small" data-action="bold" data-toggle="button"><i class="icon-bold"></i></a>
                                <a href="javascript:" class="btn btn-small" data-action="italic" data-toggle="button"><i class="icon-italic"></i></a>
                            </form>
                        </div>
                    </div><!-- end of text editor -->
                    <div class="row-fluid image-editor hide editor" style="width:100%;border:1px solid #ccc;background-color:white;margin-top:10px;padding:5px;">
                        <div class="span6">
                            <div><b>Zoom</b></div>
                            <div><input type="text" value="" data-slider-min="50" data-slider-max="300" data-slider-step="1" data-slider-value="100" data-slider-id="RC" id="image-zoom" data-slider-selection="none" data-slider-tooltip="show" data-slider-handle="square" style="width:150px"></div>
                        </div>
                        <div class="span6">
                            <div style="clear:both;display:block;"><b>Rotation</b></div>
                            <div><input type="text" value="" data-slider-min="0" data-slider-max="360" data-slider-step="1" data-slider-value="0" data-slider-id="RC" id="image-rotation" data-slider-selection="none" data-slider-tooltip="show" data-slider-handle="square" style="width:150px" ></div>
                        </div>
                    </div><!-- Image Editor -->
                    <div class="row-fluid draw-editor hide creator-parts" style="width:100%;border:1px solid #ccc;background-color:white;margin-top:10px;padding:5px;margin-bottom:20px;">
                        <div class="span6">
                            <div><b>Line Width</b></div>
                            <div><input type="text" value="" data-slider-min="1" data-slider-max="30" data-slider-step="1" data-slider-value="1" data-slider-id="RC" id="draw-width" data-slider-selection="none" data-slider-tooltip="show" data-slider-handle="square" style="width:150px"></div>
                        </div>
                        <div class="span6">
                            <div style="clear:both;display:block;"><b>Shadow Width</b></div>
                            <div><input type="text" value="" data-slider-min="1" data-slider-max="30" data-slider-step="1" data-slider-value="1" data-slider-id="RC" id="draw-shadow-width" data-slider-selection="none" data-slider-tooltip="show" data-slider-handle="square" style="width:150px" ></div>
                        </div>
                        <div style="clear:both"></div>
                        <div style="margin-top:10px;display:block;">
                            <input id="draw-fill" type="text" class="input-mini" readonly="readonly" placeholder="color" value="#000000" />

                            <select id="draw-mode-selector" style="width:auto !important;margin-top:1px;">
                                <option>Pencil</option>
                                <option>Circle</option>
                                <option>Spray</option>
                                <option>Pattern</option>

                                <option>hline</option>
                                <option>vline</option>
                                <option>square</option>
                                <option>diamond</option>
                                <option>texture</option>
                            </select>
                        </div>
                    </div><!-- draw editor -->
                </div>
                <!-- end listing-js -->

                <div class="span3">
                    <!--
                            "Quick Search" Widget
                            
                            SPECIAL NOTE: Please leave the inline style for <Select></Select> "width:100%",
                                                      the width is automatically "Re-adjusted" with javascript
                                                      See "config.js" for more details	
                    -->
                    <p><a class="btn btn-large btn-peach hide" id="btn-order"><i class="icon-mobile-phone icon-1x"></i> <span>Order Now</span></a></p>
                    <div class="qbox creator-parts" style="visibility:hidden;box-shadow:none;">
                        <h3><i class="icon-refresh icon-spin pull-right"></i>Choose Your Device</h3>
                        <div style="overflow: auto;height:460px;margin:0px;padding:0px;" id="template-list">

                        </div>
                        <form id="cart-form"><input type="hidden" id="current-item" /></form>
                    </div>
                    <div class="qbox hide" style="display: none;">
                        <h3><i class="icon-search pull-right"></i>Filters</h3>
                        <form>
                            <!-- Multiple Checkboxes -->
                            <div class="control-group">
                                <label class="control-label" for="checkboxes"></label>
                                <div class="controls">
                                    <label class="checkbox" for="checkboxes-0">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-0" value="Grayscale:">
                                        Grayscale
                                    </label>
                                    <label class="checkbox" for="checkboxes-1">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-1" value="Invert:">
                                        Invert
                                    </label>
                                    <label class="checkbox" for="checkboxes-2">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-2" value="Sepia:">
                                        Sepia
                                    </label>

                                    <label class="checkbox" for="checkboxes-3">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-3" value="Sepia2:">
                                        Sepia2
                                    </label>

                                    <label class="checkbox" for="checkboxes-0">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-0" value="Grayscale:">
                                        Blur
                                    </label>
                                    <label class="checkbox" for="checkboxes-1">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-1" value="Invert:">
                                        Sharpen
                                    </label>
                                    <label class="checkbox" for="checkboxes-2">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-2" value="Sepia:">
                                        Emboss:
                                    </label>

                                    <label class="checkbox" for="checkboxes-3">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-3" value="Sepia2:">
                                        Waterize:
                                    </label>

                                    <label class="checkbox" for="checkboxes-4">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-4" value="Remove white:">
                                        Remove white:
                                    </label>
                                    <label>Distance: <input type="range" id="remove-white-distance" value="10" min="0" max="255"></label>


                                    <label class="checkbox" for="checkboxes-5">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-5" value="Remove-white">
                                        Brightness:
                                    </label>
                                    <label>Value: <input type="range" id="remove-white-distance" value="10" min="0" max="255"></label>

                                    <label class="checkbox" for="checkboxes-6">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-6" value="Noise">
                                        Noise:
                                    </label>
                                    <label>Value: <input type="range" id="remove-white-distance" value="10" min="0" max="255"></label>


                                    <label class="checkbox" for="checkboxes-7">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-7" value="GradientTransparency">
                                        GradientTransparency:
                                    </label>
                                    <label>Value: <input type="range" id="gradientTransparency" value="10" min="0" max="255"></label>

                                    <label class="checkbox" for="checkboxes-7">
                                        <input type="checkbox" name="checkboxes" id="checkboxes-7" value="Pixelate">
                                        Pixelate:
                                    </label>
                                    <label>Value: <input type="range" id="Pixelate" value="10" min="0" max="255"></label>

                                    <label>Amplitude: <input type="range" id="Amplitude" value="10" min="0" max="255"></label>
                                    <label>Frequency: <input type="range" id="Frequency" value="10" min="0" max="255"></label>
                                    <label>Offset: <input type="range" id="Offset" value="10" min="0" max="255"></label>

                                </div>
                            </div>   
                        </form>
                    </div>	
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--/end my short list-->
                </div>
                <!-- end span3 -->					
            </div>
            <!-- end row-fluid -->
        </div>
        <!-- end fluid-container -->
    </div>
    <!-- end body-text -->
</section>
<!-- end section -->

<!-- plupload -->

<?php
$js_pluploader = array(
    "http://bp.yahooapis.com/2.4.21/browserplus-min.js",
    "pluploader/plupload.js",
    //"pluploader/plupload.gears.js",
    //"pluploader/plupload.flash.js",
    "pluploader/plupload.browserplus.js",
    "pluploader/plupload.html4.js",
    "pluploader/plupload.html5.js"
);
?>

<?php echo $this->Html->script($js_pluploader); ?>

<script type="text/javascript">
    // Custom example logic

    function PL(id) {
        return document.getElementById(id);
    }

    var uploader = new plupload.Uploader({
        runtimes: 'gears,html5,browserplus',
        browse_button: 'pickfiles',
        container: 'uploader',
        max_file_size: '10mb',
        url: 'media/upload',
        multi_selection: false,
        //resize: {width: 640, height: 240, quality: 100},
        //flash_swf_url: 'js/uploader/plupload.flash.swf',
        //silverlight_xap_url : 'js/uploader/plupload.silverlight.xap',
        filters: [
            {title: "Excel files", extensions: "png,jpeg,jpg,gif"}
        ]
    });

    uploader.bind('Init', function(up, params) {
        //$('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
    });

    uploader.init();

    uploader.bind('FilesAdded', function(up, files) {

        console.log("hello");
        if (uploader.files.length == 2) {
            uploader.removeFile(uploader.files[0]);
        }

        for (var i in files) {
            //document.getElementById('filelist').innerHTML = '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
        }
        jQuery('#progress-bar').css('width', "0%");
        uploader.start();
    });

    uploader.bind('UploadProgress', function(up, file) {
        //$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        jQuery('#progress-bar').css('width', file.percent + "%");

    });

    uploader.bind('FileUploaded', function(up, file, response) {
        plupload.each(response, function(value, key) {

            console.log(key);
            console.log(value);

            if (key == "response") {
                var result = jQuery.parseJSON(value);
                console.log(result);
                if (result.error == 0) {
                    console.log(result.files.url);
                    mememaker.tools.addpic(result.files.url);
                }
                //jQuery('#progress-bar').css('width', "0%");
            }
        });

        //alert($.parseJSON(response.response).result);
    });

</script>

<!-- fabric.js -->
<!--<script src="<?php echo $this->webroot; ?>js/fabricjs/fabric.min.js"></script>-->

<?php
$js_case = array(
    "http://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.2.0/fabric.all.min.js",
    "creator/icase.casecreator.js"
        )
?>

<?php echo $this->Html->script($js_case); ?>

<script type="text/javascript">
    jQuery(document).ready(
            function() {
                mememaker.init('c1');
                mememaker.tools.init(".tools");
                mememaker.tools.generate = preview;
                mememaker.texteditor.init(".text-editor");
                mememaker.imageeditor.init(".image-editor");
                mememaker.draweditor.init(".draw-editor");

                jQuery(".ajax-loading-indicator").hide(0);
                jQuery("#btn-order").show(1000);
                jQuery(".creator-parts").delay(1000).show(0).css('visibility', 'visible');

                jQuery.ajax({
                    url: "shop/gettemplates",
                    type: "GET",
                    beforeSend: function(xhr) {
                        console.log("working....");
                    }
                }).done(function(data) {

                    $("#template-list").prev().children(":first-child").hide(0);
                    result = jQuery.parseJSON(data);
                    jQuery(result).each(
                            function(index, value) {
                                var html = jQuery("#template-list").html() + '<h6>' + value.Product.name + ' ' + value.Product.price + '$</h6><a href="javascript:" class="thumbnail" data-price="' + value.Product.price + '" data-guid="' + value.Product.guid + '"><img src="' + value.Product.image + '" /></a><br/>';
                                jQuery("#template-list").html(html);
                            }
                    );

                    templatelist_config();

                }).fail(function() {
                    $("#template-list").prev().children(":first-child").hide(0);
                });

                jQuery("#btn-order").click(
                        function() {

                            if (jQuery.trim(jQuery("#current-item").val()) == "") {
                                return;
                            }
                            mememaker.tools.preview(preview);
                            return;
                        }
                );

                jQuery("#btn-cart").click(
                        function() {

                            var orderId = null;
                            orderId = jQuery("#modal-preview #product-info").data('guid');
                            var image = jQuery("#modal-preview #product-info").data('file');

                            shoppingcart.set(orderId + "-" + image);
                            console.log(shoppingcart.get());

                            jQuery("#modal-preview").modal('hide');

                            cart_reload();
                        }
                )

            }
    );

    function templatelist_config() {

        jQuery("#template-list a").off('click');
        jQuery("#template-list a").click(
                function() {
                    var url = $(this).children(":first-child").attr('src');
                    mememaker.tools.newtemplate(url);
                    $("#current-item").val($(this).data('guid'));
                    shoppingcart.setCurrentProductId($(this).data('guid'));
                    $("#btn-order span").text("Order Now " + $(this).data('price') + "$");
                }
        );
    }

    function preview(preview)
    {
        if (jQuery.trim(jQuery("#current-item").val()) == "") {
            return;
        }
        jQuery("#modal-preview .modal-body").html('<div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>');
        jQuery(".ajax-loading-indicator").show(0);
        jQuery("#modal-preview").modal();

        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>shop/preview",
            data: {"image-extension": "jpeg", "image-data": preview, "user": shoppingcart.getuuid(), "product": jQuery("#current-item").val()},
            type: "POST",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            jQuery(".ajax-loading-indicator").hide(0);
            jQuery("#modal-preview .modal-body").html(data);
            checkoutone();

        }).fail(function() {
            jQuery(".ajax-loading-indicator").hide(0);
        });
    }

    function checkoutone()
    {
        var orderId = null;
        orderId = jQuery("#modal-preview #product-info").data('guid');
        var image = jQuery("#modal-preview #product-info").data('file');

        console.log(orderId + "-" + image);
        shoppingcart.setCurrentProductId(orderId + "-" + image);
        return true;
    }

</script>

<!-- preview modal -->
<div id="modal-preview" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Your Design</h3>
    </div>
    <div class="modal-body" style='background:url("<?php echo $this->webroot; ?>img/pattern/whitey.png") repeat scroll 0 0 transparent;'>
        <div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>
    </div>
    <div class="modal-footer">
        <span class="pull-left">To save your design, you have to login</span>
        <a href="javascript:">Login</a> Or
        <a href="javascript:">register</a>
    </div>
    <div class="modal-footer">
        <a href="javascript:" class="btn btn-peach" id="btn-cart">Add To Cart</a>
        <a href="<?php echo $this->webroot; ?>shop/checkout/?action=single" class="btn btn-peach" target="_blank">Buy Now!</a>
    </div>
</div>

