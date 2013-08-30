<?php 
$checkout_pay_url = $this->webroot . "shop/checkout/?action=pay";
?>

<div class="row-fluid">
    <div class="qbox">
        <h1>Order Confirmation</h1>
        <div>
            <p>Thanks for your order.</p>
        </div>
        <div>
            <p>Date  : <?php echo date ("l jS \of F Y h:i:s A", time()); ?></p>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="qbox span6">
        <h1>Shipping Address</h1>
        <p><?php echo $deliver['firstname'] . " " . $deliver['lastname']; ?></p>
        <p><?php echo $deliver['address']; ?></p>
        <p><?php echo $deliver['phone']; ?></p>
        <p><?php echo $deliver['email']; ?></p>
    </div>
    <div class="qbox span6 pull-right">
        <h1>Billing Address</h1>
        <p><?php echo $bill['name']; ?></p>
        <p><?php echo $bill['address']; ?></p>
        <p><?php echo $bill['phone']; ?></p>
    </div>
</div>
<div class="row-fluid qbox">
    <table class="table table-striped">
        <thread>
            <th>Product Information</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Amount</th>
        </thread>
        <tbody>
            <?php if (!empty ($data)) : ?>
            <?php foreach ($data as $value) : ?>
            <tr>
                <td><?php echo $value['Product']['name']; ?></td>
                <td>$<?php echo $value['Product']['price']; ?></td>
                <td><?php echo $value['Product']['quantity']; ?></td>
                <td>$<?php echo round($value['Product']['price'] * $value['Product']['quantity'], 2, PHP_ROUND_HALF_DOWN); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" style="text-align:left;">Subtotal: </td>
                <td>$<?php echo $subtotal; ?></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:left;">Shipment: </td>
                <td>$<?php echo $shipment; ?></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:left;">Total: </td>
                <td>$<?php echo $total; ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <p>
        <a href="javascript:" onclick="cart_edit()" id='btn-edit' class="btn btn-primary" style="margin-right:10px">Edit</a>
        <a href="javascript:" onclick="cart_pay()" id='btn-continue' class="btn btn-primary" data-loading-text="Working...">Continue</a>
    </p>
    
</div>
<script>
    function cart_edit()
    {
        $("#box-order-confirm").toggle();
        $(".checkout").toggle();
    }
    
    function cart_pay()
    {
        jQuery.ajax({
            url: "<?php echo $checkout_pay_url; ?>",
            data: $("#form-payment").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-continue").button("loading");
                $("#btn-edit").hide();
                showAlert2("Working....");
            }
        }).done(function(data) {

            $("#btn-continue").button("reset");
            $("#btn-edit").show();
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
</script>
