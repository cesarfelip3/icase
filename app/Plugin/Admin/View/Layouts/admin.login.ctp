
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
        <link href="http://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet" type="text/css">
        <link href="<?php echo $this->webroot; ?>plugins/admin/assets/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $this->webroot; ?>plugins/admin/assets/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo $this->webroot; ?>plugins/admin/assets/css/admin.css" rel="stylesheet">
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    </head>    
    <body>
        <div class="masthead">
            <div class="container">
                <div class="masthead-top clearfix">
                    
                    <h1><i class="icon-bookmark icon-large"></i> Admin Dashboard</h1>
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
        
        function showAlert (message)
        {
            $("#box-message .body").html(message);
            $("#box-message").show ();
            window.setTimeout(function () {$("#box-message").hide(100)}, 3000);
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

    <div class="row hide" id="box-message" style="position: fixed;top:0px;left:0px;z-index:1030;margin-bottom:0;">
        <div class="span4 offset4">
            <div style="background-color:rgb(235, 235, 40);height:30px;border:1px black solid; ">
                <p style="margin-top:5px;margin-left:20px;"><strong><span class="body"></span></strong></p>
            </div>
        </div>
    </div>
</body> 

</html>