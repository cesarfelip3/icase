<?php
 $controller = $this->request->controller;
 $action = $this->request->action;

?>
<header>
    <!--logo area start-->
    <div class="logo-area">

<span id="logo"><img src="img/iCase-png.png" alt="iCase"></span>
    
<div class="sec_logo_phone">
<span id="secondary-logo"></span>
<abbr title="Phone" id="call-phone">1-800-45-PEACH</abbr>

<div style="clear:both"></div>
<ul  id="user-nav" class="list-none">
<li><a id="btn-register" class="hd-txt" href="#">Register</a></li>
<li><a class="hd-txt" href="#">Sign in</a></li>
<li><a class="hd-txt" href="#">My Account</a></li>
<li><a class="hd-txt" href="#">My Cart (0)</a></li>
<li>
<button class="btn btn-mini btn-peach colwhite"><a class="hd-txt" href="#">Checkout</a></button>
</li>
</ul>
</div>    

    <div style="clear:both"></div>



                
            </div><!--end logo area-->

    <!--nav bar start-->
    <nav class="navbar">.
        <div class="navbar-inner">
            <div class="container">
                <!--mobile nav icon (hidden:CSS)-->
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
                    menu
                </a><!--end btn-navbar-->
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="<?php if ($controller == "pages" && $action == "display") echo "active"; ?>">
                            <a href="<?php echo $this->Html->Url ("/", true); ?>">Home</a>
                        </li>
                        <li class="<?php if ($controller == "case" && $action == "newcase") echo "active"; ?>">
                            <a href="<?php echo $this->Html->Url ("/createcase", false); ?>">Create your case</a>
                        </li>
                    </ul>
                    <ul class="nav pull-right">
                        <li>
                            <a href="javascript:" onclick="cart_reload();">My Cart</a>
                        </li>
                    </ul>
                </div><!-- end nav-collapse -->
            </div><!-- end container-->
        </div><!-- end navbar-inner -->
    </nav><!--end nav bar-->
</header>