<?php ?>
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

<ul class="media-list media-body-list" style='margin:0px;'>
<?php
if (!empty($data)) :
    foreach ($data as $value) :
        ?>
            <li class="media level<?php echo $value['Industry']['level']; ?>">
                <a href="javascript:" 
                   data-id="<?php echo $value['Industry']['id']; ?>" 
                   data-guid="<?php echo $value['Industry']['guid']; ?>"
                   data-group-guid='<?php echo $value['Industry']['group_guid']; ?>'
                   data-parent-guid='<?php echo $value['Industry']['parent_guid']; ?>'
                   data-level='<?php echo $value['Industry']['level']; ?>'
                   data-name="<?php echo addslashes($value['Industry']['name']); ?>" 
                   data-order="<?php echo $value['Industry']['order']; ?>" 
                   data-slug="<?php echo addslashes($value['Industry']['slug']); ?>"
                   data-seo-keywords="<?php echo addslashes($value['Industry']['seo_keywords']); ?>"
                   data-seo-description="<?php echo addslashes($value['Industry']['seo_description']); ?>"
                   class="t<?php echo $value['Industry']['parent_guid']; ?>">
        <?php if (isset($checkbox) && $checkbox) : ?><input type="checkbox" name="industry[]" value="<?php echo $value['Industry']['guid']; ?>" <?php if (isset($value['Industry']['selected']) && $value['Industry']['selected']) echo 'checked="checked"'; ?> /><?php endif; ?> 
                    <?php echo $value['Industry']['name']; ?>
                </a>

            </li>
        <?php
    endforeach;
endif;
?>
</ul>
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
            var slug = $(this).data('slug');
            var keywords = $(this).data('seo-keywords');
            var meta = $(this).data('seo-meta');
            var description = $(this).data('seo-description');
            var order = $(this).data('order');
            var id = $(this).data('id');
            var group_guid = $(this).data('group-guid');
            var parent_guid = $(this).data('parent-guid');
            var level = $(this).data('level');

            $("#form-edit input[name='industry[id]']").val(id);
            $("#form-edit input[name='industry[guid]']").val(guid);
            $("#form-edit input[name='industry[name]']").val(name);
            $("#form-edit input[name='industry[slug]']").val(slug);
            $("#form-edit input[name='industry[group_guid]']").val(group_guid);
            $("#form-edit input[name='industry[parent_guid]']").val(parent_guid);
            $("#form-edit input[name='industry[level]']").val(level);
            $("#form-edit input[name='industry[seo_keywords]']").val(keywords);
            $("#form-edit textarea[name='industry[seo_description]']").val(description);
            $("#form-edit input[name='industry[order]']").val(order);

            //
            if ($("#box-new").is(":visible")) {
                //$("#form-new input[name='industry[parent_guid]']").val(guid);
                //$("#form-new input[name='industry[parent]']").val(name);
                //$("#box-new").hide ();
                //$("#box-edit").show ();
            }

            if ($("#box-edit").is(":visible")) {
                //$("#form-new input[name='industry[parent_guid]']").val(guid);
                //$("#form-new input[name='industry[parent]']").val(name);
            }
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
<?php if (!isset($checkbox)) : ?>
            init();
<?php endif; ?>
    }
</script>