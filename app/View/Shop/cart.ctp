<div class="span12">
    <div class="qbox">
        <h1 style="height:30px;border-bottom:2px solid white;">My Cart</h1>
        <div style="overflow: auto;max-height:400px;">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Your Design</th>
                    <th>Amount</th>
                    <th>Quantity</th>
                    <th>tax</th>
                    <th>Shipment</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (!empty ($data)) : 
                    foreach ($data as $key=>$value) : 
                    ?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><a href="javascript:" class="thumbnail" style="width:80px;"><img src="<?php echo $this->webroot; ?>uploads/<?php echo $value['Product']['file']; ?>" style="width:60px;" /></a></td>
                    <td style="min-width:100px"><?php echo $value['Product']['price'] * $value['Product']['quantity']; ?></td>
                    <td><a href="javascript:" data-action="plus" class="" data-guid="<?php echo $value['Product']['guid']; ?>" data-price="<?php echo $value['Product']['price']; ?>" style="text-decoration:none;" data-file="<?php echo $value['Product']['file']; ?>"><i class="icon-plus icon-1x"></i></a><span style="padding-left:5px;padding-right:5px;width:30px;display:inline-block;text-align: center;" id="amount"><?php echo $value['Product']['quantity']; ?></span><a href="javascript:" data-action="minus" class="" data-guid="<?php echo $value['Product']['guid']; ?>" data-price="<?php echo $value['Product']['price']; ?>" data-file="<?php echo $value['Product']['file']; ?>" style="text-decoration:none;"><i class="icon-minus icon-1x"></i></a></td>
                    <td>0.00</td>
                    <td>To be determined</td>
                    <th><a href="javascript:" data-action="remove" data-guid="<?php echo $value['Product']['guid']; ?>" data-file="<?php echo $value['Product']['file']; ?>" style="text-decoration:none;"><i class="icon-remove-sign icon-2x"></i></a></th>
                  </tr>
                  <?php
                  endforeach;
                  else:
                  ?>
                  <tr>
                      <td colspan='7'>
                          <em class='text-warning'>There is no product in the cart now</em>
                      </td>
                  </tr>
                  <?php
                  endif; ?>
                </tbody>
              </table>
        </div>
        <div>
            <?php
            if (!empty ($data)) : ?>
            <a class="btn btn-peach" onclick="javascript:cart_pay()">Pay Now</a>
            <?php
            endif; ?>
        </div>
    </div>
</div>
<script>
    function cart_pay ()
    {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>shop/checkout/?action=payment",
            data: $("#form-payment").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                showAlert2 ("Working....");
            }
        }).done(function(data) {

            var result = $.parseJSON(data);
            if (result.error == 1) {
                showAlert(result.message);
            } else {
                $("#form-payment").submit();
            }
            
        }).fail(function() {
            hideAlert ();
        });
    }
</script>