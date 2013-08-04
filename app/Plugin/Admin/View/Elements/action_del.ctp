<script>
    function del (id) {
        var r=confirm("<?php echo $message; ?>")
        if (r==true)
        {
            
        }
        else
        {
            return;
        }
        jQuery.ajax({
            url: "<?php echo $actionUrl;  ?>?id=" + id,
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            $("<?php echo $form; ?>").submit ();
        }).fail(function() {
        });
    }
</script>