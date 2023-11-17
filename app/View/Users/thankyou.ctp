<h1>Thank you for registering</h1>
<?php

    echo $this->Form->create(null, ['url' => ['controller' => 'Messages', 'action' => 'index'], 'class' => 'button-form']);
    echo $this->Form->button('Back to homepage', ['type' => 'submit', 'class' => 'button-class']);
    echo $this->Form->end();

?>