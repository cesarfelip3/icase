
<style type="text/css">
    form {
        background-color:#e0e1e3;
    }
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
<div style="background-color:#e0e1e3;">
    <ul id="myTab" class="nav nav-tabs" style="background-color:#e0e1e3;">
        <li class="active"><a href="#home" data-toggle="tab" style="background-color:#e0e1e3;">Login</a></li>
        <li><a href="#profile" data-toggle="tab" style="background-color:#e0e1e3;">Register</a></li>
    </ul>
    <div id="myTabContent" class="tab-content" style="background-color:#e0e1e3;border:none;">
        
        <div class="tab-pane fade in active" id="home">
            <form id="form-signin" style="margin-top:20px;">
                <fieldset>
                    <div>
                        <label>User/Email</label>
                        <input type="text" class="input-large"  name="signin[name]"/>
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" class="input-large" name='signin[password]' />
                    </div>
                    <p>
                        <img id="captcha" src="<?php echo $this->webroot . 'auth/captcha'; ?>" alt="" /> 
                        <a tabindex="-1" href="javascript:void(0);" onclick="javascript:document.images.captcha.src = '<?php echo $this->webroot . 'auth/captcha'; ?>?' + Math.round(Math.random(0) * 1000) + 1" class="btn btn-info"><i class="icon-refresh"></i></a>
                    </p>
                    <p>
                        <input type="text" name="signin[captcha]" />
                    </p>
                    <p style="height:30px;">
                        <a href='javascript:' class='btn btn-primary' data-loading-text="Working..." onclick="signin_submit();" id="btn-signip">Sign in</a>
                    </p>
                    <p class="text-error"></p>
                </fieldset>
            </form>
        </div>
        <div class="tab-pane fade" id="profile">
            <form id="form-signup" style="margin-top:20px;">
                <fieldset>
                    <div>
                        <label>User</label>
                        <input type="text" class="input-large"  name="signup[name]"/>
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="text" class="input-large" name='signup[email]' placeholder='email@example.com' />
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" class="input-large" name='signup[password]' />
                    </div>
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
                    <p class="text-error"></p>
                </fieldset>
            </form>
        </div>
    </div>
</div>