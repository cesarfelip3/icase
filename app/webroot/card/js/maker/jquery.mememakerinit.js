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
        selected: false,
        toolsinit: null,
        texteditorinit: null,
        imageeditorinit: null,
        draweditorinit: null
    };

    Init.prototype.init = function(id, backgroundcolor) {
        $(document).mousemove(function(event) {
            $.mememaker.mousex = event.pageX;
            $.mememaker.mousey = event.pageY;
            
        });
        
        $(document).mousedown (function (event) {
           
            
        });

        $(document).mouseup(function(event) {
            
            var el = $.mememaker.canvas.getActiveObject();
            //console.log (el);

            if (el === undefined || el === null) {
                return;
            }

            if (!$.mememaker.in (el)) {
                return;
            }
            
            if ($.mememaker.grid != null) {

                var left = Math.ceil(el.left);
                var top = Math.ceil(el.top);

                console.log("1. " + (left % 20) + ":" + top);

                if ((left % 20) / 20 > 0.5) {
                    left += 20 - (left % 20);
                } else {
                    left -= (left % 20);
                }

                if ((top % 20) / 20 > 0.5) {
                    top += 20 - (top % 20);
                } else {
                    top -= (top % 20);
                }

                el.left = left;
                el.top = top;

                console.log("2. " + el.left + ":" + el.top);

                $.mememaker.canvas.renderAll();
            }

            if (el.type == 'text') {
                if ($.mememaker.activex != el.left || $.mememaker.activey != el.top) {
                    $.mememaker.texteditor.textselected();
                    //$.mememaker.selected = false;
                    $.mememaker.activex = el.left;
                    $.mememaker.activey = el.top;
                }
            }

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
            var height = el.getBoundingRectHeight();
            var width = el.getBoundingRectWidth();

            top = top + height / 2;
            left = Math.abs(left - (600 - width) / 2);
            
            top = el.top + height + 10 + $.mememaker.top;
            left = el.left + $.mememaker.left - Math.abs((500 - width) / 2);
            
            top = Math.floor (top);
            left = Math.floor (left);
            
            $(".text-editor").show();
            $(".text-editor").css('top', top + "px");
            $(".text-editor").css('left', left + "px");

            $("#text-content").val(el.text);
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
                            var r = confirm("You will remove this element, are u sure?")
                            if (r == true)
                            {

                            }
                            else
                            {
                                return;
                            }
                            var type = $.mememaker.tools.remove();
                            if (type == 'text') {
                                $(".text-editor").hide();
                            }
                            break;
                        case 'group':
                            $.mememaker.tools.group();
                            break;
                        case 'moveleft':
                        case 'moveright':
                        case 'moveup':
                        case 'movedown':
                            $.mememaker.sender = 'move';
                            $.mememaker.tools.move (action);
                            //$.mememaker.sender = null;
                            break;
                        case 'lock':
                            var type = $.mememaker.tools.lock ();
                            if (type) {
                                $(".text-editor").hide();
                            }
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
                        case 'addgrid':
                            //$.mememaker.canvas.setDimensions ({width:1000, height:1000});
                            $.mememaker.tools.addgrid();
                            break;
                        case 'save':
                            $.mememaker.save();
                            break;
                        case 'reload':
                            break;
                        case 'zoomin':
                            var grid = false;
                            if ($.mememaker.grid != null) {
                                $.mememaker.tools.addgrid();
                                grid = true;
                            }
                            var width = $("#box-canvas-container").width();
                            width *= 1.2;
                            $("#box-canvas-container").css("width", width + "px");
                            $.mememaker.tools.zoom(1.2);

                            if (grid) {
                                $.mememaker.tools.addgrid();
                            }
                            break;
                        case 'zoomout':
                            var grid = false;
                            if ($.mememaker.grid != null) {
                                $.mememaker.tools.addgrid();
                                grid = true;
                            }
                            var width = $("#box-canvas-container").width();
                            width *= 1 / 1.2;
                            $("#box-canvas-container").css("width", width + "px");
                            $.mememaker.tools.zoom(1 / 1.2);
                            if (grid) {
                                $.mememaker.tools.addgrid();
                            }
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
