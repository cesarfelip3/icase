<?php
$admin_home = $base;
$admin_product = $base . "product";
?>
<div class="main-area dashboard">
    <div class="container">
        <div class="row">
            <div class="span6 offset3">
                <div class="slate">
                    <div class="page-header">
                        <h2>Login</h2>
                    </div>
                    <form class="form-horizontal" id="user-form" >
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" placeholder="Username/Email" name="signin[name]">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Password</label>
                                <div class="controls">
                                    <input class="input-xlarge disabled" id="disabledInput" type="password" placeholder="Password" name='signin[password]' >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput"></label>
                                <div class="controls">
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Working..." onclick="save();" id="btn-signup">Sign in</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(
            
    );
    
    function save ()
    {
        jQuery.ajax({
            url: "<?php echo $base; ?>admin/login",
            data: $("#user-form").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-signup").button("loading");
            }
        }).done(function(data) {
            console.log (data);
            $("#btn-signup").button("reset");
            
            var result = $.parseJSON(data);
            if (result.error == 1) {
                
            } else {
                window.location.href="<?php echo $base; ?>";
            }
        }).fail(function() {
        });
    }
</script>