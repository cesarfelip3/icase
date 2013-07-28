<div class="span12">
    <div class="qbox">
        <h1 style="height:30px;border-bottom:2px solid white;">Your Order<!--<a href="javascript:" class="close" type="button" data-action="close" data-dismiss="modal" aria-hidden="true" style="text-decoration:none;"><i class="icon-remove icon-1x"></i></a>--></h1>
        <div style="overflow: auto;max-height:400px;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Case Picture</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (!empty($data)) :
                        foreach ($data as $key => $value) :
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><a href="javascript:" class="thumbnail" style="width:80px;"><img src="<?php echo $this->webroot; ?>uploads/<?php echo $value['file']; ?>" style="width:60px;" /></a></td>
                                <td style="min-width:100px"><?php echo $value['amount']; ?></td>
                                <td><span style="padding-left:5px;padding-right:5px;width:30px;display:inline-block;text-align: center;" id="amount"><?php echo $value['quantity']; ?></span></td>
                                <td><textarea></textarea></td>
                                <th><!--<a href="javascript:" data-action="remove" data-guid="<?php echo $value['guid']; ?>" style="text-decoration:none;"><i class="icon-remove-sign icon-2x"></i></a>--></th>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>Total</td>
                            <td></td>
                            <td><?php echo $amount; ?></td>
                        </tr>
                        <?php
                    else:
                        ?>
                        <tr>
                            <td colspan="6" class="text-center"><em>THERE IS NO ORDER YET</em></td> 
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div>
            <?php if (!empty($data)) : ?>
                <script
                    src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
                    data-key="<?php echo $stripe_key; ?>"
                    data-amount="<?php echo $amount * 100; ?>"
                    data-name="icaseapp.com"
                    data-description="mobile case"
                    data-image="<?php echo $this->webroot; ?>img/iCase-png.png">
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>