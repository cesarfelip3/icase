<?php
$controller = $this->request->controller;
$action = $this->request->action;
//print_r ($this->params);

$slug = null;
if (isset ($this->params['slug'])) {
    $slug = $this->params['slug'];
}
?>
<footer>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12 ">
                <!-- Copyright info and links -->
                <div class="row-fluid">
                    <div class="span4">
                        <div>
                            <nav class="navbar">
                                <div style="border-radius:0px 0px 0px 0px;background-image:none;background-color:#efefef;" class="navbar-inner">
                                    <div class="container">
                                        <!--mobile nav icon (hidden:CSS)-->
                                        <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar"> 
                                            menu
                                        </a><!--end btn-navbar-->
                                        <div class="nav-collapse">
                                            <ul id="top-navbar" class="nav">
                                                <li class="<?php
                                                if ($controller == "creator" && $action == "index")
                                                    echo "active";
                                                ?>">
                                                    <a href="<?php echo $this->Html->Url("/create", false); ?>">Create</a>
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
                    </div>
                </div>
            </div>
            <div class="span12 contact-info">
                <span class="span9">beautahful creations<strong> Phone:</strong> 123 4567 890 • <a href="mailto:info@beautahfulcreations.com"> info@beautahfulcreations.com</a>
                </span>
                <ul class="span3 social-network">
                    <li><a href="javascript:void(0)"><i class="icon-linkedin-sign"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="icon-pinterest-sign"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="icon-twitter-sign"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="icon-facebook-sign"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="icon-google-plus-sign"></i></a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div><!-- end .row-fluid -->
    </div> <!-- end .container-fluid -->
</footer>
<!-- end footer -->