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
                        <label>Email</label>
                        <input type="text" class="input-large" placeholder='email@example.com' />
                    </p>
                    <p>
                        <label>Password</label>
                        <input type="password" class="input-large" />
                    </p>
                    <p>
                        <button class="btn btn-success">Sign Up</button>
                    </p>
                    <p>
                        <span>Already had account? Go </span>
                        <a href='<?php echo $this->webroot; ?>index/login'>Sign In Now</a>
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(
            function() {
                jQuery.ajax({
                    url: "<?php echo $this->webroot; ?>index/register",
                    type: "GET",
                    beforeSend: function(xhr) {
                    }
                }).done(function(data) {
                    alert (data);

                }).fail(function() {
                });
            }
    );
</script>