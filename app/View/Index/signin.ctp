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
            <h1 class='text-primary'>Best Offer Ever!</h1>
            <p>
                Slogan is here!!
            </p>
        </div>
    </div>
    <div class="span5">
        <div class="qbox" style="background:transparent;box-shadow: none;font-size:14px">
        <form id="user-form" style="margin-top:20px;">
            <fieldset>
                <p>
                    <label>User/Email</label>
                    <input type="text" class="input-large" name='User[name]' />
                </p>
                <p>
                    <label>Password</label>
                    <input type="password" class="input-large" name='User[password]' />
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
            window.href="<?php $this->webroot . "user/"; ?>";
        }).fail(function() {
        });
    }
</script>