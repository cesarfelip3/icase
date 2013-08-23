
<div class='row-fluid'>
    <div class='span8 offset3'>
        <form class="form-inline" style="margin-top:20px;" id="form-reset">
            <label>Your email : </label>
            <input type="text" class="input-large" placeholder="Registered Email" name="reset[email]">
            <a class="btn btn-info" onclick="reset_submit()" data-loading-text="Working..." id="btn-reset">Submit</a>
        </form>
        <p class='text-error' style='color:darkred'></p>
        <div style='margin-top:20px;padding:20px;' class='well hide'>
            
        </div>
    </div>
</div>
<script type="text/javascript">

    function reset_submit()
    {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>index/reset",
            data: $("#form-reset").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-reset").button("loading");
            }
        }).done(function(data) {
            $("#btn-reset").button("reset");

            var result = $.parseJSON(data);
            if (result.error == 1) {
                $(".text-error").html(result.message);
            } else {
                $(".well").html (result.message);
                $(".text-error").html("");
                $(".well").show();
            }
        }).fail(function() {
        });
     }
</script>