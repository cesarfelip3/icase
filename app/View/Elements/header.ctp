<?php
$controller = $this->request->controller;
$action = $this->request->action;
?>
<header>
    <!--logo area start-->
    <div class="logo-area">
        <span id="logo"></span>
        <div class="sec_logo_phone">
            <span id="secondary-logo"></span>
            <ul  id="user-nav" class="list-none">
                <?php if (!isset ($_auth)) : ?>
                <li><a id="btn-register" class="hd-txt" href='<?php echo $this->webroot; ?>signup'>Sign up</a></li>
                <li><a class="hd-txt" href='<?php echo $this->webroot; ?>signin'>Sign in</a></li>
                <?php else: ?>
                <li><a class="hd-txt" href='<?php echo $this->webroot; ?>user'><?php echo $_auth['name']; ?></a></li>
                <li><a class="hd-txt" href='<?php echo $this->webroot; ?>logout'>Logout</a></li>
                <?php endif; ?>
                <li><a class="hd-txt" href='<?php echo $this->webroot; ?>user'>My Account</a></li>
                <li><a class="hd-txt" href="#" id="btn-my-cart">My Cart <span class="value">(0)</span></a></li>
            </ul>
            <div style="clear:both"></div>
            <abbr title="Phone" id="call-phone">
                <div class="searchwrapper">    
                    <form name="form1" method="post" action="">
                        <input type="text" name="search" id="search" onfocus="if (this.defaultValue == this.value)
                                    this.value = '';" onblur="if ('' == this.value)
                                    this.value = this.defaultValue;" value="Search inside the box">
                        <input class="btn btn-mini btn-peach colwhite" type="submit" name="Search" id="submit" value="Search">
                    </form>
                </div>    
            </abbr>
        </div>    
        <div style="clear:both"></div>
    </div><!--end logo area-->
    <!--nav bar start-->
    <nav class="navbar">
        <div class="navbar-inner" style="border-radius:0px 0px 0px 0px;background-image:none;background-color:#efefef;">
            <div class="container">
                <!--mobile nav icon (hidden:CSS)-->
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
                    menu
                </a><!--end btn-navbar-->
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="<?php
                        if ($controller == "index" && $action == "index")
                            echo "active";
                        ?>">
                            <a href="<?php echo $this->Html->Url("/", true); ?>">Home</a>
                        </li>
                        <li class="<?php
                        if ($controller == "case" && $action == "newcase")
                            echo "active";
                        ?>">
                            <a href="<?php echo $this->Html->Url("/design", false); ?>">Design</a>
                        </li>
                    </ul>
                </div><!-- end nav-collapse -->
            </div><!-- end container-->
        </div><!-- end navbar-inner -->
    </nav><!--end nav bar-->
</header>