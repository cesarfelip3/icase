<script>
    function save(action) {

        CKEDITOR.instances.editor1.updateElement();
        jQuery.ajax({
            url: "<?php echo $actionUrl; ?>?action=" + action,
            data: $("<?php echo $form; ?>").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("<?php echo $button; ?>").button('loading');
            }
        }).done(function(data) {
            $("<?php echo $button; ?>").button('reset');

            var result = $.parseJSON(data);
            if (result.error == 1) {
                //console.log(result.element);
                $(result.element).next(".help-inline").html(result.message);
                $(result.element).parent().parent().addClass('error');
                showAlert(result.message);
            } else {
                if (action == 'create') {
                    $("input[name='product[guid]'").val(result.data);
                }
                $(result.element).parent().parent().removeClass('error');
                $(result.element).next(".help-inline").html("");
            }

        }).fail(function() {
        });
    }
</script>
