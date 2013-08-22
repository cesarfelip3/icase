<?php
$admin_home = $base;
$admin_product = $base . "creator";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $admin_home; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">
                <a href="<?php echo $admin_product; ?>">Templates</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Add</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <form class="form-horizontal" id="form-new">
            <input type="hidden" name="product[image][foreground]" value="" />
            <input type="hidden" name="product[image][background]" value="" />
            <input type="hidden" name="product[guid]" value='<?php echo $guid; ?>' />
            <div class="alert alert-info hide">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <h4 class="alert-heading">Information</h4>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="slate">
                        <div class="page-header">
                            <h2>New Template</h2>
                        </div>
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="product[name]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group hide">
                                <label class="control-label" for="focusedInput">URL Key</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="product[slug]" >
                                    <span class="help-inline">Default: Name<-id></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Description</label>
                                <div class="controls">
                                    <textarea class="ckeditor" cols="80" id="editor1" name="product[description]" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="control-group hide">
                                <label class="control-label" for="optionsCheckbox2">Template</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="product[type]" value="template" checked='checked'>
                                        Yes
                                        <span class="help-inline"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="control-group hide">
                                <label class="control-label" for="optionsCheckbox2">Featured</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="product[is_featured]" value="0">
                                        Yes
                                        <span class="help-inline"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Price</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[price]" placeholder="xxxx.xx">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning hide">
                                <label class="control-label" for="inputWarning">Tax</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[tax]" value="0.00">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning hide">
                                <label class="control-label" for="inputWarning" >Discount</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[discount]" value="0">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning" >Quantity</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[quantity]" value="65535">
                                    <span class="help-inline">65535 means unlimited</span>
                                </div>
                            </div>
                            <div class="hide">
                            <div class="page-header">
                                <h3>Special Offer</h3>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Special</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="product[is_special]">
                                        Yes
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Start Date</label>
                                <div class="controls">
                                    <input type="text" class="datepicker input-small" name="product[special_start]"/>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">End Date</label>
                                <div class="controls">
                                    <input type="text" class="datepicker input-small" name="product[special_end]" />
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Price</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[special_price]" placeholder="xxxx.xx">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class='well'>
                                <p>If "Special" is checked, the sale will start in duration, and use special price, when it's end, it will go back to the original price. All special offers will be on the top of the home product page, to promote sales.</p>
                            </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Save Option</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" class="input-mini" name="product[status]" value="published">Published
                                    </label>
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('create');" id="btn-save">Create</a>
<!--                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('update');" id="btn-save">Update</a>-->
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            
                            <div class='well'>
                                <h4><strong>Template images specification : width : 780px, height : 780px, dpi : 72 </strong></h4>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="span4">
                    <div class="slate hide" id='box-category'>
                        <div class="page-header">
                            <h2>Category</h2>
                        </div>
                        <div class='body' style="height:150px;overflow: auto;">

                        </div>
                    </div>
                    <div class="slate">
                        <div class="page-header" id='box-background-images'>
                            <h2>Background Image</h2>
                        </div>
                        <div id="background-image-uploader" style="padding:0px;margin:0px;">
                            <div id="background-image-list" style="padding:0px;margin:0px;margin-bottom:10px;"></div>
                            <div class="progress" style="height:2px;display:block;width:100%;margin-top:10px;"><div class="bar bar-warning" id="background-image-progress-bar" style="width: 0%; height:2px;"></div></div>
                            <p>
                                <a href="javascript:" id="btn-select-background-image" class="btn btn-block btn-info">Select</a> 
                                <a href="javascript:" id="btn-upload-background-image" class="btn btn-block btn-info" onclick="background_image_start_upload();">Upload</a>
                            </p>
                            <div id="box-background-image" class="row-fluid">

                            </div>
                        </div>
                    </div>
                    <div class="slate">
                        <div class="page-header">
                            <h2>Overlay Image</h2>
                        </div>
                        <div id="overlay-image-uploader" style="padding:0px;margin:0px;">
                            <div id="overlay-image-list" style="padding:0px;margin:0px;margin-bottom:10px;"></div>
                            <div class="progress" style="height:2px;display:block;width:100%;margin-top:10px;"><div class="bar bar-warning" id="overlay-image-progress-bar" style="width: 0%; height:2px;"></div></div>
                            <p>
                                <a href="javascript:" id="btn-select-overlay-image" class="btn btn-block btn-info">Select</a> 
                                <a href="javascript:" id="btn-upload-overlay-image" class="btn btn-block btn-info" onclick="overlay_image_start_upload();">Upload</a>
                            </p>
                            <div id="box-overlay-image" class="row-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="navbar navbar-fixed-bottom hide">
    <div class="navbar-inner">
        <div class="container" style="width: auto; padding: 0 20px;">
            <a class="brand" href="#">Title</a>
            <ul class="nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- -->
<script type='text/javascript'>
    $(document).ready(
            function() {
               /* jQuery.ajax({
                    url: "<?php echo $base; ?>category/?action=checkbox",
                    type: "GET",
                    beforeSend: function(xhr) {
                    }
                }).done(function(data) {
                    jQuery("#box-category .body").html(data);
                    $("#form-new").serialize();

                }).fail(function() {
                });*/
            }
    );

    function save(action) {

        CKEDITOR.instances.editor1.updateElement();
        jQuery.ajax({
            url: "<?php echo $base; ?>creator/add/?action=" + action,
            data: $("#form-new").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-save").button('loading');
            }
        }).done(function(data) {
            $("#btn-save").button('reset');

            var result = $.parseJSON(data);
            console.log(result);
            if (result.error == 1) {
                console.log(result.element);
                $(result.element).next(".help-inline").html(result.message);
                $(result.element).parent().parent().addClass('error');
                showAlert(result.message);
            } else {
                if (action == 'create') {
                    $("input[name='product[id]'").val(result.data);
                    window.location.href="";
                }
                $(result.element).parent().parent().removeClass('error');
                $(result.element).next(".help-inline").html("");
            }

        }).fail(function() {
        });
    }
</script>
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
        browse_button: 'btn-select-overlay-image',
        container: 'overlay-image-uploader',
        max_file_size: '10mb',
        url: '<?php echo $base; ?>media/uploadimage2/?id=<?php echo $guid; ?>&type=fg',
        multi_selection: false,
        //resize: {width: 640, height: 240, quality: 100},
        //flash_swf_url: 'js/uploader/plupload.flash.swf',
        //silverlight_xap_url : 'js/uploader/plupload.silverlight.xap',
        filters: [
            {title: "Image Files", extensions: "png"}
        ]
    });

    uploader.bind('Init', function(up, params) {
        //$('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
    });

    uploader.init();

    uploader.bind('FilesAdded', function(up, files) {

        if (uploader.files.length == 2) {
            uploader.removeFile(uploader.files[0]);
        }

        for (var i in files) {
            document.getElementById('overlay-image-list').innerHTML = '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
        }
        jQuery('#overlay-image-progress-bar').css('width', "0%");
        //uploader.start();
    });

    uploader.bind('UploadProgress', function(up, file) {
        //$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        jQuery('#overlay-image-progress-bar').css('width', file.percent + "%");

    });

    uploader.bind('FileUploaded', function(up, file, response) {
        plupload.each(response, function(value, key) {

            console.log(key);
            console.log(value);

            if (key == "response") {
                var result = jQuery.parseJSON(value);
                
                if (result.error == 0) {
                    var url = result.files.url;
                    
                    $("#box-overlay-image").append('<div><a class="featured-thumbnail"><img src="' + url + '"  /></a></div>');
                    $("input[name='product[image][foreground]']").val(result.files.target);
                } else {
                    showAlert (result.message);
                }
            }
        });

        //alert($.parseJSON(response.response).result);
    });

    function overlay_image_start_upload()
    {
        uploader.start();
        $("#overlay-image-list").html("");
        $("#box-overlay-image").html("");
    }

</script>

<script type="text/javascript">
    var total = 0;

    var uploader2 = new plupload.Uploader({
        runtimes: 'gears,html5,browserplus',
        browse_button: 'btn-select-background-image',
        container: 'background-image-uploader',
        max_file_size: '10mb',
        url: '<?php echo $base; ?>media/uploadimage2/?id=<?php echo $guid; ?>&type=bg',
        multi_selection: true,
        //resize: {width: 640, height: 240, quality: 100},
        //flash_swf_url: 'js/uploader/plupload.flash.swf',
        //silverlight_xap_url : 'js/uploader/plupload.silverlight.xap',
        filters: [
            {title: "Image Files", extensions: "png"}
        ]
    });

    uploader2.bind('Init', function(up, params) {
        document.getElementById('background-image-list').innerHTML = "";
    });

    uploader2.init();

    uploader2.bind('FilesAdded', function(up, files) {

        document.getElementById('background-image-list').innerHTML = "";
        if (uploader2.files.length == 2) {
            //uploader2.removeFile(uploader2.files[0]);
        }

        for (var i in files) {
            document.getElementById('background-image-list').innerHTML += '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
        }
        jQuery('#background-image-progress-bar').css('width', "0%");
        //uploader.start();
    });

    uploader2.bind('UploadProgress', function(up, file) {
        //$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        jQuery('#background-image-progress-bar').css('width', file.percent + "%");

    });

    uploader2.bind('FileUploaded', function(up, file, response) {
        plupload.each(response, function(value, key) {

            //console.log(key);
            //console.log(value);

            if (key == "response") {
                
                var result = jQuery.parseJSON(value);
                
                if (result.error == 0) {
                    var url = result.files.url;
                    
                    $("#box-background-image").append('<div><a class="featured-thumbnail"><img src="' + url + '"  /></a></div>');
                    $("input[name='product[image][background]']").val(result.files.target);
                } else {
                    showAlert (result.message);
                }
            }
        });

        //alert($.parseJSON(response.response).result);
    });

    function background_image_start_upload()
    { 
        uploader2.start();
        $('#box-background-image').html("");
        $('#background-image-list').html("");
        $("input[name='product[image][background]'").val("");
    }
</script>