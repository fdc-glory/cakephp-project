<h1>Welcome to Message List</h1>

<br>

<?php
    // echo $user_id; 

    echo $this->Html->link("View profile", ['controller' => 'users', 'action' => 'view', $user_id]);

    echo $this->Form->create(null, ['url' => ['controller' => 'Messages', 'action' => 'add'], 'class' => 'button-form']);
    echo $this->Form->button('New Meassages', ['type' => 'submit', 'class' => 'button-class']);
    echo $this->Form->end();
?>