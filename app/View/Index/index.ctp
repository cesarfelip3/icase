<h1>Register</h1>
<?php
echo $this->Form->create();
echo $this->Form->input('nome');
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->submit('Register');
echo $this->Form->end();
?>