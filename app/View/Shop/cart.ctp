<div class="span8 offset2">
    <div class="qbox">
        <h1 style="height:30px;border-bottom:2px solid white;"><a href="javascript:" class="close" type="button" data-action="close" data-dismiss="modal" aria-hidden="true" style="text-decoration:none;"><i class="icon-remove icon-1x"></i></a></h1>
        <div style="overflow: auto;max-height:400px;">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Your Design</th>
                    <th>Price</th>
                    <th>Total</th>
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
                    <td><a href="javascript:" class="thumbnail" style="width:80px;"><img src="<?php $this->webroot; ?>uploads/<?php echo $value['Product']['file']; ?>" style="width:60px;" /></a></td>
                    <td style="min-width:100px"><?php echo $value['Product']['price'] * $value['Product']['quantity']; ?></td>
                    <td><a href="javascript:" data-action="plus" class="" data-guid="<?php echo $value['Product']['guid']; ?>" data-price="<?php echo $value['Product']['price']; ?>" style="text-decoration:none;" data-file="<?php echo $value['Product']['file']; ?>"><i class="icon-plus icon-1x"></i></a><span style="padding-left:5px;padding-right:5px;width:30px;display:inline-block;text-align: center;" id="amount"><?php echo $value['Product']['quantity']; ?></span><a href="javascript:" data-action="minus" class="" data-guid="<?php echo $value['Product']['guid']; ?>" data-price="<?php echo $value['Product']['price']; ?>" data-file="<?php echo $value['Product']['file']; ?>" style="text-decoration:none;"><i class="icon-minus icon-1x"></i></a></td>
                    <th><a href="javascript:" data-action="remove" data-guid="<?php echo $value['Product']['guid']; ?>" data-file="<?php echo $value['Product']['file']; ?>" style="text-decoration:none;"><i class="icon-remove-sign icon-2x"></i></a></th>
                  </tr>
                  <?php
                  endforeach;
                  endif;
                  ?>
                </tbody>
              </table>
        </div>
        <div>
            <?php
            if (!empty ($data)) : ?>
            <a class="btn btn-peach">Checkout</a>
            <?php
            endif; ?>
            <a class="btn btn-success pull-right">Register</a>
            <a class="btn btn-success pull-right" style="margin-right:10px">Login</a>
            <span class="help-block">You have to login to save your design</span>
        </div>
    </div>
</div>