<?php
$controller = $this->request->controller;
$action = $this->request->action;
?>
<header>
    <style>
    </style>
    <!--nav bar start-->
    <nav class="navbar">
        <div class="navbar-inner" style="border-radius:0px 0px 0px 0px;background-image:none;background-color:#313131;">
            <div class="container">
                <!--mobile nav icon (hidden:CSS)-->
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
                    menu
                </a><!--end btn-navbar-->
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="active">
                            <a href="<?php echo $this->Html->Url("/", true); ?>" style="background-color:#313131;">Home</a>
                        </li>
                        <li class="<?php
                        if ($controller == "case" && $action == "newcase")
                            echo "active";
                        ?>">
                            <a href="<?php echo $this->Html->Url("/design", false); ?>" style="border-radius: 0px 0px 0px 0px;background-color:#313131;color:orange">Design</a>
                        </li>
                    </ul>
                </div><!-- end nav-collapse -->
            </div><!-- end container-->
        </div><!-- end navbar-inner -->
    </nav><!--end nav bar-->
</header>