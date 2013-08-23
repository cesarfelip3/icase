<h1>Reset your password now</h1>
<p>Hi <?php echo $data['name']; ?>, </p>
<div>
    <p>Thanks for your registration. Your account is ready now, please click this link to active it, or paste it to your browser. This link will be expired in 24 hours. </p>
    <p><a href="<?php echo env("SERVER_NAME") . $this->webroot; ?>index/verfiy/?id=<?php echo $data['verified_code']; ?>"><?php echo env("SERVER_NAME") . $this->webroot; ?>index/verfiy/?id=<?php echo $data['verified_code']; ?></a>
</div>
