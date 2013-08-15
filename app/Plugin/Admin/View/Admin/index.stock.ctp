<table class="orders-table table">
    <tbody>
        <?php if (!empty ($data)) : ?>
        <?php foreach ($data as $value) : ?>
        <tr>
            <td><a href="<?php echo $base; ?>product/edit/?guid=<?php echo $value['Product']['guid']; ?>"><?php echo $value['Product']['name']; ?></a></td>
            <td>Quantity is <?php echo $value['Product']['quantity']; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2"><a href="<?php echo $base; ?>product/">View all products</a></td>
        </tr>
        <?php else: ?>
        <tr>
            <td colspan="2"><em class="text-warning">No products yet</em></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>