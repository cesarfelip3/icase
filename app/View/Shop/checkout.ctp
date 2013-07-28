
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
                    <input type="text" class="input-medium" />
                </p>
                <p>
                    <label>Last Name</label>
                    <input type="text" class="input-medium" />
                </p>
                <p>
                    <label>Address1</label>
                    <input type="text" class="input-xlarge" />
                </p>
                <p>
                    <label>Address2</label>
                    <input type="text" class="input-xlarge" />
                </p>
                <p>
                    <label>State</label>
                    <select class="input-small"></select>
                </p>
                <p>
                    <label>City</label>
                    <select class="input-small"></select>
                </p>
                <p>
                    <label>Zip Code</label>
                    <input type="text" class="input-small" />
                </p>
                <p>
                    <label>Email</label>
                    <input type="text" class="input-medium" />
                    <span class="help-inline">Notify you ...</span>
                </p>    
            </div>
        </div>
        <div class="span6">
            <div class="qbox">
                <h1 style="height:30px;border-bottom:2px solid white;">Sign Up</h1>
                <div id="payment-stripe">
                    <p>
                        <label>User</label>
                        <input type="text" class="input-large" />
                    </p>
                    <p>
                        <label>Email</label>
                        <input type="text" class="input-large"/>
                    </p>
                    <p>
                        <label>Password</label>
                        <input type="text" class="input-large"/>
                    </p>
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

                console.log($.shoppingcart.getuuid());
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
</script>
