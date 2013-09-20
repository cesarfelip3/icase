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
        resize: null,
        init: null,
        selected: false,
        toolsinit: null,
        texteditorinit: null,
        imageeditorinit: null,
        draweditorinit: null
    };

    Init.prototype.init = function(id, backgroundcolor) {

        function onResize() {
            $.mememaker.update();
        }

        $(window).resize(function() {
            clearTimeout(this.resize);
            this.resize = setTimeout(onResize, 100);
        });
        
        
        $(window).scroll(function() {
            $.mememaker.update();
            console.log ("offset: " + $.mememaker.left + ":" + $.mememaker.top);
        });

        $(document).mousemove(function(event) {
            $.mememaker.mousex = event.pageX;
            $.mememaker.mousey = event.pageY;

            $.mememaker.imageeditor.cropresize(event);
        });

        $(document).mousedown(function(event) {
            $.mememaker.mousex = event.pageX;
            $.mememaker.mousey = event.pageY;
            $.mememaker.update();

            $.mememaker.imageeditor.cropselect(event);
        })

        $(document).mouseup(function(event) {
            $.mememaker.mousex = event.pageX;
            $.mememaker.mousey = event.pageY;
            $.mememaker.update();

            $.mememaker.imageeditor.cropunselect();

            var el = $.mememaker.canvas.getActiveObject();
            ////console.log (el);

            if (el === undefined || el === null) {
                return;
            }

            if (!$.mememaker.inEl(el)) {
                return;
            }

            if (el.lockMovementX == true) {
                return;
            }

            if ($.mememaker.grid.visible) {

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

    Init.prototype.reload = function() {
        jQuery.ajax({
            url: "process/index.php?action=reload",
            type: "GET",
            beforeSend: function(xhr) {
                showAlert2("Reloading......");
            }
        }).done(function(data) {

            var result = $.parseJSON(data);
            if (result.error == 1) {

            } else {
                $.mememaker.tools.reload(result.data.json);
            }

            hideAlert();

        }).fail(function() {
            showAlert2("failed");
        });
    }

    Init.prototype.toolsinit = function(id) {

        console.log("toolsinit");
        $.mememaker.tools.init();

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

        // poor performance...:(
        $.mememaker.tools.move_callback = function() {
            $(".text-editor").hide();
            $(".image-editor").hide();
        }

        $("#box-editing").scroll(function() {
            console.log('scroll');
            $.mememaker.canvas.calcOffset();
            $.mememaker.update();
        });

        $.mememaker.tools.save_callback = function(json)
        {
            jQuery.ajax({
                url: "process/index.php?action=save",
                data: {'json': json},
                type: "POST",
                beforeSend: function(xhr) {
                    showAlert2("Saving......");
                }
            }).done(function(data) {

                var result = $.parseJSON(data);
                if (result.error == 1) {
                    $("#modal-user").modal();
                    formuser_load();
                } else {
                    $("#canvas_guid").val(result.data.guid);
                    $("#canvas_guid").data('saved', '1');
                    alert("Your progress just saved");
                }

                hideAlert();

            }).fail(function() {
                showAlert2("Failed");
            });
        }

        $.mememaker.tools.preview_callback = function preview(data)
        {
            $("#modal-preview").modal();
            jQuery.ajax({
                url: "process/index.php?action=preview",
                data: {"image-extension": "jpeg", "image-data": data},
                type: "POST",
                beforeSend: function(xhr) {
                }
            }).done(function(data) {
                var result = jQuery.parseJSON(data);
                
                if (result.error == 0) {
                    var url = result.files.url;
                    $("#modal-preview .modal-body").html ("<img src='" + url + "' style='width:100%;height:100%' />");
                }
                (data);
            }).fail(function() {
                jQuery(".ajax-loading-indicator").hide(0);
            });
        }

        $(id + " a").click(
                function(evt) {
                    var action = $(this).data('action');
                    if (action === undefined || action === null) {
                        return;
                    }

                    console.log(action);

                    switch (action) {
                        case 'new':
                            $.mememaker.tools.newcanvas ("#eb3d2d");
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
                            $.mememaker.tools.toBack();
                            break;
                        case 'forward':
                            $.mememaker.tools.toFront();
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
                            $("#box-toolbar-shape").hide();
                            $("#box-toolbar-bg").show();
                            break;
                        case 'addshape':
                            $("#box-toolbar-bg").hide();
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
                        case 'undo':
                            $.mememaker.tools.undo();
                            break;
                        case 'save':
                            if ($("#box-attribute") !== undefined) {
                                $("#box-attribute").show();
                            }
                            
                            $.mememakerinit.zoomcount = 0;
                            $("#box-canvas-wrapper").css("width", $.mememaker.width + "px");
                            $.mememaker.tools.save();
                            break;
                        case 'reload':
                            $.mememakerinit.zoomcount = 0;
                            $("#box-canvas-wrapper").css("width", $.mememaker.width + "px");
                            $.mememakerinit.reload();
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
                        case 'pagefront':
                            if ($(this).parent().hasClass('disabled')) {
                                return;
                            }
                            $.mememaker.savepage (0);
                            $.mememaker.loadpage (1);
                            $(this).parent().addClass('disabled');
                            break;
                        case 'pageback' :
                            if ($(this).parent().hasClass('disabled')) {
                                return;
                            }
                            $.mememaker.savepage (1);
                            $.mememaker.loadpage (0);
                            $(this).parent().addClass('disabled');
                            break;
                        default:
                            break;
                    }
                }
        );
    }


    Init.prototype.texteditorinit = function(id) {


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

            top = $.mememaker.offset + top;
            $(".text-editor").show();
            $(".text-editor").css('top', top + "px");
            $(".text-editor").css('left', left + "px");

            $("#text-content").val(el.text);

        }


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
    }


    Init.prototype.imageeditorinit = function(id) {

        $.mememaker.imageeditor.init();

        $.mememaker.imageeditor.imageselected = function() {

            var el = $.mememaker.canvas.getActiveObject();

            if (el === undefined || el === null) {
                return;
            }

            if (el.type != "image") {
                return;
            }

            var height = el.getBoundingRectHeight();
            var top = el.top + height / 2 + 10 + $.mememaker.top;
            var left = el.left - el.getBoundingRectWidth() / 2 + $.mememaker.left;
            
            top = top + $.mememaker.offset;
            top = Math.floor(top);
            left = Math.ceil(left - (100 - el.getBoundingRectWidth()) / 2);

            $(".text-editor").hide();
            $(".image-editor").show();
            $(".image-editor").css('top', top + "px");
            $(".image-editor").css('left', left + "px");

        }

        $(id + " a").click(
                function() {
                    var action = $(this).data('action');
                    console.log(action);
                    switch (action) {
                        case "cropstart":
                            $.mememaker.imageeditor.cropstart();
                            break;
                        case "cropend":
                            $.mememaker.imageeditor.cropend();
                            break;
                        case "close":
                            $.mememaker.imageeditor.cropcancel();
                            $(".image-editor").hide();
                            break;
                        default:
                            break;
                    }
                });



        //var json = $.mememaker.canvas.toJSON();
        //json = JSON.stringify(json);
        localStorage.state2 = localStorage.state = JSON.stringify([]);
        console.log(localStorage.state);

    }


    Init.prototype.draweditorinit = function(id) {

    }

    $.mememakerinit = new Init();

}(window.jQuery));
