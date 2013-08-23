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
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty ($data)) : $i = 0;?>
            <?php foreach ($data as $value) : ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $value['Order']['name']; ?></td>
                <td><?php echo $value['Order']['status']; ?></td>
                <td><a href="javascript:">View</a></td>
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