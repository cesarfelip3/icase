<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/bootstrap.min.css">

        <!--        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/bootstrap-responsive.min.css">-->
        <!-- link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/<?php echo $this->webroot; ?>css/font-awesome.css" rel="stylesheet" -->
        <link href="<?php echo $this->webroot; ?>css/font-awesome.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/main.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/sky-forms.css" />
        <style type="text/css">
        	body {
        		padding-top:60px;
        	}
        </style>
        <script src="<?php echo $this->webroot; ?>js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    </head>
    <body>
        <!--[if lt IE 9]>
            <p class="chromeframe">You are using an <strong><i>NO SUPPORTED</i></strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser, we recommand ie9+, google chrome, firefox, safari and opera latest version</a></p>
        <![endif]-->

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-fixed-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#" style="margin-left:5px;">Online DIY maker</a>

                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><a href="index.html">Home</a></li>
                            <li class="active"><a href="<?php echo $this->webroot; ?>admin/">Admin</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- content -->
        <div class="container unselectable" id="box-container">
            <form class="sky-form" style="background:none;border:none;box-shadow:none;" id="form-filter">
                <div class="row-fluid">
                    <div class="span3 pull-left">
                        <label class="select state-success">
                            <select name="filter_category" onchange="subcategorylist()" id="filter_category">
                            	   <option value="">All Category</option>
                            	   <?php foreach ($categories as $value) : $value = $value['Category']; ?>
                            	   <option value="<?php echo $value['guid'];?>"><?php echo $value['name']; ?></option>
                            	   <?php endforeach; ?>
                            	   <!-- 
                                <option value="2">Flyers &amp; Leaflets</option>
                                <option value="1">Business Cards</option>
                                <option value="3">Letterheads</option>
                                <option value="4">Compliments Slips</option>
                                <option value="5">Posters</option>
                                <option value="6">Roller Banners</option>
                                <option value="7">Invitations</option>
                                -->
                            </select>
                            <i></i>
                        </label>
                    </div>
                    <div class="span2 pull-left hide">
                        <label class="select state-success" id="box-subcategory" onchange="loaddata();">
                        	<!--
                            <select class="hide">
                                <option value="0"> --- </option>
                                <option value="6" data-category="2">A3</option>
                                <option value="2" data-category="2">A4</option>
                                <option value="3" data-category="2">A5</option><option value="4" data-category="2" selected="selected">A6</option>
                                <option value="5" data-category="2">DL</option>
                            </select>
                           -->
                            <i></i>
                        </label>
                    </div>
                    <div class="span4">
                        <label class="select state-success">
                            <select name="filter_industry" onchange="loaddata();">
                            		<option value="">All Industry</option>
                            	   <?php foreach ($industries as $value) : $value = $value['Industry']; ?>
                            	   <option value="<?php echo $value['guid'];?>"><?php echo $value['name']; ?></option>
                            	   <?php endforeach; ?>
                            	<!--
                                <option value="0">All Industry</option>
                                <option value="8">automotive,travel &amp; transportation</option>
                                <option value="19">baby &amp; kids</option>
                                <option value="7">beauty, health care &amp; medical</option>
                                <option value="17">birthday &amp; party</option>
                                <option value="9">child care &amp; education</option>
                                <option value="2">energy &amp; environment</option>
                                <option value="1">food &amp; beverage</option>
                                <option value="15">gardening, florists &amp; farming</option>
                                <option value="14">general</option>
                                <option value="18">general</option>
                                <option value="3">home maintenance &amp; cleaning</option>
                                <option value="6">legal, financial &amp; real estate</option>
                                <option value="4">music &amp; arts</option>
                                <option value="5">pets &amp; animals</option>
                                <option value="20">photo-invites</option>
                                <option value="11">retail, sales &amp; fashion</option>
                                <option value="12">sports &amp; fitness</option>
                                <option value="10">technology &amp; information</option>
                                <option value="16">wedding &amp; anniversary</option>
                                <option value="13">wedding, events &amp; event planning</option>
                               -->
                            </select>
                            <i></i>
                        </label>
                    </div>
                </div>
            </form>
            <hr/>
            <div class="row-fluid">
                <ul class="breadcrumb sky-form" style="height:40px;background:none;border:none;box-shadow:none;">
                    <li><h3><strong>A6 Flyer Designs - Prices start from £9</strong></h3></li>
                    <li class="pull-right"><a class="button" id="btn-all-price"><i class="icon-gbp icon-large"></i> View All Price</a></li>
                </ul>
            </div>
            <hr/>
            <div class="row-fluid" style='padding-top:10px;margin-top:2px;' id="box-content">
                <ul class="thumbnails hide">
                    <li class="span3" id="li-template-box1">
                        <div class="thumbnail" style="margin-bottom:5px;">
                            <a href="javascript:">
                                <img src="img/thumb_small.jpg"  style=""/>
                            </a>
                            <div class="caption">
                                <h4>Letter</h4>
                            </div>
                        </div>
                        <div class="thumbnail">
                            <a href="javascript:">
                                <img src="img/thumb_small_1.jpg"  style=""/>
                            </a>
                            <div class="caption">
                                <h4>Letter</h4>
                            </div>
                        </div>
                    </li>
                    <li class="span3" id="li-template-box2">
                        <div class="thumbnail">
                            <a href="javascript:">
                                <img src="img/thumb_small.jpg"  style=""/>
                            </a>
                            <div class="caption">
                                <h4>Letter</h4>
                            </div>
                        </div>
                        <div class="thumbnail">
                            <a href="javascript:">
                                <img src="img/thumb_small_1.jpg"  style=""/>
                            </a>
                            <div class="caption">
                                <h4>Letter</h4>
                            </div>
                        </div>
                    </li>
                    <li class="span3" id="li-template-box3">
                        <div class="thumbnail">
                            <a href="javascript:">
                                <img src="img/thumb_small_1.jpg"  style=""/>
                            </a>
                            <div class="caption">
                                <h4>Letter</h4>
                            </div>
                        </div>
                        <div class="thumbnail">
                            <a href="javascript:" style="">
                                <img src="img/thumb_small.jpg"  style=""/>
                            </a>
                            <div class="caption">
                                <h4>Letter</h4>
                            </div>
                        </div>
                    </li>
                    <li class="span3" id="li-template-box4">
                        <div class="thumbnail">
                            <a href="javascript:">
                                <img src="img/thumb_small.jpg"  style=""/>
                            </a>
                            <div class="caption">
                                <h4>Letter</h4>
                            </div>
                        </div>
                        <div class="thumbnail">
                            <a href="javascript:">
                                <img src="img/thumb_small.jpg"  style=""/>
                            </a>
                            <div class="caption">
                                <h4>Letter</h4>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="row-fluid" id="box-bottom">
                <div class="span12" style="margin:auto;text-align:center" id="box-ajax-indicator">
                    <i class="icon-refresh icon-spin icon-2x" style="color:orange"></i>
                </div>
            </div>
            <!-- editor -->

        </div>
        <!-- end fluid-container -->

        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $this->webroot; ?>js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script>
            var loaded = false;
            var page = 0;
            var poss;
            
            $(document).ready(
                    function() {
                    		
                    		loaded = true;
                    		loaddata();

                        jQuery(document).scroll(function() {
                            var top = document.getElementById("box-bottom");
                            pos = top.getBoundingClientRect();

                           // console.log(pos.top);
                            //console.log(jQuery("#box-bottom").scrollTop());
                            //console.log(jQuery(window).height());
                            
                            //alert (pos.top);

                            if (pos.top <= jQuery(window).height() && !loaded) {
                            		//alert ("bottom");
                                console.log("bottom");
                                loaddata2 (page++);
                                
                            }
                        });

                        $("#btn-all-price").click(
                                function() {
                                    $("#modal-allprice").modal();
                                });
                                
                        $("#modal-preview a").click (
                        		function () {
	                        		var action = $(this).data('action');
	                        		switch (action) {
	                        			case 'reverse':
	                        			    $("#img-front").toggle();
	                        			    $("#img-reverse").toggle();
	                        				break;
	                        	        case 'custom':
	                        	            break;
	                        		}
                        		}
                        );
                    });
                    
			function init()
			{
				$("#box-bottom-indicator").hide();
				$(".thumbnail a").off ('click');
				$(".thumbnail a").click(
					function(e) {
						var front = $(this).data('image-front');
						var reverse = $(this).data('image-reverse');
						var name = $(this).data('name');
						var guid = $(this).data('guid');
						
						$("#modal-box-image").html("<img id='img-front' src='" + front + "' style='width:350px' />");
						$("#modal-box-image").html($("#modal-box-image").html() + "<img id='img-reverse' src='" + reverse + "' style='width:350px;' />")
						$("#img-reverse").hide();
						$("#modal-name").html(name);
						$("#btn-go-design").data('guid', guid);
						$("#btn-go-design").attr ('href', "<?php echo $this->webroot; ?>creator/create/?action=list&id=" + guid);
						$("#btn-go-design").attr('target', 'new');
						$("#modal-preview").modal();
				});

			}
            
            function subcategorylist ()
		    {
		        var guid = $("#filter_category").val();
		        jQuery.ajax({
		            url: "<?php echo $this->webroot; ?>index/subcategorylist/?id=" + guid,
		            type: "GET",
		            beforeSend: function(xhr) {
		                //showAlert2 ("Loading sub categories......");
		            }
		        }).done(function(data) {
		            //var html = $("#box-filter-category").html();
		            //hideAlert ();
		            
		            if ($("#filter_subcategory")) {
		                $("#filter_subcategory").remove ();
		            }
		            
		            if (data == 'no') {
		            		$("#box-subcategory").parent().hide();
		            		loaddata();
		                return;
		            }
		            
		            $("#box-subcategory").html(data);
		            $("#box-subcategory").parent().show();
		        }).fail(function() {
		            //showAlert ("Failed");
		        });
		    }
		    
		    function loaddata () {
		    	
		    		$("#box-bottom-indicator").show();
		        jQuery.ajax({
		            url: "<?php echo $this->webroot; ?>index/templatelist",
		            type: "GET",
		            data: $("#form-filter").serialize(),
		            beforeSend: function(xhr) {
		                //showAlert2 ("Loading sub categories......");
		            }
		        }).done(function(data) {
		            if (data == "no") {
		            		$("#box-ajax-indicator").hide();
		            		return;
		            }
		            
		            $("#box-content").html (data);
		            loaded = false;
		            init();
		        }).fail(function() {
		            //showAlert ("Failed");
		        });
		    }
		    
		    function loaddata2 (page) {
		    	
		    		loaded = true;
		    		$("#box-bottom-indicator").show();
		    		
		    		var data = $("#form-filter").serialize();
		    		console.log (data);
		    		
		    		var data = {"action":"nextpage", "page":page, "filter_category":$("#filter_category").val(), "filter_industry":$("#filter_industry").val(), "filter_subcategory":$("#filter_subcategory").val()}
		    		
		        jQuery.ajax({
		            url: "<?php echo $this->webroot; ?>index/templatelist2/",
		            type: "GET",
		            data: data,
		            beforeSend: function(xhr) {
		            }
		        }).done(function(data) {
		        		console.log (data);
		        		
		            if (data == "no") {
		            		//loaded = true;
		            		$("#box-ajax-indicator").hide();
		            		return;
		            }
		            
		            var result = JSON.parse (data); 
		            var html = "";
		            var j = 0;
		            
		            console.log (result);
		            
		            for (i in result) {
		            		html = '<div class="thumbnail" style="margin-bottom:5px;"><a href="javascript:" data-image-front="' + result[i].featured[0] + '" data-image-reverse="' + result[i].featured[1] + '" data-guid="' + result[i].guid + '" data-name="' + result[i].name + '"> <img src="' + result[i].thumbnails[0] + '" style="" /> </a><div class="caption"><h4>' + result[i].name + '</h4></div></div>'
		            		j = parseInt(i) + 1;
		            		$("#li-template-box" + j).append(html);
		            		console.log (j);
		            };
		            
		            loaded = false;
                    init();
		        }).fail(function() {
		            //showAlert ("Failed");
		        });
		    }
        </script>
        <!-- preview modal -->
        <div id="modal-preview" class="modal-category-preview hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="well" style="background-color:white;margin:auto;text-align: center;">
                <div style="background-color:#ccc;padding:20px;" id="modal-box-image">
                    <img src="img/thumb_large.jpg" style="350px" />
                </div>
                <h4 style='text-align:left;'><span id="modal-name"></span><a class='pull-right btn btn-info btn-no-corner' data-action="reverse"><i class='icon-share-alt icon-large'></i> See Reverse</a></h4>
                <hr/>
                <div style="height:40px;padding:10px;">
                    <a class="btn btn-warning pull-right btn-no-corner" data-action="custom" id="btn-go-design">Let's Customize <i class='icon-pencil icon-large'></i></a>
                    <a class="btn btn-warning pull-right btn-no-corner"  data-dismiss="modal" aria-hidden="true" style='margin-right:5px;'>Cancel <i class='icon-remove icon-large'></i></a>
                </div>
            </div>

            <div>
                <div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>
            </div>
        </div>

        <!-- user modal -->
        <div id="modal-allprice" class="modal-category-allprice fade hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">All price</h3>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <script src="<?php echo $this->webroot; ?>js/vendor/bootstrap.min.js"></script>

        <script src="<?php echo $this->webroot; ?>js/plugins.js"></script>
        <script src="<?php echo $this->webroot; ?>js/main.js"></script>
        

    </body>
</html>
