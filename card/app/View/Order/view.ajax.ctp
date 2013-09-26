<table class="table">
    <thead>
        <tr>
            <th colspan='2'><h3>Order Info</h3></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($order)) : ?>
        <tr>
            <td>Title</td>
            <td><?php echo $order['title']; ?></td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td><?php echo $order['quantity']; ?></td>
        </tr>
        <tr>
            <td>Amount</td>
            <td><?php echo $order['amount']; ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo $order['status']; ?></td>
        </tr>
        <tr>
            <td>Modified</td>
            <td><?php echo date ("m/d/y g:i:s A", $order['modified']); ?></td>
        </tr>
        <tr>
            <td>Created</td>
            <td><?php echo date ("m/d/y g:i:s A", $order['created']); ?></td>
        </tr>
        <?php if ($order['type'] == 'template') : ?>
        <tr>
            <td colspan='2'>
                Your design
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <img src='<?php echo $this->webroot . "uploads/preview/" . str_replace(".", "_user.", $order['attachement']); ?>' style='width:100%' />
            </td>
        </tr>
        <?php else :  ?>
        <tr>
            <td>Product</td>
            <td><a href='http://<?php echo env('SERVER_NAME') . $this->webroot . "catalogue/single/?id=" . $order['product_guid']; ?>'>Check Lastest Info</a></td>
        </tr>
        <?php endif; ?>
        <?php endif; ?>
    </tbody>
</table>
<table class="table">
    <thead>
        <tr>
            <th colspan='2'><h3>Bill Info</h3></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($bill)) : ?>
        <tr>
            <td>Name</td>
            <td><?php echo $bill['name']; ?></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><?php echo $bill['phone']; ?></td>
        </tr>
        <tr>
            <td>Country</td>
            <td><?php echo $bill['country']; ?></td>
        </tr>
        <tr>
            <td>State</td>
            <td><?php echo $bill['state']; ?></td>
        </tr>
        <tr>
            <td>City</td>
            <td><?php echo $bill['city']; ?></td>
        </tr>
        <tr>
            <td>Created</td>
            <td><?php echo date ("m/d/y g:i:s A", $bill['created']); ?></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<table class="table">
    <thead>
        <tr>
            <th colspan='2'><h3>Deliver Info</h3></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($deliver)) : ?>
        <tr>
            <td>Name</td>
            <td><?php echo $deliver['firstname'] . " " . $deliver['lastname']; ?></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><?php echo $deliver['phone']; ?></td>
        </tr>
        <tr>
            <td>Country</td>
            <td><?php echo $deliver['country']; ?></td>
        </tr>
        <tr>
            <td>State</td>
            <td><?php echo $deliver['state']; ?></td>
        </tr>
        <tr>
            <td>City</td>
            <td><?php echo $deliver['city']; ?></td>
        </tr>
        <tr>
            <td>Zip code</td>
            <td><?php echo $deliver['zipcode']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $deliver['email']; ?></td>
        </tr>
        <tr>
            <td>Created</td>
            <td><?php echo date ("m/d/y g:i:s A", $deliver['created']); ?></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>