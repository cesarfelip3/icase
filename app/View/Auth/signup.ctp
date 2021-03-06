<?php
$signup_url = $this->webroot . "signup";
$signin_url = $this->webroot . "signin";
$reset_url = $this->webroot . "auth/reset";
?>
<style type="text/css">
    form#form-signup label {
        display:inline-block;
        width:70px;
        font-size:14px;
    }

    form#form-signup p {
        line-height: 20px;
        font-size: 14px
    }

</style>
<div class="row-fluid">
    <div class="span7">
        <div class="qbox" style="background:transparent;box-shadow: none;border:none;">
            <h1 class='text-primary' style="text-transform:none;">Want to save your creations? Sign up Now!</h1>
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
            <div class="well" style="margin-top:20px;">
                <p style="font-size:14px;font-weight: normal;">We will send a link to verify your email address, so please enter a valid email address.</p>
            </div>
        </div>
    </div>
    <div class="span5">
        <div class="qbox" style="background:transparent;box-shadow: none;font-size:14px">
            <form id="form-signup" style="margin-top:20px;">
                <fieldset>
                    <p>
                        <label>User</label>
                        <input type="text" class="input-large"  name="signup[name]"/>
                    </p>
                    <p>
                        <label>Email</label>
                        <input type="text" class="input-large" name='signup[email]' placeholder='email@example.com' />
                    </p>
                    <p>
                        <label>Password</label>
                        <input type="password" class="input-large" name='signup[password]' />
                    </p>
                    <p>
                        <img id="captcha" src="<?php echo $this->webroot . 'auth/captcha'; ?>" alt="" /> 
                        <a tabindex="-1" href="javascript:void(0);" onclick="javascript:document.images.captcha.src = '<?php echo $this->webroot . 'auth/captcha'; ?>?' + Math.round(Math.random(0) * 1000) + 1" class="btn btn-info"><i class="icon-refresh"></i></a>
                    </p>
                    <p>
                        <input type="text" name="signup[captcha]" />
                    </p>
                    <p>
                        <a href='javascript:' class='btn btn-primary' data-loading-text="Working..." onclick="signup_submit();" id="btn-signup">Sign up</a>
                    </p>
                    <p>
                        <span>Already had account? Go </span>
                        <a href='<?php echo $signin_url; ?>'>Sign In Now</a>
                    </p>
                    <p class="text-error" style="color:darkred">

                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

                            function signup_submit()
                            {
                                jQuery.ajax({
                                    url: "<?php echo $signup_url; ?>",
                                    data: $("#form-signup").serialize(),
                                    type: "POST",
                                    beforeSend: function(xhr) {
                                        $("#btn-signup").button("loading");
                                    }
                                }).done(function(data) {
                                    $("#btn-signup").button("reset");

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