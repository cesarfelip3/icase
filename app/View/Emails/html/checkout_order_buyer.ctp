<h1 class="p3">Thank you for placing your order with Beautahful Creations.</h1>
    <span class="s1"><br>
        <br>
    </span>This email is to confirm your recent order.<span class="s1"><br>
        <br>
        <span class="Apple-converted-space"> </span></span>Date <?php echo date("", time()); ?><span class="s1"><br>
        <br>
    </span>Shipping address<span class="s1"><br>
    </span><?php echo $deliver['firstname'] . " " . $deliver['lastname']; ?><span class="s1"><br>
    </span><?php echo $deliver['address']; ?><span class="s1"><br>
    </span><?php echo $deliver['country']; ?><span class="s1"><br>
        <br>
    </span>Billing address<span class="s1"><br>
    </span><?php echo $bill['name']; ?><span class="s1"><br>
    </span><?php echo $bill['address']; ?><span class="s1"><br>
    </span><?php echo $bill['country']; ?><span class="s1"><br>
        <br>
        
    <table class="table">
                <thead>
                    <tr>
                        <th>ID</td>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)) : $i = 1; ?>
                    <?php foreach ($orders as $key => $value) : ?>
                        <tr>
                            <td>#<?php echo $value['guid']; ?></td>
                            <td><?php echo $value['title']; ?></td>
                            <td><?php echo $value['amount']; ?></td>
                            <td>
                                    <?php echo $value['quantity']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Items Subtotal: </td>
                        <td colspan='3'>
                            <span>$<?php echo $subtotal; ?> USD</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Shipment: </td>
                        
                        <td colspan='3'>
                            <span>$<?php echo $shipment; ?> USD</span>
                        </td>
                    </tr>
                    <?php if (isset ($discount)) : ?>
                    <tr>
                        <td>Discount: </td>
                        <td colspan="3"><?php echo $discount . "%"; ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td>Total: </td>
                        <td colspan='7'>
                            <span><?php echo $total; ?> USD</span>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
<p class="p1"><br></p>
<p class="p4"><b>Take care! If you have any questions, please contact us below:</b><br>
    <br>
    <b>Beautahful Creations LLC.</b><br>
    <b>Email: </b><a href="mailto:orders@beautahfulcreations.com"><b>orders@beautahfulcreations.com</b></a><br>
    <b>Website:</b> <a href="http://www.slidebelts.com/">http://</a><a href="http://www.beautahfulcreations.com/">www.beautahfulcreations.com</a></p>