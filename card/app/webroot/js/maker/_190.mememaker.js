/**
 * Small cutomize tool jquery plugin library, based on jquery and fabric.js Core
 * functionality, all functionality doesn't concern with HTML
 *
 * @author http://www.github.com/hellomaya
 * @date 2013.09.06
 * @description to extend functionality only, no HTML concerned
 */
( function($) {

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

		// So prototype is the way to make all objects from it share its property and method
		// If one of this value changed, and then all object's value changed
		// this.property, only worked for the one

		// So in OO, prototype is the way to make abstract class, or parent class
		// class b {}; class a extends b {}; n = new a();
		// Why we need inheriate?

		// var a = function () {}; var b = function (); b.prototype = new a();
		// var a = {}; var b = function (); b.prototype = new a();

		Mememaker.prototype = {
			containerId : '#box-canvas',
			wrapperId : 'box-canvas-wrapper',
			canvasId : 'c1',
			canvas : null,
			canvasScale : 0,
			width : 780,
			height : 780,
			originx : 0, // canvas postion - startup
			originy : 0, // canvas postion - startup
			left : 0, // canvas postion - changed
			top : 0, // canvas postion - changed
			offset : 0, //
			content : {
				pages : [],
				index : 0
			},
			grid : {
				lines : null,
				size : 20,
				visible : false,
				close : false,
				box : []
			},
			crop : {
				on : false,
				select : false,
				disable : false,
				selector : null,
				mousex : 0,
				mousey : 0
			},
			undo : {
				current : null,
				list : [],
				state : [],
				index : 0,
				index2 : 0,
				action : false,
				refresh : true,
				callback : null
			},
			base : {
				id : 0
			},
			backgroundColor : 'white',
			defaultText : null,
			mousex : 0,
			mousey : 0,
			selected : false,
			activex : 0,
			activey : 0,
			sender : null,
			// methods
			init : null,
			position : null,
			inEl : null,
			generateId : null,
			// object member
			tools : null,
			texteditor : null,
			imageeditor : null,
			draweditor : null
		};

		Tools.prototype = {
			containerId : '.tools',
			container : null,
			//
			init : null,
			newcanvas : null,
			remove : null,
			group : null,
			backward : null,
			forward : null,
			toBack : null,
			toFront : null,
			flip : null,
			addtext : null,
			addpic : null,
			addpic_callback : null,
			addgrid : null,
			backgroundcolor : null,
			overlayimage : null,
			move_callback : null,
			// server API
			zoom : null,
			tosvg : null,
			preview : null,
			preview_callback : null,
			save : null,
			save_callback : null,
			reload : null
		};

		TextEditor.prototype = {
			containerId : ".text-editor",
			id : null,
			current : null,
			container : null,
			//
			init : null,
			fill : null,
			changeFontFamily : null,
			changeText : null,
			changeFontProperty : null,
			textselected : null,
			textselected_callback : null
		};

		ImageEditor.prototype = {
			containerId : ".image-editor",
			id : null,
			current : null,
			zoomValue : null,
			rotateValue : null,
			container : null,
			//
			init : null,
			zoom : null,
			rotate : null,
			flipX : null,
			flipY : null,
			imageselected : null
		};

		DrawEditor.prototype = {
			containerId : ".draw-editor",
			id : null,
			current : null,
			lineWidth : null,
			shadowWidth : null,
			container : null,
			//
			init : null,
			fill : null,
			enable : null
		};

		Mememaker.prototype.tools = new Tools();
		Mememaker.prototype.texteditor = new TextEditor();
		Mememaker.prototype.imageeditor = new ImageEditor();
		Mememaker.prototype.draweditor = new DrawEditor();

		Mememaker.prototype.defaultText = {
			text : 'Your Text Is Here',
			property : {
				fontFamily : 'Arial',
				fontSize : 30,
				fill : 'black'
				// stroke: 'white',
				// strokeWidth: 0,
				// originX: 'left',
				// originY: 'top',
				// left: this.lastTextX,
				// top: this.lastTextY
			}
		};

		Mememaker.prototype.init = function(id, backgroundcolor, scale) {
			this.canvasId = id;
			this.canvasScale = scale;

			this.canvas = canvas = new fabric.Canvas(this.canvasId);

			this.width = canvas.getWidth();
			this.height = canvas.getHeight();

			canvas.backgroundColor = this.backgroundColor = backgroundcolor;
			// canvas.selection = true;
			// canvas.controlsAboveOverlay = true;
			// canvas.allowTouchScrolling = true;

			canvas.clear();
			this.update();
			this.originx = this.left;
			this.originy = this.top;

			localStorage.pages = JSON.stringify($.mememaker.content.pages);
			
			$.mememaker.tools.container = $.mememaker;
			$.mememaker.texteditor.container = $.mememaker;
			$.mememaker.imageeditor.container = $.mememaker;
			$.mememaker.draweditor.container = $.mememaker;
			
			console.log('canvas postion : ' + this.left + ":" + this.top);
		};

		Mememaker.prototype.position = function(el) {
			var pos = null;
			pos = [0, 0];

			var r = el.getBoundingClientRect();
			return r;
		};

		Mememaker.prototype.update = function() {
			var pos = this.position(document.getElementById(this.canvasId));
			this.left = pos.left;
			this.top = pos.top;
			this.offset = this.originy - this.top;
		};

		Mememaker.prototype.inEl = function(el) {
			if (el === undefined || el === null) {
				return false;
			}

			var left = el.left - el.getBoundingRectWidth() / 2 + this.left;
			var top = el.top - el.getBoundingRectHeight() / 2 + this.top;

			var right = left + el.getBoundingRectWidth();
			var bottom = top + el.getBoundingRectHeight();

			if (this.mousex > left && this.mousex < right) {
				if (this.mousey > top && this.mousey < bottom) {
					return true;
				}
			}

			return false;
		};

		Mememaker.prototype.generateId = function() {
			return this.base.id++;
		};

		// ============================================
		// tools
		// ============================================

		// Tools.prototype.container = $.mememaker;

		Tools.prototype.init = function() {
			
			this.addgrid();
			this.savepage(0);
			this.savepage(1);
			//this.addbox();
			this.onEvent ();
		};
		
		Tools.prototype.initReload = function() {
			var objects = $.mememaker.canvas.getObjects();
            var j = 0;
            var k = 0;
            
            //$.mememaker.grid.box = [];
            
            for (i in objects) {
            		if (objects[i].type == 'rect' && objects[i].fill === "transparent") {
            			//$.mememaker.grid.box[j] = objects[i];
            			//objects[i].selectable = false;
            			//j++;
            		}
            		
            		if (objects[i].type == 'line' && objects[i].visible === false) {
            			$.mememaker.grid.lines[k] = objects[i];
            			objects[i].selectable = false;
            			objects[i].setCoords();
            			k++;
            		}
            }
            /*
            for (i in $.mememaker.grid.box) {
            		$.mememaker.grid.box[i].remove();
            }
            
            for (i in $.mememaker.grid.lines) {
            		$.mememaker.grid.lines[i].remove();
            }
            this.addgrid();
            this.addbox();
            */
           
            canvas.renderAll();
		};

		Tools.prototype.newcanvas = function(color) {
			canvas.backgroundColor = this.backgroundColor = color;
			canvas.clear();
		};

		Tools.prototype.exist = function() {
			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				el = canvas.getActiveGroup();
				if (el === undefined || el === null) {
					return false;
				}
			}

			return true;
		};

		Tools.prototype.remove = function() {
			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				el = canvas.getActiveGroup();
				if (el === undefined || el === null) {
					return false;
				}

				canvas.discardActiveGroup();
				for ( i = 0; i < el.getObjects().length; ++i) {
					canvas.remove(el.item(i));
				}

				return el.type;
			}

			canvas.remove(el);
			return el.type;
		};

		Tools.prototype.group = function() {
			var el = canvas.getActiveGroup();
			if (el === undefined || el === null) {
				return;
			}

			var texts = [];
			var images = [];
			var i = 0;

			for ( i = 0; i < el.getObjects().length; ++i) {

				if (el.item(i).isType('image')) {
					texts[i] = null;
				} else {
					texts[i] = el.item(i).clone();
				}
			}

			for ( i = 0; i < el.getObjects().length; ++i) {

				if (el.item(i).isType('image')) {
					images[i] = el.item(i);
				} else {
					images[i] = null;
				}
			}

			function cloneImages(j, items, images, gr) {
				if (j >= images.length) {
					var group = new fabric.Group(items, {
						'left' : gr.left,
						'top' : gr.top
					});

					canvas.discardActiveGroup();
					for ( i = 0; i < items.length; ++i) {
						canvas.remove(gr.item(i));
					}

					canvas.add(group);
					return;
				}

				if (images[j] !== null) {
					images[j].clone(function(el) {
						items[j] = el;
						cloneImages(j + 1, items, images, gr);
					}, null);

				} else {
					cloneImages(j + 1, items, images, gr);
				}
			}

			cloneImages(0, texts, images, el);
		};

		Tools.prototype.move = function(direct) {
			if (direct === undefined || direct === null) {
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
		};

		Tools.prototype.lock = function() {
			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				el = canvas.getActiveGroup();
				if (el === undefined || el === null) {
					return false;
				}
			}

			el.lockMovementX = el.lockMovementX === false ? true : false;
			el.lockMovementY = el.lockMovementY === false ? true : false;
			canvas.renderAll();
			return el.lockMovementX;
		};

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

			if (x === 0) {
				el.flipX = el.flipX === true ? false : true;
			} else {
				el.flipY = el.flipY === true ? false : true;
			}

			canvas.renderAll();
		};

		Tools.prototype.addtext = function() {
			var text = new fabric.Text($.mememaker.defaultText.text, $.mememaker.defaultText.property);

			text.text = "CLICK TO EDIT";

			text.left = canvas.width / 2;
			text.top = canvas.height / 2;
			text.id = $.mememaker.generateId();
			canvas.add(text);

			// text.center();
			text.selectable = true;
			text.setCoords();
			// text.scaleToWidth(300);
			canvas.renderAll();

		};

		Tools.prototype.addpic = function(url) {

			fabric.Image.fromURL(url, function(oImg) {
				oImg.id = $.mememaker.generateId();
				oImg.padding = 10;
				oImg.left = canvas.width * 1 / 3;
				oImg.top = canvas.height * 1 / 3;
				oImg.scaleToWidth(Math.ceil(canvas.getWidth() * 2 / 3));
				canvas.add(oImg);
				canvas.renderAll();
				$.mememaker.tools.addpic_callback();
				//console.log(oImg);
			});
		};

		//=======================================
		// undo/redo
		//=======================================
		
		Tools.prototype.undo = function() {

			if ($.mememaker.undo.index <= 0) {
				$.mememaker.undo.index = 0;
				return false;
			}

			if ($.mememaker.undo.refresh === true) {
				$.mememaker.undo.index--;
				$.mememaker.undo.refresh = false;
			}

			console.log('undo');

			$.mememaker.undo.index2 = $.mememaker.undo.index - 1;
			$.mememaker.undo.current = $.mememaker.undo.list[$.mememaker.undo.index2];
			$.mememaker.undo.current.setOptions(JSON.parse($.mememaker.undo.state[$.mememaker.undo.index2]));

			$.mememaker.undo.index--;

			$.mememaker.undo.current.setCoords();
			canvas.renderAll();
			$.mememaker.undo.action = true;

			return true;
		};

		Tools.prototype.redo = function() {

			$.mememaker.undo.action = true;
			if ($.mememaker.undo.index >= $.mememaker.undo.state.length - 1) {
				return false;
			}

			console.log('redo');

			$.mememaker.undo.index2 = $.mememaker.undo.index + 1;
			$.mememaker.undo.current = $.mememaker.undo.list[index2];
			$.mememaker.undo.current.setOptions(JSON.parse($.mememaker.undo.state[index2]));
			$.mememaker.undo.current.setCoords();
			
			$.mememaker.undo.index++;
			canvas.renderAll();
			return true;
		};

		Tools.prototype.onEvent = function() {

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

					$.mememaker.selected = true;
					$.mememaker.activex = el.left;
					$.mememaker.activey = el.top;
					$.mememaker.imageeditor.imageselected();
				}
				
				var object = e.target;
				console.log('object:added');
				
				if (object.type === 'rect' && object.fill === "transparent") {
					return;
				}
				
				if (object.type === 'line' && object.visible === false) {
					return;
				}
				
				console.log('object:action');
				console.log(object);

				if ($.mememaker.undo.action === true) {
					$.mememaker.undo.state = [$.mememaker.undo.state[$.mememaker.undo.index2]];
					$.mememaker.undo.list = [$.mememaker.undo.list[$.mememaker.undo.index2]];

					$.mememaker.undo.action = false;
					console.log($.mememaker.undo.state);
					$.mememaker.undo.index = 1;
				}
				object.saveState();

				$.mememaker.undo.state[$.mememaker.undo.index] = JSON.stringify(object.originalState);
				$.mememaker.undo.list[$.mememaker.undo.index] = object;
				$.mememaker.undo.index++;
				$.mememaker.undo.index2 = $.mememaker.undo.index - 1;

				$.mememaker.undo.refresh = true;
				$.mememaker.undo.callback();
			});

			canvas.on('object:added', function(e) {

				var object = e.target;
				console.log('object:added');
				
				if (object.type === 'rect' && object.fill === "transparent") {
					return;
				}
				
				if (object.type === 'line' && object.visible === false) {
					return;
				}
				
				console.log('object:action');
				console.log(object);

				if ($.mememaker.undo.action === true) {
					$.mememaker.undo.state = [$.mememaker.undo.state[$.mememaker.undo.index2]];
					$.mememaker.undo.list = [$.mememaker.undo.list[$.mememaker.undo.index2]];

					$.mememaker.undo.action = false;
					console.log($.mememaker.undo.state);
					$.mememaker.undo.index = 1;
				}
				object.saveState();

				$.mememaker.undo.state[$.mememaker.undo.index] = JSON.stringify(object.originalState);
				$.mememaker.undo.list[$.mememaker.undo.index] = object;
				$.mememaker.undo.index++;
				$.mememaker.undo.index2 = $.mememaker.undo.index - 1;

				$.mememaker.undo.refresh = true;
				$.mememaker.undo.callback();
			});

			canvas.on('object:modified', function(e) {
				// localStorage.state2 = localStorage.state;
				var object = e.target;
				console.log('object:modified');
				
				if (object.type === 'rect' && object.fill == 'transparent') {
					return;
				}
				
				if (object.type === 'line' && object.visible === false) {
					return;
				}
				
				console.log('object:action');

				if ($.mememaker.undo.action === true) {
					$.mememaker.undo.state = [$.mememaker.undo.state[$.mememaker.undo.index2]];
					$.mememaker.undo.list = [$.mememaker.undo.list[$.mememaker.undo.index2]];

					$.mememaker.undo.action = false;
					console.log($.mememaker.undo.state);
					$.mememaker.undo.index = 1;
				}

				object.saveState();

				$.mememaker.undo.state[$.mememaker.undo.index] = JSON.stringify(object.originalState);
				$.mememaker.undo.list[$.mememaker.undo.index] = object;
				$.mememaker.undo.index++;
				$.mememaker.undo.index2 = $.mememaker.undo.index - 1;

				console.log($.mememaker.undo.state);
				$.mememaker.undo.refresh = true;
				$.mememaker.undo.callback(true);
			});

			canvas.on('object:removed', function(e) {
				
				$.mememaker.undo.state = [];
				$.mememaker.undo.list = [];
				$.mememaker.undo.index = 0;
				$.mememaker.undo.index2 = 0;
				$.mememaker.undo.refresh = true;
				$.mememaker.undo.callback(false);
			});

		};
		
		Tools.prototype.offEvent = function () {
			canvas.off ("object:modified");
			canvas.off ("object:added");
			canvas.off ("object:removed");
			canvas.off ("object:selected");
		};
		
		Tools.prototype.addshape = function(type) {

			if (type === undefined || type === null) {
				return;
			}

			var el;

			if (type == 'circle') {
				el = new fabric.Circle({
					radius : Math.ceil(canvas.width * 2 / 5 / 2),
					fill : 'green'
				});
			}

			if (type == 'rect') {
				el = new fabric.Rect({
					// left: 100,
					// top: 100,
					fill : '#ccc',
					width : Math.ceil(canvas.width * 2 / 5),
					height : Math.ceil(canvas.width * 2 / 5)
				});

				// rect.center();
			}

			if (type == 'tri') {
				el = new fabric.Triangle({
					width : Math.ceil(canvas.width * 2 / 5),
					height : Math.ceil(canvas.width * 2 / 5),
					fill : 'blue'
				});
			}

			el.left = canvas.width / 2;
			el.top = canvas.width / 2;
			canvas.add(el);

			// canvas.renderAll();
		};

		//

		Tools.prototype.addbox = function() {
			var rect = new fabric.Rect({
				left : 20,
				top : 20,
				originX: 'left',
				originY: 'top',
				width : canvas.width - 40,
				height : canvas.height - 40,
				fill : "transparent",
				strokeWidth : 1,
				stroke : "red"
			});

			rect.selectable = false;
			canvas.add(rect);
			rect.sendToBack();
			$.mememaker.grid.box[0] = rect;

			var rect2 = new fabric.Rect({
				left : 31,
				top : 31,
				originX: 'left',
				originY: 'top',
				width : canvas.width - 63,
				height : canvas.height - 63,
				fill : "transparent",
				strokeWidth : 1,
				stroke : "green"
			});

			rect2.selectable = false;
			canvas.add(rect2);
			rect2.sendToBack();
			$.mememaker.grid.box[1] = rect2;
			canvas.renderAll();
			
			//this.togglebox();
		};

		Tools.prototype.removebox = function() {
			for (i in $.mememaker.grid.box) {
				$.mememaker.grid.box[i].remove();
			}
			canvas.renderAll();
		};
		
		Tools.prototype.togglebox = function () {
			
			console.log ($.mememaker.grid.box);
				
			for (i in $.mememaker.grid.box) {
				$.mememaker.grid.box[i].visible = !$.mememaker.grid.box[i].visible;
			}
			
			canvas.renderAll();
		};

		Tools.prototype.addgrid = function() {

			var width = canvas.width;
			var height = canvas.height;

			var lines = [];
			var j = 0;
			var line = null;
			var rect = [];
			var size = this.container.grid.size;

			for ( j = 0; j < 4; ++j) {
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
					stroke : '#999',
					opacity : 0.5
				});

				line.selectable = false;
				line.visible = false;
				canvas.add(line);
				line.sendToBack();

				lines[j] = line;
				j += 1;
			}

			for ( i = 0; i < Math.ceil(height / 20); ++i) {
				rect[0] = 0;
				rect[1] = i * size;

				rect[2] = width;
				rect[3] = i * size;

				line = null;
				line = new fabric.Line(rect, {
					stroke : '#999',
					opacity : 0.5
				});
				line.selectable = false;
				line.visible = false;
				canvas.add(line);
				line.sendToBack();

				lines[j] = line;
				j += 1;
			}

			this.container.grid.lines = lines;
			canvas.renderAll();
		};

		Tools.prototype.removegrid = function() {
			for (i in this.container.grid.lines) {
				this.container.grid.lines[i].remove();
			}

			this.container.grid.lines = null;
		};

		Tools.prototype.showgrid = function() {
			if (this.container.grid.lines === null) {
				return false;
			}

			this.container.grid.visible = !this.container.grid.visible;

			for (i in this.container.grid.lines) {
				this.container.grid.lines[i].visible = !this.container.grid.lines[i].visible;
				// true;
			}

			canvas.renderAll();
			return true;
		};

		Tools.prototype.closegrid = function() {

			if (this.container.grid.close) {
				this.showgrid();
				this.container.grid.close = false;
				return;
			}

			if (this.container.grid.visible === false) {
				return;
			}

			this.showgrid();
			this.container.grid.close = true;
		};

		Tools.prototype.backgroundcolor = function(color) {
			this.container.backgroundColor = color;
			canvas.backgroundColor = color;
			canvas.renderAll();
		};

		Tools.prototype.backgroundimage = function(url) {
			canvas.setBackgroundImage(url, function() {
				canvas.renderAll();
			}, {
				'originX' : 'left',
				'originY' : 'top',
				'left' : 0,
				'top' : 0
			});
		};

		Tools.prototype.overlayimage = function(url) {
			canvas.setOverlayImage(url, canvas.renderAll.bind(canvas));
		};

		Tools.prototype.zoom = function(width) {

			var scale = width / canvas.getWidth();
			height = scale * canvas.getHeight();

			canvas.setDimensions({
				"width" : width,
				"height" : height
			});

			canvas.calcOffset();
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

				if (objects[i].type == 'line' && objects[i].get('opacity') === 0.5) {
					continue;
				}

				objects[i].scaleX = tempScaleX;
				objects[i].scaleY = tempScaleY;
				objects[i].left = tempLeft;
				objects[i].top = tempTop;

				objects[i].setCoords();
			}
			canvas.renderAll();

			this.container.update();
		};

		Tools.prototype.zoomreset = function() {

			// var scale = $.mememaker.canvasScale;
			
			if (this.container.width === canvas.width) {
				console.log ("no scale");
				return;
			}

			var scale = this.container.width / canvas.getWidth();
			canvas.setDimensions({
				"width" : this.container.width,
				"height" : this.container.height
			});

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

				if (objects[i].type == 'line' && objects[i].selectable === false && objects[i].get('opacity') === 0.5) {
					continue;
				}

				objects[i].scaleX = tempScaleX;
				objects[i].scaleY = tempScaleY;
				objects[i].left = tempLeft;
				objects[i].top = tempTop;

				objects[i].setCoords();
			}

			canvas.renderAll();

			this.container.update();
		};

		// Server API
		Tools.prototype.preview = function() {
			// it will convert canvas to base64

			// var scale = $.mememaker.canvasScale;
			// this.zoom(scale);

			// var width = this.canvas.width;
			// this.zoomreset();
			this.closegrid();
			canvas.deactivateAll();

			var preview = canvas.toDataURL({
				format : 'jpeg',
				quality : 1
			});

			this.closegrid();
			// this.zoom(width);
			if (this.preview_callback !== null) {
				this.preview_callback(preview);
			}
		};

		Tools.prototype.preview2 = function() {

			this.zoomreset();
			this.closegrid();
			//this.togglebox();
			canvas.deactivateAll();

			var preview = canvas.toDataURL({
				format : 'jpeg',
				quality : 1
			});

			this.closegrid();
			//this.togglebox();
			
			if (this.container.grid.visible) {
				this.showgrid();
			}

			return preview;
		};

		Tools.prototype.save = function() {
			//this.savepage($.mememaker.content.index);
			//this.savepage(1);
			this.save_callback(localStorage.pages);
		};

		Tools.prototype.reload = function(json, callback) {
			this.zoomreset();
			canvas.clear();
			canvas.loadFromJSON(json, function() {
				var objects = canvas.getObjects();
				var j = 0;

				for (var i in objects) {
					if (objects[i].type === 'line' && objects[i].get('opacity') === 0.5) {
						objects[i].selectable = false;
						objects[i].setCoords();
						console.log (objects[i]);
						$.mememaker.grid.lines[j] = objects[i];
						j++;
						continue;
					}
				}
				canvas.renderAll();
				canvas.calcOffset();

				if (callback) {
					callback();
				}
			});
		};

		Tools.prototype.toSVG = function() {

			this.zoomreset();
			this.removegrid();
			canvas.deactivateAll();

			var svg = canvas.toSVG();
			this.addgrid();
			if (this.container.grid.visible) {
				this.showgrid();
			}
			return svg;
		};

		Tools.prototype.savepage = function(page) {

			this.zoomreset();

			$.mememaker.content.pages[page] = JSON.stringify(canvas.toJSON());
			localStorage.pages = JSON.stringify($.mememaker.content.pages);
		};

		Tools.prototype.loadpage = function(page, callback) {
			page = parseInt(page);

			if (page < 0) {
				return false;
			}

			if (Number.isNaN(page)) {
				return false;
			}

			$.mememaker.content.pages = JSON.parse(localStorage.pages);
			if ($.mememaker.content.pages.length <= 0 || page >= $.mememaker.content.pages.length) {
				return false;
			}

			$.mememaker.content.index = page;
			canvas.clear();

			this.reload($.mememaker.content.pages[page], callback);
			return true;
		};

		// ===========================================
		// text editor
		// ===========================================

		TextEditor.prototype.fill = function(color) {
			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				return;
			}

			if (el.type != "text") {
				return;
			}

			el.fill = color;
			canvas.renderAll();
		};

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
		};

		TextEditor.prototype.changeText = function(value) {
			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				return;
			}

			if (el.type != "text") {
				return;
			}

			el.text = value;
			if (el.text === "") {
				canvas.remove(el);
			}
			
			el.setCoords();
			canvas.renderAll();
		};

		TextEditor.prototype.changeFontProperty = function(property) {

			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				return;
			}

			if (el.type != "text") {
				return;
			}

			console.log(el);

			if (property == "weight") {
				if (el.fontWeight == "800") {
					el.fontWeight = "400";
				} else {
					el.fontWeight = "800";
				}
			}

			if (property == "italic") {
				if (el.fontStyle == "italic") {
					el.fontStyle = "";
				} else {
					el.fontStyle = "italic";
				}
			}

			el.useNative = true;
			// el.originX = 'left';
			// el.originY = 'top';

			if (property == "underline") {
				if (el.textDecoration == 'underline') {
					el.textDecoration = null;
				} else {
					el.textDecoration = 'underline';
					// el.lineHeight = lineheight;
				}
			}

			el.setCoords();
			canvas.renderAll();
		};

		TextEditor.prototype.changeFontSize = function(size) {

			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				return;
			}

			if (el.type != "text") {
				return;
			}

			size = parseInt(size, 10);

			if (size <= 0) {
				return;
			}

			el.fontSize = size;
			el.setCoords();

			canvas.renderAll();			
			return;
		};

		TextEditor.prototype.changeFontColor = function(color) {

			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				return;
			}

			if (el.type != "text") {
				return;
			}

			el.fill = color;
			canvas.renderAll();
			return;
		};

		TextEditor.prototype.changeFontAlign = function(align) {

			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				return;
			}

			if (el.type != "text") {
				return;
			}

			el.textAlign = align;
			canvas.renderAll();
			return;
		};
		// ==================================================================
		// image editor
		// ==================================================================

		ImageEditor.prototype.init = function() {
		};

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

			// $(".text-editor").hide(10);
			// $(".image-editor").show(10);
		};

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
		};

		ImageEditor.prototype.cropstart = function() {
			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				return false;
			}

			if (el.type != "image") {
				return false;
			}

			this.container.crop.on = true;
			this.container.crop.select = false;
			this.container.crop.disable = false;
			el.lockMovementX = el.lockMovementY = true;
			el.lockRotation = true;

			return true;
			// this.cropResize();
		};

		ImageEditor.prototype.cropselect = function(event) {
			if (this.container.crop.on === false) {
				return false;
			}

			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				return false;
			}

			if (el.type != "image") {
				return false;
			}

			if (!this.container.inEl(el)) {
				return false;
			}

			console.log('crop select');

			if (this.container.crop.selector === null) {
				var rect = new fabric.Rect({
					// left: 100,
					// top: 100,
					fill : 'transparent',
					originX : 'left',
					originY : 'top',
					stroke : 'orangered',
					strokeDashArray : [2, 2],
					opacity : 1,
					width : 1,
					height : 1
				});

				rect.visible = false;
				this.container.crop.selector = rect;
				canvas.add(this.container.crop.selector);
			}

			this.container.crop.selector.visible = false;
			this.container.crop.selector.width = 1;
			this.container.crop.selector.height = 1;
			this.container.crop.select = true;
			this.container.crop.selector.left = event.pageX - $.mememaker.left;
			this.container.crop.selector.top = event.pageY - $.mememaker.top;
			// el.selectable = false;
			this.container.crop.selector.visible = true;
			canvas.bringToFront(this.container.crop.selector);

			$.mememaker.crop.mousex = event.pageX;
			$.mememaker.crop.mousey = event.pageY;
			return true;
		};

		ImageEditor.prototype.cropunselect = function(event) {

			if (this.container.crop.on === false) {
				return;
			}

			this.container.crop.select = false;
		};

		ImageEditor.prototype.cropresize = function(event) {

			if (this.container.crop.on === false) {
				return false;
			}

			if (this.container.crop.select === false) {
				return false;
			}

			var el = canvas.getActiveObject();

			if (el === undefined || el === null) {
				return false;
			}

			if (el.type != "image") {
				return false;
			}

			if (!this.container.inEl(el)) {
				return false;
			}

			if (this.container.crop.selector === null) {
				return false;
			}

			var width = event.pageX - $.mememaker.crop.mousex;
			var limit = el.left + el.getBoundingRectWidth() / 2;

			if (width > 0 && width + this.container.crop.selector.left < limit) {
				this.container.crop.selector.width = event.pageX - $.mememaker.crop.mousex;
			}

			width = event.pageY - $.mememaker.crop.mousey;
			limit = el.top + el.getBoundingRectHeight() / 2;

			if (width > 0 && width + this.container.crop.selector.top < limit) {
				this.container.crop.selector.height = event.pageY - $.mememaker.crop.mousey;
			}
			return true;
			// canvas.add(this.container.crop.selector);
		};

		ImageEditor.prototype.cropend = function() {
			if (this.container.crop.on === false) {
				return false;
			}

			var el = canvas.getActiveObject();
			console.log(el);

			if (el === undefined || el === null) {
				return false;
			}

			if (el.type != "image") {
				return false;
			}

			var left = this.container.crop.selector.left - el.left;
			// - object.left
			var top = this.container.crop.selector.top - el.top;

			var width = this.container.crop.selector.width;
			var height = this.container.crop.selector.height;

			left *= 1 / el.scaleX;
			top *= 1 / el.scaleY;

			width *= 1 / el.scaleX;
			height *= 1 / el.scaleY;

			el.clipTo = function(ctx) {
				ctx.rect(left, top, width, height);
				// 0, 0, 100, 100);//, top,
				// width, height);
			};

			this.container.crop.selector.visible = false;
			canvas.renderAll();

			var ctx = canvas.getContext('2d');
			var data = ctx.getImageData(this.container.crop.selector.left, this.container.crop.selector.top, this.container.crop.selector.width, this.container.crop.selector.height);

			var c = document.createElement('canvas');

			c.setAttribute('id', '_temp_canvas');
			c.width = this.container.crop.selector.width;
			c.height = this.container.crop.selector.height;

			c.getContext('2d').putImageData(data, 0, 0);

			fabric.Image.fromURL(c.toDataURL(), function(img) {
				img.left = el.left;
				img.top = el.top;
				img.padding = 10;
				canvas.add(img);
				img.bringToFront();
				el.selectable = false;
				el.visible = false;
				c = null;
				$('#_temp_canvas').remove();
				canvas.renderAll();
			});
			this.cropcancel();
			return true;
		};

		ImageEditor.prototype.cropcancel = function() {
			if (this.container.crop.on === false) {
				return;
			}
			this.container.crop.on = false;
			this.container.crop.selector.remove();
			this.container.crop.selector = null;

			$.mememaker.tools.lock();
		};

		ImageEditor.prototype.crop2 = function() {
			fabric.Image.filters.crop2 = fabric.util.createClass({
				type : 'Redify',
				applyTo : function(canvasEl) {
					var context = canvasEl.getContext('2d');
					var imageData = context.getImageData(0, 0, canvasEl.width, canvasEl.height);
					var data = imageData.data;

					for (var i = 0, len = data.length; i < len; i += 4) {
						data[i + 1] = 0;
						data[i + 2] = 0;
					}

					context.putImageData(imageData, 0, 0);
				}
			});

			fabric.Image.filters.crop2.fromObject = function(object) {
				return new fabric.Image.filters.crop2(object);
			};
		};
		
		// ==================================================================
		// image editor
		// ==================================================================
		DrawEditor.prototype.changeBrushProperty = function(name, value) {
			switch (name) {
				case "linewidth":
					canvas.freeDrawingBrush.width = value;
					break;
				case "shadowwidth":
					canvas.freeDrawingBrush.shadowBlur = value;
					break;
				case "color":
					canvas.freeDrawingBrush.color = value;
					break;
			}
		};

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
							width : squareWidth,
							height : squareWidth,
							angle : 45,
							fill : this.color
						});
						var canvasWidth = rect.getBoundingRectWidth();

						patternCanvas.width = patternCanvas.height = canvasWidth + squareDistance;
						rect.set({
							left : canvasWidth / 2,
							top : canvasWidth / 2
						});

						var ctx = patternCanvas.getContext('2d');
						rect.render(ctx);

						return patternCanvas;
					};
				};
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
				// canvas.freeDrawingBrush.color = $("#draw-fill").val();
				canvas.freeDrawingBrush.width = this.lineWidth.getValue();
				canvas.freeDrawingBrush.shadowBlur = this.shadowWidth.getValue();
			}

		};

		DrawEditor.prototype.enable = function() {
			enable = canvas.isDrawingMode === true ? false : true;
			if (enable) {
				canvas.discardActiveObject();
				canvas.discardActiveGroup();

				// canvas.freeDrawingLineWidth = width;
				// canvas.freeDrawingColor = $("#draw-fill").val();
				canvas.isDrawingMode = true;
				canvas.freeDrawingBrush.width = 1;
				canvas.freeDrawingBrush.color = "#eb34dc";

				// canvas.renderAll();

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
		};

		$.mememaker = new Mememaker();
	}(window.jQuery));
