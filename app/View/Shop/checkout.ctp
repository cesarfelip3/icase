
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
    <form id="form-payment" class="info" action="<?php echo $this->webroot; ?>shop/checkout?action=<?php echo $action; ?>" method="post">
        <div class="row-fluid" id="box-cart">
            <div class="ajax-loading-indicator" style="margin:10px;"><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading orders....</a></div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="qbox">
                    <h1 style="height:30px;border-bottom:2px solid white;">Bill Details<!--<a href="javascript:" class="close" type="button" data-action="close" data-dismiss="modal" aria-hidden="true" style="text-decoration:none;"><i class="icon-remove icon-1x"></i></a>--></h1>
                    <p>
                        <span class="label label-warning">All fields are required</span>
                    </p>
                    <p>
                        <label>First Name</label>
                        <input type="text" class="input-medium" name="deliver[firstname]" />
                        <span class="text-warning" style="text-shadow:none;" >hello</span>
                    </p>
                    <p>
                        <label>Last Name</label>
                        <input type="text" class="input-medium" name="deliver[lastname]" />
                    </p>
                    <p>
                        <label>Email</label>
                        <input type="text" class="input-medium" name="deliver[email]" />
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
                        <select  name="deliver[state]">
                            <option value="Utah">Utah</option>
                        </select>
                    </p>
                    <p>
                        <label>City</label>
                        <select name="deliver[city]">
                            <option value="Salt Lake City">Salt Lake City</option>
                        </select>
                    </p>
                    <p>
                        <label>Zip Code</label>
                        <input type="text" class="input-small" name="deliver[zipcode]" />
                    </p>   
                </div>
            </div>
            <div class="span6">
                <div class="qbox">
                    <h1 style="height:30px;border-bottom:2px solid white;">Sign In <span class="text-warning">to save your design</span></h1>
                    <div id="payment-stripe">
                        <p>
                            <label>User/Email</label>
                            <input type="text" class="input-large" name="signin[name]" />
                        </p>
                        <p>
                            <label>Password</label>
                            <input type="text" class="input-large" name="signin[password]"/>
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
                    </div>

                </div>
            </div>           
        </div>
    </form>

    <script type="text/javascript">
        jQuery(document).ready(
                function() {
                    checkout_cart();
                    $("#btn-signup").click(
                            function() {
                                $("#box-signup").toggle(200);
                            });
                }
        )

        function checkout_single() {
            cart_reload(true);

    //        jQuery.ajax({
    //            url: "<?php echo $this->webroot; ?>shop/cart",
    //            data: {"orders": $.shoppingcart.getCurrentProductId(), "user": $.shoppingcart.getuuid()},
    //            type: "POST",
    //            beforeSend: function(xhr) {
    //                console.log("working....");
    //            }
    //        }).done(function(data) {
    //            $("#box-cart").html(data);
    //            $("#payment-form").show();
    //        }).fail(function() {
    //
    //        });
        }

        function checkout_single_succ() {
            $.shoppingcart.setCurrentProductId(null);
        }

        function checkout_cart() {
            cart_reload(false);

            /*
             jQuery.ajax({
             url: "<?php echo $this->webroot; ?>shop/cart",
             data: {"orders": $.shoppingcart.get(), "user": $.shoppingcart.getuuid()},
             type: "POST",
             beforeSend: function(xhr) {
             console.log("working....");
             }
             }).done(function(data) {
             $("#box-cart").html(data);
             $("#payment-form").show();
             $("#stripe-script").data("amount", $("#amount-total").val());
             }).fail(function() {
             
             });
             */
        }

        function checkout_cart_succ() {
            $.shoppingcart.clear();
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
        $.shoppingcart.clear ();
    </script>
<?php endif; ?>

