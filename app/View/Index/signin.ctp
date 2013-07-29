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
                    <label>User</label>
                    <input type="text" class="input-large" />
                </p>
                <p>
                    <label>Password</label>
                    <input type="text" class="input-large" />
                </p>
                <p>
                    <button class="btn btn-success">Sign In</button>
                </p>
                <p>
                    <a href='<?php echo $this->webroot; ?>index/reset'><span>Forget Password?</span></a>
                </p>
                <p>
                    <span>Don't have account yet?</span>
                    <a href='<?php echo $this->webroot; ?>index/register'>Sign Up Now</a>
                </p>
            </fieldset>
        </form>
        </div>
    </div>
</div>