
<style>
    form.info label {
        width:80px;
        display:inline-block;
    }

    form.info input {
        display:inline;
    }

    .qbox {
        background-color:white;
    }
</style>
<?php if (!isset($paid)) : ?>
    <form id="form-payment" class="info" action="<?php echo $this->webroot; ?>shop/checkout/?action=<?php echo $action; ?>" method="post">
        <div class="row-fluid checkout" id="box-cart">
            <div class="ajax-loading-indicator" style="margin:10px;"><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading orders....</a></div>
        </div>
        <div class="row-fluid checkout">
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
                            <option value="" selected="selected">Select a State</option> 
                            <option value="AL">Alabama</option> 
                            <option value="AK">Alaska</option> 
                            <option value="AZ">Arizona</option> 
                            <option value="AR">Arkansas</option> 
                            <option value="CA">California</option> 
                            <option value="CO">Colorado</option> 
                            <option value="CT">Connecticut</option> 
                            <option value="DE">Delaware</option> 
                            <option value="DC">District Of Columbia</option> 
                            <option value="FL">Florida</option> 
                            <option value="GA">Georgia</option> 
                            <option value="HI">Hawaii</option> 
                            <option value="ID">Idaho</option> 
                            <option value="IL">Illinois</option> 
                            <option value="IN">Indiana</option> 
                            <option value="IA">Iowa</option> 
                            <option value="KS">Kansas</option> 
                            <option value="KY">Kentucky</option> 
                            <option value="LA">Louisiana</option> 
                            <option value="ME">Maine</option> 
                            <option value="MD">Maryland</option> 
                            <option value="MA">Massachusetts</option> 
                            <option value="MI">Michigan</option> 
                            <option value="MN">Minnesota</option> 
                            <option value="MS">Mississippi</option> 
                            <option value="MO">Missouri</option> 
                            <option value="MT">Montana</option> 
                            <option value="NE">Nebraska</option> 
                            <option value="NV">Nevada</option> 
                            <option value="NH">New Hampshire</option> 
                            <option value="NJ">New Jersey</option> 
                            <option value="NM">New Mexico</option> 
                            <option value="NY">New York</option> 
                            <option value="NC">North Carolina</option> 
                            <option value="ND">North Dakota</option> 
                            <option value="OH">Ohio</option> 
                            <option value="OK">Oklahoma</option> 
                            <option value="OR">Oregon</option> 
                            <option value="PA">Pennsylvania</option> 
                            <option value="RI">Rhode Island</option> 
                            <option value="SC">South Carolina</option> 
                            <option value="SD">South Dakota</option> 
                            <option value="TN">Tennessee</option> 
                            <option value="TX">Texas</option> 
                            <option value="UT">Utah</option> 
                            <option value="VT">Vermont</option> 
                            <option value="VA">Virginia</option> 
                            <option value="WA">Washington</option> 
                            <option value="WV">West Virginia</option> 
                            <option value="WI">Wisconsin</option> 
                            <option value="WY">Wyoming</option>
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
                            <select name="bill[cc_expired][month]" class='input-mini'>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <select name="bill[cc_expired][year]" class='input-mini'>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                            </select>
                        </p>
                        <p>
                            <label>Phone</label>
                            <input type="text" class="input-large" name="bill[phone]" placeholder='Phone' />
                        </p
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
                                <option value="" selected="selected">Select a State</option> 
                                <option value="AL">Alabama</option> 
                                <option value="AK">Alaska</option> 
                                <option value="AZ">Arizona</option> 
                                <option value="AR">Arkansas</option> 
                                <option value="CA">California</option> 
                                <option value="CO">Colorado</option> 
                                <option value="CT">Connecticut</option> 
                                <option value="DE">Delaware</option> 
                                <option value="DC">District Of Columbia</option> 
                                <option value="FL">Florida</option> 
                                <option value="GA">Georgia</option> 
                                <option value="HI">Hawaii</option> 
                                <option value="ID">Idaho</option> 
                                <option value="IL">Illinois</option> 
                                <option value="IN">Indiana</option> 
                                <option value="IA">Iowa</option> 
                                <option value="KS">Kansas</option> 
                                <option value="KY">Kentucky</option> 
                                <option value="LA">Louisiana</option> 
                                <option value="ME">Maine</option> 
                                <option value="MD">Maryland</option> 
                                <option value="MA">Massachusetts</option> 
                                <option value="MI">Michigan</option> 
                                <option value="MN">Minnesota</option> 
                                <option value="MS">Mississippi</option> 
                                <option value="MO">Missouri</option> 
                                <option value="MT">Montana</option> 
                                <option value="NE">Nebraska</option> 
                                <option value="NV">Nevada</option> 
                                <option value="NH">New Hampshire</option> 
                                <option value="NJ">New Jersey</option> 
                                <option value="NM">New Mexico</option> 
                                <option value="NY">New York</option> 
                                <option value="NC">North Carolina</option> 
                                <option value="ND">North Dakota</option> 
                                <option value="OH">Ohio</option> 
                                <option value="OK">Oklahoma</option> 
                                <option value="OR">Oregon</option> 
                                <option value="PA">Pennsylvania</option> 
                                <option value="RI">Rhode Island</option> 
                                <option value="SC">South Carolina</option> 
                                <option value="SD">South Dakota</option> 
                                <option value="TN">Tennessee</option> 
                                <option value="TX">Texas</option> 
                                <option value="UT">Utah</option> 
                                <option value="VT">Vermont</option> 
                                <option value="VA">Virginia</option> 
                                <option value="WA">Washington</option> 
                                <option value="WV">West Virginia</option> 
                                <option value="WI">Wisconsin</option> 
                                <option value="WY">Wyoming</option>
                            </select>
                        </p>
                        <p>
                            <label>City</label>
                            <input type="text" placeholder="City" name="bill[city]" />
                        </p>
                    </div>
                </div>
                <?php if (isset($identity)) : ?>
                    <div class="qbox hide" style='display:none'>
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
                    <div class="qbox hide" id='box-signin' style='display:none'>
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
                    <div class="qbox hide" id='box-signup' style='display:none'>
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
        <div id="box-order-confirm">


        </div>
        <div id="box-order-success">


        </div>
    </form>

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
    );

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
                    var type = $(this).data('type');

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
                            if (file == "" || type == 'product') {
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
                            if (file == "" || type == 'product') {
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
                            if (file == "" || type == 'product') {
                                guid = guid;
                            } else {
                                guid = guid + "-" + file;
                            }
                            $.shoppingcart.removeall(guid);
                            window.location.href = "";
                            //cart_reload();
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
                $("#btn-paynow").parent().remove();
                $("#box-bill-details").html($("#box-bill-details").html() + '<p><a class="btn btn-peach" onclick="javascript:cart_check()" id="btn-paynow">Pay Now</a></p>');
            }

            cart_config();

        }).fail(function() {

        });
    }

    function cart_check()
    {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>shop/checkout/?action=check",
            data: $("#form-payment").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                showAlert2("Working....");
            }
        }).done(function(data) {


            try {
                var result = $.parseJSON(data);
                if (result.error == 1) {
                    showAlert(result.message);
                } else {

                }
            }
            catch (e) {
                hideAlert();
                $(".checkout").hide(0)
                $("#box-order-confirm").show(0);
                $("#box-order-confirm").html(data);
            }

        }).fail(function() {
            hideAlert();
        });
    }

    function cart_pay()
    {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>shop/checkout/?action=pay",
            data: $("#form-payment").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                showAlert2("Working....");
            }
        }).done(function(data) {


            try {
                var result = $.parseJSON(data);
                if (result.error == 1) {
                    showAlert(result.message);
                } else {

                }
            }
            catch (e) {
                hideAlert();
                $(".checkout").hide(0)
                $("#box-order-confirm").hide(0);
                $("#box-order-success").show(0);
                $("#box-order-success").html(data);
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