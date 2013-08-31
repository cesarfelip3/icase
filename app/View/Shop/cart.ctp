<div class="span12">
    <div class="qbox" style="background-color:white;">
        <h1 style="height:30px;border-bottom:2px solid white;">My Cart</h1>
        <div style="overflow: auto;max-height:400px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Picture</th>
                        <th>Amount</th>
                        <th>Quantity</th>
    <!--                    <th>tax</th>-->
                        <th>Shipment</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)) : $i = 1; ?>
                    <input type="hidden" name="hasorder" value="1" />
                    <?php foreach ($data as $key => $value) : ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td style="text-transform: uppercase;"><?php echo "#" . $value['Product']['guid']; ?></td>
                            <td><?php echo $value['Product']['name']; ?></td>
                            <td><a href="javascript:" class="thumbnail" style="width:80px;"><img src="<?php
                                    if ($value['Product']['type'] == 'template')
                                        echo $this->webroot . "uploads/preview/" . str_replace(".", "_user.", $value['Product']['file']);
                                    else
                                        echo $this->webroot . "uploads/product/{$value['Product']['file']}";
                                    ?>" /></a></td>
                            <td style="min-width:100px">$<?php echo round($value['Product']['price'] * $value['Product']['quantity'], 2, PHP_ROUND_HALF_DOWN); ?></td>
                            <td>
                                <a href="javascript:" 
                                   data-action="plus" 
                                   data-type="<?php echo $value['Product']['type']; ?>"
                                   data-guid="<?php echo $value['Product']['guid']; ?>" 
                                   data-price="<?php echo $value['Product']['price']; ?>"
                                   data-file="<?php echo $value['Product']['file']; ?>"
                                   data-quantity="<?php echo $value['Product']['max']; ?>"
                                   style="text-decoration:none;" >
                                    <i class="icon-plus icon-1x"></i>
                                </a>
                                <span style="padding-left:5px;padding-right:5px;width:30px;display:inline-block;text-align: center;" id="amount">
                                    <?php echo $value['Product']['quantity']; ?>
                                </span>
                                <a href="javascript:" 
                                   data-action="minus" 
                                   data-type="<?php echo $value['Product']['type']; ?>"
                                   data-guid="<?php echo $value['Product']['guid']; ?>" 
                                   data-price="<?php echo $value['Product']['price']; ?>" 
                                   data-file="<?php echo $value['Product']['file']; ?>"
                                   data-quantity="<?php echo $value['Product']['max']; ?>" 
                                   style="text-decoration:none;">
                                    <i class="icon-minus icon-1x"></i>
                                </a>
                            </td>
                            <td>To be determined</td>
                            <td><a href="javascript:" 
                                   data-action="remove" 
                                   data-type="<?php echo $value['Product']['type']; ?>"
                                   data-guid="<?php echo $value['Product']['guid']; ?>" 
                                   data-file="<?php echo $value['Product']['file']; ?>" 
                                   style="text-decoration:none;"><i class="icon-remove-sign icon-2x"></i>
                                </a></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Items Subtotal: </td>
                        <td colspan='7'>
                            <span>$<?php echo $subtotal; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Shipment: </td>
                        
                        <td colspan='7'>
                            <span>$<?php echo $shipment; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Total: </td>
                        <td colspan='7'>
                            <span>$<?php echo $total; ?></span>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan='8'>
                            <input type="hidden" name="hasorder" value="0" />
                            <em class='text-warning'>There is no product in the cart now</em>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
<?php if (empty($_identity) && !empty($data)) : ?>
            <hr/>
            <div style="width:50%;line-height: 18px;">

                <p style="font-size:14px;font-weight:normal;">You don't need to create an account to check out, but if you want easy access to your order history and status click<a href="javascript:" onclick="formuser_load();"> HERE </a>to create an account.</p>
                <p style="font-size:14px;font-weight:normal;">If you have an account with us click <a href="javascript:" onclick="formuser_load();">HERE</a> to sign in.</p>
            </div>
<?php endif; ?>
    </div>
</div>
<script>
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
                            //console.log(i);
                            i = parseInt(jQuery.trim(i));
                            i++;
                            if (i > parseInt($(this).data('quantity'))) {
                                alert ("Sorry, quantity exceed stocks");
                                return;
                            }
                            jQuery(this).next().text(i);
                            if (file == "" || type == 'product') {
                                guid = guid;
                            } else {
                                guid = guid + "-" + file;
                            }
                            $.shoppingcart.set(guid, 1);
                            price = $(this).data('price');
                            price = parseFloat(price) * i;
                            $(this).parent().prev().text(price.toFixed(2));
                            break;
                        case 'minus' :
                            i = jQuery(this).prev().text();
                            i = parseInt(jQuery.trim(i));
                            i--;
                            if (file == "" || type == 'product') {
                                guid = guid;
                            } else {
                                guid = guid + "-" + file;
                            }
                            
                            if (i <= 0) {
                                $.shoppingcart.removeall(guid);
                                window.location.href = "";
                                break;
                            }
                            jQuery(this).prev().text(i);
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
</script>