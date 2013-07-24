<?php
 $controller = $this->request->controller;
 $action = $this->request->action;

?>
<header>
    <!--logo area start-->
    <div class="logo-area">
        <span id="logo"></span>
        <span id="secondary-logo"></span>
        <abbr title="Phone" id="call-phone">1-800-45-ICASE</abbr>
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