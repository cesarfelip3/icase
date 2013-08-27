<?php
$cart_url = $this->webroot . "shop/cart/?action=cart";
$checkout_cart_url = $this->webroot . "shop/checkout/?action=cart";
$checkout_confirm_url = $this->webroot . "shop/checkout/?action=check";

$loginform_url = $this->webroot . "auth/formuser";
$signin_url = $this->webroot . "signin";
$signup_url = $this->webroot . "signup";
?>
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
        box-shadow: none;
    }

    .qbox h1 {
        height:30px;
        border-bottom:2px solid white;
    }

    .qbox h1 span {
        font-size:12px;
        font-weight:normal;
        text-transform: none;
        color:red;
        float:right;
    }
</style>
<div class="row-fluid">
    <form id="form-payment" class="info">
        <!-- load cart -->
        <div class="row-fluid checkout">
            <div class="span12" id="box-cart">
                <div class="ajax-loading-indicator" style="margin:10px;"><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading orders....</a></div>
            </div>
        </div>

        <!-- checkout form -->
        <?php if (isset($deliver)) : ?>
            <div class="row-fluid checkout">
                <div class="span6">
                    <div class="qbox" id="box-bill-details">
                        <h1>Shippment<span>All fields are required</span></h1>
                        <p>
                            <label>First Name</label>
                            <input type="text" class="input-medium" name="deliver[firstname]" value="<?php echo $deliver['firstname']; ?>" />
                            <span class="text-warning" style="text-shadow:none;"></span>
                        </p>
                        <p>
                            <label>Last Name</label>
                            <input type="text" class="input-medium" name="deliver[lastname]" value="<?php echo $deliver['lastname']; ?>" />
                        </p>
                        <p>
                            <label>Email</label>
                            <input type="text" class="input-large" name="deliver[email]" value="<?php echo $deliver['email2']; ?>" />
                            <span class="help-inline"></span>
                        </p> 
                        <p>
                            <label>Address</label>
                            <textarea name="deliver[address]" style="width:400px"><?php echo $deliver['address']; ?></textarea>
                        </p>
                        <p>
                            <label>Phone</label>
                            <input type="text" class="input-medium" name="deliver[phone]" value="<?php echo $deliver['phone']; ?>" />
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
                            <input type="text" placeholder="City" name="deliver[city]" value="<?php echo $deliver['city']; ?>" />
                        </p>
                        <p>
                            <label>Zip Code</label>
                            <input type="text" class="input-small" name="deliver[zipcode]" value="<?php echo $deliver['zipcode']; ?>" />
                        </p>   
                    </div>
                </div>
                <div class="span6 pull-right">
                    <div class="qbox">
                        <h1>Billing<span>All fields are required</span></h1>
                        <div id="payment-stripe">
                            <p>
                                <label class="checkout" style="width:100%;"><input type="checkbox" name="bill[same]" id="checkbox-same" /> billing same as shippment</label>
                            </p>
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
                            <p>
                                <label>Zip code</label>
                                <input type="text" placeholder="Zip code" name="bill[zipcode]" />
                            </p>
                        </div>
                    </div>
                </div>           
            </div>
        <?php else : ?>
            <div class="row-fluid checkout">
                <div class="span6">
                    <div class="qbox" id="box-bill-details">
                        <h1>Shippment<span>All fields are required</span></h1>
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
                <div class="span6 pull-right">
                    <div class="qbox">
                        <h1>Billing<span>All fields are required</span></h1>
                        <div id="payment-stripe">
                            <p>
                                <label class="checkout" style="width:100%;"><input type="checkbox" name="bill[same]" id="checkbox-same" /> billing same as shippment</label>
                            </p>
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
                            <p>
                                <label>Zip code</label>
                                <input type="text" placeholder="Zip code" name="bill[zipcode]" />
                            </p>
                        </div>
                    </div>
                    <div class="qbox" style="height:auto !important;min-height:30px !important;height:100px;">
                        <div>
                            <p style="font-size:14px;font-weight:normal;">You don't need to create an account to check out, but if you want easy access to your order history and status click<a href="javascript:" onclick="formuser_load();"> HERE </a>to create an account.</p>
                            <p style="font-size:14px;font-weight:normal;">If you have an account with us click <a href="javascript:" onclick="formuser_load();">HERE</a> to sign in.</p>
                        </div>
                    </div>
                </div>           
            </div>
        <?php endif; ?>
        <div id="box-order-confirm">


        </div>
        <div id="box-order-success">


        </div>
    </form>
</div>

<!-- user modal -->
<div id="modal-user" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">User</h3>
    </div>
    <div class="modal-body" style='background:url("<?php echo $this->webroot; ?>img/pattern/whitey.png") repeat scroll 0 0 transparent;'>
        <div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>
    </div>
    <div class="modal-footer">
        <p class="text-error"></p>
    </div>
</div>
<script>
       //===================================================

    function formuser_load()
    {
        $("#modal-user").modal();
        jQuery.ajax({
            url: "<?php echo $loginform_url; ?>",
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {

            $("#modal-user .modal-body").html(data);

        }).fail(function() {
            jQuery(".ajax-loading-indicator").hide(0);
        });
    }

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
                $("#form-signup .text-error").html(result.message);
            } else {
                $("#modal-user").modal('hide');
                window.location.href="<?php echo $checkout_cart_url; ?>";
            }
        }).fail(function() {
        });
    }

    function signin_submit()
    {
        jQuery.ajax({
            url: "<?php echo $signin_url; ?>",
            data: $("#form-signin").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-signin").button("loading");
            }
        }).done(function(data) {
            $("#btn-signin").button("reset");

            var result = $.parseJSON(data);
            if (result.error == 1) {
                $("#form-signin .text-error").html(result.message);
            } else {
                $("#modal-user").modal('hide');
                window.location.href="<?php echo $checkout_cart_url; ?>";
            }
        }).fail(function() {
        });
    }
</script>
<script type="text/javascript">
    jQuery(document).ready(
            function() {
                checkout_cart();
                jQuery(".datepicker").datepicker({format: 'mm/yy'});
                
                $("#checkbox-same").click (
                    function () {
                        $("input[name='bill[name]']").val ($("input[name='deliver[firstname]']").val () + " " + $("input[name='deliver[lastname]']").val ());
                        $("input[name='bill[phone]']").val ($("input[name='deliver[phone]']").val ());
                        $("textarea[name='bill[address]']").val($("textarea[name='deliver[address]']").val ());
                        $("input[name='bill[city]']").val ($("input[name='deliver[city]']").val ());
                        
                        //console.log ($("input[name='deliver[address]']").val());
                        $("input[name='bill[zipcode]']").val ($("input[name='deliver[zipcode]']").val ());
                        $("select[name='bill[state]']").val($("select[name='deliver[state]']").val());
                    });
            }
    );

    function checkout_cart() {
        cart_reload('cart');
    }

    function cart_reload() {

        jQuery.ajax({
            url: "<?php echo $cart_url; ?>",
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
                $("#box-bill-details").html($("#box-bill-details").html() + '<p><a class="btn btn-peach" onclick="javascript:cart_confirm()" id="btn-paynow">Continue</a></p>');
            }

            cart_config();

        }).fail(function() {

        });
    }

    function cart_confirm()
    {
        //cart_reload ();
        jQuery.ajax({
            url: "<?php echo $checkout_confirm_url; ?>",
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

</script>