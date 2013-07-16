<h1>login</h1>
<?php
echo $this->Form->create();
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->submit('login');
echo $this->Form->end();
?>