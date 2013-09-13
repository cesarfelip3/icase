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
        zoomcount: 0,
        init: null,
        selected: false,
        toolsinit: null,
        texteditorinit: null,
        imageeditorinit: null,
        draweditorinit: null
    };

    Init.prototype.init = function(id, backgroundcolor) {

        function doSomething() {
            $.mememaker.update();
        }

        var resizeTimer;
        $(window).resize(function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(doSomething, 100);
        });

        $(document).mousemove(function(event) {
            $.mememaker.mousex = event.pageX;
            $.mememaker.mousey = event.pageY;

        });

        $(document).mousedown(function(event) {
            $.mememaker.mousex = event.pageX;
            $.mememaker.mousey = event.pageY;
            $.mememaker.update ();
            
            var el = $.mememaker.canvas.getActiveObject();
            ////console.log (el);

            if (el === undefined || el === null) {
                return;
            }

            if (!$.mememaker.in(el)) {
                return;
            }

            if (el.type == 'image') {
                //el.clipTo = function(ctx) {
                //ctx.arc(0, 0, 60, 0, Math.PI * 2, true);
                //ctx.rect(0,0,150,100);
                //};
            }
        })

        $(document).mouseup(function(event) {
            $.mememaker.mousex = event.pageX;
            $.mememaker.mousey = event.pageY;
            $.mememaker.update ();

            var el = $.mememaker.canvas.getActiveObject();
            ////console.log (el);

            if (el === undefined || el === null) {
                return;
            }

            if (!$.mememaker.in(el)) {
                return;
            }

            if (el.lockMovementX == true) {
                return;
            }

            if ($.mememaker.grid != null) {

                var left = Math.ceil(el.left - el.getBoundingRectWidth() / 2);
                var top = Math.ceil(el.top - el.getBoundingRectHeight() / 2);

                //console.log("1. " + (left % 20) + ":" + top);

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

                el.left = left + el.getBoundingRectWidth() / 2;
                el.top = top + el.getBoundingRectHeight() / 2;

                //console.log("2. " + el.left + ":" + el.top);

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

        console.log ("toolsinit");
        $.mememaker.tools.init();
        $.mememaker.texteditor.textselected = function() {

            var el = $.mememaker.canvas.getActiveObject();

            if (el === undefined || el === null) {
                return;
            }

            if (el.type != "text") {
                return;
            }


            var height = el.getBoundingRectHeight();
            var top = el.top + height / 2 + 10 + $.mememaker.top;
            var left = el.left - el.getBoundingRectWidth() / 2 + $.mememaker.left;

            top = Math.floor(top);
            left = Math.ceil(left - (500 - el.getBoundingRectWidth()) / 2);

            $(".text-editor").show();
            $(".text-editor").css('top', top + "px");
            $(".text-editor").css('left', left + "px");

            $("#text-content").val(el.text);

        }

        $("#bg-color-picker").spectrum({
            color: "yellow",
            show: function() {
                $(this).parent().parent().css('display', 'block');
            },
            change: function(color) {
                var color = color.toHexString();
                $.mememaker.tools.backgroundcolor(color);
                $(this).parent().parent().attr('style', '');
            }
        })

        $.mememaker.tools.addpic_callback = function() {
            hideAlert();
        }

        $("#box-editing .span12").scroll(function() {
            console.log ('scroll');
            $.mememaker.canvas.calcOffset();
            $.mememaker.update ();
        });

        $(id + " a").click(
                function(evt) {
                    var action = $(this).data('action');
                    if (action === undefined || action === null) {
                        return;
                    }

                    console.log(action);

                    switch (action) {
                        case 'new':
                            $.mememaker.tools.new ("#eb3d2d");
                            break;
                        case 'remove':
                            if ($.mememaker.tools.exist() == false) {
                                //alert ("Select an object and try");
                                return;
                            }

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
                            $.mememaker.tools.move(action);
                            //$.mememaker.sender = null;
                            break;
                        case 'lock':
                            var type = $.mememaker.tools.lock();
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
                        case 'addshape':
                            $("#box-toolbar-shape").show();
                            break;
                        case 'shape-rect':
                        case 'shape-circle':
                        case 'shape-tri':
                            $.mememaker.tools.addshape($(this).data('data'));
                            break;
                        case 'backgroundcolor':
                            var color = $(this).data('data');
                            $.mememaker.tools.backgroundcolor(color);
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
                            $.mememaker.tools.showgrid();
                            break;
                        case 'save':
                            $.mememaker.save();
                            break;
                        case 'reload':
                            break;
                        case 'zoomin':
                            if ($.mememakerinit.zoomcount >= 4) {
                                alert("You reach the maxium zoom level");
                                return;
                            }

                            var width = $("#box-canvas-wrapper").width();
                            width *= 1.2;
                            width = Math.ceil(width);
                            $.mememakerinit.zoomcount++;

                            $("#box-canvas-wrapper").css("width", width + "px");
                            $.mememaker.tools.zoom(width);

                            $(this).parent().next().removeClass('disabled');
                            $(this).parent().next().next().removeClass('disabled');
                            break;
                        case 'zoomout':
                            if ($(this).parent().hasClass('disabled')) {
                                return;
                            }

                            if ($.mememakerinit.zoomcount < 0) {
                                return;
                            }

                            var width = $("#box-canvas-wrapper").width();
                            width *= 1 / 1.2;
                            width = Math.ceil(width);

                            if (width <= $.mememaker.width) {
                                $("#box-canvas-wrapper").css("width", $.mememaker.width + "px");
                                $.mememaker.tools.zoomreset();
                                $.mememakerinit.zoomcount = 0;
                                $(this).parent().addClass('disabled');
                                $(this).parent().next().addClass('disabled');
                                return;
                            }

                            $.mememakerinit.zoomcount--;
                            $("#box-canvas-wrapper").css("width", width + "px");
                            $.mememaker.tools.zoom(width);
                            break;
                        case 'zoomfit':
                            if ($(this).parent().hasClass('disabled')) {
                                return;
                            }

                            $.mememakerinit.zoomcount = 0;

                            $("#box-canvas-wrapper").css("width", $.mememaker.width + "px");
                            $.mememaker.tools.zoomreset();

                            $(this).parent().addClass('disabled');
                            $(this).parent().prev().addClass('disabled');
                            break;
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


        $("#font-color-picker").spectrum({
            color: "yellow",
            show: function() {
                $(this).parent().parent().css('display', 'block');
            },
            change: function(color) {
                var color = color.toHexString();
                $.mememaker.texteditor.changeFontColor(color);
                $(this).parent().parent().attr('style', '');
            }
        })
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
                    var action = $(this).data('action');
                    console.log(action);
                    switch (action) {
                        case "weight":
                        case "italic":
                        case "underline":
                            $.mememaker.texteditor.changeFontProperty(action);
                            break;
                        case "size":
                            var size = $(this).data('data');
                            size = parseInt(size);
                            $.mememaker.texteditor.changeFontSize(size);
                            break;
                        case "color":
                            var color = $(this).data('data');
                            $.mememaker.texteditor.changeFontColor(color);
                            break;
                        case "align":
                            var align = $(this).data('data');
                            $.mememaker.texteditor.changeFontAlign(align);
                            break;
                        case "confirm":
                            var text = $("#text-content").val();
                            if ($.trim(text) == "") {
                                alert("Empty typo, if you insist, remove element instead");
                                return;
                            }
                            $.mememaker.texteditor.changeText(text);
                            $.mememaker.texteditor.textselected();
                            break;
                        case "close":
                            $("#box-toolbar-texteditor").hide();
                            break;
                        default:
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

        /*
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
         */
    }


    Init.prototype.draweditorinit = function(id) {

        /*
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
         
         
         $("#draw-fill").colorpicker().on('changeColor', function(ev) {
         $.mememaker.draweditor.changeBrushProperty("color", ev.color.toHex());
         ;
         });
         
         $('#draw-mode-selector').on('change', function() {
         $.mememaker.draweditor.changeBrushType(this.value);
         }); */
    }

    $.mememakerinit = new Init();

}(window.jQuery));
