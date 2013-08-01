<?php
$result = array ();

function categoryList ($data, $group)
{
    global $result;
    
    if (empty ($group)) {
        $result[$i] = $data;
    }
    
    if ($data['group_guid'] == $group) {
        
    }
}
?>
<style type="text/css">
    ul {
        margin-top:0px;
        margin-bottom:0px;
        padding:0px;
        list-style: none;
    }
    
    /* */
    ul.media-body-list {
        /*margin-top:5px;*/
    }

    ul.media-body-list li {
        margin:0px;
        padding:0px;
    }

    ul.media-body-list li a {
        margin:0px;
        padding:2px;
        display:block;
        width:100%;
        color:black;
        text-decoration: none;
        background-color:none;
    }

    ul.media-body-list li.active a {
        margin:0px;
        padding:2px;
        display:block;
        background-color:#2fa4e7;
        color:white;
    }

    ul.media-body-list li.active a:hover {
        /*margin:0px;*/
        padding:2px;
        display:block;
        background-color:#2fa4e7;
        color:white;
    }

    ul.media-body-list li a:hover {
        margin:0px;
        padding:2px;
        background-color:#e8e8d8;
    }
    
    ul.media-body-list li.level0 a {
        
    }
    
    ul.media-body-list li.level1 a {
        margin-left:15px;
    }
    
    ul.media-body-list li.level2 a {
        margin-left:35px;
    }
    
    ul.media-body-list li.level3 a {
        margin-left:55px;
    }
    
    ul.media-body-list li.level4 a {
        margin-left:75px;
    }
    
    ul.media-body-list li.level5 a {
        margin-left:95px;
    }
</style>
<div>
    <div class="alert" style="display:none">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <span id="alert-text"></span>
    </div>

    <div id="editor-accessory" class="row-fluid">

        <style>
            .test {
                background-color: hsla(80%, 0%, 100%, .5);
                height:400px;
                padding-left:0px;
                overflow:auto;
            }
        </style>
        <div class="span12 test">                        
            <ul class="media-list media-body-list">

                <?php
                if (!empty($data)) :
                    foreach ($data as $value) :
                        ?>
                        <li class="media level<?php echo $value['Category']['level']; ?>">
                            <a href="javascript:" data-guid="<?php echo $value['Category']['guid']; ?>" data-name="<?php echo $value['Category']['name']; ?>" data-order="<?php echo $value['Category']['order']; ?>" class="t<?php echo $value['Category']['parent_guid']; ?>"><?php if (isset($checkbox) && $checkbox) : ?><input type="checkbox" name="" value="" /><?php endif; ?> <?php echo $value['Category']['name']; ?><?php if ($value['Category']['children'] > 0 && false) : ?><i class="icon-chevron-down indicator-expension"></i><?php else: ?><?php endif; ?></a>
                            
                        </li>
                        <?php
                    endforeach;
                endif;
                ?>
                <!--                        
                                        <li><ul class="media-body media-body-list">
                                                <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                <li>
                                                    <a href="javascript:" data-guid="" data-name="aaa"><i class="icon-chevron-down indicator-expension"></i>aaa</span></a></li>
                                                <li>
                                                    <ul class="media-body media-body-list">                   
                                                        <li><a href="javascript:" data-guid="" data-name="abc">abc</a><input type="text" class="input-small" style="display:none;" value="abc" /></li>
                                                        <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                        <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                        <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                        <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                        <li><a href="javascript:" data-guid="" data-name="abc">abc</a></li>
                                                    </ul>   
                                                </li>
                                            </ul>
                                        </li>-->
            </ul>
        </div>
        <!-- explaination -->
        <!-- end of explaination -->
    </div>
    <script type="text/javascript">

        function init()
        {
            $('#myTab a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $(".indicator-expension").click(function(e) {
                var c = $(this).data('guid');
                //$(".t" + c).hide();
                if ($(this).hasClass("icon-chevron-up")) {
                    $(this).removeClass("icon-chevron-up");
                    $(this).addClass("icon-chevron-down");
                } else if ($(this).hasClass("icon-chevron-down")) {
                    $(this).removeClass("icon-chevron-down");
                    $(this).addClass("icon-chevron-up");
                }
            });

            $(".media-body-list a").click(function(e) {
                $(".media-body-list li").removeClass("active");
                $(this).parent().addClass("active");
                var name = $(this).data('name');
                var guid = $(this).data('guid');
                
                var order = $(this).data('order');

                $("input[name='category[parent_guid]']").val(guid);
                $("input[name='category[parent]']").val(name);
                
                $("input[name='category[edit][order]']").val(order);
                $("input[name='category[edit][name]']").val(name);
                $("input[name='category[edit][guid]']").val(guid);
            });

            $("#user-form a").click(function() {
                var action = $(this).data('action');
                switch (action) {
                    case "add":
                        break;
                    case "add-label":
                        break;
                    default:
                        break;
                }
            })
        }

        if (window.jQuery) {
            init();
        }
    </script>