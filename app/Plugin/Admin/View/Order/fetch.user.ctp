<table class="orders-table table">
    <tbody>
        <?php if (!empty ($data)) : ?>
        <?php foreach ($data as $value) : ?>
        <tr>
            <td>
                <a href="<?php echo $base; ?>order/view/?id=<?php echo $value['Order']['guid']; ?>">
                    #<?php echo $value['Order']['guid']; ?> - <?php echo $value['Order']['title']; ?>
                </a> <span class="label label-info"><?php echo $value['Order']['status']; ?></span>
            </td>
            <td><?php echo $value['Order']['amount']; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2"><a href="<?php echo $base; ?>order/">View more orders</a></td>
        </tr>
        <?php else: ?>
        <tr>
            <td colspan="2"><em class="text-warning">No orders yet</em></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>