<div class="span12">
    <div class="qbox" style="background-color:white;">
        <h1 style="height:30px;border-bottom:2px solid white;">My Cart</h1>
        <div style="overflow: auto;max-height:400px;">
            <table class="table table-striped">
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
                    <?php $i = 1; if (!empty ($data)) : ?>
                    <input type="hidden" name="hasorder" value="1" />
                    <?php foreach ($data as $key=>$value) : ?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td style="text-transform: uppercase;"><?php echo "#" . $value['Product']['guid']; ?></td>
                    <td><?php echo $value['Product']['name']; ?></td>
                    <td><a href="javascript:" class="thumbnail" style="width:80px;"><img src="<?php if($value['Product']['type'] == 'template') echo $this->webroot . "uploads/preview/{$value['Product']['file']}"; else echo $this->webroot . "uploads/product/{$value['Product']['file']}"; ?>" style="width:60px;" /></a></td>
                    <td style="min-width:100px"><?php echo $value['Product']['price'] * $value['Product']['quantity']; ?></td>
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
<!--                    <td>0.00</td>-->
                    <td>To be determined</td>
                    <th><a href="javascript:" 
                           data-action="remove" 
                           data-type="<?php echo $value['Product']['type']; ?>"
                           data-guid="<?php echo $value['Product']['guid']; ?>" 
                           data-file="<?php echo $value['Product']['file']; ?>" 
                           style="text-decoration:none;"><i class="icon-remove-sign icon-2x"></i></a></th>
                  </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <tr>
                      <td colspan='7'>
                          <input type="hidden" name="hasorder" value="0" />
                          <em class='text-warning'>There is no product in the cart now</em>
                      </td>
                  </tr>
                  <?php
                  endif; ?>
                </tbody>
              </table>
        </div>
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
                            console.log(i);
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