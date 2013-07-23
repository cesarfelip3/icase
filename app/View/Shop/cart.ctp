<div class="span8 offset2">
    <div class="qbox">
        <h1><a href="javascript:" class="close" type="button" data-action="close" data-dismiss="modal" aria-hidden="true" style="text-decoration:none;"><i class="icon-remove icon-1x"></i></a></h1>
        <div>
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
                    <td><a href="javascript:" class="thumbnail" style="width:80px;"><img src="img/template/iphone.png" style="width:80px;" /></a></td>
                    <td style="min-width:100px"><?php echo $value['data']['Product']['price'] * $value['value']; ?></td>
                    <td><a href="javascript:" data-action="plus" class="" data-guid="<?php echo $value['data']['Product']['guid']; ?>" data-price="<?php echo $value['data']['Product']['price']; ?>" style="text-decoration:none;"><i class="icon-plus icon-1x"></i></a><span style="padding-left:5px;padding-right:5px;width:30px;display:inline-block;text-align: center;" id="amount"><?php echo $value['value']; ?></span><a href="javascript:" data-action="minus" class="" data-guid="<?php echo $value['data']['Product']['guid']; ?>" data-price="<?php echo $value['data']['Product']['price']; ?>" style="text-decoration:none;"><i class="icon-minus icon-1x"></i></a></td>
                    <th><a href="javascript:" data-action="remove" data-guid="<?php echo $value['data']['Product']['guid']; ?>" style="text-decoration:none;"><i class="icon-remove-sign icon-2x"></i></a></th>
                  </tr>
                  <?php
                  endforeach;
                  endif;
                  ?>
                </tbody>
              </table>
            <hr/>
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