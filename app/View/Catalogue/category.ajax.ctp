
<style type="text/css">
    ul.media-list {
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
        color:orangered;
        text-decoration: none;
        background-color:none;
        text-transform:uppercase
    }

    ul.media-body-list li.active a {
        margin:0px;
        padding:2px;
        display:block;
        background-color:#2fa4e7;
        color:white;
        text-transform:uppercase
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
<h3 style="border-bottom:1px solid #ccc">Categories</h3>
<ul class="media-list media-body-list">
    <?php
    if (!empty($data)) :
        foreach ($data as $value) :
            ?>
            <li class="media level<?php echo $value['Category']['level']; ?> <?php if (isset($value['Category']['_active'])) echo 'active'; ?>">
                <a href="<?php echo $this->webroot; ?>category/<?php echo $value['Category']['slug']; ?>" data-guid="<?php echo $value['Category']['guid']; ?>" data-name="<?php echo $value['Category']['name']; ?>" data-order="<?php echo $value['Category']['order']; ?>" class="t<?php echo $value['Category']['parent_guid']; ?>"> <?php echo $value['Category']['name']; ?><?php if ($value['Category']['children'] > 0 && false) : ?><i class="icon-chevron-down indicator-expension"></i><?php else: ?><?php endif; ?></a>

            </li>
            <?php
        endforeach;
    endif;
    ?>

</div>