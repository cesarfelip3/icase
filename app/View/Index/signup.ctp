<style type="text/css">
    form#user-form label {
        display:inline-block;
        width:70px;
        font-size:14px;
    }

    form#user-form p {
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
            <form id="user-form" style="margin-top:20px;">
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
                        <a href='javascript:' class='btn btn-primary' data-loading-text="Working..." onclick="save();" id="btn-signup">Sign up</a>
                    </p>
                    <p>
                        <span>Already had account? Go </span>
                        <a href='<?php echo $this->webroot; ?>signin'>Sign In Now</a>
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(
            
    );
    
    function save ()
    {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>index/signup",
            data: $("#user-form").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-signup").button("loading");
            }
        }).done(function(data) {
            $("#btn-signup").button("reset");
            
            var result = $.parseJSON(data);
            if (result.error == 1) {
                
            } else {
                window.location.href="<?php $this->webroot . "user/"; ?>";
            }
        }).fail(function() {
        });
    }
</script>