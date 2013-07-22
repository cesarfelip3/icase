<div class="span8 offset2">
    <div class="qbox">
        <h1><a href="#" type="button" class="close" data-dismiss="modal" aria-hidden="true" style="text-decoration:none;"><i class="icon-remove icon-1x"></i></a></h1>
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
                    <td><a href="#" class="thumbnail" style="width:80px;"><img src="img/template/iphone.png" style="width:80px;" /></a></td>
                    <td><?php echo $value['data']['Product']['price'] * $value['value']; ?></td>
                    <td><a href="javascript:" class="remove" data-guid="<?php echo $value['data']['Product']['guid']; ?>" style="text-decoration:none;"><i class="icon-plus icon-1x"></i></a><?php echo $value['value']; ?></td>
                    <th><a href="javascript:" class="remove" data-guid="<?php echo $value['data']['Product']['guid']; ?>" style="text-decoration:none;"><i class="icon-remove-sign icon-2x"></i></a></th>
                  </tr>
                  <?php
                  endforeach;
                  endif;
                  ?>
                </tbody>
              </table>
            <hr/>
            <a class="btn btn-large btn-peach">Checkout</a>
        </div>
    </div>
</div>