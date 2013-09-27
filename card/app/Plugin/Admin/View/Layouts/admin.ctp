
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Your Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" value="" />
        <meta name="description" value="The secrets to baking fresh chewy chocolate chip cookies that make you wish thousands of calories were actually good for you!" />
        <meta name="author" content="">
        <!-- Le styles -->
<!--        <link href="http://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet" type="text/css">-->
        <link href="<?php echo $this->webroot; ?>plugins/admin/assets/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $this->webroot; ?>plugins/admin/assets/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo $this->webroot; ?>plugins/admin/assets/css/admin.css" rel="stylesheet">
        
        <link href="<?php echo $this->webroot; ?>css/font-awesome.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/main_admin.css">
        <link rel='stylesheet' href='<?php echo $this->webroot; ?>js/spectrum/spectrum.css' />
        
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="<?php echo $this->webroot; ?>js/vendor/jquery-1.9.1.min.js"></script>
    </head>    
    <body>
        <div class="masthead">
            <div class="container">
                <div class="masthead-top clearfix">
                    <ul class="nav nav-pills pull-right">
                        <li>
                            <a href="<?php echo $this->webroot; ?>" target="new"><i class="icon-globe"></i> View Website</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i>  <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="">Your Profile</a></li>
<!--                                <li class="active"><a href="form.html">Account Settings</a></li>-->
                                <li class="divider"></li>
                                <li><a href="<?php echo $base; ?>index/logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                    <h1><i class="icon-bookmark icon-large"></i> Admin Dashboard</h1>
                </div>
                <div class="navbar">
                    <div class="navbar-inner">
                        <div class="container">
                            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <div class="nav-collapse">
                                <ul class="nav">
                                    <li class="active">
                                        <a href="<?php echo $base; ?>"><i class="icon-home"></i> Dashboard</a>
                                    </li>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-shopping-cart"></i> Store <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo $base; ?>category/">Manage Category</a></li>
                                            <li><a href="<?php echo $base; ?>industry/">Manage Industry</a></li>
                                            <li><a href="<?php echo $base; ?>template/">Manage Template</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->fetch('content'); ?>
        <!-- Le javascript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo $this->webroot; ?>plugins/admin/assets/js/bootstrap.js"></script>
        <script src="<?php echo $this->webroot; ?>plugins/admin/assets/js/excanvas.min.js"></script>
        <script src="<?php echo $this->webroot; ?>plugins/admin/assets/js/jquery.flot.min.js"></script>
        <script src="<?php echo $this->webroot; ?>plugins/admin/assets/js/jquery.flot.resize.js"></script>


        <script type="text/javascript">
            //<!--
            if (typeof CKEDITOR === 'undefined' || null == CKEDITOR) {
            document.write ('<script type="text/javascript" src="<?php echo $this->webroot; ?>js/ckeditor.basic/ckeditor.js"); ?>"></script><div style="display:none"><textarea class="ckeditor" cols="80" id="editor2" name="editor2" rows="10" style=""></textarea></div>');
        };

    </script>
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>js/datepicker/css/datepicker.css">
    <script type="text/javascript" src="<?php echo $this->webroot; ?>js/datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        jQuery(document).ready (function() {
            window.prettyPrint && prettyPrint();
            jQuery(".datepicker").datepicker({format: 'yyyy-mm-dd'});
            
            
        });
    </script>
    <script type="text/javascript">
//                $(function() {
//            var d1 = [];
//            d1.push([0, 20]);
//            d1.push([1, 16]);
//            d1.push([2, 17]);
//            d1.push([3, 25]);
//            d1.push([4, 51]);
//            d1.push([5, 57]);
//            d1.push([6, 46]);
//            d1.push([7, 36]);
//            d1.push([8, 27]);
//            d1.push([9, 36]);
//            d1.push([10, 38]);
//            d1.push([11, 41]);
//            d1.push([12, 45]);
//            d1.push([13, 48]);
//            d1.push([14, 40]);
//            d1.push([15, 36]);
//            d1.push([16, 34]);
//            $.plot($("#placeholder"), [d1], {grid: {backgroundColor: 'white', color: '#999', borderWidth: 1, borderColor: '#DDD'}, colors: ["#6ECBE2"], series: {lines: {show: true, fill: true, fillColor: "rgba(110, 203, 226, 0.5)"}}});
//        });
    </script>

    <div class="row hide" id="box-message" style="position: fixed;top:0px;left:0px;z-index:1030;margin-bottom:0;">
        <div class="span4 offset4">
            <div style="background-color:yellow;min-height:20px;border:1px black solid; ">
                <p style="margin-top:5px;margin-left:20px;"><strong><span class="body"></span></strong></p>
            </div>
        </div>
    </div>
    
    <script>
        
        function showAlert (message)
        {
            $("#box-message .body").html(message);
            $("#box-message").show ();
            window.setTimeout(function () {$("#box-message").hide(100)}, 5000);
        }
        
        function showAlert2 (message) 
        {
            $("#box-message .body").html(message);
            $("#box-message").show ();
        }
        
        function hideAlert (message)
        {
            $("#box-message").hide ();
        }
        
    </script>
    
</body> 

</html>