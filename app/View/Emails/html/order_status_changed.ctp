<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
    </head>
    <body>
        Dear <?php echo $bill['name']; ?>,<br/>
        <?php echo $email_content; ?>
        <br/>
        <?php if (!empty ($deliver)) : ?>
        Address: <?php echo $deliver['address']; ?><br/>
        Location: <?php echo $deliver['city']; ?> <?php echo $deliver['state']; ?>  <?php echo $deliver['country']; ?><br/>
        Phone: <?php echo $deliver['phone']; ?><br/><br/>
        <?php endif; ?>
        <?php if (!empty ($orders)) : ?>
        Including the following items:<br/><br/>
        <?php foreach ($orders as $value) : $value = $value['Order']; ?>
        <div>
            <span>ID : #<?php echo $value['guid']; ?></span><br/>
            <span>Name : <?php echo $value['title']; ?></span><br/>
            <span>QYT : <?php echo $value['quantity']; ?></span><br/>
        </div>
        <br/>
        <?php endforeach; ?>
        <?php endif; ?>
        <p>Take care! If you have any questions, please contact us below:<br/>
        Beautahful Creations LLC.<br/>
        <b>Email: </b><a href="mailto:orders@beautahfulcreations.com"><b>orders@beautahfulcreations.com</b></a><br/>
        <b>Website: </b><a href="http://www.beautahfulcreations.com/">http://www.beautahfulcreations.com</a></p>
    </body>
</html>