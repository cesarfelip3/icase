<?php
$signup_url = $this->webroot . "signup";
$signin_url = $this->webroot . "signin";
$reset_url = $this->webroot . "auth/reset";
?>

<style type="text/css">
    form#form-signin label {
        display:inline-block;
        width:100px;
        font-size:14px;
    }

    form#form-signin p {
        line-height: 20px;
        font-size: 14px
    }

</style>
<div class="row-fluid">
    <div class="span7">
        <div class="qbox" style="background:transparent;box-shadow: none;border:none;">
            <h1 class='text-primary' style="text-transform:none;">Want to save your creations, Sign in Now!</h1>
            <div>
                <ul style="font-size:14px;">
                    <li>Your will have unlimited space to save your creator progress</li>
                    <li>Your will have unlimited space to save your final creations and download it</li>
                    <li>Faster checkout without enter deliver message twice</li>
                    <li>Get your order status immediately</li>
                    <li>Change your email as you want</li>
                    <li>More advantages from our upgrades</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="span5">
        <div class="qbox" style="background:transparent;box-shadow: none;font-size:14px">
            <form id="form-signin" style="margin-top:20px;">
                <fieldset>
                    <p>
                        <label>User/Email</label>
                        <input type="text" class="input-large" name='signin[name]' />
                    </p>
                    <p>
                        <label>Password</label>
                        <input type="password" class="input-large" name='signin[password]' />
                    </p>
                    <p>
                        <img id="captcha" src="<?php echo $this->webroot . 'auth/captcha'; ?>" alt="" /> 
                        <a tabindex="-1" href="javascript:void(0);" onclick="javascript:document.images.captcha.src = '<?php echo $this->webroot . 'auth/captcha'; ?>?' + Math.round(Math.random(0) * 1000) + 1" class="btn btn-info"><i class="icon-refresh"></i></a>
                    </p>
                    <p>
                        <input type="text" name="signin[captcha]" />
                    </p>
                    <p>
                        <a href='javascript:' class='btn btn-primary' data-loading-text="Working..." onclick="signin_submit();" id="btn-signin" >Sign in</a>
                    </p>
                    <p>
                        <a href='<?php echo $reset_url; ?>'><span>Forget Password?</span></a>
                    </p>
                    <p>
                        <span>Don't have account yet?</span>
                        <a href='<?php echo $signup_url; ?>'>Sign Up Now</a>
                    </p>
                    <p class="text-error" style="color:darkred">

                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

                        function signin_submit()
                        {
                            jQuery.ajax({
                                url: "<?php echo $signin_url; ?>",
                                data: $("#form-signin").serialize(),
                                type: "POST",
                                beforeSend: function(xhr) {
                                    $("#btn-signin").button("loading");
                                }
                            }).done(function(data) {
                                console.log(data);
                                $("#btn-signin").button("reset");

                                var result = $.parseJSON(data);
                                if (result.error == 1) {
                                    $(".text-error").html(result.message);
                                } else {
                                    window.location.href = "<?php $this->webroot . "user/"; ?>";
                                }
                            }).fail(function() {
                            });
                        }
</script>