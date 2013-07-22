<?php
$controller = $this->request->controller;
$action = $this->request->action;

?>
<header>
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
                        <li>
                            <a href="#">Membership</a>
                        </li>
                        <li class="active">
                            <a href="">Product</a>
                        </li>
                    </ul>
                </div><!-- end nav-collapse -->
            </div><!-- end container-->
        </div><!-- end navbar-inner -->
    </nav><!--end nav bar-->
</header>