<section id="main">
    <div class="body-text">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3 hidden-phone">

                    <!-- Upload image -->
                    <div class="qbox">
                        <h3><i class="icon-eye-open pull-right"></i>IMAGE TOOLS</h3>

                        <div class="tools">
                            <div id="uploader">
                                <div id="filelist"></div>
                                <a href="javascript:" id="pickfiles" class="btn btn-small">Add Your Picture</a> 
                                <a id="uploadfiles" class="btn" href="javascript:;">Start</a>
                            </div>
                        </div>
                    </div>
                    <!-- end zone alert -->
                    <!-- add text -->
                    <div class="qbox">
                        <h3><i class="icon-eye-open pull-right"></i>BASIC TOOLS</h3>
                        <!--<button id="singlebutton" name="singlebutton" class="btn btn-default">Enter Drawing mode</button>-->
                        <style>
                            .tools a {text-decoration:none;}
                        </style>
                        <div style="padding:20px" class="tools">
                            <p>
                                <a href="javascript:" data-action="info" title="info"><i class="icon-info-sign icon-3x"></i></a>&nbsp;&nbsp;
                                <a href="javascript:" data-action="remove" title="remove"><i class="icon-remove-sign icon-3x"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:" data-action="group" title="group"><i class="icon-resize-small icon-3x"></i></a>&nbsp;&nbsp;
                                <a href="javascript:" data-action="lock" title="lock/unlock"><i class="icon-lock icon-3x"></i></a>&nbsp;&nbsp;
                            </p>
                            <p>
                                <a href="javascript:" data-action="backward" title="backward"><i class="icon-chevron-down icon-3x"></i></a>&nbsp;&nbsp;
                                <a href="javascript:" data-action="forward" title="forward"><i class="icon-chevron-up icon-3x"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:" data-action="back" title="bottom"><i class="icon-circle-arrow-down icon-3x"></i></a>&nbsp;&nbsp;
                                <a href="javascript:" data-action="front" title="top"><i class="icon-circle-arrow-up icon-3x"></i></a>
                            </p>
                            <hr/>
                        </div><!-- tools -->
                    </div>
                </div>
                <div class="span6 listing-js">

                    <!-- page title with dropdown -->
                    <h1>Create Your Case</h1>
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
                    </div>
                    <!-- end page title -->

                    <!--start Canvas-->
                    <canvas class="upper-canvas " style="border: 1px solid rgb(170, 170, 170); -moz-user-select: none; cursor: crosshair;" width="450" height="450" id="c1"></canvas>							
                    <!--end Canvas-->
                    <div class="tools">
                        <a id="text" name="singlebutton" class="btn btn-info tools" data-action="newtext">Add Text</a>
                        <a id="singlebutton" name="singlebutton" class="btn btn-danger tools" data-action="new">Clear Canvas</a><br><br>
                    </div>

                    <!-- Form Name -->
                    <!-- Textarea -->
                    <div class="control-group">

                        <div class="controls">                     
                            <textarea name="textarea" id="text-content" placeholder="Enter your text"></textarea>
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="control-group">
                        <label class="control-label" for="selectbasic">Font</label>
                        <div class="controls">
                            <select id="text-font-family" name="selectbasic" class="input-large">
                                <option value="Impact">Impact</option>
                                <option value="Helvitica">Helvitica</option>
                                <option value="Arial">Arial</option>
                                <option value="Verdana">Verdana</option>
                            </select>
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="control-group">
                        <label class="control-label" for="selectbasic">Text Align</label>
                        <div class="controls">
                            <select id="selectbasic" name="selectbasic" class="input-xlarge">
                                <option>Left</option>
                                <option>Right</option>
                                <option>Center</option>
                            </select>
                        </div>
                    </div>
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
                    <p><button class="btn btn-large btn-peach">Order Now</button></p>
                    <div class="qbox">

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
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>

<script type="text/javascript" src="js/pluploader/plupload.js"></script>
<script type="text/javascript" src="js/pluploader/plupload.gears.js"></script>
<script type="text/javascript" src="js/pluploader/plupload.silverlight.js"></script>
<script type="text/javascript" src="js/pluploader/plupload.flash.js"></script>
<script type="text/javascript" src="js/pluploader/plupload.browserplus.js"></script>
<script type="text/javascript" src="js/pluploader/plupload.html4.js"></script>
<script type="text/javascript" src="js/pluploader/plupload.html5.js"></script>

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
        resize: {width: 320, height: 240, quality: 90},
        //flash_swf_url: 'js/uploader/plupload.flash.swf',
        //silverlight_xap_url : 'js/uploader/plupload.silverlight.xap',
        filters: [
            {title: "Excel files", extensions: "png,jpeg,jpg,gif,bmp"}
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
            document.getElementById('filelist').innerHTML = '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div><div class="progress"><div class="bar" id="progress-bar" style="width: 0%;"></div></div>';
        }
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
            }
        });

        //alert($.parseJSON(response.response).result);
    });

    $('uploadfiles').onclick = function() {
        uploader.start();
        return false;
    };
</script>