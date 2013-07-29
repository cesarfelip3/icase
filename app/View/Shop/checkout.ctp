
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
    <div class="row-fluid" id="box-orders">
        <div class="ajax-loading-indicator" style="margin:10px;"><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading orders....</a></div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <div class="qbox">
                <h1 style="height:30px;border-bottom:2px solid white;">Deliver Info<!--<a href="javascript:" class="close" type="button" data-action="close" data-dismiss="modal" aria-hidden="true" style="text-decoration:none;"><i class="icon-remove icon-1x"></i></a>--></h1>
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
                    <span class="help-inline">Notify you ...</span>
                </p> 
                <p>
                    <label>Address1</label>
                    <input type="text" class="input-xlarge" name="deliver[address1]" />
                </p>
                <p>
                    <label>Address2</label>
                    <input type="text" class="input-xlarge" name="deliver[address2]" />
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
                <div>
                    <span class="text-info">You will have your panel, saved case design and more after your signup or signin</span>
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
                <div>
                    <span class="text-info">You will have your panel, saved case design and more after your signup or signin</span>
                </div>
            </div>
        </div>           
    </div>
</form>

<script type="text/javascript">
    jQuery(document).ready(
            function() {
<?php if (isset($checkout_single)) : ?>
                    checkout_single();
<?php else : ?>
                    checkout_cart();
<?php endif; ?>

            }
    )

    function checkout_single() {
        
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>shop/order",
            data: {"orders": $.shoppingcart.getCurrentProductId(), "user": $.shoppingcart.getuuid()},
            type: "POST",
            beforeSend: function(xhr) {
                console.log("working....");
            }
        }).done(function(data) {
            $("#box-orders").html(data);
            $("#payment-form").show();
        }).fail(function() {

        });
    }
    
    function checkout_single_succ() {
        $.shoppingcart.setCurrentProductId(null);
    }

    function checkout_cart() {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>shop/order",
            data: {"orders": $.shoppingcart.get(), "user": $.shoppingcart.getuuid()},
            type: "POST",
            beforeSend: function(xhr) {
                console.log("working....");
            }
        }).done(function(data) {
            $("#box-orders").html(data);
            $("#payment-form").show();
            $("#stripe-script").data("amount", $("#amount-total").val());
        }).fail(function() {

        });
    }
    
    function checkout_cart_succ() {
        $.shoppingcart.clear();
    }
</script>
