<!--[if !lte IE 6]><!-->
<!-- Link to Google CDN jQuery + jQueryUI; fall back to local -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery.min.js"><\/script>')</script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>window.jQuery.ui || document.write('<script src="js/libs/jquery.ui.min.js"><\/script>')</script>

<!-- RECOMMENDED: For (IE6 - IE8) CSS3 pseudo-classes and attribute selectors -->
<!--[if lt IE 9]> 
   <script src="js/include/selectivizr.min.js"></script>                   
<![endif]-->

<script src="js/libs/jquery.ui.touch-punch.min.js"></script>                <!-- REQUIRED:  A small hack that enables the use of touch events on mobile -->

<!-- Add 'http:' for testing locally -->
<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>

<script src="js/menu/jquery.ct.3LevelAccordion.min.js"></script>            <!-- REQUIRED: Accordion Menu with filter-->
<script src="js/slider/jquery.responsivethumbnailgallery.min.js"></script>  <!-- REQUIRED: Responsive Gallery Plugin -->
<script src="js/slider/jquery.onebyone.min.js"></script>                    <!-- REQUIRED: Slider Plugin -->
<script src="js/slider/jquery.touchwipe.min.js"></script>                   <!-- REQUIRED: Plugin to make Slider Plugin work on Touch Devices -->
<script src="js/slider/jquery.onebyone.min.js"></script>                    <!-- REQUIRED: Slider Plugin -->
<script src="js/slider/jquery.touchwipe.min.js"></script>                   <!-- REQUIRED: Plugin to make Slider Plugin work on Touch Devices -->

<script src="js/include/jquery.fitvids.min.js"></script>                    <!-- RECOMMENDED: Responsive videos -->         
<script src="js/include/jquery.tweet.min.js"></script>                      <!-- OPTIONAL: Twitter display plugin -->
<script src="js/include/jquery.equal-heights.min.js"></script>              <!-- RECOMMENDED: Plugin to keep div heights consistant --> 
<script src="js/include/jquery.todo.min.js"></script>                       <!-- REQUIRED: Plugin to save "add to short list" items -->
<script src="js/include/jquery.pubsub.min.js"></script>                     <!-- REQUIRED: (If todo.js is in use) Dependent with todo.js -->
<script src="js/include/jquery.select2.min.js"></script>                    <!-- RECOMMENDED: Custom jQuery/searchable dropdowns -->    
<script src="js/include/bootstrap.min.js"></script>                         <!-- REQUIRED: For BootStrap build -->

<script src="js/config.js"></script>
<script type="text/javascript"></script>
$(function() {
    //$( "#slider" ).slider();
});
</script>   

<!-- DO NOT REMOVE: Contains major plugin initiations and functions -->
<!--<![endif]-->

<!-- jquery range -->
<!--<script type="text/javascript" src = "js/tools/jquery.tools.min.js"></script>-->
<link rel="stylesheet" href="js/bootstrapslider/css/slider.css">
<script type="text/javascript" src="js/bootstrapslider/js/bootstrap-slider.js"></script>
<!-- colorpicker -->
<link rel="stylesheet" href="js/colorpicker2/css/bootstrap-colorpicker.css">
<script type="text/javascript" src="js/colorpicker2/js/bootstrap-colorpicker.js"></script>
<!--<script type="text/javascript" src="js/colorpicker2/js/docs.js"></script>-->
<!-- fabric.js -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.2.0/fabric.all.min.js"></script>
    <!--<script src="js/fabric.js"></script>-->
<script>
    
var $ = jQuery.noConflict ();

var mememaker = {
    canvasId: 'c1',
    activeObject: null,
    template: null,
    objects: [],
    canvas: null,
    lastImageX: 10,
    lastImageY: 10,
    lastTextX: 150,
    lastTextY: 10,
    textTotal: 0,
    imageTotal: 0,
    backgroundColor: 'white',

    defaultText: null,

    // methods
    init: null,
    mousedown: null,

    // object memeber
    tools: {
        container: '.tools',
        init: null,
        new: null,
        info: null,
        remove: null,
        group: null,
        backward: null,
        forward: null,
        toBack: null,
        toFront: null,
        flip: null,
        newtext: null,
        newpic: null,
        addpic: null,
        resize: null,
        preview: null,
        backgroundcolor: null,
        newtemplate: null,
    },
    texteditor: {
        id: null,
        current: null,
        init: null,
        fill: null,
        changeFontFamily: null,
        changeText: null,
        changeFontProperty: null,
        textselected: null,
    },
    imageeditor: {
        id: null,
        current: null,
        zoomValue: null,
        rotateValue: null,
        init: null,
        zoom: null,
        rotate: null,
        flipX: null,
        flipY: null,
        imageselected: null,
    },
    draweditor: {
        id: null,
        current: null,
        lineWidth: null,
        shadowWidth: null,
        init: null,
        fill: null,
        enable: null
    }
};

mememaker.defaultText = {
    text: 'Your Text Is Here',
    property: {
        fontFamily: 'Impact',
        fontWeight: 'bold',
        fontSize: 40,
        fill: 'black',       
        //stroke: 'white',
        //strokeWidth: 0,
        originX: 'left',
        originY: 'top',
        left: mememaker.lastTextX,
        top: mememaker.lastTextY
    }
}

mememaker.mousedown = function (options) {
    var type = options.target.type;
    switch (type) {
        case "text":
            break;
        case "image":
            break;
        case "group":
            break;
        default:
            break;
    }
    return false;
}

mememaker.init = function (id) {
    mememaker.canvasId = id;

    mememaker.canvas = new fabric.Canvas(mememaker.canvasId);
    mememaker.canvas.backgroundColor = mememaker.backgroundColor = 'white';
    mememaker.canvas.selection = true;
    mememaker.canvas.clear ();

    /*
    mememaker.canvas.on (
        'mouse:down',
        function (options) {
            //mememaker.mousedown (options)
        }
    );

    mememaker.canvas.on (
        'mouse:up',
        function (options) {

        }
     )*/
}

// tools
mememaker.tools.init = function (id) {
    if (id != null) {
        mememaker.tools.container = id;
    }
    
    //$("#canvas-background-color").colorpicker().on('changeColor', function (ev) {
    //    mememaker.tools.backgroundcolor (ev.color.toHex());    
    //});
    
    $(mememaker.tools.container + " a").click(
            function(evt) {
                var action = $(this).data('action');

                switch (action) {
                    case 'new':
                        mememaker.tools.new ();
                        break;
                    case 'info':
                        break;
                    case 'remove':
                        mememaker.tools.remove();
                        break;
                    case 'group':
                        mememaker.tools.group();
                        break;
                    case 'backward':
                        mememaker.tools.backward();
                        break;
                    case 'forward':
                        mememaker.tools.forward();
                        break;
                    case 'back':
                        mememaker.tools.toBack();
                        break;
                    case 'front':
                        mememaker.tools.toFront();
                        break;
                    case 'flipx':
                        mememaker.tools.flip (0);
                        break;
                    case 'flipy':
                        mememaker.tools.flip (1);
                        break;
                    case 'newtext':
                        mememaker.tools.newtext();
                        break;
                    case 'newpic':
                        break;
                    case '+height':
                        mememaker.tools.resize(true, this);
                        break;
                    case '-height':
                        mememaker.tools.resize(false, this);
                        break;
                    case 'preview':
                        mememaker.tools.preview();
                        break;
                    case 'backgroundcolor':
                        //mememaker.tools.backgroundcolor ();
                        break;
                    case 'backgroundimage':
                        mememaker.tools.backgroundimage("img/muffin.png");
                        break;
                    case 'draw':
                        mememaker.draweditor.enable ($(this));
                        break;
                    default:
                        break;
                }
            }
    );
}

mememaker.tools.new = function() {
    mememaker.backgroundColor = 'white';
    mememaker.lastTextX = 150;
    mememaker.lastTextY = 10;
    mememaker.lastImageX = 10;
    mememaker.lastImageY = 10;
    mememaker.canvas.backgroundColor = mememaker.backgroundColor;
    //mememaker.canvas.backgroundImage = null;
    mememaker.canvas.clear();
}

mememaker.tools.remove = function() {
    var el = mememaker.canvas.getActiveObject();

    if (el == null || el == undefined) {
        el = mememaker.canvas.getActiveGroup();
        if (el == null || el == undefined) {
            return;
        }

        //alert (el);
        mememaker.canvas.discardActiveGroup();
        for (i = 0; i < el.getObjects().length; ++i) {
            mememaker.canvas.remove(el.item(i));
        }

        return;
    }

    mememaker.canvas.remove(el);
}

mememaker.tools.group = function() {
    var el = mememaker.canvas.getActiveGroup();
    if (el == null || el == undefined) {
        return;
    }

    var texts = [];
    var images = [];
    var i = 0;

    for (i = 0; i < el.getObjects().length; ++i) {

        if (el.item(i).isType('image')) {
            texts[i] = null;
        } else {
            texts[i] = el.item(i).clone();
        }
    }

    for (i = 0; i < el.getObjects().length; ++i) {

        if (el.item(i).isType('image')) {
            images[i] = el.item(i);
        } else {
            images[i] = null;
        }
    }

    function cloneImages(j, items, images, gr)
    {
        if (j >= images.length) {
            var group = new fabric.Group(
                    items,
                    {
                        'left': gr.left,
                        'top': gr.top
                    }
            );

            mememaker.canvas.discardActiveGroup();
            for (i = 0; i < items.length; ++i) {
                mememaker.canvas.remove(gr.item(i));
            }

            mememaker.canvas.add(group);
            return;
        }

        if (images[j] != null) {
            images[j].clone(
                    function(el) {
                        items[j] = el;
                        cloneImages(j + 1, items, images, gr);
                    }, null
                    )
        } else {
            cloneImages(j + 1, items, images, gr);
        }
    }

    cloneImages(0, texts, images, el);
}

mememaker.tools.backward = function() {
    var el = mememaker.canvas.getActiveObject();

    if (el == null || el == undefined) {
        el = mememaker.canvas.getActiveGroup();
        if (el == null || el == undefined) {
            return;
        }

        //alert (el);
        el.sendBackwards();

        return;
    }

    el.sendBackwards();
}

mememaker.tools.forward = function() {
    var el = mememaker.canvas.getActiveObject();

    if (el == null || el == undefined) {
        el = mememaker.canvas.getActiveGroup();
        if (el == null || el == undefined) {
            return;
        }

        //alert (el);
        el.bringForward();

        return;
    }

    el.bringForward();
}

mememaker.tools.toBack = function() {
    var el = mememaker.canvas.getActiveObject();

    if (el == null || el == undefined) {
        el = mememaker.canvas.getActiveGroup();
        if (el == null || el == undefined) {
            return;
        }

        //alert (el);
        el.sendToBack();

        return;
    }

    el.sendToBack();
}

mememaker.tools.toFront = function() {
    var el = mememaker.canvas.getActiveObject();

    if (el == null || el == undefined) {
        el = mememaker.canvas.getActiveGroup();
        if (el == null || el == undefined) {
            return;
        }

        //alert (el);
        el.bringToFront();

        return;
    }

    el.bringToFront();
}

mememaker.tools.flip = function (x) {
    var el = mememaker.canvas.getActiveObject();

    if (el == null || el == undefined) {
        el = mememaker.canvas.getActiveGroup();
        if (el == null || el == undefined) {
            return;
        }

        if (x == 0) {
            el.flipX = el.flipX == true ? false : true;
        } else {
            el.flipY = el.flipY == true ? false : true;
        }

        mememaker.canvas.renderAll();
        return;
    }

    if (x == 0) {
        el.flipX = el.flipX == true ? false : true;
    } else {
        el.flipY = el.flipY == true ? false : true;
    }

    mememaker.canvas.renderAll();   
}

mememaker.tools.newtext = function() {
    var text = new fabric.Text(mememaker.defaultText.text, mememaker.defaultText.property);

    //var content = $("#text-text").val();
    //if ($.trim(content) == "") {
        //return;
    //}
    //$("#text-text").val ("");
    
    text.text = "CLICK TO EDIT";
    text.fontFamily = $("#text-font-family").val();
    text.originX = "center";
    text.originY = "center";
    text.left = mememaker.lastTextX + text.getWidth() / 2;
    text.top = mememaker.lastTextY + text.getHeight() / 2;

    mememaker.canvas.add(text);
    //mememaker.lastTextX += 10;
    mememaker.lastTextY += 10;

    if (mememaker.lastTextX >= 400) {
        mememaker.textTotal += 1;
        mememaker.lastTextX = mememaker.textTotal * 10;
        mememaker.lastTextY = mememaker.textTotal * 10;
    }

    mememaker.canvas.renderAll();
    
    text.on(
            'selected',
            function(options) {
                mememaker.texteditor.textselected ();
            }
    )
}

mememaker.tools.addpic = function(url) {
   
    fabric.Image.fromURL(url, function(oImg) {
        // scale image down, and flip it, before adding it onto canvas
        //oImg.set('originX', 'left');
        //oImg.set('originY', 'top');
        oImg.left = mememaker.lastImageX + oImg.getWidth() / 2;
        oImg.top = mememaker.lastImageY + oImg.getHeight() / 2;

        mememaker.canvas.add(oImg);
        mememaker.lastImageX += 10;
        mememaker.lastImageY += 10;

        if (mememaker.lastImageX >= 400) {
            mememaker.imageTotal += 1;
            mememaker.lastImageX = mememaker.textTotal * 10;
            mememaker.lastImageY = mememaker.textTotal * 10;
        }
        
        oImg.on(
            'selected',
            function(options) {
                mememaker.imageeditor.imageselected ();
            }
        );
        
    });
}

mememaker.tools.newtemplate = function (url) {
    
    mememaker.canvas.setOverlayImage(url, mememaker.canvas.renderAll.bind(mememaker.canvas));

}

mememaker.tools.resize = function(plus, evt) {

    var height = $('#' + $(evt).data('prefix') + '-height').val();

    height = $.trim(height);
    if (height == '') {
        height = '0';
    }

    height = parseInt(height);

    if (plus == false) {
        if (height == 0) {
            return;
        }
        if (mememaker.canvas.getHeight() - height <= 0) {
            mememaker.canvas.setDimensions({width: 460, height: 460});
        } else {
            mememaker.canvas.setDimensions({width: 460, height: mememaker.canvas.getHeight() - height});
        }
        return;
    }

    if (height == 0) {
        height = 460;
    }

    mememaker.canvas.setDimensions({width: 460, height: mememaker.canvas.getHeight() + height});
}

mememaker.tools.preview = function() {
    // it will convert canvas to base64
    console.log ('preview');
    var c = "box-" + mememaker.canvasId;

    $("#" + c).toggle();
    $("#" + c + "-preview").toggle();

    var preview = mememaker.canvas.toDataURL(
            {
                format: 'jpeg',
                quality: 1
            }
    );

    $.ajax({
        url: "media/preview",
        data:{"image-extension":"jpeg", "image-data":preview},
        type: "POST",
        beforeSend: function(xhr) {
            //$("#ajax-indicator").show();
            console.log ("working....");
        }
    }).done(function(data) {
        //$("#ajax-indicator").hide();
        
        result = $.parseJSON (data);
        if (result.error == 0) {
            var url = result.files.url;
            console.log (url);
        } else {
            console.log (result.message);
        }
        
        //if (data=='ok') {
        //    
        //    $("input[type=text]").val('');
        //    $("input[type='password'").val('');
        //    $("textarea").val('');
        //    $(".alert").hide();
        //    
        //} else {
        //    $(".alert").show();
        //    $("#alert-text").html(data);
        //    setTimeout(function () {$(".alert").hide(100)}, 3000);
        //}
    }).fail(function () {
        
    });
    //mememaker.canvas.deactivateAll();
    //$("#" + mememaker.canvasId + "-preview").attr('src', preview);
}

mememaker.tools.backgroundcolor = function(color) {
    //console.log (color);
    mememaker.canvas.backgroundColor = color;
    mememaker.canvas.renderAll();
}

mememaker.tools.backgroundimage = function(url) {
    mememaker.canvas.setBackgroundImage(
            url,
            function() {
                mememaker.canvas.renderAll();
            }, {'originX': 'left', 'originY': 'top', 'left': 0, 'top': 0}
    )
}

// text editor

mememaker.texteditor.init = function (id) {
   if (id !== null) {
      mememaker.texteditor.id = id;
   }
   
   $("#text-font-family").change (
      function () {
         mememaker.texteditor.changeFontFamily ($(this).val());
      }
   )  
    
    $("#text-fill").colorpicker().on('changeColor', function(ev){
        mememaker.texteditor.fill (ev.color.toHex());
    });
    
    $("#text-text").keyup (
        function (evt) {
            if ( evt.which == 13 ) {
                evt.preventDefault();
                mememaker.texteditor.changeText ();
                return;
            }
            
            mememaker.texteditor.changeText ();
        }
    )
    
    $(mememaker.texteditor.id + " a").click (
        function () {
            switch ($(this).data('action')) {
                case "bold":
                    mememaker.texteditor.changeFontProperty ("weight");
                    break;
                case "italic":
                    mememaker.texteditor.changeFontProperty ("italic");
                    break;
            }
        }
    )
}

mememaker.texteditor.textselected = function(options) {
    
    var el = mememaker.canvas.getActiveObject();
    
    if (el == null || el == undefined) {
        return;
    }

    if (el.type != "text") {
        return;
    }
    
    $("#text-text").val (el.text);
    $("#text-font-family").val (el.fontFamily);
    $("#text-fill").val (el.fill);
    $(".editor").hide (0);
    $(".text-editor").show(0);
}

mememaker.texteditor.fill = function (color) {
    var el = mememaker.canvas.getActiveObject();
    
    if (el == null || el == undefined) {
        return;
    }

    if (el.type != "text") {
        return;
    }
    
    el.fill = color;
    mememaker.canvas.renderAll();
}

mememaker.texteditor.changeFontFamily = function (fontFamily) {
    var el = mememaker.canvas.getActiveObject();
    
    if (el == null || el == undefined) {
        return;
    }

    if (el.type != "text") {
        return;
    }
    
    el.fontFamily = fontFamily;
    mememaker.canvas.renderAll();    
}

mememaker.texteditor.changeText = function (fontFamily) {
    var el = mememaker.canvas.getActiveObject();
    
    if (el == null || el == undefined) {
        return;
    }

    if (el.type != "text") {
        return;
    }
    
    el.text = $("#text-text").val ();
    if (el.text == "") {
        mememaker.canvas.remove (el);
    }
    mememaker.canvas.renderAll();    
}

mememaker.texteditor.changeFontProperty = function (property) {
    
    var el = mememaker.canvas.getActiveObject();
    
    if (el == null || el == undefined) {
        return;
    }

    if (el.type != "text") {
        return;
    }
    
    if (property == "weight") {
        if (el.fontWeight == "normal") {
            el.fontWeight = "bold";
        } else if (el.fontWeight == "bold") {
            el.fontWeight = "normal";
        }
    }
    
    if (property == "italic") {
        if (el.fontStyle == "italic") {
            el.fontStyle = "";
        } else {
            el.fontStyle = "italic";
        }
    }
    mememaker.canvas.renderAll();
}

// image editor

mememaker.imageeditor.init = function (id) {
    
    if (id !== null) {
        mememaker.imageeditor.id = id;
    }
    
    //http://www.eyecon.ro/bootstrap-slider/
    mememaker.imageeditor.zoomValue = $("#image-zoom").slider(
        {
            formater: function(value) {
                return '' + value / 100;
            }
        }
    ).on (   
        "slide",
        function () {
            mememaker.imageeditor.zoom (mememaker.imageeditor.zoomValue.getValue());
        }
    ).data('slider');
    
    mememaker.imageeditor.rotateValue = $("#image-rotation").slider(
        {
            formater: function(value) {
                return '' + value;
            }
        }
    ).on (
        "slide",
        function () {
            mememaker.imageeditor.rotate (mememaker.imageeditor.rotateValue.getValue());
        }
    ).data('slider');
}

mememaker.imageeditor.imageselected = function () {
    var el = mememaker.canvas.getActiveObject();
    
    if (el == null || el == undefined) {
        return;
    }

    if (el.type != "image") {
        return;
    }
    
    $(".editor").hide (0); 
    $(".image-editor").show(0);  
}

mememaker.imageeditor.zoom = function (value) {
     var el = mememaker.canvas.getActiveObject();
    
    if (el == null || el == undefined) {
        return;
    }

    if (el.type != "image") {
        return;
    }
    
    var scale = value / 100;
    el.scale (scale);
    mememaker.canvas.renderAll();
    
    //$(".text-editor").hide(10);  
    //$(".image-editor").show(10);    
}

mememaker.imageeditor.rotate = function (value) {
     var el = mememaker.canvas.getActiveObject();
    
    if (el == null || el == undefined) {
        return;
    }

    if (el.type != "image") {
        return;
    }
    
    el.originX = "center";
    el.originY = "center";
    
    //el.left = el.left + el.getWidth () / 2;
    //el.top = el.top + el.getHeight () / 2;
    el.angle = value;
    mememaker.canvas.renderAll();
    
    //$(".text-editor").hide(10);  
    //$(".image-editor").show(10);    
}

//
mememaker.draweditor.init = function (id) {
    if (id !== null) {
        mememaker.draweditor.id = id;
    }
    
    mememaker.draweditor.lineWidth = $("#draw-width").slider(
        {
            formater: function(value) {
                return '' + value;
            }
        }
    ).on (   
        "slide",
        function () {
            mememaker.canvas.freeDrawingBrush.width =  mememaker.draweditor.lineWidth.getValue();
        }
    ).data('slider');
    
    mememaker.draweditor.shadowWidth = $("#draw-shadow-width").slider(
        {
            formater: function(value) {
                return '' + value;
            }
        }
    ).on (
        "slide",
        function () {
            mememaker.canvas.freeDrawingBrush.shadowBlur = mememaker.draweditor.shadowWidth.getValue();
        }
    ).data('slider');
    
    $("#draw-fill").colorpicker().on('changeColor', function(ev){
        mememaker.canvas.freeDrawingBrush.color = ev.color.toHex();
    });
    
    $('#draw-mode-selector').on('change', function() {
        
        console.log (this.value);
        if (this.value === 'hline') {
            if (fabric.PatternBrush) {
               var vLinePatternBrush = new fabric.PatternBrush(mememaker.canvas);
               vLinePatternBrush.getPatternSrc = function() {
           
                 var patternCanvas = fabric.document.createElement('canvas');
                 patternCanvas.width = patternCanvas.height = 10;
                 var ctx = patternCanvas.getContext('2d');
           
                 ctx.strokeStyle = this.color;
                 ctx.lineWidth = 5;
                 ctx.beginPath();
                 ctx.moveTo(0, 5);
                 ctx.lineTo(10, 5);
                 ctx.closePath();
                 ctx.stroke();
           
                 return patternCanvas;
               };
            }
            console.log (vLinePatternBrush);
            mememaker.canvas.freeDrawingBrush = vLinePatternBrush;
        }
        else if (this.value === 'vline') {
            if (fabric.PatternBrush) {
           
                var hLinePatternBrush = new fabric.PatternBrush(mememaker.canvas);
                hLinePatternBrush.getPatternSrc = function() {
            
                  var patternCanvas = fabric.document.createElement('canvas');
                  patternCanvas.width = patternCanvas.height = 10;
                  var ctx = patternCanvas.getContext('2d');
            
                  ctx.strokeStyle = this.color;
                  ctx.lineWidth = 5;
                  ctx.beginPath();
                  ctx.moveTo(5, 0);
                  ctx.lineTo(5, 10);
                  ctx.closePath();
                  ctx.stroke();
            
                  return patternCanvas;
                };
            }
            mememaker.canvas.freeDrawingBrush = hLinePatternBrush;
        }
        else if (this.value === 'square') {
            if (fabric.PatternBrush) {
           
                var squarePatternBrush = new fabric.PatternBrush(mememaker.canvas);
                squarePatternBrush.getPatternSrc = function() {
                
                    var squareWidth = 10, squareDistance = 2;
              
                    var patternCanvas = fabric.document.createElement('canvas');
                    patternCanvas.width = patternCanvas.height = squareWidth + squareDistance;
                    var ctx = patternCanvas.getContext('2d');
              
                    ctx.fillStyle = this.color;
                    ctx.fillRect(0, 0, squareWidth, squareWidth);
              
                    return patternCanvas;
                  };
            }
            mememaker.canvas.freeDrawingBrush = squarePatternBrush;
        }
        else if (this.value === 'diamond') {
            if (fabric.PatternBrush) {
           
                 var diamondPatternBrush = new fabric.PatternBrush(mememaker.canvas);
                diamondPatternBrush.getPatternSrc = function() {
                
                      var squareWidth = 10, squareDistance = 5;
                      var patternCanvas = fabric.document.createElement('canvas');
                      var rect = new fabric.Rect({
                        width: squareWidth,
                        height: squareWidth,
                        angle: 45,
                        fill: this.color
                      });
                      var canvasWidth = rect.getBoundingRectWidth();

                        patternCanvas.width = patternCanvas.height = canvasWidth + squareDistance;
                        rect.set({ left: canvasWidth / 2, top: canvasWidth / 2 });
                  
                        var ctx = patternCanvas.getContext('2d');
                        rect.render(ctx);
                  
                        return patternCanvas;
                }
            }
            mememaker.canvas.freeDrawingBrush = diamondPatternBrush;
        }
        else if (this.value === 'texture') {
            if (fabric.PatternBrush) {
                var img = new Image();
                img.src = 'img/texture/texture_honey.png';
            
                var texturePatternBrush = new fabric.PatternBrush(mememaker.canvas);
                texturePatternBrush.source = img;
            }
            mememaker.canvas.freeDrawingBrush = texturePatternBrush;
        }
        else {
            mememaker.canvas.freeDrawingBrush = new fabric[this.value + 'Brush'](mememaker.canvas);
        }
    
        if (mememaker.canvas.freeDrawingBrush) {
            mememaker.canvas.freeDrawingBrush.color = $("#draw-fill").val ();
            mememaker.canvas.freeDrawingBrush.width = mememaker.draweditor.lineWidth.getValue();
            mememaker.canvas.freeDrawingBrush.shadowBlur = mememaker.draweditor.shadowWidth.getValue();
        }
  });
}

mememaker.draweditor.enable = function (obj) {
    enable = mememaker.canvas.isDrawingMode == true ? false : true;
    if (enable) {
        $(obj).css('color', 'green');
        mememaker.canvas.discardActiveObject();
        mememaker.canvas.discardActiveGroup();
        
        var width = $("#draw-width").val ();
        if (width != "") {
            width = parseInt(width);    
        }
        
        //mememaker.canvas.freeDrawingLineWidth = width;
        //mememaker.canvas.freeDrawingColor = $("#draw-fill").val();
        mememaker.canvas.isDrawingMode = true;
        mememaker.canvas.freeDrawingBrush.width = width;
        mememaker.canvas.freeDrawingBrush.color = $("#draw-fill").val ();
        
        //mememaker.canvas.renderAll();
        
        $(".editor").hide (0);
        $(".draw-editor").show(0);
    } else {
        $(obj).css('color', '#c24f19');
        mememaker.canvas.discardActiveObject();
        mememaker.canvas.discardActiveGroup();
        mememaker.canvas.isDrawingMode = false;
    }
}
//
$(document).ready(
        function() {
            //alert ("hello");
            mememaker.init('c1');
            mememaker.tools.init(".tools");
            mememaker.tools.newtemplate("<?php echo $this->webroot . "img/template/iphone.png"; ?>");
            mememaker.texteditor.init (".text-editor");
            mememaker.imageeditor.init (".image-editor");
            mememaker.draweditor.init (".draw-editor");

            $(".thumbnail-list a").click(
                    function() {
                        //var url = $(this).children(":first-child").attr ('src');
                        //mememaker.tools.addpic (url);
                    }
            )
        }
);

</script>
