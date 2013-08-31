<?php
$admin_home = $base;
$admin_mail = $base . "mail";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $admin_home; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">
                <a href="<?php echo $admin_mail; ?>">Mail Templates</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Add</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <form class="form-horizontal" id="form-new">
            <input type="hidden" name="mail[featured]" value="" />
            <input type="hidden" name="mail[image]" value="" />
            <input type="hidden" name="mail[guid]" value='' />
            <div class="alert alert-info hide">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <h4 class="alert-heading">Information</h4>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="slate">
                        <div class="page-header">
                            <h2>New Mail Template</h2>
                        </div>
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="mail[name]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Usage</label>
                                <div class="controls">
                                    <select>
                                        <option> - None - </option>
                                        <option>Subscribe</option>
                                        <option>Order Notification</option>
                                    </select>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Subject</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="mail[slug]" >
                                    <span class="help-inline">Default: Name<-id></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Content</label>
                                <div class="controls">
                                    <textarea class="ckeditor" cols="80" id="editor1" name="mail[description]" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Save Option</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" class="input-mini" name="mail[status]" value="published">Published
                                    </label>
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('create');" id="btn-save">Create</a>
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('update');" id="btn-save">Update</a>
                                    <span class="help-inline">Create new one or update current one</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="span4">
                    <div class="slate">
                        <div class="page-header" id='box-featured-images'>
                            <h2>Insert Images</h2>
                        </div>
                        <div id="featured-image-uploader" style="padding:0px;margin:0px;">
                            <div id="featured-image-list" style="padding:0px;margin:0px;margin-bottom:10px;"></div>
                            <div class="progress" style="height:2px;display:block;width:100%;margin-top:10px;"><div class="bar bar-warning" id="featured-image-progress-bar" style="width: 0%; height:2px;"></div></div>
                            <p>
                                <a href="javascript:" id="btn-select-featured-image" class="btn btn-block btn-info">Select</a> 
                                <a href="javascript:" id="btn-upload-featured-image" class="btn btn-block btn-info" onclick="featured_image_start_upload();">Upload</a>
                            </p>
                            <div id="box-featured-image" class="row-fluid">

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
                jQuery.ajax({
                    url: "<?php echo $base; ?>category/?action=checkbox",
                    type: "GET",
                    beforeSend: function(xhr) {
                    }
                }).done(function(data) {
                    jQuery("#box-category .body").html(data);
                    $("#form-new").serialize();

                }).fail(function() {
                });
            }
    );

    function save(action) {

        CKEDITOR.instances.editor1.updateElement();
        jQuery.ajax({
            url: "<?php echo $base; ?>mail/add/?action=" + action,
            data: $("#form-new").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-save").button('loading');
            }
        }).done(function(data) {
            $("#btn-save").button('reset');

            var result = $.parseJSON(data);
            //console.log(result);
            if (result.error == 1) {
                //console.log(result.element);
                $(result.element).next(".help-inline").html(result.message);
                $(result.element).parent().parent().addClass('error');
                showAlert(result.message);
            } else {
                if (action == 'create') {
                    $("input[name='mail[guid]'").val(result.data);
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
        browse_button: 'btn-select-template-image',
        container: 'template-image-uploader',
        max_file_size: '10mb',
        url: '<?php echo $base; ?>media/uploadimage/?action=template',
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

        if (uploader.files.length == 2) {
            uploader.removeFile(uploader.files[0]);
        }

        for (var i in files) {
            document.getElementById('template-image-list').innerHTML = '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
        }
        jQuery('#template-image-progress-bar').css('width', "0%");
        //uploader.start();
    });

    uploader.bind('UploadProgress', function(up, file) {
        //$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        jQuery('#template-image-progress-bar').css('width', file.percent + "%");

    });

    uploader.bind('FileUploaded', function(up, file, response) {
        plupload.each(response, function(value, key) {

            //console.log(key);
            //console.log(value);

            if (key == "response") {
                var result = jQuery.parseJSON(value);
                //console.log(result);
                if (result.error == 0) {
                    //console.log(result.files.url);
                    $("#box-template-image").html('<div class="span8"><a class="featured-thumbnail"><img src="' + result.files.url + '" style="width:60px" /></a></div>');
                    $('input[name="mail[image]"]').val(result.files.target);
                }
                //jQuery('#progress-bar').css('width', "0%");
            }
        });

        //alert($.parseJSON(response.response).result);
    });

    function template_image_start_upload()
    {
        uploader.start();
        $("#template-image-list").html("");
        $("#box-template-image").html("");
    }

</script>

<script type="text/javascript">
    var total = 0;

    var uploader2 = new plupload.Uploader({
        runtimes: 'gears,html5,browserplus',
        browse_button: 'btn-select-featured-image',
        container: 'featured-image-uploader',
        max_file_size: '10mb',
        url: '<?php echo $base; ?>media/uploadimage/?action=mail',
        multi_selection: true,
        //resize: {width: 640, height: 240, quality: 100},
        //flash_swf_url: 'js/uploader/plupload.flash.swf',
        //silverlight_xap_url : 'js/uploader/plupload.silverlight.xap',
        filters: [
            {title: "Image Files", extensions: "png,jpeg,jpg,gif"}
        ]
    });

    uploader2.bind('Init', function(up, params) {
        document.getElementById('featured-image-list').innerHTML = "";
    });

    uploader2.init();

    uploader2.bind('FilesAdded', function(up, files) {

        document.getElementById('featured-image-list').innerHTML = "";
        if (uploader2.files.length == 2) {
            //uploader2.removeFile(uploader2.files[0]);
        }

        for (var i in files) {
            document.getElementById('featured-image-list').innerHTML += '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
        }
        jQuery('#featured-image-progress-bar').css('width', "0%");
        //uploader.start();
    });

    uploader2.bind('UploadProgress', function(up, file) {
        //$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        jQuery('#featured-image-progress-bar').css('width', file.percent + "%");

    });

    uploader2.bind('FileUploaded', function(up, file, response) {
        plupload.each(response, function(value, key) {

            ////console.log(key);
            ////console.log(value);

            if (key == "response") {
                var result = jQuery.parseJSON(value);
                ////console.log(result);
                if (result.error == 0) {
                    ////console.log(result.files.url);
                    $("#box-featured-image").append('<div class="thumbnail" style="width:24%;float:left;margin-left:5px;margin-bottom:10px;"><a class="featured-thumbnail"><img src="' + result.files.url150 + '" style="" /></a><div class="caption"><p><a class="btn btn-success" data-image="' + result.files.target + '" onclick="featured_image_delete(this);">Delete</a></p></div></div>');
                    $("input[name='mail[featured]']").val($("input[name='mail[featured]']").val() + "-" + result.files.target);
                    ////console.log ($("input[name='mail[featured]']").val());
                    init();
                }
                //jQuery('#progress-bar').css('width', "0%");
            }
        });

        //alert($.parseJSON(response.response).result);
    });

    function featured_image_start_upload()
    {
        uploader2.start();
        $('#box-featured-image').html("");
        $('#featured-image-list').html("");
        $('input[name="mail[featured]"]').val("");
    }

    function featured_image_delete(id)
    {
        ////console.log (jQuery(id).parent().parent());
        jQuery(id).parent().parent().parent().remove();

        var image = $(id).data('image');
        var images = $('input[name="mail[featured]"]').val();

        image = "-" + image;
        images = images.replace(image, "");

        $('input[name="mail[featured]"]').val(images);
        //console.log(image + ":" + images);
    }
</script>