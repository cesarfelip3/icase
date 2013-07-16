<style>
    .tools a {text-decoration:none;}
</style>
<section id="main">
    <div class="body-text">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3 hidden-phone">

                    <!-- Upload image -->
                    <div class="qbox creator-parts" style="visibility: hidden">
                        <h3><i class="icon-eye-open pull-right"></i>IMAGE TOOLS</h3>

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
                    <div class="qbox creator-parts" style="visibility: hidden">
                        <h3><i class="icon-eye-open pull-right"></i>BASIC TOOLS</h3>
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

                    <!-- page title with dropdown -->
                    <!--                    <h1>Create Your Case</h1>
                                        <div class="container-fluid">
                                            <div class="row-fluid">
                                                <div class="span7 dropdown-results">
                                                    <p>Select Your Device:</p>
                                                </div>
                                                <div class="span5">
                                                    <select id="sort" name="sort">
                                                        <option value="iphone5">Iphone 5</option>
                                                        <option value="iphone4">Iphone 4/4S</option>
                                                        <option value="ipad">Ipad</option>
                                                        <option value="ipad-mine">Ipad Mine</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>-->
                    <!-- end page title -->

                    <!--start Canvas-->
                    <div>
                        <div class="progress" style="height:2px"><div class="bar bar-warning" id="progress-bar" style="width: 0%; height:2px;"></div></div>
                        <p><a href="javascript:" id="btn-loading-canvas" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading Canvas...</a></p>
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

                    <!-- Form Name -->
                    <!-- Textarea -->
                    <!--<div class="control-group">

                        <div class="controls">                     
                            <textarea name="textarea"  placeholder="Enter your text"></textarea>
                        </div>
                    </div>-->

                    <!-- Select Basic -->
                    <!--<div class="control-group">
                        <label class="control-label" for="selectbasic">Font</label>
                        <div class="controls">
                            <select id="text-font-family" name="selectbasic" class="input-large">
                                <option value="Impact">Impact</option>
                                <option value="Helvitica">Helvitica</option>
                                <option value="Arial">Arial</option>
                                <option value="Verdana">Verdana</option>
                            </select>
                        </div>
                    </div>-->

                    <!-- Select Basic -->
                    <!--<div class="control-group">
                        <label class="control-label" for="selectbasic">Text Align</label>
                        <div class="controls">
                            <select id="selectbasic" name="selectbasic" class="input-xlarge">
                                <option>Left</option>
                                <option>Right</option>
                                <option>Center</option>
                            </select>
                        </div>
                    </div>-->
                    <!--</form>		-->
                </div>
                <!-- end listing-js -->

                <div class="span3">
                    <!--
                            "Quick Search" Widget
                            
                            SPECIAL NOTE: Please leave the inline style for <Select></Select> "width:100%",
                                                      the width is automatically "Re-adjusted" with javascript
                                                      See "config.js" for more details	
                    -->
                    <p><a class="btn btn-large btn-peach hide" id="btn-choose-device"><i class="icon-mobile-phone icon-1x"></i> Order Now</a></p>
                    <div class="qbox creator-parts" style="visibility:hidden">
                        <h3><i class="icon-search pull-right"></i>Choose Your Device</h3>
                        <div style="overflow: auto;height:460px;margin:0px;padding:0px;">
                            <h6>iphone 5</h6>
                            <a href="#" class="thumbnail">
                                <img src="img/template/iphone.png" />
                            </a>
                            <br/>
                            <h6>iphone 4S</h6>
                            <a href="#" class="thumbnail">
                                <img src="img/template/iphone.png" />
                            </a>
                            <br/>
                            <br/>
                        </div>
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

$js_pluploader = array (
    "pluploader/plupload.js",
    "pluploader/plupload.gears.js",
    "pluploader/plupload.flash.js",
    "pluploader/plupload.browserplus.js",
    "pluploader/plupload.html4.js",
    "pluploader/plupload.html5.js"
);

?>

<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<?php echo $this->Html->script($js_pluploader); ?>

<script type="text/javascript">
    // Custom example logic
    function $(id) {
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

    /*
    $('uploadfiles').onclick = function() {
        uploader.start();
        return false;
    };*/
</script>