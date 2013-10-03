function PL(id) {
	return document.getElementById(id);
}

var uploader = new plupload.Uploader({
	runtimes : 'gears,html5,browserplus',
	browse_button : 'btn-upload-image',
	container : 'uploader',
	max_file_size : '10mb',
	url : 'process/index.php?action=upload',
	multi_selection : false,
	//resize: {width: 640, height: 240, quality: 100},
	//flash_swf_url: 'js/uploader/plupload.flash.swf',
	//silverlight_xap_url : 'js/uploader/plupload.silverlight.xap',
	filters : [ {
		title : "Image Files",
		extensions : "png,jpeg,jpg,gif"
	} ]
});

uploader.bind('Init', function(up, params) {
	//$('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
});

uploader.init();

uploader.bind('FilesAdded', function(up, files) {
	if (uploader.files.length == 2) {
		uploader.removeFile(uploader.files[0]);
	}
	for ( var i in files) {
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
			} catch (e) {
				console.log(e);
			}
			//jQuery('#progress-bar').css('width', "0%");
		}
	});
	//alert($.parseJSON(response.response).result);
});

jQuery(document).ready(function() {
	$(window).on('beforeunload', function() {
		//return 'Are you sure you want to leave? Your design isn\'t saved yet.';
	});
	maker_init();
	;
});

function maker_init() {
	
	$.mememakerinit.init('c1', "#FFFFFF");
	$.mememakerinit.toolsinit(".tools");
	$.mememakerinit.texteditorinit(".text-editor");
	$.mememakerinit.imageeditorinit(".image-editor");
	$.mememakerinit.draweditorinit(".draw-editor");
	//$.mememaker.tools.backgroundcolor("red");
	//$(".upper-canvas").css ("left", "20px");
	//templatelist_load();
	if ($("#canvas_guid").data('reload') == "1") {
		//reload_canvas();
	}
	// display all buttons after canvas loaded
}

//===========================================================
// Server API
//===========================================================
function save_canvas(json) {
	jQuery.ajax({
		url : "",
		data : {
			'data' : data
		},
		type : "POST",
		beforeSend : function(xhr) {
		}
	}).done(function(data) {
		var result = $.parseJSON(data);
		if (result.error == 1) {
		} else {
			alert("Your progress just saved");
		}
	}).fail(function() {
		//$("#template-list").prev().children(":first-child").hide(0);
	});
}

function reload_canvas() {
	var guid = $("#canvas_guid").val();
	jQuery.ajax({
		url : "",
		data : {
			'guid' : guid
		},
		type : "POST",
		beforeSend : function(xhr) {
		}
	}).done(function(data) {
		//console.log (data);
		var result = $.parseJSON(data);
		//console.log(data);
		if (result.error == 1) {
		} else {
			//console.log (result.data.json);
			$("#current-item").data('name', result.data.name);
			$("#current-item").val(result.data.product);
			$.mememaker.reload(result.data.json);
		}
	}).fail(function() {
		//$("#template-list").prev().children(":first-child").hide(0);
	});
}

//===========================================================
// Server API
//===========================================================
function templatelist_load() {
	jQuery.ajax({
		url : "",
		type : "GET",
		beforeSend : function(xhr) {
		}
	}).done(function(data) {
		$("#box-template-list").html(data);
		templatelist_config();
	}).fail(function() {
		//$("#template-list").prev().children(":first-child").hide(0);
	});
}

function templatelist_config() {
	jQuery("#template-list a").off('click');
	jQuery("#template-list a").click(function() {
		var bg = $(this).data('bg');
		var fg = $(this).data('fg');
		//$.mememaker.tools.backgroundimage(bg);
		$.mememaker.tools.newtemplate(fg);
		$.mememaker.tools.backgroundcolor("#DDDDDD");
		$("#current-item").val($(this).data('guid'));
		$("#current-item").data('name', $(this).data('name'));
		$.shoppingcart.setCurrentProductId($(this).data('guid'));
		$("#btn-order span").text("Order Now " + $(this).data('price') + "$");
	});
}

//==================================================================
// order
//==================================================================            
function order_config() {
	jQuery("#btn-cart").click(function() {
		var orderId = null;
		orderId = jQuery("#modal-preview #product-info").data('guid');
		var image = jQuery("#modal-preview #product-info").data('file');
		$.shoppingcart.set(orderId + "-" + image);
		jQuery("#modal-preview").modal('hide');
		window.open("", "_blank");
		window.focus();
	})
}

function order() {
	if (jQuery.trim(jQuery("#current-item").val()) == "") {
		return;
	}
	$.mememaker.tools.preview(preview);
	return;
}

function preview(preview) {
	if (jQuery.trim(jQuery("#current-item").val()) == "") {
		return;
	}
	jQuery("#modal-preview .modal-body")
			.html(
					'<div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>');
	jQuery(".ajax-loading-indicator").show(0);
	jQuery("#modal-preview").modal();
	jQuery.ajax({
		url : "",
		data : {
			"image-extension" : "jpeg",
			"image-data" : preview,
			"user" : $.shoppingcart.getuuid(),
			"product" : jQuery("#current-item").val()
		},
		type : "POST",
		beforeSend : function(xhr) {
		}
	}).done(function(data) {
		jQuery(".ajax-loading-indicator").hide(0);
		jQuery("#modal-preview .modal-body").html(data);
		order_config();
		order_current();
	}).fail(function() {
		jQuery(".ajax-loading-indicator").hide(0);
	});
}

function order_current() {
	var orderId = null;
	orderId = jQuery("#modal-preview #product-info").data('guid');
	var image = jQuery("#modal-preview #product-info").data('file');
	$.shoppingcart.setCurrentProductId(orderId + "-" + image);
	return true;
}

//===================================================
function formuser_load() {
	jQuery.ajax({
		url : "",
		type : "GET",
		beforeSend : function(xhr) {
		}
	}).done(function(data) {
		$("#modal-user .modal-body").html(data);
	}).fail(function() {
		jQuery(".ajax-loading-indicator").hide(0);
	});
}

function signup_submit() {
	jQuery.ajax({
		url : "",
		data : $("#form-signup").serialize(),
		type : "POST",
		beforeSend : function(xhr) {
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

function signin_submit() {
	jQuery.ajax({
		url : "",
		data : $("#form-signin").serialize(),
		type : "POST",
		beforeSend : function(xhr) {
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

function showAlert(message) {
	$("#box-alert .body").html(message);
	$("#box-alert").show();
	window.setTimeout(function() {
		$("#box-alert").hide(100)
	}, 5000);
}

function showAlert2(message) {
	$("#box-alert .body").html(message);
	$("#box-alert").show();
}

function hideAlert(message) {
	$("#box-alert").hide();
}
