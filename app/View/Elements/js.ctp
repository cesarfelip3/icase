<!--[if !lte IE 6]><!-->
<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
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
    $( "#slider" ).slider();
});
</script>   

<!-- DO NOT REMOVE: Contains major plugin initiations and functions -->
<!--<![endif]-->

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
        init: null,
        fill: null,
        textselected: null,
    },
    imageeditor: {

    },
    groupeditor: {

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

    /*
     $("#resize-color").colorpicker().on('changeColor', function(ev){
     mememaker.tools.backgroundcolor (ev.color.toHex());
     });*/
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

mememaker.tools.info = function(type) {

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

mememaker.tools.newtext = function() {
    var text = new fabric.Text(mememaker.defaultText.text, mememaker.defaultText.property);

    var content = $("#text-content").val();
    if ($.trim(content) == "") {
        return;
    }

    text.text = content;
    text.fontFamily = $("#text-font-family").val();
    text.originX = "left";
    text.originY = "top";
    text.left = mememaker.lastTextX;
    text.top = mememaker.lastTextY;

    mememaker.canvas.add(text);
    //mememaker.lastTextX += 10;
    mememaker.lastTextY += 10;

    if (mememaker.lastTextX >= 400) {
        mememaker.textTotal += 1;
        mememaker.lastTextX = mememaker.textTotal * 10;
        mememaker.lastTextY = mememaker.textTotal * 10;
    }

    mememaker.canvas.renderAll();
    /*
    text.on(
            'selected',
            function(options) {
                //mememaker.texteditor.textselected (options);
            }
    )*/
}

mememaker.tools.addpic = function(url) {
   
    fabric.Image.fromURL(url, function(oImg) {
        // scale image down, and flip it, before adding it onto canvas
        oImg.set('originX', 'left');
        oImg.set('originY', 'top');
        oImg.left = mememaker.lastImageX;
        oImg.top = mememaker.lastImageY;

        mememaker.canvas.add(oImg);
        mememaker.lastImageX += 10;
        mememaker.lastImageY += 10;

        if (mememaker.lastImageX >= 400) {
            mememaker.imageTotal += 1;
            mememaker.lastImageX = mememaker.textTotal * 10;
            mememaker.lastImageY = mememaker.textTotal * 10;
        }
        
    });
}

mememaker.tools.newtemplate = function (url) {
    
    mememaker.canvas.setOverlayImage(url, mememaker.canvas.renderAll.bind(mememaker.canvas));

}

mememaker.tools.resize = function(plus, evt) {

    var height = $('#' + $(evt).data('prefix') + '-height').val();

    console.log(height);
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
    var c = "box-" + mememaker.canvasId;

    $("#" + c).toggle();
    $("#" + c + "-preview").toggle();

    var preview = mememaker.canvas.toDataURL(
            {
                format: 'jpeg',
                quality: 1
            }
    );

    //mememaker.canvas.deactivateAll();
    $("#" + mememaker.canvasId + "-preview").attr('src', preview);
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
                console.log(url);
                mememaker.canvas.renderAll();
            }, {'originX': 'left', 'originY': 'top', 'left': 0, 'top': 0}
    )
}

// text editor
mememaker.texteditor.textselected = function(options) {
    console.log(options);
}

$(document).ready(
        function() {
            //alert ("hello");
            mememaker.init('c1');
            mememaker.tools.init(".tools");
            mememaker.tools.newtemplate("<?php echo $this->webroot . "img/template/iphone.png"; ?>");

            $(".thumbnail-list a").click(
                    function() {
                        //var url = $(this).children(":first-child").attr ('src');
                        //mememaker.tools.addpic (url);
                    }
            )
        }
);

</script>
