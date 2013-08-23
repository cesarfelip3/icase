<style type="text/css">
    form#user-form label {
        display:inline-block;
        width:100px;
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
        <form id="user-form" style="margin-top:20px;">
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
                    <a href='javascript:' class='btn btn-primary' data-loading-text="Working..." onclick="save();" id="btn-signup">Sign in</a>
                </p>
                <p>
                    <a href='<?php echo $this->webroot; ?>index/reset'><span>Forget Password?</span></a>
                </p>
                <p>
                    <span>Don't have account yet?</span>
                    <a href='<?php echo $this->webroot; ?>signup'>Sign Up Now</a>
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
            url: "<?php echo $this->webroot; ?>index/signin",
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
                window.location.href="<?php $this->webroot . "user/"; ?>";
            }
        }).fail(function() {
        });
    }
</script>