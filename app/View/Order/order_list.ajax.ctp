<style tyle="text/css">
    a.title {text-decoration: none;color:orange}
</style>
<div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Quantity</th>
                <th>Modified</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty ($data)) : $i = 0;?>
            <?php foreach ($data as $value) : ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $value['Order']['title']; ?></td>
                <td><?php echo $value['Order']['status']; ?></td>
                <td><?php echo $value['Order']['amount']; ?></td>
                <td><?php echo $value['Order']['quantity']; ?></td>
                <td><?php echo date ("m/d/y g:i:s A", $value['Order']['modified']); ?></td>
                <td><a href="javascript:" class="btn btn-info btn-small">View</a></td>
            </tr>
            <?php endforeach; ?>
            <?php else :  ?>
            <tr>
                <td colspan="4"><em class="text-warning">No orders yet</em></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>