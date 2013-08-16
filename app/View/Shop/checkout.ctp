
<style>
    form.info label {
        width:80px;
        display:inline-block;
    }

    form.info input {
        display:inline;
    }
</style>
<?php if (!isset($paid)) : ?>
    <form id="form-payment" class="info" action="<?php echo $this->webroot; ?>shop/checkout/?action=<?php echo $action; ?>" method="post">
        <div class="row-fluid" id="box-cart">
            <div class="ajax-loading-indicator" style="margin:10px;"><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading orders....</a></div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="qbox" id="box-bill-details">
                    <h1 style="height:30px;border-bottom:2px solid white;">Shippment<span style="font-size:12px;font-weight:normal;text-transform: none;color:red;float:right;">All fields are required</span></h1>
                    <p>
                        <label>First Name</label>
                        <input type="text" class="input-medium" name="deliver[firstname]" />
                        <span class="text-warning" style="text-shadow:none;"></span>
                    </p>
                    <p>
                        <label>Last Name</label>
                        <input type="text" class="input-medium" name="deliver[lastname]" />
                    </p>
                    <p>
                        <label>Email</label>
                        <input type="text" class="input-large" name="deliver[email]" />
                        <span class="help-inline"></span>
                    </p> 
                    <p>
                        <label>Address</label>
                        <textarea name="deliver[address]" style="width:400px"></textarea>
                    </p>
                    <p>
                        <label>Phone</label>
                        <input type="text" class="input-medium" name="deliver[phone]" />
                    </p>
                    <p>
                        <label>Country</label>
                        <select name="deliver[country]">
                            <option value="US">United State</option>
                        </select>
                    </p>
                    <p>
                        <label>State</label>
                        <select name="deliver[state]">
                            <option value="Utah">Utah</option>
                        </select>
                    </p>
                    <p>
                        <label>City</label>
                        <input type="text" placeholder="City" name="deliver[city]" />
                    </p>
                    <p>
                        <label>Zip Code</label>
                        <input type="text" class="input-small" name="deliver[zipcode]" />
                    </p>   
                </div>
            </div>
            <div class="span6">
                <div class="qbox">
                    <h1 style="height:30px;border-bottom:2px solid white;">Billing<span style="font-size:12px;font-weight:normal;text-transform: none;color:red;float:right;">All fields are required</span></h1>
                    <div id="payment-stripe">
                        <p>
                            <label>Name</label>
                            <input type="text" class="input-large" name="bill[name]" placeholder='' />
                        </p>
                        <p>
                            <label>Number</label>
                            <input type="text" class="input-large" name="bill[cc_number]" placeholder='Credit Card Number' />
                        </p>
                        <p>
                            <label>Expired</label>
                            <input type="text" class="input-large datepicker" readonly="readonly" name="bill[cc_expired]" placeholder='Credit Card Expire Date'/>
                        </p> 
                        <p>
                            <label>Address</label>
                            <textarea name="bill[address]" style="width:400px"></textarea>
                        </p>
                        <p>
                            <label>Country</label>
                            <select name="bill[country]">
                                <option value="US">United State</option>
                            </select>
                        </p>
                        <p>
                            <label>State</label>
                            <select name="bill[state]">
                                <option value="Utah">Utah</option>
                            </select>
                        </p>
                        <p>
                            <label>City</label>
                            <input type="text" placeholder="City" name="bill[city]" />
                        </p>
                    </div>
                </div>
                <?php if (isset($identity)) : ?>
                    <div class="qbox">
                        <h1 style="height:30px;border-bottom:2px solid white;">Your Account <span class="text-warning">to save your design</span></h1>
                        <div id="payment-stripe">
                            <p>
                                <label>User</label>
                                <label style="width:auto;"><?php echo $identity['name']; ?></label>
                            </p>
                            <p>
                                <label>Email</label>
                                <label style="width:auto;"><?php echo $identity['email']; ?></label>
                            </p>
                            <p>
                                <a class="btn btn-primary" href="javascript:" onclick="logout();">Logout</a>
                            </p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="qbox" id='box-signin'>
                        <h1 style="height:30px;border-bottom:2px solid white;">Sign In <span class="text-warning">to save your design</span></h1>
                        <div id="payment-stripe">
                            <p>
                                <label>User/Email</label>
                                <input type="text" class="input-large" name="signin[name]" />
                            </p>
                            <p>
                                <label>Password</label>
                                <input type="password" class="input-large" name="signin[password]"/>
                            </p>
                            <p>
                                <a class="btn btn-primary" href="javascript:" onclick="login()">Sign in</a>
                            </p>
                            <p>
                                <span>Don't have account yet?</span><a href='javascript:' id='btn-signup'> Sign up Now</a>
                            </p>
                        </div>
                    </div>
                    <div class="qbox" id='box-signup' style='display:none'>
                        <h1 style="height:30px;border-bottom:2px solid white;">Sign Up</h1>
                        <div id="payment-stripe">
                            <p>
                                <label>User</label>
                                <input type="text" class="input-large" name="signup[name]" />
                            </p>
                            <p>
                                <label>Email</label>
                                <input type="text" class="input-large" name="signup[email]"/>
                            </p>
                            <p>
                                <label>Password</label>
                                <input type="text" class="input-large" name="signup[password]"/>
                            </p>
                            <p>
                                <a class="btn btn-primary" href="javascript:" onclick="signup()">Sign up</a>
                            </p>
                            <p>
                                <span>Already have account...</span><a href='javascript:' id='btn-signin'> Sign in Now</a>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>           
        </div>
    </form>

    <script type="text/javascript">
                                jQuery(document).ready(
                                        function() {
                                            checkout_cart();
                                            $("#btn-signup").click(
                                                    function() {
                                                        $("#box-signup").show();
                                                        $("#box-signin").hide();
                                                    });

                                            $("#btn-signin").click(
                                                    function() {
                                                        $("#box-signup").hide();
                                                        $("#box-signin").show();
                                                    });

                                            jQuery(".datepicker").datepicker({format: 'mm/yy'});
                                        }
                                )

                                function checkout_single() {
                                    cart_reload('single');
                                }

                                function checkout_cart() {
                                    cart_reload('cart');
                                }

                                function cart_config() {

                                    jQuery("#box-cart a").off('click');
                                    jQuery("#box-cart a").click(
                                            function() {
                                                var action = $(this).data('action');
                                                var guid = $(this).data('guid');
                                                var file = $(this).data('file');
                                                var i = 0;
                                                var price = 0;

                                                switch (action) {
                                                    case 'close':
                                                        jQuery("#box-cart").hide(0);
                                                        break;
                                                    case 'plus' :
                                                        i = jQuery(this).next().text();
                                                        console.log(i);
                                                        i = parseInt(jQuery.trim(i));
                                                        i++;
                                                        jQuery(this).next().text(i);
                                                        if (file == "") {
                                                            guid = guid;
                                                        } else {
                                                            guid = guid + "-" + file;
                                                        }
                                                        $.shoppingcart.set(guid);
                                                        price = $(this).data('price');
                                                        price = parseFloat(price) * i;
                                                        $(this).parent().prev().text(price.toFixed(2));
                                                        break;
                                                    case 'minus' :
                                                        i = jQuery(this).prev().text();
                                                        console.log(i);
                                                        i = parseInt(jQuery.trim(i));
                                                        i--;
                                                        if (i <= 0) {
                                                            $.shoppingcart.removeall(guid);
                                                            cart_reload();
                                                            break;
                                                        }
                                                        jQuery(this).prev().text(i);
                                                        if (file == "") {
                                                            guid = guid;
                                                        } else {
                                                            guid = guid + "-" + file;
                                                        }
                                                        $.shoppingcart.remove(guid);
                                                        price = $(this).data('price');
                                                        price = parseFloat(price) * i;
                                                        $(this).parent().prev().text(price.toFixed(2));
                                                        break;
                                                    case 'remove' :
                                                        if (file == "") {
                                                            guid = guid;
                                                        } else {
                                                            guid = guid + "-" + file;
                                                        }
                                                        $.shoppingcart.removeall(guid);
                                                        cart_reload();
                                                        break;
                                                }
                                            }
                                    );
                                }

                                function cart_reload(single) {

                                    jQuery.ajax({
                                        url: "<?php echo $this->webroot; ?>shop/cart/?action=" + single,
                                        data: {"user": $.shoppingcart.getuuid()},
                                        type: "POST",
                                        beforeSend: function(xhr) {
                                        }
                                    }).done(function(data) {
                                        $("#box-cart").html(data);
                                        $("#box-cart").show();

                                        var hasorder = $("input[name=hasorder]").val();
                                        if (hasorder == "1") {
                                            $("#box-bill-details").html($("#box-bill-details").html() + '<p><a class="btn btn-peach" onclick="javascript:cart_pay()">Pay Now</a></p>');
                                        }

                                        cart_config();

                                    }).fail(function() {

                                    });
                                }

                                function cart_pay()
                                {
                                    jQuery.ajax({
                                        url: "<?php echo $this->webroot; ?>shop/checkout/?action=payment",
                                        data: $("#form-payment").serialize(),
                                        type: "POST",
                                        beforeSend: function(xhr) {
                                            showAlert2("Working....");
                                        }
                                    }).done(function(data) {

                                        var result = $.parseJSON(data);
                                        if (result.error == 1) {
                                            showAlert(result.message);
                                        } else {
                                            $("#form-payment").submit();
                                        }

                                    }).fail(function() {
                                        hideAlert();
                                    });
                                }

                                //===================================
                                function login()
                                {
                                    jQuery.ajax({
                                        url: "<?php echo $this->webroot; ?>signin/",
                                        data: $("#form-payment").serialize(),
                                        type: "POST",
                                        beforeSend: function(xhr) {
                                            showAlert2("Working....");
                                        }
                                    }).done(function(data) {

                                        var result = $.parseJSON(data);
                                        if (result.error == 1) {
                                            showAlert(result.message);
                                        } else {
                                            window.location.href = "";
                                        }

                                    }).fail(function() {
                                        hideAlert();
                                    });
                                }

                                function signup()
                                {
                                    jQuery.ajax({
                                        url: "<?php echo $this->webroot; ?>signup/",
                                        data: $("#form-payment").serialize(),
                                        type: "POST",
                                        beforeSend: function(xhr) {
                                            showAlert2("Working....");
                                        }
                                    }).done(function(data) {

                                        var result = $.parseJSON(data);
                                        if (result.error == 1) {
                                            showAlert(result.message);
                                        } else {
                                            window.location.href = "";
                                        }

                                    }).fail(function() {
                                        hideAlert();
                                    });
                                }

                                function logout()
                                {
                                    jQuery.ajax({
                                        url: "<?php echo $this->webroot; ?>logout/",
                                        type: "GET",
                                        beforeSend: function(xhr) {
                                            showAlert2("Working....");
                                        }
                                    }).done(function(data) {

                                        var result = $.parseJSON(data);
                                        if (result.error == 1) {
                                            showAlert(result.message);
                                        } else {
                                            window.location.href = "";
                                        }

                                    }).fail(function() {
                                        hideAlert();
                                    });
                                }
    </script>
<?php else: ?>
    <div class="row-fluid">
        <div class="span12">
            <div class="qbox">
                <h1 style="height:30px;border-bottom:2px solid white;">My Cart</h1>
                <p>Your order is successfully paid.</p>
            </div>
        </div>
    </div>

    <script>
        $.shoppingcart.clear();
    </script>
<?php endif; ?>

