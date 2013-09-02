<?php
$admin_home = $base;
$admin_product = $base . "product";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $admin_home; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">
                <a href="<?php echo $admin_product; ?>">Products</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <form class="form-horizontal" id="form-new">
            <input type="hidden" name="product[featured]" value="<?php echo $data['featured']; ?>" />
            <input type="hidden" name="product[image]" value="<?php echo $data['image']; ?>" />
            <input type="hidden" name="product[guid]" value='<?php echo $data['guid']; ?>' />
            <input type="hidden" name="product[id]" value='<?php echo $data['id']; ?>' />
            <div class="alert alert-info hide">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <h4 class="alert-heading">Information</h4>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="slate">
                        <div class="page-header">
                            <h2>Edit Product</h2>
                        </div>
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="product[name]" value="<?php echo $data['name']; ?>" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">URL Key</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="product[slug]" value="<?php echo $data['slug']; ?>" >
                                    <span class="help-inline">Default: Name<-id></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Description</label>
                                <div class="controls">
                                    <textarea class="ckeditor" cols="80" id="editor1" name="product[description]" rows="10"><?php echo $data['description']; ?></textarea>
                                </div>
                            </div>
                            <?php if ($data['type'] == 'template') : ?>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Template</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="product[type]" value="template" <?php if ($data['type'] == 'template') echo 'checked'; ?>>
                                        Yes
                                        <span class="help-inline"><b><em style="color:green">Template means this product is only for cusomized case</em></b></span>
                                    </label>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Featured</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="product[is_featured]" value="1" <?php if ($data['is_featured'] == 1) echo 'checked'; ?>>
                                        Yes
                                        <span class="help-inline"></span>
                                    </label>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Price</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[price]" placeholder="xxxx.xx" value="<?php echo $data['price']; ?>">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning hide">
                                <label class="control-label" for="inputWarning">Tax</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[tax]" value="<?php echo $data['tax']; ?>">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning hide">
                                <label class="control-label" for="inputWarning" >Discount</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[discount]" value="<?php echo $data['discount']; ?>">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning" >Quantity</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[quantity]"  value="<?php echo $data['quantity']; ?>">
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
                                        <input type="checkbox" id="optionsCheckbox2" name="product[is_special]" <?php if ($data['is_special'] == 1) echo 'checked'; ?>>
                                        Yes
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Start Date</label>
                                <div class="controls">
                                    <input type="text" class="datepicker input-small" name="product[special_start]" value="<?php if ($data['special_start'] > 0) echo date("Y-m-d", $data['special_start']); ?>"/>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">End Date</label>
                                <div class="controls">
                                    <input type="text" class="datepicker input-small" name="product[special_end]" value="<?php if ($data['special_end'] > 0) echo date("Y-m-d", $data['special_end']); ?>" />
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Price</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[special_price]" placeholder="xxxx.xx" value="<?php echo $data['special_price']; ?>">
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
                                        <input type="checkbox" class="input-mini" name="product[status]" value="published" <?php if ($data['status'] == 'published') echo 'checked'; ?>>Published
                                    </label>
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('update');" id="btn-save">Update</a>
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
                    <div class="slate">
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
                                <?php if (!empty ($data['featured2'])) : $images = $data['featured2']['origin']; ?>
                                <?php foreach ($images as $key => $image) : ?>
                                <div class="thumbnail" style="width:20%;float:left;margin-left:5px;margin-bottom:10px;">
                                    <a class="featured-thumbnail">
                                        <img src="<?php echo $this->webroot . "uploads/product/" . $data['featured2']['150w'][$key]; ?>" style=""></a>
                                    <div class="caption">
                                        <p><a href="javascript:" data-image="<?php echo $image; ?>" onclick="featured_image_delete(this);">Delete</a></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php if (!empty($data['featured2'])) : $images = $data['featured2']['origin']; ?>
        <div>
            <div class="thumbnail">
                <img src="<?php echo $this->webroot . "uploads/product/" . $images[0]; ?>" style="">
            </div>
        </div>
    <?php endif; ?>
    <div id="box-crop" class="hide">
        <div style="padding:10px;height:50px;">
            <a href="javascript:" class="btn btn-info pull-right" onclick="featured_image_crop_ajax()">Crop</a>
        </div>
        <div class="thumbnail">
            <img src="" id="img-crop" />
        </div>
    </div>
</div>
<!-- -->
<script type='text/javascript'>
    $(document).ready(
            function() {
                jQuery.ajax({
                    url: "<?php echo $base; ?>category/?action=checkbox&id=<?php echo $data['guid']; ?>",
                    type: "GET",
                    beforeSend: function(xhr) {
                        showAlert2 ("Loading categories...")
                    }
                }).done(function(data) {
                    jQuery("#box-category .body").html(data);
                    hideAlert ();

                }).fail(function() {
                    hideAlert ();
                });
            }
    );

    function save(action) {

        CKEDITOR.instances.editor1.updateElement();
        jQuery.ajax({
            url: "<?php echo $base; ?>product/edit/?action=" + action,
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
                if (result.element != "") {
                    $(result.element).next(".help-inline").html(result.message);
                    $(result.element).parent().parent().addClass('error');
                }
                showAlert(result.message);
            } else {
                if (action == 'create') {
                    $("input[name='product[guid]'").val(result.data);
                }
                $(result.element).parent().parent().removeClass('error');
                $(result.element).next(".help-inline").html("");
                window.location.href = "<?php echo $base; ?>product/"
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
    "jcrop/js/jquery.Jcrop.min.js"
);
?>

<?php echo $this->Html->script($js_pluploader); ?>
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/jcrop/css/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript">
    var total = 0;

    var uploader2 = new plupload.Uploader({
        runtimes: 'gears,html5,browserplus',
        browse_button: 'btn-select-featured-image',
        container: 'featured-image-uploader',
        max_file_size: '10mb',
        url: '<?php echo $base; ?>media/uploadimage/?action=product',
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
                    
                    var url = result.files.url150;
                    if (url == "") {
                        url = result.files.url;
                    }
                    $("#box-featured-image").append('<div class="thumbnail" style="width:20%;float:left;margin-left:5px;margin-bottom:10px;"><a class="featured-thumbnail"><img src="' + url + '" style="" /></a><div class="caption"><p><a href="javascript:" data-image="' + result.files.target + '" onclick="featured_image_delete(this);">Delete</a></p></div></div>');
                    $("input[name='product[featured]']").val($("input[name='product[featured]']").val() + "-" + result.files.target);
                    ////console.log ($("input[name='product[featured]']").val());
                    //<a href="javascript:" data-image="' + result.files.target + '" onclick="featured_image_crop(this);">Crop</a>
                    init();
                } else {
                    showAlert (result.message);
                }
                //jQuery('#progress-bar').css('width', "0%");
            }
        });

        //alert($.parseJSON(response.response).result);
    });

    var crop_data;
    var crop_action = "product_edit";
    
    function featured_image_start_upload()
    {
        uploader2.start();
        $('#box-featured-image').html("");
        $('#featured-image-list').html("");
        $('input[name="product[featured]"]').val("");
        
        crop_action = "";
    }

    function featured_image_delete(id)
    {
        ////console.log (jQuery(id).parent().parent());
        jQuery(id).parent().parent().parent().remove();

        var image = $(id).data('image');
        var images = $('input[name="product[featured]"]').val();

        image = image;
        images = images.replace(image, "");

        $('input[name="product[featured]"]').val(images);
        $("#img-crop").attr('src', "");
        $("#box-crop").hide();
    }
    
    
    var crop_api;
    
    function featured_image_crop(id)
    {
        var image = $(id).data('image');
        $("#img-crop").attr('src', "");
        $("#box-crop").show();
        
        $("#img-crop").attr('src', "<?php echo $this->webroot; ?>uploads/" + image);
        $("#img-crop").css('width', $(id).data('width') + "px !important");
        $('#img-crop').Jcrop({ 
        
            onSelect: featured_image_cropped,
            onChange: featured_image_cropped,
            onRelease: featured_image_cropped,
        }, function () {
             jcrop_api = this;
             jcrop_api.setOptions({ aspectRatio: 1 });
        });
        
    }
    
    function featured_image_cropped (c)
    {
        //console.log (c);
        crop_data = c;
    }
    
    function featured_image_crop_ajax ()
    {
        var data = new Object();
        
        if (crop_data == null) {
            return;
        }
        
        if ($("#img-crop").attr('src') == "") {
            return;
        }
        
        data.json = crop_data;
        data.file = $("#img-crop").attr('src');
        
        jQuery.ajax({
            url: "<?php echo $base; ?>media/crop/?action=" + crop_action,
            data: {'json':JSON.stringify(data)},
            type: "POST",
            beforeSend: function(xhr) {
                showAlert2 ("Croping......");
            }
        }).done(function(data) {
            $("#btn-save").button('reset');

            var result = $.parseJSON(data);
            //console.log(result);
            if (result.error == 1) {
                showAlert (result.message);
            } else {
                alert ("Cropped successfully.")
                //$("#img-crop").attr('src', result.files.url);
            }
            
            hideAlert ();

        }).fail(function() {
            showAlert ("failed");
        });       
    }
    
</script>