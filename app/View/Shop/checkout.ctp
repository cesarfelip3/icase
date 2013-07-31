
<style>
    form.info label {
        width:80px;
        display:inline-block;
    }

    form.info input {
        display:inline;
    }
</style>
<form id="payment-form" class="info" action="<?php echo $this->webroot; ?>shop/checkout?action=<?php echo $action; ?>" method="post">
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
                    <textarea name="deliver[address1]" style="width:400px"></textarea>
                </p>
                <p>
                    <label>Phone</label>
                    <input type="text" class="input-medium" name="deliver[phone]" />
                </p>
                <p>
                    <label>State</label>
                    <select class="input-small" name="deliver[state]"></select>
                </p>
                <p>
                    <label>City</label>
                    <select class="input-small" name="deliver[city]"></select>
                </p>
                <p>
                    <label>Zip Code</label>
                    <input type="text" class="input-small" name="deliver[zipcode]" />
                </p>   
            </div>
        </div>
        <div class="span6">
            <div class="qbox">
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
            <div class="qbox">
                <h1 style="height:30px;border-bottom:2px solid white;">Sign In</h1>
                <div id="payment-stripe">
                    <p>
                        <label>User/Email</label>
                        <input type="text" class="input-large" name="signin[name]" />
                    </p>
                    <p>
                        <label>Password</label>
                        <input type="text" class="input-large" name="signin[password]"/>
                    </p>
                </div>
            </div>
        </div>           
    </div>
</form>

<script type="text/javascript">
    jQuery(document).ready(
            function() {
                checkout_cart ();
            }
    )

    function checkout_single() {
        cart_reload (true);
        
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
        cart_reload (false);
        
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
