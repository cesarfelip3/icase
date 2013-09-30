<?php
$admin_home = $base;
$admin_template = $base . "template";
$action_create = $base . "creator/create";

?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $admin_home; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">
                <a href="<?php echo $admin_template; ?>">Templates</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Add</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <form class="form-horizontal" id="form-new">
            <input type="hidden" name="template[featured]" value="" />
            <input type="hidden" name="template[guid]" value="<?php echo $guid; ?>" />
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
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="template[name]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Description</label>
                                <div class="controls">
                                    <textarea class="ckeditor" cols="80" id="editor1" name="template[description]" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Width</label>
                                <div class="controls">
                                    <input class="input-small focused" id="focusedInput" type="text" name="template[width]" >
                                    <span class="help-inline">mm</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Height</label>
                                <div class="controls">
                                    <input class="input-small focused" id="focusedInput" type="text" name="template[height]" >
                                    <span class="help-inline">mm</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Featured</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="template[is_featured]" value="1">
                                        Yes
                                        <span class="help-inline"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Industry</label>
                                <div class="controls">
                                    <label>
                                        <select name="template[industry_guid]">
                                            <option value="">Choose Industry</option>
                                            <?php if (!empty ($industries)) : ?>
                                            <?php foreach ($industries as $value) : ?>
                                            <?php $value = $value['Industry']; ?>
                                            <option value="<?php echo $value['guid']; ?>">
                                                <?php echo $value['name']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <span class="help-inline"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning"></label>
                                <div class="controls">
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('create');" id="btn-save">Create</a>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="span4">
                    <div class="slate" id='box-category'>
                        <div class="page-header">
                            <h2>Category</h2>
                        </div>
                        <div class='body' style="height:150px;overflow: auto;">

                        </div>
                    </div>
                    <div class="slate hide">
                        <div class="page-header" id='box-featured-images'>
                            <h2>Featured Images</h2>
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
<!-- -->
<script type='text/javascript'>
    $(document).ready(function () {
            categorylist ();
    });

    function categorylist () {
    
        jQuery.ajax({
            url: "<?php echo $base; ?>category/categorylist/?action=checkbox",
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            jQuery("#box-category .body").html(data);
        }).fail(function() {
        });
            
    }

    function save(action) {

        CKEDITOR.instances.editor1.updateElement();
        jQuery.ajax({
            url: "<?php echo $base; ?>template/add/?action=" + action,
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
                    $("input[name='template[id]'").val(result.data);
                    window.location.href="<?php echo $action_create; ?>/?action=new&id=" + result.data;
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
    "pluploader/plupload.html5.js",
);
?>

<?php echo $this->Html->script($js_pluploader); ?>


<script type="text/javascript">
    var total = 0;

    var uploader2 = new plupload.Uploader({
        runtimes: 'gears,html5,browserplus',
        browse_button: 'btn-select-featured-image',
        container: 'featured-image-uploader',
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

    uploader2.bind('Init', function(up, params) {
        document.getElementById('featured-image-list').innerHTML = "";
    });

    uploader2.init();

    uploader2.bind('FilesAdded', function(up, files) {

        document.getElementById('featured-image-list').innerHTML = "";
        if (uploader2.files.length == 2) {
            uploader2.removeFile(uploader2.files[0]);
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
                    ////console.log(result.file.url);
                    var url = result.file.url;
                    if (url == "") {
                        url = result.file.url;
                    }
                    
                    $("#box-featured-image").append('<div class="thumbnail" style="width:24%;float:left;margin-left:5px;margin-bottom:10px;"><a class="featured-thumbnail"><img src="' + url + '" style="" /></a><div class="caption"><p><a class="btn btn-success" data-image="' + result.file.target + '" onclick="featured_image_delete(this);">Delete</a></p></div></div>');
                    $("input[name='template[featured]']").val(result.file.target);
                    ////console.log ($("input[name='template[featured]']").val());
                    //<p><a class="btn btn-success" data-image="' + result.file.target + '" data-width="' + result.file.width + '" onclick="featured_image_crop(this);">Crop</a></p>
                    init();
                } else {
                    showAlert (result.message);
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
        $('input[name="template[featured]"]').val("");
    }

    function featured_image_delete(id)
    {
        ////console.log (jQuery(id).parent().parent());
        jQuery(id).parent().parent().parent().remove();

        $('input[name="template[featured]"]').val("");
        $("#featured-image-progress-bar").css('width', "0%");
    }
    
    
</script>