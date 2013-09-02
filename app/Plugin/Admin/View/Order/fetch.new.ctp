
<div class="slate">
    <div class="page-header">
        <div class="btn-group pull-right hide">
            <button class="btn dropdown-toggle" data-toggle="dropdown">
                <i class="icon-download-alt"></i> Export
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="">CSV</a></li>
                <li><a href="">Excel</a></li>
                <li><a href="">PDF</a></li>
            </ul>
        </div>
        <h2>New Orders</h2>
    </div>
    <table class="orders-table table">
        <thead>
            <tr>
                <th>#</th>
                <th>Orders</th>
                <th class="value">QTY</th>
                <th class="value">Amount</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            <?php if (!empty($data)) : ?>
                <?php foreach ($data as $value) : $value = $value['Order']; ?>
                
                    <tr>
                        <td>
                            <?php echo ++$i; ?>
                        </td>
                        <td>
                            <a href="<?php echo $base; ?>order/view/?id=<?php echo $value['guid']; ?>" style="font-size:14px;">
                                <span style="color:#888">#<?php echo $value['guid']; ?></span><br/>
                                <?php echo $value['title']; ?>
                            </a>
                            <br/>
                            <span class="label label-info">
                                <?php echo $value['status']; ?>
                            </span>
                            <br/>
                            <span class="meta" style="color:black;font-size:14px;">
                                <?php echo date("F j, Y, g:i a", $value['created']); ?>
                            </span>
                        </td>
                        <td class="value">
                            <?php echo $value['quantity']; ?>
                        </td>
                        <td class="value">
                            $<?php echo $value['amount']; ?>
                        </td>
                        <td class="actions">
                            <a class="btn btn-small btn-primary" href="<?php echo $base; ?>order/view/?id=<?php echo $value['guid']; ?>">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else :  ?>
                    <tr>
                        <td colspan="5"><em>Now new orders yet.</em></td>
                    </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>