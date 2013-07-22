<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html lang="en">
    <!--begin head-->
    <head>
        <meta charset="utf-8">
        <title>iCase App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- set content to full screen on iphones -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="description" content="">
        <meta name="author" content="">

        <!--[if lte IE 6]>
            <link rel="stylesheet" href="//universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
        <![endif]-->

        <!--[if !lte IE 6]><!-->
        <!-- Load Google Web Font -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
        <!-- Load style.css: contains all css files concatenated to one single file -->
        <?php echo $this->Html->css ("style.css"); ?>
        <!-- link href="css/style.css" rel="stylesheet" -->
        <!--<![endif]-->

        <!-- Load HTMLShiv for IE9 HTML5 support -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->	

        <!-- Your Favoriate Icons -->
        <link rel="shortcut icon" href="ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">

        <!--
                NOTE: All the javascripts have been moved to the bottom of the page to load the content faster.
        -->
        <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

        
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $this->webroot; ?>js/libs/jquery.min.js"><\/script>')</script>

    </head><!--end head-->


    <!--begin body-->
    <body>
        <?php echo $this->element('header') ?>	
        <section id="main">
            <?php echo $this->fetch('content'); ?>
        </section>	
        <?php echo $this->element('footer') ?>
        <?php echo $this->element('js') ?>
    </body>

</html>
