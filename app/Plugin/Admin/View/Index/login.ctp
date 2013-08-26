<?php
$admin_home = $base;
$admin_product = $base . "product";
?>
<div class="main-area dashboard">
    <div class="container">
        <div class="row">
            <div class="span8 offset2">
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
                                <label class="control-label" for="disabledInput">Captcha</label>
                                <div class="controls">
                                    <img id="captcha" src="<?php echo $this->webroot . 'admin/index/captcha'; ?>" alt="" /> 
                                <a href="javascript:void(0);" onclick="javascript:document.images.captcha.src = '<?php echo $this->webroot . 'admin/index/captcha'; ?>?' + Math.round(Math.random(0) * 1000) + 1">Reload image</a>
                                <br/>
                                <input type="text" name="signin[captcha]" />
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

                                    function save()
                                    {
                                        jQuery.ajax({
                                            url: "<?php echo $base; ?>index/login",
                                            data: $("#user-form").serialize(),
                                            type: "POST",
                                            beforeSend: function(xhr) {
                                                $("#btn-signup").button("loading");
                                            }
                                        }).done(function(data) {
                                            console.log(data);
                                            $("#btn-signup").button("reset");

                                            var result = $.parseJSON(data);
                                            if (result.error == 1) {

                                            } else {
                                                window.location.href = "";
                                            }
                                        }).fail(function() {
                                        });
                                    }
</script>