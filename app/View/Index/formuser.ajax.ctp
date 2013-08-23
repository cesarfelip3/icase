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

    form#form-signin label {
        display:inline-block;
        width:90px;
        font-size:14px;
    }

    form#form-signin p {
        line-height: 20px;
        font-size: 14px
    }

</style>
<div class="row-fluid">
    <div class="span6" style="border-right:1px solid #333">
        <form id="form-signup" style="margin-top:20px;">
            <fieldset>
                <div>
                    <label>User</label>
                    <input type="text" class="input-medium"  name="signup[name]"/>
                </div>
                <div>
                    <label>Email</label>
                    <input type="text" class="input-medium" name='signup[email]' placeholder='email@example.com' />
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" class="input-medium" name='signup[password]' />
                </div>
                <p>
                    <a href='javascript:' class='btn btn-primary' data-loading-text="Working..." onclick="signup_submit();" id="btn-signup">Sign up</a>
                </p>
                <p class="text-error"></p>
            </fieldset>
        </form>
    </div>
    <div class="span6">
        <form id="form-signin" style="margin-top:20px;">
            <fieldset>
                <div>
                    <label>User/Email</label>
                    <input type="text" class="input-medium"  name="signin[name]"/>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" class="input-medium" name='signin[password]' />
                </div>
                <div style="visibility:hidden">
                    <label>Email</label>
                    <input type="text" class="input-medium" placeholder='email@example.com' />
                </div>
                <p style="height:30px;">
                    <a href='javascript:' class='btn btn-primary pull-right' data-loading-text="Working..." onclick="signin_submit();" id="btn-signip">Sign in</a>
                </p>
                <p class="text-error"></p>
            </fieldset>
        </form>
    </div>
</div>