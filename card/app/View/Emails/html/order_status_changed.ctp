<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
    </head>
    <body>
        <p>Dear <?php echo $bill['name']; ?>,</p>
        <?php echo $email_content; ?>
        <p>Shipped To:</p>
        <p><?php echo $deliver['address']; ?></p>
        <p><?php echo $deliver['city']; ?> <?php echo $deliver['state']; ?> <?php echo $deliver['phone']; ?> <?php echo $deliver['country']; ?></p>
        <p>This shipment includes the following items:</p>
        <div>
            <p>ID : #<?php echo $orders['guid']; ?></p>
            <p>Name : <?php echo $orders['title']; ?></p>
            <p>QYT : <?php echo $orders['quantity']; ?></p>
        </div>
        <p>Take care! If you have any questions, please contact us below:</p>
        <p>Beautahful Creations LLC.</p>
        <p><b>Email: </b><a href="mailto:orders@beautahfulcreations.com"><b>orders@beautahfulcreations.com</b></a></p>
        <p><b>Website: </b><a href="http://www.beautahfulcreations.com/">http://www.beautahfulcreations.com</a></p>
    </body>
</html>