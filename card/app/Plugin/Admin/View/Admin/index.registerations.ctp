
<table class="orders-table table">
    <tbody>
        <?php if (!empty ($data)) : ?>
        <?php foreach ($data as $value) : ?>
        <tr>
            <td>
                <a href="<?php echo $base; ?>member/edit?id=<?php echo $value['User']['guid']; ?>">
                    <?php echo $value['User']['name']; ?>
                </a> <span class="label label-info"><?php echo date ("Y-m-d H:i:s", $value['User']['created']); ?></span>
            </td>
            <td class="pull-right"><?php echo $value['User']['email']; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2"><a href="<?php echo $base; ?>member/">View more orders</a></td>
        </tr>
        <?php else: ?>
        <tr>
            <td colspan="2"><em class="text-warning">No users yet</em></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>