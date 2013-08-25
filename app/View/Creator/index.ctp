<?php
$loginform_url = $this->webroot . "auth/formuser";
$signin_url = $this->webroot . "signin";
$signup_url = $this->webroot . "signup";

$template_url = $this->webroot . "creator/templates";
$preview_url = $this->webroot . "creator/preview";
$save_url = $this->webroot . "creator/save";
$reload_url = $this->webroot . "creator/reload";

$uploader_url = $this->webroot . "media/upload";

$checkout_url = $this->webroot . "shop/checkout?action=cart";
?>

<style>
    .tools a {text-decoration:none;margin-right:10px;}
    /*.tools label {width:100px;display:inline-block;}*/
    hr {border-color:#E9E9E9}
</style>
<div class="body-text">
    <div class="container-fluid qbox creator-parts" style="margin:0 !important; box-shadow:none;font-size:14px;background:#EEE;padding:10px;">
        <div class="row-fluid">
            <div style="display:block;width:100%;height:30px">
                <div class="pull-left tools" id="uploader" style="padding:0px;margin:0px;">
                    <div id="filelist" style="display:none;padding:0px;margin:0px;"></div>
                    <a href="javascript:" id="btn-upload-image"><i class="icon-picture icon-2x"></i> From Computer</a> 
                    <a href="javascript:"><i class="icon-picture icon-2x"></i> From Service</a>
                    <a href="javascript:" data-action="new" title="remove"><i class="icon-remove-sign icon-2x"></i> <span>clear canvas</span></a>
                    <a href="javascript:" data-action="preview" title="remove"><i class="icon-eye-open icon-2x"></i> preview</a>
                    <a href="javascript:" data-action="save" title="remove"><i class="icon-save icon-2x"></i> save</a>
                </div>
                <div class="tools pull-right">
                    <a id="btn-order" onclick="order();" style="background-color:orange;padding:2px;padding-left:12px; padding-right:10px; color:white;text-shadow: none;" href="javascript:">
                        <i class="icon-shopping-cart icon-2x"></i> 
                        <span>Order Now</span>
                    </a>
                </div>
            </div>
        </div>
        <div style="clear:both;border-top:1px solid #bbb;width:100%;margin-top:5px;margin-bottom:5px;"></div>
        <div class="row-fluid">
            <div class="span12">
                <div class="tools">
                    <div style="padding:5px;">
                        <a href="javascript:" data-action="backward" title="backward"><i class="icon-chevron-down icon-2x"></i> backward</a>
                        <a href="javascript:" data-action="forward" title="forward"><i class="icon-chevron-up icon-2x"></i> forward</a>
                        <a href="javascript:" data-action="back" title="bottom"><i class="icon-circle-arrow-down icon-2x"></i> back</a>
                        <a href="javascript:" data-action="front" title="top"><i class="icon-circle-arrow-up icon-2x"></i> front</a>
                        <a href="javascript:" data-action="flipx"><i class="icon-resize-horizontal icon-2x"></i> <b>flip 90</b></a>
                        <a href="javascript:" data-action="flipy" style="margin-left:5px;"><i class="icon-resize-vertical icon-2x"></i> <b>flip 180</b></a>
                        <a href="javascript:" data-action="remove" title="remove"><i class="icon-remove-sign icon-2x"></i> remove</a>
                        <a href="javascript:" data-action="group" title="group"><i class="icon-resize-small icon-2x"></i> group</a>
                        <a href="javascript:" data-action="newtext" title="remove"><i class="icon-font icon-2x"></i> new text</a>
                        <a href="javascript:" data-action="draw" title="remove"><i class="icon-pencil icon-2x"></i> draw</a>
                        <a id="canvas-background-color" type="text" class="input-mini" readonly="readonly" placeholder="background" style="width:20px;height:40px;background-color:#ccc;border:1px solid black;" href="javascript:">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    </div>
                </div>
            </div> 
        </div>
        <!-- canvas -->
        <div class="progress" style="height:2px;display:block;width:100%;margin-top:10px;"><div class="bar bar-warning" id="progress-bar" style="width: 0%; height:2px;"></div></div>
        <input type="hidden" id="current-item" style="display:none;" />
        <input type="hidden" name="canvas_guid" id="canvas_guid" style="display:none;" value="<?php echo $canvas_guid; ?>" data-reload="<?php echo $canvas_load; ?>" />
        <div class="row-fluid">
            <div class="span10" style="width:780px;">
                <div>
                    <div class="ajax-loading-indicator" style="position: absolute;"><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading Canvas...</a></div>
                    <canvas class="upper-canvas " style="border: 1px #ccc dashed; -moz-user-select: none; cursor: crosshair;" width="780" height="780" id="c1"></canvas>				   
                </div>
            </div>
            <div class="span2" id="box-template-list" style="border:1px #ccc dashed;width:130px;padding:5px;background-color:white;">

            </div>
        </div>
        <!-- editor -->
        <div class="row-fluid">
            <div class="text-editor editor span9 hide" style="width:100%;border:1px solid #ccc;margin-top:10px;padding:5px;">
                <form class="form-inline">
                    <input type="text" class="input-xlarge" id="text-text" placeholder="text" />
                    <input id="text-fill" type="text" class="input-mini" readonly="readonly" placeholder="font color" />
                    <select id="text-font-family" style="width:auto !important;margin-top:1px;">
                        <option value="Impact">Impact</option>
                        <option value="Helvitica">Helvitica</option>
                        <option value="Arial">Arial</option>
                        <option value="Verdana">Verdana</option>
                    </select>
                    <div class="display:inline">
                        <a href="javascript:" class="btn btn-small" data-action="bold" data-toggle="button"><i class="icon-bold"></i></a>
                        <a href="javascript:" class="btn btn-small" data-action="italic" data-toggle="button"><i class="icon-italic"></i></a>
                    </div>
                </form>
            </div><!-- end of text editor -->
            <div style="clear:both;"></div>
        </div>
        <div class="row-fluid">
            <div class="image-editor editor span9 hide" style="width:100%;border:1px solid #ccc;margin-top:10px;padding:5px;clear:both;">
                <div style="display:inline"><span style="display:inline-block;width:60px;">ZOOM</span><input type="text" value="" data-slider-min="10" data-slider-max="300" data-slider-step="1" data-slider-value="100" data-slider-id="RC" id="image-zoom" data-slider-selection="none" data-slider-tooltip="show" data-slider-handle="square" style="width:150px"></div>
                <div style="display:inline;margin-left:20px;"><span style="display:inline-block;width:90px;">ROTATION</span><input type="text" value="" data-slider-min="0" data-slider-max="360" data-slider-step="1" data-slider-value="0" data-slider-id="RC" id="image-rotation" data-slider-selection="none" data-slider-tooltip="show" data-slider-handle="square" style="width:150px" ></div>
            </div><!-- Image Editor -->
        </div>
        <div class="row-fluid">
            <div class="draw-editor span9 hide" style="width:100%;border:1px solid #ccc;margin-top:10px;padding:5px;margin-bottom:20px;">
                <div style="display:inline"><span style="display:inline-block;width:100px;"><b>LINE WIDTH</b></span><input type="text" value="" data-slider-min="1" data-slider-max="30" data-slider-step="1" data-slider-value="1" data-slider-id="RC" id="draw-width" data-slider-selection="none" data-slider-tooltip="show" data-slider-handle="square" style="width:150px"></div>
                <div style="display:inline;margin-left:10px;"><span style="display:inline-block;width:130px;"><b>SHADOW WIDTH</b></span><input type="text" value="" data-slider-min="1" data-slider-max="30" data-slider-step="1" data-slider-value="1" data-slider-id="RC" id="draw-shadow-width" data-slider-selection="none" data-slider-tooltip="show" data-slider-handle="square" style="width:150px" ></div>
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

    </div>
    <!-- end fluid-container -->
</div>
<!-- end body-text -->

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
    function PL(id) {
        return document.getElementById(id);
    }

    var uploader = new plupload.Uploader({
        runtimes: 'gears,html5,browserplus',
        browse_button: 'btn-upload-image',
        container: 'uploader',
        max_file_size: '10mb',
        url: '<?php echo $uploader_url; ?>',
        multi_selection: false,
        //resize: {width: 640, height: 240, quality: 100},
        //flash_swf_url: 'js/uploader/plupload.flash.swf',
        //silverlight_xap_url : 'js/uploader/plupload.silverlight.xap',
        filters: [
            {title: "Image Files", extensions: "png,jpeg,jpg,gif"}
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
                    showAlert2("Loading image....");
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
    "site/icase.casecreator.js"
        )
?>

<?php echo $this->Html->script($js_case); ?>

<script type="text/javascript">
    jQuery(document).ready(
            function() {

                $(window).on('beforeunload', function() {
                    //return 'Are you sure you want to leave? Your design isn\'t saved yet.';
                });

                newcase_init();

            }
    );

    function order_config() {

        jQuery("#btn-cart").click(
                function() {

                    var orderId = null;
                    orderId = jQuery("#modal-preview #product-info").data('guid');
                    var image = jQuery("#modal-preview #product-info").data('file');

                    $.shoppingcart.set(orderId + "-" + image);

                    jQuery("#modal-preview").modal('hide');
                    cart_count();

                    window.open("<?php echo $checkout_url; ?>", "_blank");
                    window.focus();
                }
        )
    }

    function newcase_init()
    {
        mememaker.init('c1');
        mememaker.tools.init(".tools");
        mememaker.tools.generate = preview;

        mememaker.save_callback = save_canvas;

        mememaker.texteditor.init(".text-editor");
        mememaker.imageeditor.init(".image-editor");
        mememaker.draweditor.init(".draw-editor");
        //mememaker.tools.backgroundcolor("red");

        templatelist_load();

        if ($("#canvas_guid").data('reload') == "1") {
            reload_canvas ();
        }

        jQuery(".ajax-loading-indicator").hide(0);
        jQuery("#btn-order").show(1000);
        jQuery(".creator-parts").delay(1000).show(0).css('visibility', 'visible');
    }

    //===========================================================
    //
    //===========================================================

    function save_canvas(json)
    {
        var id = $("#canvas_guid").val();
        var name = $("#current-item").data('name');
        var guid = $("#current-item").val();

        if ($("#current-item").val() == "") {
            alert("You don't have to save an empty canvas.");
            return false;
        }

        jQuery.ajax({
            url: "<?php echo $save_url; ?>/?id=" + id,
            data: {'json': json, 'name': name, 'product': guid},
            type: "POST",
            beforeSend: function(xhr) {

            }
        }).done(function(data) {

            var result = $.parseJSON(data);
            if (result.error == 1) {
                $("#modal-user").modal();
                formuser_load ();
            } else {
                $("#canvas_guid").val(result.data.guid);
                $("#canvas_guid").data('saved', '1');
                alert("Your progress just saved");
            }

        }).fail(function() {
            //$("#template-list").prev().children(":first-child").hide(0);
        });
    }

    function reload_canvas()
    {
        var guid = $("#canvas_guid").val();

        jQuery.ajax({
            url: "<?php echo $reload_url; ?>",
            data: {'guid': guid},
            type: "POST",
            beforeSend: function(xhr) {

            }
        }).done(function(data) {

            //console.log (data);
            var result = $.parseJSON(data);
            //console.log(data);

            if (result.error == 1) {

            } else {
                //console.log (result.data.json);
                $("#current-item").data('overlay', result.data.overlay);
                $("#current-item").data('name', result.data.name);
                $("#current-item").val(result.data.product);
                mememaker.overlayImage = result.data.overlay;
                mememaker.reload(result.data.json);
            }

        }).fail(function() {
            //$("#template-list").prev().children(":first-child").hide(0);
        });
    }

    //===========================================================
    // template list
    //===========================================================
    function templatelist_load()
    {
        jQuery.ajax({
            url: "<?php echo $template_url; ?>",
            type: "GET",
            beforeSend: function(xhr) {

            }
        }).done(function(data) {

            $("#box-template-list").html(data);
            templatelist_config();

        }).fail(function() {
            //$("#template-list").prev().children(":first-child").hide(0);
        });
    }

    function templatelist_config() {

        jQuery("#template-list a").off('click');
        jQuery("#template-list a").click(
                function() {

                    var bg = $(this).data('bg');
                    var fg = $(this).data('fg');

                    //mememaker.tools.backgroundimage(bg);
                    mememaker.tools.newtemplate(fg);
                    mememaker.tools.backgroundcolor("#DDDDDD");

                    $("#current-item").val($(this).data('guid'));
                    $("#current-item").data('name', $(this).data('name'));
                    $.shoppingcart.setCurrentProductId($(this).data('guid'));
                    $("#btn-order span").text("Order Now " + $(this).data('price') + "$");
                }
        );
    }

    //==================================================================
    // order
    //==================================================================

    function order()
    {
        if (jQuery.trim(jQuery("#current-item").val()) == "") {
            return;
        }
        mememaker.tools.preview(preview);
        return;
    }

    function preview(preview)
    {
        console.log('preview callback');
        console.log(jQuery("#current-item").val());

        if (jQuery.trim(jQuery("#current-item").val()) == "") {
            return;
        }
        jQuery("#modal-preview .modal-body").html('<div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>');
        jQuery(".ajax-loading-indicator").show(0);
        jQuery("#modal-preview").modal();

        jQuery.ajax({
            url: "<?php echo $preview_url; ?>",
            data: {"image-extension": "jpeg", "image-data": preview, "user": $.shoppingcart.getuuid(), "product": jQuery("#current-item").val()},
            type: "POST",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            jQuery(".ajax-loading-indicator").hide(0);
            jQuery("#modal-preview .modal-body").html(data);
            order_config();
            order_current();

        }).fail(function() {
            jQuery(".ajax-loading-indicator").hide(0);
        });
    }

    function order_current()
    {
        var orderId = null;
        orderId = jQuery("#modal-preview #product-info").data('guid');
        var image = jQuery("#modal-preview #product-info").data('file');

        $.shoppingcart.setCurrentProductId(orderId + "-" + image);
        return true;
    }
    
    //===================================================
    
    function formuser_load ()
    {
        jQuery.ajax({
            url: "<?php echo $loginform_url; ?>",
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            
            $("#modal-user .modal-body").html (data);

        }).fail(function() {
            jQuery(".ajax-loading-indicator").hide(0);
        });
    }
    
    function signup_submit()
    {
        jQuery.ajax({
            url: "<?php echo $signup_url; ?>",
            data: $("#form-signup").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-signup").button("loading");
            }
        }).done(function(data) {
            $("#btn-signup").button("reset");

            var result = $.parseJSON(data);
            if (result.error == 1) {
                $("#form-signup .text-error").html(result.message);
            } else {
                $("#modal-user").modal('hide');
                alert ("Now click 'save'to save your progress");
            }
        }).fail(function() {
        });
    }

    function signin_submit()
    {
        jQuery.ajax({
            url: "<?php echo $signin_url; ?>",
            data: $("#form-signin").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-signin").button("loading");
            }
        }).done(function(data) {
            $("#btn-signin").button("reset");

            var result = $.parseJSON(data);
            if (result.error == 1) {
                $("#form-signin .text-error").html(result.message);
            } else {
                $("#modal-user").modal('hide');
                alert ("Now click 'save'to save your progress");
            }
        }).fail(function() {
        });
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
    </div>
</div>

<!-- user modal -->
<div id="modal-user" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">User</h3>
    </div>
    <div class="modal-body" style='background:url("<?php echo $this->webroot; ?>img/pattern/whitey.png") repeat scroll 0 0 transparent;'>
        <div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>
    </div>
    <div class="modal-footer">
        <p class="text-error">You have to sign in to save your progress.</p>
    </div>
</div>

