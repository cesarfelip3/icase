<?php
$controller = $this->request->controller;
$action = $this->request->action;
//print_r ($this->params);
$slug = null;
if (isset($this->params['slug'])) {
    $slug = $this->params['slug'];
}
?>
<header>
    <!--logo area start-->
    <div class="logo-area">
        <span id="logo"></span>
        <div class="sec_logo_phone">
            <span id="secondary-logo"></span>
            <ul  id="user-nav" class="list-none">
                <?php if (!isset($identity)) : ?>
                    <li><a id="btn-register" class="hd-txt" href='<?php echo $this->webroot; ?>signup'>Sign up</a></li>
                    <li><a class="hd-txt" href='<?php echo $this->webroot; ?>signin'>Sign in</a></li>
                <?php else: ?>
                    <li><a class="hd-txt" href='<?php echo $this->webroot; ?>user'><?php echo $identity['name']; ?></a></li>
                    <li><a class="hd-txt" href='<?php echo $this->webroot; ?>logout'>Logout</a></li>
                <?php endif; ?>
                <li><a class="hd-txt" href='<?php echo $this->webroot; ?>user'>My Account</a></li>
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
                                if ($controller == "case" && $action == "newcase")
                                    echo "active";
                                ?>">
                                    <a href="<?php echo $this->Html->Url("/design", false); ?>">Create</a>
                                </li>
                                <?php if (!empty($top_header)) : ?>
                                    <?php foreach ($top_header as $value) : ?>
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
            <div id="slogan">Custom Phone Cases</div>
            <div id="search"><abbr title="Phone" id="call-phone">
                    <div class="searchwrapper">    
                        <form name="form1" method="GET" action="/search">
                            <input type="text" name="search" id="search" onfocus="if (this.defaultValue == this.value)
                                    this.value = '';" onblur="if ('' == this.value)
                                    this.value = this.defaultValue;" value="Search inside the box">
                            <input class="btn btn-mini btn-peach colwhite" type="button" name="Search" id="submit" value="Search" onclick='header_search();'>
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
    function header_search ()
    {
        var keywords = $("input[name=search]").val();
        
        console.log (keywords);
        
        keywords = $.trim(keywords);
        if (keywords == '') {
            alert ("Keywords are required.");
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
                window.location.href="<?php echo $this->webroot;?>search/" + keywords;
            }

        }).fail(function() {
            //hideAlert();
        });
    }
</script>