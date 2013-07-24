<div class="row-fluid">
    <?php if ($error['error'] != 0) : ?>
    <div class="span12">
        
    </div>
    <?php else : ?>
    <div class="span5">
        <input type="hidden" id="product-info" data-guid="<?php echo $data['Product']['guid']; ?>" data-file="<?php echo $error['files']['target']; ?>" data-amount="<?php echo $data['Product']['price']; ?>" data-quantity="1" />
        <p><a class="thumbnail" href="javascript:"><img src="<?php echo $this->webroot . $error['files']['url']; ?>" style="width:200px" data-file="<?php echo $error['files']['target']; ?>" /></a></p>
    </div>
    <div class="span7">
        <div class="well">
            <table class="table table-bordered table-striped" style="font-size:16px">
                <tbody>
                    <tr>
                        <td class="text-info">Type</td>
                        <td><?php echo $data['Product']['name']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-success">Quantity</td>
                        <td><span style="padding-left:5px;padding-right:5px;width:30px;display:inline-block;text-align: center;" id="amount">1</span></td>
                    </tr>
                    <tr>
                        <td class="text-success">Amount</td>
                        <td><?php echo $data['Product']['price']; ?></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><?php echo $data['Product']['description']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>