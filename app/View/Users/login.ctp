<h1>Log in</h1>

<?php
    echo $this->Form->create();
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->end('Login');

?>