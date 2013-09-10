
/**
 * Small cutomize tool jquery plugin library, based on jquery and fabric.js
 * Core functionality, all functionality doesn't concern with HTML
 * 
 * @author http://www.github.com/hellomaya
 * @date 2013.09.06
 * @description to extend functionality only, no HTML concerned
 */
(function($) {

    var canvas = null;

    var Mememaker = function() {

    }

    var Tools = function() {
        
    }

    var TextEditor = function() {

    }

    var ImageEditor = function() {

    }

    var DrawEditor = function() {

    }

    Mememaker.prototype = {
        container: '#box-canvas',
        canvasId: 'c1',
        canvas: null,
        backgroundColor: 'white',
        defaultText: null,
        canvasScale: 0,
        width: 780,
        height: 780,
        mousex: 0,
        mousey: 0,
        // methods
        init: null,
        // object member
        tools: null,
        texteditor: null,
        imageeditor: null,
        draweditor: null
    }

    Tools.prototype = {
        container: '.tools',
        owner: null,
        //
        init: null,
        new : null,
        remove: null,
        group: null,
        backward: null,
        forward: null,
        toBack: null,
        toFront: null,
        flip: null,
        addtext: null,
        addpic: null,
        backgroundcolor: null,
        newtemplate: null,
        // server API
        zoom: null,
        preview: null,
        preview_callback: null,
        save: null,
        save_callback: null,
        reload: null,
    }

    TextEditor.prototype = {
        container: ".text-editor",
        id: null,
        current: null,
        owner: null,
        //
        init: null,
        fill: null,
        changeFontFamily: null,
        changeText: null,
        changeFontProperty: null,
        textselected: null,
        textselected_callback: null,
    }

    ImageEditor.prototype = {
        container: ".image-editor",
        id: null,
        current: null,
        zoomValue: null,
        rotateValue: null,
        owner: null,
        //
        init: null,
        zoom: null,
        rotate: null,
        flipX: null,
        flipY: null,
        imageselected: null,
    }

    DrawEditor.prototype = {
        container: ".draw-editor",
        id: null,
        current: null,
        lineWidth: null,
        shadowWidth: null,
        owner: null,
        //
        init: null,
        fill: null,
        enable: null
    }

    Mememaker.prototype.tools = new Tools();
    Mememaker.prototype.texteditor = new TextEditor();
    Mememaker.prototype.imageeditor = new ImageEditor();
    Mememaker.prototype.draweditor = new DrawEditor();

    Mememaker.prototype.defaultText = {
        text: 'Your Text Is Here',
        property: {
            fontFamily: 'Impact',
            fontWeight: 'bold',
            fontSize: 40,
            fill: 'black',
            //stroke: 'white',
            //strokeWidth: 0,
//            originX: 'left',
//            originY: 'top',
//            left: this.lastTextX,
//            top: this.lastTextY
        }
    }

    Mememaker.prototype.init = function(id, backgroundcolor, scale) {
        this.canvasId = id;
        this.canvasScale = scale;
        
        this.canvas = canvas = new fabric.Canvas(this.canvasId);
        this.width = canvas.getWidth();
        this.height = canvas.getHeight();
        
        canvas.backgroundColor = this.backgroundColor = backgroundcolor;
        canvas.selection = true;
        canvas.controlsAboveOverlay = true;
        canvas.clear();

    }


//============================================
// tools
//============================================

    Tools.prototype.owner = $.mememaker;
    
    Tools.prototype.new = function(backgroundcolor) {
        canvas.backgroundColor = this.backgroundColor = backgroundcolor;
        canvas.clear();
    }

    Tools.prototype.remove = function() {
        var el = canvas.getActiveObject();

        if (el == null || el == undefined) {
            el = canvas.getActiveGroup();
            if (el == null || el == undefined) {
                return;
            }

            //alert (el);
            canvas.discardActiveGroup();
            for (i = 0; i < el.getObjects().length; ++i) {
                canvas.remove(el.item(i));
            }

            return;
        }

        canvas.remove(el);
    }

    Tools.prototype.group = function() {
        var el = canvas.getActiveGroup();
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

                canvas.discardActiveGroup();
                for (i = 0; i < items.length; ++i) {
                    canvas.remove(gr.item(i));
                }

                canvas.add(group);
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

    Tools.prototype.backward = function() {
        var el = canvas.getActiveObject();

        if (el == null || el == undefined) {
            el = canvas.getActiveGroup();
            if (el == null || el == undefined) {
                return;
            }

            //alert (el);
            el.sendBackwards();

            return;
        }

        el.sendBackwards();
    };

    Tools.prototype.forward = function() {
        var el = canvas.getActiveObject();

        if (el === null || el === undefined) {
            el = canvas.getActiveGroup();
            if (el === null || el === undefined) {
                return;
            }

            //alert (el);
            el.bringForward();

            return;
        }

        el.bringForward();
    };

    Tools.prototype.toBack = function() {
        var el = canvas.getActiveObject();

        if (el === null || el === undefined) {
            el = canvas.getActiveGroup();
            if (el === null || el === undefined) {
                return;
            }

            el.sendToBack();

            return;
        }

        console.log(el);
        el.sendToBack();
    };

    Tools.prototype.toFront = function() {
        var el = canvas.getActiveObject();

        if (el === null || el === undefined) {
            el = canvas.getActiveGroup();
            if (el === null || el === undefined) {
                return;
            }

            //alert (el);
            el.bringToFront();

            return;
        }

        el.bringToFront();
    };

    Tools.prototype.flip = function(x) {
        var el = canvas.getActiveObject();

        if (el === null || el === undefined) {
            el = canvas.getActiveGroup();
            if (el === null || el === undefined) {
                return;
            }

            if (x == 0) {
                el.flipX = el.flipX == true ? false : true;
            } else {
                el.flipY = el.flipY == true ? false : true;
            }

            canvas.renderAll();
            return;
        }

        if (x == 0) {
            el.flipX = el.flipX == true ? false : true;
        } else {
            el.flipY = el.flipY == true ? false : true;
        }

        canvas.renderAll();
    };

    Tools.prototype.addtext = function() {
        var text = new fabric.Text($.mememaker.defaultText.text, $.mememaker.defaultText.property);

        text.text = "CLICK TO EDIT\nHello world";
        canvas.add(text);
        text.center();
        text.scaleToWidth(300);

        canvas.renderAll();

        console.log(text);
        text.on(
                'selected',
                function(options) {
                    $.mememaker.texteditor.textselected();
                }
        )

        //$($.mememaker.imageeditor.container).hide(0);
        //$($.mememaker.draweditor.container).hide(0);
        //$(this.container).show(0);
    };

    Tools.prototype.addpic = function(url) {

        fabric.Image.fromURL(url, function(oImg) {

            canvas.add(oImg);
            oImg.center();
            oImg.scaleToWidth(400);
            canvas.renderAll();

            oImg.on(
                    'selected',
                    function(options) {
                        this.imageselected();
                    }
            );

            //hideAlert();

        });
    }

    Tools.prototype.resize = function(height, plus) {

        if (plus == false) {
            if (height == 0) {
                return;
            }
            if (canvas.getHeight() - height <= 0) {
                canvas.setDimensions({width: 460, height: 460});
            } else {
                canvas.setDimensions({width: 460, height: canvas.getHeight() - height});
            }
            return;
        }

        if (height == 0) {
            height = 460;
        }

        canvas.setDimensions({width: 460, height: canvas.getHeight() + height});
    }


    Tools.prototype.backgroundcolor = function(color) {
        //console.log (color);
        canvas.backgroundColor = color;
        canvas.renderAll();
    }

    Tools.prototype.backgroundimage = function(url) {
        canvas.setBackgroundImage(
                url,
                function() {
                    canvas.renderAll();
                }, {'originX': 'left', 'originY': 'top', 'left': 0, 'top': 0}
        )
    }

    Tools.prototype.newtemplate = function(url) {
        canvas.setOverlayImage(url, canvas.renderAll.bind(canvas));
    }

    Tools.prototype.zoom = function(scale) {

        //var scale = $.mememaker.canvasScale;

        canvas.setDimensions ({"width":canvas.getWidth() * scale, "height":canvas.getHeight() * scale});
        //canvas.setHeight(canvas.getHeight() * scale);
        //canvas.setWidth(canvas.getWidth() * scale);
        
        console.log (canvas.getWidth());
        console.log (canvas.getHeight());

        var objects = canvas.getObjects();
        for (var i in objects) {
            var scaleX = objects[i].scaleX;
            var scaleY = objects[i].scaleY;
            var left = objects[i].left;
            var top = objects[i].top;

            var tempScaleX = scaleX * scale;
            var tempScaleY = scaleY * scale;
            var tempLeft = left * scale;
            var tempTop = top * scale;

            objects[i].scaleX = tempScaleX;
            objects[i].scaleY = tempScaleY;
            objects[i].left = tempLeft;
            objects[i].top = tempTop;

            objects[i].setCoords();
        }

        canvas.renderAll();
    }

    // Server API
    Tools.prototype.preview = function() {
        // it will convert canvas to base64
        
        var scale = $.mememaker.canvasScale;
        this.zoom (scale);
        canvas.deactivateAll();

        var preview = canvas.toDataURL(
                {
                    format: 'jpeg',
                    quality: 1
                }
        );

        this.zoom (1 / scale);
        if (this.preview_callback == null) {
            return;
        }
        this.preview_callback(preview);
    }

    Tools.prototype.save = function()
    {
        var json = JSON.stringify(canvas.toJSON());
        this.save_callback(json);
    }

    Tools.prototype.reload = function(json)
    {
        canvas.loadFromJSON(json);
        canvas.renderAll();

        // optional
        //canvas.calculateOffset();
    }

    //===========================================
    // text editor
    //===========================================

/*
    TextEditor.prototype.textselected = function() {

        var el = canvas.getActiveObject();

        if (el == null || el == undefined) {
            return;
        }

        if (el.type != "text") {
            return;
        }

        this.textselected_callback(el);
    }*/ 

    TextEditor.prototype.fill = function(color) {
        var el = canvas.getActiveObject();

        if (el === undefined || el == null) {
            return;
        }

        if (el.type != "text") {
            return;
        }

        el.fill = color;
        canvas.renderAll();
    }

    TextEditor.prototype.changeFontFamily = function(fontFamily) {
        var el = canvas.getActiveObject();

        if (el == null || el == undefined) {
            return;
        }

        if (el.type != "text") {
            return;
        }

        el.fontFamily = fontFamily;
        canvas.renderAll();
    }

    TextEditor.prototype.changeText = function(value) {
        var el = canvas.getActiveObject();

        if (el == null || el == undefined) {
            return;
        }

        if (el.type != "text") {
            return;
        }

        el.text = value;
        if (el.text == "") {
            canvas.remove(el);
        }
        canvas.renderAll();
    }

    TextEditor.prototype.changeFontProperty = function(property) {

        var el = canvas.getActiveObject();

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
        canvas.renderAll();
    }


    //==================================================================
    // image editor 
    //==================================================================

    ImageEditor.prototype.imageselected = function() {
        var el = canvas.getActiveObject();

        if (el == null || el == undefined) {
            return;
        }

        if (el.type != "image") {
            return;
        }

        $($.mememaker.texteditor.container).hide(0);
        $($.mememaker.draweditor.container).hide(0);
        $(this.container).show(0);
    }

    ImageEditor.prototype.zoom = function(value) {
        var el = canvas.getActiveObject();

        if (el == null || el == undefined) {
            return;
        }

        if (el.type != "image") {
            return;
        }

        var scale = value / 100;
        el.scale(scale);
        canvas.renderAll();

        //$(".text-editor").hide(10);  
        //$(".image-editor").show(10);    
    }

    ImageEditor.prototype.rotate = function(value) {
        var el = canvas.getActiveObject();

        if (el == null || el == undefined) {
            return;
        }

        if (el.type != "image") {
            return;
        }

        el.originX = "center";
        el.originY = "center";
        el.angle = value;
        canvas.renderAll();
    }

    //==================================================================
    // image editor 
    //==================================================================
    DrawEditor.prototype.changeBrushProperty = function(name, value) {
        switch (name) {
            case "linewidth" :
                canvas.freeDrawingBrush.width = value;
                break;
            case "shadowwidth" :
                canvas.freeDrawingBrush.shadowBlur = value;
                break;
            case "color" :
                canvas.freeDrawingBrush.color = value;
                break;
        }
    }

    DrawEditor.prototype.changeBrushType = function(name) {

        if (name == "vline") {
            if (fabric.PatternBrush) {
                var vLinePatternBrush = new fabric.PatternBrush(canvas);
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
            console.log(vLinePatternBrush);
            canvas.freeDrawingBrush = vLinePatternBrush;
        }

        if (name == "hline") {
            if (fabric.PatternBrush) {

                var hLinePatternBrush = new fabric.PatternBrush(canvas);
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
            canvas.freeDrawingBrush = hLinePatternBrush;
        }

        if (name == "square") {
            if (fabric.PatternBrush) {

                var squarePatternBrush = new fabric.PatternBrush(canvas);
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
            canvas.freeDrawingBrush = squarePatternBrush;
        }

        if (name == "diamond") {
            if (fabric.PatternBrush) {

                var diamondPatternBrush = new fabric.PatternBrush(canvas);
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
                    rect.set({left: canvasWidth / 2, top: canvasWidth / 2});

                    var ctx = patternCanvas.getContext('2d');
                    rect.render(ctx);

                    return patternCanvas;
                }
            }
            canvas.freeDrawingBrush = diamondPatternBrush;
        }

        if (name == "texture") {
            if (fabric.PatternBrush) {
                var img = new Image();
                img.src = 'img/texture/texture_honey.png';

                var texturePatternBrush = new fabric.PatternBrush(canvas);
                texturePatternBrush.source = img;
            }
            canvas.freeDrawingBrush = texturePatternBrush;
        } else {
            canvas.freeDrawingBrush = new fabric[name + 'Brush'](canvas);
        }


        if (canvas.freeDrawingBrush) {
            //canvas.freeDrawingBrush.color = $("#draw-fill").val();
            canvas.freeDrawingBrush.width = this.lineWidth.getValue();
            canvas.freeDrawingBrush.shadowBlur = this.shadowWidth.getValue();
        }

    }

    DrawEditor.prototype.enable = function() {
        enable = canvas.isDrawingMode == true ? false : true;
        if (enable) {
            canvas.discardActiveObject();
            canvas.discardActiveGroup();

            //canvas.freeDrawingLineWidth = width;
            //canvas.freeDrawingColor = $("#draw-fill").val();
            canvas.isDrawingMode = true;
            canvas.freeDrawingBrush.width = 1;
            canvas.freeDrawingBrush.color = "#eb34dc";

            //canvas.renderAll();

            $($.mememaker.texteditor.container).hide(0);
            $($.mememaker.imageeditor.container).hide(0);
            $(this.container).show(0);
        } else {
            canvas.discardActiveObject();
            canvas.discardActiveGroup();
            canvas.isDrawingMode = false;
            $(this.container).hide(0);
        }

        return enable;
    }

    $.mememaker = new Mememaker();
}(window.jQuery));
