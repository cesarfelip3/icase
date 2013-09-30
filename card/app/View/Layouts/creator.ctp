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
        
        <link rel='stylesheet' href='<?php echo $this->webroot; ?>js/spectrum/spectrum.css' />
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/main.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/sky-forms.css" />
        <style type="text/css">
        	body {
        		padding-top:60px;
        		background-color:#333;
        	}
        </style>
        <script src="<?php echo $this->webroot; ?>js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $this->webroot; ?>js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

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
        
		<?php echo $this->fetch('content'); ?>
		
		
        
        <script src="<?php echo $this->webroot; ?>js/vendor/bootstrap.min.js"></script>

        <script src="<?php echo $this->webroot; ?>js/plugins.js"></script>
        <script src="<?php echo $this->webroot; ?>js/main.js"></script>
        

    </body>
</html>


