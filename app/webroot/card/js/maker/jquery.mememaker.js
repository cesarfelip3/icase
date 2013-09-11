
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
    };
    var Tools = function() {
    };
    var TextEditor = function() {
    };
    var ImageEditor = function() {
    };
    var DrawEditor = function() {
    };

    Mememaker.prototype = {
        containerId: '#box-canvas',
        wrapperId: 'box-canvas-wrapper',
        canvasId: 'c1',
        canvas: null,
        canvasScale: 0,
        width: 780,
        height: 780,
        left: 0,
        top: 0,
        grid: null,
        gridsize: 20,
        backgroundColor: 'white',
        defaultText: null,
        mousex: 0,
        mousey: 0,
        selected: false,
        activex: 0,
        activey: 0,
        sender: null,
        // methods
        init: null,
        position: null,
        in: null,
        // object member
        tools: null,
        texteditor: null,
        imageeditor: null,
        draweditor: null
    }

    Tools.prototype = {
        containerId: '.tools',
        container: null,
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
        addgrid: null,
        backgroundcolor: null,
        overlayimage: null,
        // server API
        zoom: null,
        preview: null,
        preview_callback: null,
        save: null,
        save_callback: null,
        reload: null,
    }

    TextEditor.prototype = {
        containerId: ".text-editor",
        id: null,
        current: null,
        container: null,
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
        containerId: ".image-editor",
        id: null,
        current: null,
        zoomValue: null,
        rotateValue: null,
        container: null,
        //
        init: null,
        zoom: null,
        rotate: null,
        flipX: null,
        flipY: null,
        imageselected: null,
    }

    DrawEditor.prototype = {
        containerId: ".draw-editor",
        id: null,
        current: null,
        lineWidth: null,
        shadowWidth: null,
        container: null,
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
            //originX: 'left',
            //originY: 'top',
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

        this.update();
    }

    Mememaker.prototype.position = function(el) {
        var pos = null;
        pos = [0, 0];

        var r = el.getBoundingClientRect();
        pos[0] = r.left;
        pos[1] = r.top;
        return pos;
    }

    Mememaker.prototype.update = function() {
        var pos = this.position(document.getElementById(this.wrapperId));
        this.left = pos[0];
        this.top = pos[1];
        console.log('canvas postion : ' + this.left + ":" + this.top);
    }

    Mememaker.prototype.in = function(el) {
        if (el === undefined || el === null) {
            return;
        }

        var left = el.left + this.left;
        var top = el.top + this.top;

        var right = left + el.getBoundingRectWidth();
        var bottom = top + el.getBoundingRectHeight();

        if (this.mousex > left && this.mousex < right) {
            if (this.mousey > top && this.mousey < bottom) {
                return true;
            }
        }

        return false;
    }


//============================================
// tools
//============================================

    //Tools.prototype.container = $.mememaker;

    Tools.prototype.init = function() {
        this.selected();
        this.container = $.mememaker;
    }

    Tools.prototype.new = function(color) {
        canvas.backgroundColor = this.backgroundColor = color;
        canvas.clear();
    }

    Tools.prototype.remove = function() {
        var el = canvas.getActiveObject();

        if (el === undefined || el === null) {
            el = canvas.getActiveGroup();
            if (el === undefined || el === null) {
                return false;
            }

            canvas.discardActiveGroup();
            for (i = 0; i < el.getObjects().length; ++i) {
                canvas.remove(el.item(i));
            }

            return el.type;
        }

        canvas.remove(el);
        return el.type;
    }

    Tools.prototype.group = function() {
        var el = canvas.getActiveGroup();
        if (el === undefined || el === null) {
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

    Tools.prototype.move = function(direct) {
        if (direct === undefined || direct == null) {
            return;
        }

        var el = canvas.getActiveObject();

        if (el === undefined || el === null) {
            el = canvas.getActiveGroup();
            if (el === undefined || el === null) {
                return;
            }
        }

        if (direct == 'moveleft') {
            el.left--;
        }

        if (direct == 'moveright') {
            el.left++;
        }

        if (direct == 'moveup') {
            el.top--;
        }

        if (direct == 'movedown') {
            el.top++;
        }

        canvas.renderAll();
    }

    Tools.prototype.lock = function() {
        var el = canvas.getActiveObject();

        if (el === undefined || el === null) {
            el = canvas.getActiveGroup();
            if (el === undefined || el === null) {
                return false;
            }
        }

        el.lockMovementX = el.lockMovementX == false ? true : false;
        el.lockMovementY = el.lockMovementY == false ? true : false;
        canvas.renderAll();
        return el.lockMovementX;
    }

    Tools.prototype.backward = function() {
        var el = canvas.getActiveObject();

        if (el === undefined || el === null) {
            el = canvas.getActiveGroup();
            if (el === undefined || el === null) {
                return;
            }
        }

        el.sendBackwards();
        canvas.renderAll();
    };

    Tools.prototype.forward = function() {
        var el = canvas.getActiveObject();

        if (el === undefined || el === null) {
            el = canvas.getActiveGroup();
            if (el === undefined || el === null) {
                return;
            }
        }

        el.bringForward();
    };

    Tools.prototype.toBack = function() {
        var el = canvas.getActiveObject();

        if (el === undefined || el === null) {
            el = canvas.getActiveGroup();
            if (el === undefined || el === null) {
                return;
            }
        }

        el.sendToBack();
    };

    Tools.prototype.toFront = function() {
        var el = canvas.getActiveObject();

        if (el === undefined || el === null) {
            el = canvas.getActiveGroup();
            if (el === undefined || el === null) {
                return;
            }
        }

        el.bringToFront();
    };

    Tools.prototype.flip = function(x) {
        var el = canvas.getActiveObject();

        if (el === undefined || el === null) {
            el = canvas.getActiveGroup();
            if (el === undefined || el === null) {
                return;
            }
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

        text.text = "CLICK TO EDIT";
        text.originX = 'left';
        text.originY = 'top'; // default rotation will never work as it's left/top
        canvas.add(text);

        text.left = canvas.width / 2 - text.getBoundingRectWidth() / 2;
        text.top = canvas.height / 2 - text.getBoundingRectHeight() / 2;
        text.hasRotatingPoint = false; // so disable default rotation control

        //text.center();
        //text.scaleToWidth(300);

        canvas.renderAll();

    };

    Tools.prototype.addpic = function(url) {

        fabric.Image.fromURL(url, function(oImg) {
            canvas.add(oImg);
            oImg.center();
            oImg.scaleToWidth(Math.ceil(canvas.getWidth() * 2 / 3));
            canvas.renderAll();
        });
    }

    Tools.prototype.selected = function() {
        canvas.on('object:selected', function(e) {
            var el = e.target;

            if (el.type == 'text') {
                console.log(el.type);
                $.mememaker.selected = true;
                $.mememaker.activex = el.left;
                $.mememaker.activey = el.top;
                $.mememaker.texteditor.textselected();
            }

            if (el.type == 'image') {

            }
        });
    }

    Tools.prototype.addshape = function(type) {

        if (type === undefined || type === null) {
            return;
        }

        if (type == 'circle') {

        }

        if (type == 'rect') {

        }

        if (type == 'ellipse') {

        }
    }

    Tools.prototype.addgrid = function() {

        var width = canvas.width;
        var height = canvas.height;

        if (this.removegrid()) {
            return;
        }

        var lines = [];
        var j = 0;
        var line = null;
        var rect = [];
        var size = $.mememaker.gridsize;
        
        for (j = 0; j < 5; ++j) {
            width *= 1.2;
            height *= 1.2;
        }
        
        j = 0;

        for (var i = 0; i < Math.ceil(width / 20); ++i) {
            rect[0] = i * size;
            rect[1] = 0;

            rect[2] = i * size;
            rect[3] = height;

            line = null;
            line = new fabric.Line(rect, {
                stroke: '#999',
                opacity: 0.5,
            });

            line.selectable = false;
            canvas.add(line);
            line.sendToBack();

            lines[j++] = line;
        }

        for (i = 0; i < Math.ceil(height / 20); ++i) {
            rect[0] = 0;
            rect[1] = i * size;

            rect[2] = width;
            rect[3] = i * size;

            line = null;
            line = new fabric.Line(rect, {
                stroke: '#999',
                opacity: 0.5,
            });
            line.selectable = false;
            canvas.add(line);
            line.sendToBack();

            lines[j++] = line;
        }

        this.container.grid = lines;
        canvas.renderAll();
    }

    Tools.prototype.removegrid = function() {
        if (this.container.grid == null) {
            return false;
        }

        for (var i = 0; i < this.container.grid.length; ++i) {
            this.container.grid[i].remove();
        }

        this.container.grid = null;
        return true;
    }

    Tools.prototype.backgroundcolor = function(color) {
        this.container.backgroundColor = color;
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

    Tools.prototype.overlayimage = function(url) {
        canvas.setOverlayImage(url, canvas.renderAll.bind(canvas));
    }

    Tools.prototype.zoom = function(width) {

        var scale = width / canvas.getWidth();
        height = scale * canvas.getHeight();
        
        canvas.setDimensions({
            "width": width,
            "height": height}
        );

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
            
            if (objects[i].type == 'line' && objects[i].selectable === false 
            && objects[i].get('opacity') == 0.5) {
                continue;
            }

            objects[i].scaleX = tempScaleX;
            objects[i].scaleY = tempScaleY;
            objects[i].left = tempLeft;
            objects[i].top = tempTop;

            objects[i].setCoords();
        }

        canvas.renderAll();

        this.container.update ();
    }

    Tools.prototype.zoomreset = function() {

        //var scale = $.mememaker.canvasScale;

        var scale = this.container.width / canvas.getWidth();
        canvas.setDimensions({
            "width": $.mememaker.width, 
            "height": $.mememaker.height});
        

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
            
            if (objects[i].type == 'line' && objects[i].selectable === false
            && objects[i].get('opacity') == 0.5) {
                continue;
            }

            objects[i].scaleX = tempScaleX;
            objects[i].scaleY = tempScaleY;
            objects[i].left = tempLeft;
            objects[i].top = tempTop;

            objects[i].setCoords();
        }

        canvas.renderAll();

        this.container.update ();
    }

    // Server API
    Tools.prototype.preview = function() {
        // it will convert canvas to base64

        var scale = $.mememaker.canvasScale;
        this.zoom(scale);
        canvas.deactivateAll();

        var preview = canvas.toDataURL(
                {
                    format: 'jpeg',
                    quality: 1
                }
        );

        this.zoom(1 / scale);
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
     
     if (el === undefined || el === null) {
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

        if (el === undefined || el === null) {
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

        if (el === undefined || el === null) {
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

        if (el === undefined || el === null) {
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

        if (el === undefined || el === null) {
            return;
        }

        if (el.type != "image") {
            return;
        }

        $($.mememaker.texteditor.containerId).hide(0);
        $($.mememaker.draweditor.containerId).hide(0);
        $(this.containerId).show(0);
    }

    ImageEditor.prototype.zoom = function(value) {
        var el = canvas.getActiveObject();

        if (el === undefined || el === null) {
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

        if (el === undefined || el === null) {
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

            $($.mememaker.texteditor.containerId).hide(0);
            $($.mememaker.imageeditor.containerId).hide(0);
            $(this.containerId).show(0);
        } else {
            canvas.discardActiveObject();
            canvas.discardActiveGroup();
            canvas.isDrawingMode = false;
            $(this.containerId).hide(0);
        }

        return enable;
    }

    $.mememaker = new Mememaker();
}(window.jQuery));
