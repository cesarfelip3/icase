<?php

    $base = $this->webroot;
    $width = intval ($template['width']);
    $height = intval ($template['height']);
    
    if ($width <= 350) {
        $width *= 2;
        $height *= 2;
    }
    
    $guid = $template['guid'];
    $action_reload = $base . "creator/reload";
    $action_upload = $base . "creator/upload";
    
    if ($action == 'edit') {
        $returnUrl = $base . "template/edit/?id=" . $guid;
    } 
    
    if ($action == 'new') {
        $returnUrl = $base . "template/add/?id=" . $guid;
    }
    
    if ($action == 'list') {
        $returnUrl = $base . "template";
    }
?>

<div class="unselectable" id="box-container">
        <div class="hm-row" style="height:70px;">
            <div class="hm-span6">
                <h5 style="padding:0px;margin:0px;">Click the text and images to personalise your business card.</h5>
                <div style="font-size:13px;line-height: 15px;">
                    (You can add new images and text areas by dragging and dropping the image and text icons to the right onto your business card)
                </div>
            </div>
            <div class="hm-span6">
                <div class="pull-right tools" id="box-toolbar-main">
                    <ul class="hm-thumbnails">
                        <li>
                            <div class="hm-thumbnail">
                                <a href="javascript:" data-action="background" class="active"><i class="icon-desktop icon-2x"></i></a>
                                <div class="caption">
                                    Background
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="hm-thumbnail" style="border:none;text-align:center;margin:auto;">
                                <a href="javascript:" data-action="addgrid" style="border:none;text-shadow: none;box-shadow: none;"><i class="icon-building icon-2x"></i></a>
                                <div class="caption">
                                    Snap to grid
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="hm-thumbnail" style="border:none;text-align:center;margin:auto;">
                                <a href="javascript:" data-action="addtext" title="add text" style="border:none;text-shadow: none;box-shadow: none;"><i class="icon-font icon-2x"></i></a>
                                <div class="caption">
                                    Add text
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="hm-thumbnail" style="border:none;text-align:center;margin:auto;" id="uploader">
                                <a href="javascript:" id="btn-upload-image" style="border:none;text-shadow: none;box-shadow: none;"><i class="icon-picture icon-2x"></i></a>
                                <div class="caption">
                                    Add image
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="hm-thumbnail" style="border:none;text-align:center;margin:auto;">
                                <a href="javascript:" data-action="addshape" style="border:none;text-shadow: none;box-shadow: none;"><i class="icon-th-large icon-2x"></i></a>
                                <div class="caption">
                                    Add shape
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div style="height:1px;background-color:#ccc"></div>
        <div class="hm-row tools" id="box-controlbar">
            <div class="hm-span6">
            </div>
            <div class="hm-span6 pull-right">
                <ul class="pull-right">
                    <li>
                        <a href="javascript:" data-action="save" title="save your work">
                            <i class="icon-save icon-2x"></i>
                        </a>
                    </li>
<!--                    <li>
                        <a href="javascript:" data-action="reload" title="reload yoru work">
                            <i class="icon-upload-alt icon-2x"></i>
                        </a>
                    </li>-->
                    <li>
                        <a href="javascript:" data-action="preview" title="preview">
                            <i class="icon-eye-open icon-2x"></i>
                        </a>
                    </li>
                    <li class="disabled" style="padding-left:20px;">
                        <a href="javascript:" data-action="pagefront" title="switch to front page">
                            <i class="icon-file-text icon-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:" data-action="pageback" title="switch to the reverse">
                            <i class="icon-file-text-alt icon-2x"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <input type="hidden" id="current-item" style="display:none;" />
        <input type="hidden" name="status" style="display:none;" data-action="<?php echo $action; ?>" data-guid="<?php echo $guid; ?>" />
        <div id="box-editing">
            <div class="hm-row">
                <div class="hm-row" style="width:934px;height:100px;position:absolute;margin:0px;padding:0px;">
                    <div class="tools unselectable pull-right" id="box-toolbar-move" style="margin-right:10px;">
                        <ul>
                            <li></li>
                            <li>
                                <a href="javascript:" data-action="moveup">
                                    <i class="icon-arrow-up icon-2x"></i>
                                </a>
                            </li>
                            <li></li>
                            <li>
                                <a href="javascript:" data-action="moveleft" class="pull-left">
                                    <i class="icon-arrow-left icon-2x"></i>
                                </a>
                            </li>
                            <li></li>
                            <li>
                                <a href="javascript:" data-action="moveright" class="pull-right">
                                    <i class="icon-arrow-right icon-2x"></i>
                                </a>
                            </li>
                            <li></li>
                            <li>
                                <a href="javascript:" data-action="movedown">
                                    <i class="icon-arrow-down icon-2x"></i>
                                </a>
                            </li>
                            <li></li>
                        </ul>
                    </div>
                </div>
                <!-- width=@width, height=@height -->
                <div id="box-canvas-wrapper" style="width:<?php echo $width . "px"; ?>;height:<?php echo $height . "px"; ?>">
                    <canvas style="-moz-user-select: none; cursor: crosshair;" width="<?php echo $width; ?>" height="<?php echo $height; ?>" id="c1"></canvas>
                </div>
                <div id="box-alert" class="hide" style="">
                    <p class="body" style="color:orange;padding:5px;background-color:white;"></p>
                </div>
                <div class="progress hm-progress hide">
                    <div id="progress-bar" style="width:0%;height:8px;background-color:orange"></div>   
                </div>
                <div class="tools unselectable" id="box-toolbar-zoom">
                    <ul style="list-style:none;">
                        <li style="border-bottom:1px solid #333">
                            <a href="javascript:" data-action="remove" title="trash"><i class="icon-trash icon-2x"></i></a>
                        </li>
                        <li>
                            <a href="javascript:" data-action="backward" title="backword"><i class="icon-file-alt icon-2x"></i></a>
                        </li>
                        <li>
                            <a href="javascript:" data-action="forward" title="forward"><i class="icon-file icon-2x"></i></a>
                        </li>
                        <li>
                            <a href="javascript:" data-action="lock" title="forward"><i class="icon-lock icon-2x"></i></a>
                        </li>
                        <li style="height:10px;"></li>
                        <li>
                            <a href="javascript:" data-action="zoomin"><i class="icon-zoom-in icon-2x"></i></a>
                        </li>
                        <li class="disabled">
                            <a href="javascript:" data-action="zoomout"><i class="icon-zoom-out icon-2x"></i></a>
                        </li>
                        <li class="disabled">
                            <a href="javascript:" data-action="zoomfit"><i class="icon-screenshot icon-2x"></i></a>
                        </li>
                        <li class="disabled">
                            <a href="javascript:" data-action="undo" title="undo" id="btn-undo"><i class="icon-undo icon-2x"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="tools unselectable hide" id="box-toolbar-bg">
                    <ul style="list-style:none;">
                        <li class="divider" id="li-backgroundcolor">
                            <a href="javascript:"><i class="icon-unchecked icon-2x"></i></a>
                            <ul class="hide" >
                                <li>
                                    <a href='javascript:' data-action="backgroundcolor" data-data="black" style="background-color:black;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="backgroundcolor" data-data="red" style="background-color:red;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="backgroundcolor" data-data="blue" style="background-color:blue;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="backgroundcolor" data-data="yellow" style="background-color:yellow;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="backgroundcolor" data-data="green" style="background-color:green;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="backgroundcolor" data-data="pink" style="background-color:pink;"></a>
                                </li>
                                <li style="width:auto;" class="disabled">
                                    <input type="text" id="bg-color-picker" />
                                </li>
                            </ul>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="backgroundcolor" data-data="#ffffff"><i class="icon-trash icon-2x"></i></a>
                        </li>
                        <li>
                            <a href="javascript:" onclick="jQuery('#box-toolbar-bg').hide();"><i class="icon-ok icon-2x"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="tools unselectable hide" id="box-toolbar-shape">
                    <ul style="list-style:none;">
                        <li class="divider" id="li-backgroundcolor">
                            <a href="javascript:" data-action="shape-circle" data-data="circle"><i class="icon-circle icon-2x"></i></a>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="shape-rect" data-data="rect"><i class="icon-stop icon-2x"></i></a>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="shape-tri" data-data="tri"><i class="icon-play icon-2x"></i></a>
                        </li>
                        <li>
                            <a href="javascript:" onclick="jQuery('#box-toolbar-shape').hide();"><i class="icon-ok icon-2x"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="image-editor unselectable hide" id="box-toolbar-imageeditor">
                    <ul style="list-style:none;">
                        <li class="divider">
                            <a href="javascript:" data-action="cropstart"><i class="icon-crop icon-2x"></i></a>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="cropend"><i class="icon-ok icon-2x"></i></a>
                        </li>
                        <li>
                            <a href="javascript:" data-action="close"><i class="icon-remove icon-2x"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="text-editor unselectable hide" id="box-toolbar-texteditor">
                    <ul style="list-style:none;">
                        <li class="divider" style='background-color:#eee' id="li-text-content">
                            <a href="javascript:" data-action="backgroundcolor"><i class="icon-pencil icon-2x"></i></a>
                            <ul style='display:block;'>
                                <li>
                                    <textarea style='width:455px;border:1px solid #ccc;height:140px;resize:none;border-radius: 0px;' id="text-content"></textarea>
                                </li>
                            </ul>
                        </li>
                        <li class="divider" id='li-font-type' >
                            <a href="javascript:" data-action="clearbackground"><i class="icon-font icon-2x"></i></a>
                            <ul>
                                <li title="Arial"><a data-action="type" data-data="Arial" style="font-family: Arial">Arial</a></li>
                                <li title="Arial Black"><a data-action="type" data-data="Arial Black" style="font-family: Arial Black">Arial Black</a></li>
                                <li title="Comic Sans MS"><a data-action="type" data-data="Comic Sans MS" style="font-family: Comic Sans MS">Comic Sans MS</a></li>
                                <li title="Courier New"><a data-action="type" data-data="Courier New" style="font-family: Courier New">Courier New</a></li>
                                <li title="Arial Black"><a data-action="type" data-data="Georgia" style="font-family: Georgia">Georgia</a></li>
                                <li title="Impact"><a data-action="type" data-data="Impact" style="font-family: Impact">Impact</a></li>
                                <li title="Times New Roman"><a data-action="type" data-data="Times New Roman" style="font-family: Times New Roman">Times New Roman</a></li>
                                <li title="Trebuchet MS"><a data-action="type" data-data="Trebuchet MS" style="font-family: Trebuchet MS">Trebuchet MS</a></li>
                                <li title="Verdana"><a data-action="type" data-data="Verdana" style="font-family: Verdana">Verdana</a></li>
                                <!-- 
                                <li title="League Gothic"><p style="background-position:10px -40px"></p></li>
                                <li title="Arial" class="selected"><p style="background-position:10px -60px"></p></li>
                               <li title="Georgia"><p style="background-position:10px -80px"></p></li>
                                <li title="Lobster"><p style="background-position:10px -100px"></p></li>
                                <li title="Bebas Nueue"><p style="background-position:10px -120px"></p></li>
                                <li title="Gill Sans"><p style="background-position:10px -140px"></p></li>
                                <li title="Optima"><p style="background-position:10px -160px"></p></li>
                                <li title="Bodoni"><p style="background-position:10px -180px"></p></li>
                                <li title="Gill Sans Light"><p style="background-position:10px -200px"></p></li>
                                <li title="Overlock"><p style="background-position:10px -220px"></p></li>
                                <li title="Bradley Hand"><p style="background-position:10px -240px"></p></li>
                                <li title="Gladifilthefte"><p style="background-position:10px -260px"></p></li>
                                <li title="Rockwell"><p style="background-position:10px -280px"></p></li>
                                <li title="Cartoonist Hand"><p style="background-position:10px -300px"></p></li>
                                <li title="Great Vibes"><p style="background-position:10px -320px"></p></li>
                                <li title="Sofia"><p style="background-position:10px -340px"></p></li>
                                <li title="ChunkFive"><p style="background-position:10px -360px"></p></li>
                                <li title="Helvetica Nueue Condensed"><p style="background-position:10px -380px"></p></li>
                                <li title="Tangerine"><p style="background-position:10px -400px"></p></li>
                                <li title="Clarendon"><p style="background-position:10px -420px"></p></li>
                                <li title="Helvetica Nueue Light"><p style="background-position:10px -440px"></p></li>
                                <li title="Times"><p style="background-position:10px -460px"></p></li>
                                <li title="Dancing Script"><p style="background-position:10px -480px"></p></li>-->
                            </ul>
                        </li>
                        <li class="divider" id='li-font-size'>
                            <a href="javascript:" data-action="backgroundcolor"><i class="icon-text-width icon-2x"></i></a>
                            <ul>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="9">9</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="10">10</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="11">11</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="12">12</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="13">13</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="14">14</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="18">18</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="24">24</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="36">36</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="48">48</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="64">64</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="72">72</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="96">96</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="144">144</a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="size" data-data="288">288</a>
                                </li>
                            </ul>
                        </li>
                        <li class="divider" id="li-font-color">
                            <a href="javascript:" data-action="clearbackground"><i class="icon-unchecked icon-2x"></i></a>
                            <ul>
                                <li>
                                    <a href='javascript:' data-action="color" data-data="black" style="background-color:black;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="color" data-data="red" style="background-color:red;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="color" data-data="blue" style="background-color:blue;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="color" data-data="yellow" style="background-color:yellow;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="color" data-data="green" style="background-color:green;"></a>
                                </li>
                                <li>
                                    <a href='javascript:' data-action="color" data-data="pink" style="background-color:pink;"></a>
                                </li>
                                <li style="width:auto;" class="disabled">
                                    <input type="text" id="font-color-picker" />
                                </li>
                            </ul>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="weight"><i class="icon-bold icon-2x"></i></a>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="italic"><i class="icon-italic icon-2x"></i></a>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="underline"><i class="icon-underline icon-2x"></i></a>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="align" data-data="left"><i class="icon-align-left icon-2x"></i></a>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="align" data-data="center"><i class="icon-align-center icon-2x"></i></a>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="align" data-data="right"><i class="icon-align-right icon-2x"></i></a>
                        </li>
                        <li class="divider">
                            <a href="javascript:" data-action="confirm"><i class="icon-ok icon-2x"></i></a>
                        </li>
                        <li>
                            <a href="javascript:" data-action="close"><i class="icon-remove icon-2x"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- editor -->
    </div>

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
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

<!-- preview modal -->
<div id="modal-preview" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Your Design</h3>
    </div>
    <div class="modal-body" style="background:#ccc">
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
    <div class="modal-body">
        <div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>
    </div>
    <div class="modal-footer">
        <p class="text-error">You have to sign in to save your progress.</p>
    </div>
</div>
<!-- user modal -->
<div id="modal-upload-progress" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body">
    </div>
</div>

<script src='<?php echo $this->webroot; ?>js/spectrum/spectrum.js'></script>
<script src='<?php echo $this->webroot; ?>js/maker/json2.js'></script>
<script src='<?php echo $this->webroot; ?>js/maker/jquery.cookie.js'></script>
<script src="<?php echo $this->webroot; ?>js/maker/1211.all.js"></script>
<script src="<?php echo $this->webroot; ?>js/maker/_190.mememaker.js"></script>
<script src="<?php echo $this->webroot; ?>js/maker/_190.mememakerinit.js"></script>

<script>
function PL(id) {   
    return document.getElementById(id);
}

var uploader = new plupload.Uploader({
    runtimes: 'gears,html5,browserplus',
    browse_button: 'btn-upload-image',
    container: 'uploader',
    max_file_size: '10mb',
    url: '<?php echo $action_upload; ?>',
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
        //document.getElementById('filelist').innerHTML = '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
    }
    jQuery('#progress-bar').css('width', "0%");
    $("#progress-bar").parent().show();
    uploader.start();
});

uploader.bind('UploadProgress', function(up, file) {
    //$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
    jQuery('#progress-bar').css('width', file.percent + "%");
});

uploader.bind('FileUploaded', function(up, file, response) {
    plupload.each(response, function(value, key) {
        if (key == "response") {
            try {
                var result = jQuery.parseJSON(value);
                if (result.error == 0) {
                    //showAlert2("Loading image....");
                    $("#progress-bar").css("width", "0px");
                    $("#progress-bar").parent().hide();
                    showAlert2("Loading image......");
                    $.mememaker.tools.addpic(result.files.url);
                }
            }
            catch (e) {
                console.log(e);
            }
            //jQuery('#progress-bar').css('width', "0%");
        }
    });
    //alert($.parseJSON(response.response).result);
});

jQuery(document).ready(
        function() {
            $(window).on('beforeunload', function() {
                //return 'Are you sure you want to leave? Your design isn\'t saved yet.';
            });
            maker_init();
            ;
        }
);
    
function maker_init()
{
    $.mememakerinit.init('c1', "#FFFFFF");
    $.mememakerinit.toolsinit(".tools");
    $.mememakerinit.texteditorinit(".text-editor");
    $.mememakerinit.imageeditorinit(".image-editor");
    $.mememakerinit.draweditorinit(".draw-editor");
    
    $.mememakerinit.returnurl = "<?php echo $returnUrl; ?>";
    
    var val = $("input[name=status]").data('action');
    var guid = $("input[name=status").data('guid');
    
    if (val === 'edit' || val === 'list') {
        reload (guid);
    }
}

//===========================================================
// Server API
//===========================================================

function reload (guid)
{
    showAlert2 ("Loading template, please wait......");
    jQuery.ajax({
        url: "<?php echo $action_reload; ?>/?id=" + guid,
        type: "GET",
        beforeSend: function(xhr) {
        }
    }).done(function(data) {
        
        if (data === "nodata") {
        		hideAlert ();
        		return;
        }
        
        showAlert2 ("Initialize pages, please wait......");
        var result = JSON.parse(data);
        localStorage.pages = JSON.stringify(result);
        $.mememaker.tools.loadpage(0, function () {
            hideAlert ();
        });
        
        //hideAlert ();
        
    }).fail(function() {
        showAlert ("Failed");
    });
}

//===================================================
function formuser_load()
{
    jQuery.ajax({
        url: "",
        type: "GET",
        beforeSend: function(xhr) {
        }
    }).done(function(data) {
        $("#modal-user .modal-body").html(data);
    }).fail(function() {
        jQuery(".ajax-loading-indicator").hide(0);
    });
}

function signup_submit()
{
    jQuery.ajax({
        url: "",
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
            alert("Now click 'save'to save your progress");
        }
    }).fail(function() {
    });
}

function signin_submit()
{
    jQuery.ajax({
        url: "",
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
            alert("Now click 'save'to save your progress");
        }
    }).fail(function() {
    });
}
</script>

<div class="row hide" id="box-message" style="position: fixed;top:0px;left:0px;z-index:1030;margin-bottom:0;">
        <div class="span4 offset4">
            <div style="background-color:yellow;min-height:20px;border:1px black solid; ">
                <p style="margin-top:5px;margin-left:20px;"><strong><span class="body"></span></strong></p>
            </div>
        </div>
    </div>
    
    <script>
        
        function showAlert (message)
        {
            $("#box-message .body").html(message);
            $("#box-message").show ();
            window.setTimeout(function () {$("#box-message").hide(100)}, 5000);
        }
        
        function showAlert2 (message) 
        {
            $("#box-message .body").html(message);
            $("#box-message").show ();
        }
        
        function hideAlert (message)
        {
            $("#box-message").hide ();
        }
        
    </script>