<div class="row-fluid" id="box-orders">
    <div class="ajax-loading-indicator" style="margin:10px;"><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading orders....</a></div>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="qbox">
            <h1 style="height:30px;border-bottom:2px solid white;">Deliver Info<!--<a href="javascript:" class="close" type="button" data-action="close" data-dismiss="modal" aria-hidden="true" style="text-decoration:none;"><i class="icon-remove icon-1x"></i></a>--></h1>
            <style>
                form.info label {
                    width:60px;
                    display:inline-block;
                }

                form.info input {
                    display:inline;
                }
            </style>
            <form class="info">
                <fieldset>
                    <p>
                        <label>First Name</label>
                        <input type="text" />
                    </p>
                    <p>
                        <label>Last Name</label>
                        <input type="text" />
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
                        <input type="text" />
                    </p>
                    <hr/>
                    <h2>Optional</h2>
                    <hr/>
                    <p>
                        <label>Email</label>
                        <input type="text" />
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="span6">
        <div class="qbox">
            <!--<h1 style="height:30px;border-bottom:2px solid white;">Payment Info<a href="javascript:" class="close" type="button" data-action="close" data-dismiss="modal" aria-hidden="true" style="text-decoration:none;"><i class="icon-remove icon-1x"></i></a>--></h1>
            <form action="" method="POST">
                <script
                    src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
                    data-key="<?php echo $stripe_key; ?>"
                    data-amount="20"
                    data-name="icaseapp.com"
                    data-description="2 widgets ($20.00)"
                    data-image="<?php echo $this->webroot; ?>img/iCase-png.png">
                </script>
            </form>
        </div>
    </div>
</div>
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
            data: {"orders": shoppingcart.getCurrentProductId(), "user": shoppingcart.getuuid()},
            type: "POST",
            beforeSend: function(xhr) {
                console.log("working....");
            }
        }).done(function(data) {
            $("#box-orders").html(data);
        }).fail(function() {

        });
    }

    function checkout_cart() {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>shop/order",
            data: {"orders": shoppingcart.get(), "user": shoppingcart.getuuid()},
            type: "POST",
            beforeSend: function(xhr) {
                console.log("working....");
            }
        }).done(function(data) {
            $("#box-orders").html(data);
        }).fail(function() {

        });
    }
</script>
