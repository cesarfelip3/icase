/**
 * Small cutomize tool jquery plugin library, based on jquery and fabric.js
 * API, between HTML and Core functionality
 * 
 * @author http://www.github.com/hellomaya
 * @date 2013.09.06
 * @description you only need to rewrite these parts, if you changed HTML
 * 
 */
(function($) {
    var Init = function() {
    };

    Init.prototype = {
        init: null,
        toolsinit: null,
        texteditorinit: null,
        imageeditorinit: null,
        draweditorinit: null
    };

    Init.prototype.init = function(id, backgroundcolor) {
        $(document).mousemove(function(event) {
            $.mememaker.mousex = event.pageX;
            $.mememaker.mousey = event.pageY;

            //console.log ($.mememaker.mousex);
            //console.log ($.mememaker.mousey);
        });
        $.mememaker.init(id, backgroundcolor, 1850 / 780);
    }

    Init.prototype.toolsinit = function(id) {

        /*
         $("#canvas-background-color").colorpicker().on('changeColor', function(ev) {
         $.mememaker.tools.backgroundcolor(ev.color.toHex());
         $(this).css("background-color", ev.color.toHex());
         });*/

        $.mememaker.texteditor.textselected = function() {

            var el = $.mememaker.canvas.getActiveObject();

            if (el == null || el == undefined) {
                return;
            }

            if (el.type != "text") {
                return;
            }
            
            var top = $.mememaker.mousey;
            var left = $.mememaker.mousex;
            var height = el.height;
            var width = el.width;
            
            top = top + height;
            left = Math.abs(left - (600 - width) / 2); 
            $(".text-editor").show ();
            $(".text-editor").css ('top', top + "px");
            $(".text-editor").css ('left', left + "px");
            
            $("#text-content").val (el.text);
            console.log('selected');
            console.log(el);
        }

        $(id + " a").click(
                function(evt) {
                    var action = $(this).data('action');
                    if (action == undefined || action == null) {
                        return;
                    }

                    console.log(action);
                    switch (action) {
                        case 'new':
                            $.mememaker.tools.new ("#eb3d2d");
                            break;
                        case 'remove':
                            $.mememaker.tools.remove();
                            break;
                        case 'group':
                            $.mememaker.tools.group();
                            break;
                        case 'backward':
                            $.mememaker.tools.backward();
                            break;
                        case 'forward':
                            $.mememaker.tools.forward();
                            break;
                        case 'back':
                            $.mememaker.tools.toBack();
                            break;
                        case 'front':
                            $.mememaker.tools.toFront();
                            break;
                        case 'flipx':
                            $.mememaker.tools.flip(0);
                            break;
                        case 'flipy':
                            $.mememaker.tools.flip(1);
                            break;
                        case 'addtext':
                            $.mememaker.tools.addtext();
                            break;
                        case 'preview':
                            $.mememaker.tools.preview();
                            break;
                        case 'background':
                            $("#box-toolbar-bg").show();
                            break;
                        case 'backgroundimage':
                            //this.backgroundimage("img/muffin.png");
                            break;
                        case 'draw':
                            if ($.mememaker.draweditor.enable()) {
                                $(this).data('color', $(this).css('color'));
                                $(this).css('color', 'green');
                            } else {
                                $(this).css('color', $(this).data('color'));
                            }
                            break;
                        case 'save':
                            $.mememaker.save();
                            break;
                        case 'reload':
                            break;
                        case 'zoomin':
                            var width = $("#box-canvas-container").width();
                            width *= 1.2;
                            $("#box-canvas-container").css("width", width + "px");
                            console.log(width);
                            $.mememaker.tools.zoom(1.2);
                            break;
                        case 'zoomout':
                            var width = $("#box-canvas-container").width();
                            width *= 1 / 1.2;
                            $("#box-canvas-container").css("width", width + "px");
                            $.mememaker.tools.zoom(1 / 1.2);
                            break;
                        case 'zoomfit':
                            $.mememaker.tools.zoomreset();
                        default:
                            break;
                    }
                }
        );
    }


    Init.prototype.texteditorinit = function(id) {

        $("#text-font-family").change(
                function() {
                    $.mememaker.texteditor.changeFontFamily($(this).val());
                }
        )
        /*
         $("#text-fill").colorpicker().on('changeColor', function(ev) {
         $.mememaker.texteditor.fill(ev.color.toHex());
         });*/

        $("#text-text").keyup(
                function(evt) {
                    if (evt.which == 13) {
                        evt.preventDefault();
                        $.mememaker.texteditor.changeText($("#text-text").val());
                        return;
                    }

                    $.mememaker.texteditor.changeText($("#text-text").val());
                }
        )

        $(id + " a").click(
                function() {
                    switch ($(this).data('action')) {
                        case "bold":
                            $.mememaker.texteditor.changeFontProperty("weight");
                            break;
                        case "italic":
                            $.mememaker.texteditor.changeFontProperty("italic");
                            break;
                    }
                }
        )

        $.mememaker.texteditor.textselected_callback = function(el) {

            $("#text-text").val(el.text);
            $("#text-font-family").val(el.fontFamily);
            $("#text-fill").val(el.fill);
            $(".editor").hide(0);
            $(".text-editor").show(0);
        }
    }


    Init.prototype.imageeditorinit = function(id) {

        //http://www.eyecon.ro/bootstrap-slider/
        this.zoomValue = $("#image-zoom").slider(
                {
                    formater: function(value) {
                        return '' + value / 100;
                    }
                }
        ).on(
                "slide",
                function() {
                    this.zoom(this.zoomValue.getValue());
                }
        ).data('slider');

        this.rotateValue = $("#image-rotation").slider(
                {
                    formater: function(value) {
                        return '' + value;
                    }
                }
        ).on(
                "slide",
                function() {
                    this.rotate(this.rotateValue.getValue());
                }
        ).data('slider');
    }


    Init.prototype.draweditorinit = function(id) {

        $.mememaker.draweditor.changeBrushProperty('color', '#333');
        //$.mememaker.draweditor.changeBrushType("");

        $.mememaker.draweditor.lineWidth = $("#draw-width").slider(
                {
                    formater: function(value) {
                        return '' + value;
                    }
                }
        ).on(
                "slide",
                function() {
                    $.mememaker.draweditor.changeBrushProperty("linewidth", $.mememaker.draweditor.lineWidth.getValue());
                }
        ).data('slider');

        $.mememaker.draweditor.shadowWidth = $("#draw-shadow-width").slider(
                {
                    formater: function(value) {
                        return '' + value;
                    }
                }
        ).on(
                "slide",
                function() {
                    $.mememaker.draweditor.changeBrushProperty("shadowwidth", $.mememaker.draweditor.shadowWidth.getValue());
                }
        ).data('slider');

        /*
         $("#draw-fill").colorpicker().on('changeColor', function(ev) {
         $.mememaker.draweditor.changeBrushProperty("color", ev.color.toHex());
         ;
         });*/

        $('#draw-mode-selector').on('change', function() {
            $.mememaker.draweditor.changeBrushType(this.value);
        });
    }

    $.mememakerinit = new Init();

}(window.jQuery));
