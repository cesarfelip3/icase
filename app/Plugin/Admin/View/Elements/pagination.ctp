
<div class="pagination pull-left">
    <ul>
        <li><a href="javascript:" data-page="<?php echo $page - 1; ?>">Prev</a></li>
        <?php
        $j = 0;
        for (; $j < $pages; ++$j) :
            ?>
            <li <?php if ($j == $page) : echo 'class="active"';
        endif;
            ?>>
                <a href="javascript:" data-page="<?php echo $j; ?>"><?php echo $j + 1; ?></a>
            </li>
        <?php endfor;
        ?>
        <li><a href="javascript:" data-page="<?php echo $page + 1; ?>">Next</a></li>
    </ul>
</div>
<script type="text/javascript">
    $(document).ready 
    (
        function () 
        {
            $(".pagination a").click (
                function () {
                    var page = $(this).data('page');
                    $('input[name=page]').val (page);
                    $("<?php echo $form; ?>").submit();
                });
        }
    );
</script>
