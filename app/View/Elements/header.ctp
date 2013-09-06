<?php
$controller = $this->request->controller;
$action = $this->request->action;
//print_r ($this->params);
$slug = null;
if (isset($this->params['slug'])) {
    $slug = $this->params['slug'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <!--begin head-->
    <head>
        <meta charset="utf-8">
        <title><?php echo $_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- set content to full screen on iphones -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="description" content="<?php echo $_description; ?>">
        <meta name="author" content="">
        <!--[if lte IE 6]>
            <link rel="stylesheet" href="//universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
        <![endif]-->
        <!--[if !lte IE 6]><!-->
        <!-- Load Google Web Font -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
        <!-- Load style.css: contains all css files concatenated to one single file -->
<?php echo $this->Html->css("style.css"); ?>
        <!-- link href="css/style.css" rel="stylesheet" -->
        <!--<![endif]-->
        <!-- Load HTMLShiv for IE9 HTML5 support -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->	
        <!-- Your Favoriate Icons -->
        <link rel="shortcut icon" href="<?php echo $this->webroot; ?>img/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->webroot; ?>ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->webroot; ?>ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->webroot; ?>ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo $this->webroot; ?>ico/apple-touch-icon-57-precomposed.png">
        <!--
                NOTE: All the javascripts have been moved to the bottom of the page to load the content faster.
        -->
        <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $this->webroot; ?>js/libs/jquery.min.js"><\/script>')</script>
    </head><!--end head-->

    <!--begin body-->
    <body>
        <header>
            <!--logo area start-->
            <div class="logo-area">
                <span id="logo"></span>
                <div class="sec_logo_phone">
                    <ul  id="user-nav" class="list-none">
<?php if (empty($_identity)) : ?>
                            <li><a id="btn-register" class="hd-txt" href='<?php echo $this->webroot; ?>signup'>Sign up</a></li>
                            <li><a class="hd-txt" href='<?php echo $this->webroot; ?>signin'>Sign in</a></li>
                            <li><a class="hd-txt" href='<?php echo $this->webroot; ?>user'>My Account</a></li>
<?php else: ?>
                            <li><a class="hd-txt" href='<?php echo $this->webroot; ?>user'><?php echo $_identity['name']; ?></a></li>
                            <li><a class="text-info" href='<?php echo $this->webroot; ?>logout'>Logout</a></li>
<?php endif; ?>
                        <li><a class="hd-txt" href="<?php echo $this->webroot; ?>shop/checkout" id="btn-my-cart">My Cart <span class="value" id="cart-indicator-value">(0)</span></a></li>
                        <li>&nbsp;&nbsp;</li>
                    </ul>
                    <div style="clear:both"></div>
                    <nav class="navbar">
                        <div class="navbar-inner" style="border-radius:0px 0px 0px 0px;background-image:none;background-color:#efefef;">
                            <div class="container">
                                <!--mobile nav icon (hidden:CSS)-->
                                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
                                    menu
                                </a><!--end btn-navbar-->
                                <div class="nav-collapse">
                                    <ul class="nav" id="top-navbar">
                                        <li class="<?php
                                        if ($controller == "index" && $action == "index")
                                            echo "active";
                                        ?>">
                                            <a href="<?php echo $this->Html->Url("/", true); ?>">Home</a>
                                        </li>
                                        <li class="<?php
                                        if ($controller == "creator" && $action == "index")
                                            echo "active";
                                        ?>">
                                            <a href="<?php echo $this->Html->Url("/create", false); ?>">Create</a>
                                        </li>
                                        <?php if (!empty($_home_menu)) : ?>
    <?php foreach ($_home_menu as $value) : ?>
                                                <li class="<?php if ($slug == $value['Category']['slug']) echo 'active'; ?>">
                                                    <a href="<?php echo $this->Html->Url("/category/{$value['Category']['slug']}", false); ?>"><?php echo $value['Category']['name']; ?></a>
                                                </li>
                                            <?php endforeach; ?>
<?php endif; ?>
                                    </ul>
                                </div><!-- end nav-collapse -->
                            </div><!-- end container-->
                        </div><!-- end navbar-inner -->
                    </nav>
                </div>    
                <div style="clear:both"></div>
                <div id="slogansearch" class="desktop">
                    <div id="slogan">Personalizing your life one item at time!</div>
                    <div id="search"><abbr title="Phone" id="call-phone">
                            <div class="searchwrapper">    
                                <form name="form1" action='<?php echo $this->webroot; ?>search/a'>
                                    <input type="text" name="search" id="search" onfocus="if (this.defaultValue == this.value)
                            this.value = '';" onblur="if ('' == this.value)
                    this.value = this.defaultValue;" value="Search inside the box">
                                    <input class="btn btn-mini btn-peach colwhite" type="button" name="Search" id="submit" value="Search" onclick='header_search();' onkeypress='header_search();' />
                                </form>
                            </div>    
                        </abbr></div>
                </div>
                <div style="clear:both"></div>
            </div><!--end logo area-->
            <!--nav bar start-->
            <!--end nav bar-->
        </header>
        <script type='text/javascript'>
                    function header_search()
                    {
                        var keywords = $("input[name=search]").val();

                        //console.log(keywords);

                        keywords = $.trim(keywords);
                        if (keywords == '') {
                            alert("Keywords are required.");
                            return;
                        }

                        jQuery.ajax({
                            url: "<?php echo $this->webroot; ?>search/" + keywords,
                            type: "GET",
                            beforeSend: function(xhr) {
                                //showAlert2("Loading category data now......");
                            }
                        }).done(function(data) {

                            var ret = $.parseJSON(data);
                            if (ret.error == 1) {
                            } else {
                                window.location.href = "<?php echo $this->webroot; ?>search/" + keywords;
                            }

                        }).fail(function() {
                            //hideAlert();
                        });
                    }
        </script>