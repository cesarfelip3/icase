<h1>There are some new orders...</h1>
<p>Hi </p>
<div>
    <table>
        <thead>
            
        </thead>
        <tbody>
            <?php if (!empty ($data)) : ?>
            <?php foreach ($data as $value) : ?>
            <tr>
                <td>#<?php echo $value['Order']['guid']; ?></td>
                <td><?php echo $value['Order']['name']; ?></td>
                <td><?php echo $value['Order']['amount']; ?></td>
                <td><?php echo $value['Order']['quantity']; ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>