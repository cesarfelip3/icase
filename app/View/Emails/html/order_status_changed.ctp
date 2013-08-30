<p class="p5">
    <span class="s2">Dear,</span><br>
    <br>
    Thank you for your order from BeaUTAHful Creations<b>! </b>We wanted to let you know that your order was shipped via USPS, USPS Priority Mail on 7/27/2013.  You can track your package at any time using the link below.<br>
    <br>
    <b>Shipped To:</b><br>
<p><?php echo $deliver['address']; ?></p>
<p><?php echo $deilver['city']; ?> <?php echo $deilver['state']; ?> <?php echo $deliver['phone']; ?> <?php echo $deliver['country']; ?></p><br>
<br>
<b>Track Your Shipment:</b> <a href="https://tools.usps.com/go/TrackConfirmAction.action?tLabels=9405510200986104431161">9405510200986104431161</a><br>
<br>
This shipment includes the following items:</p>
<table class="table">
    <thead>
        <tr>
            <th>ID</td>
            <th>Name</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orders)) : $i = 1; ?>
            <?php foreach ($orders as $key => $value) : ?>
                <tr>
                    <td>#<?php echo $value['Order']['guid']; ?></td>
                    <td><?php echo $value['Order']['title']; ?></td>
                    <td>
                        <?php echo $value['Order']['quantity']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<p class="p4"><span class="s3"><br>
        <br>
    </span><b>Take care! If you have any questions, please contact us below:</b><span class="s1"><br>
        <br>
    </span><b>Beautahful Creations LLC.</b><span class="s1"><br>
    </span><b>Email: </b><a href="mailto:orders@beautahfulcreations.com"><b>orders@beautahfulcreations.com</b></a><span class="s1"><br>
    </span><b>Website:</b><span class="s1"> <a href="http://www.beautahfulcreations.com/"><span class="s2">http://</span>www.beautahfulcreations.com</a></span></p>
<p class="p7"><br></p>
<p class="p7"><br></p>