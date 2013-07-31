<style type="text/css">
    ul {
        margin-top:0px;
        margin-bottom:0px;
        padding:0px;
        list-style: none;
    }

    ul#media-group-list {
        margin-top:5px;
    }

    ul#media-group-list li {
        padding:0px;
        margin:0px;
    }

    ul#media-group-list li a {
        margin:0px;
        padding:2px;
        display:block;
        width:100%;
        color:black;
        text-decoration: none;
        background-color:none;
    }

    ul#media-group-list li.active a {
        margin:0px;
        padding:2px;
        display:block;
        background-color:#2fa4e7;
        color:white;
    }

    ul#media-group-list li.active a:hover {
        margin:0px;
        padding:2px;
        display:block;
        background-color:#2fa4e7;
        color:white;
    }

    ul#media-group-list li a:hover {
        margin:0px;
        padding:2px;
        display:block;
        background-color:#e8e8d8;
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
        margin:0px;
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
</style>
<div>
    <div class="alert" style="display:none">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <span id="alert-text"></span>
    </div>

    <form id="user-form" action="" method="post">
        <fieldset>
            <div id="editor-accessory" class="row-fluid">

                <style>
                    .test {
                        background-color: hsla(80%, 0%, 100%, .5);
                        height:300px;
                        padding-left:0px;
                        overflow:auto;
                    }
                </style>
                <div class="span12 test">                        
                    <ul class="media-list media-body-list">
                        <li class="media">
                            <a href="javascript:" data-guid="" data-name="aaa"><i class="icon-chevron-down indicator-expension"></i>aaa</a>
                        </li>
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
                        </li>
                    </ul>
                </div>
        </fieldset>
    </form>
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
            $(this).parent().parent().next().children(":first-child").toggle();
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

            $("input[name='group[group_parent]']").val(name);
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