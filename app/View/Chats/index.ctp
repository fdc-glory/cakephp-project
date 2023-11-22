<h2>Welcome to Message List</h2>
<?php
    // echo $user_id; 

    echo $this->Html->link("View profile", ['controller' => 'users', 'action' => 'view', $user_id]);

    echo $this->Form->create(null, ['url' => ['controller' => 'Chats', 'action' => 'add'], 'class' => 'button-form']);
    echo $this->Form->button('New Message', ['type' => 'submit', 'class' => 'button-class']);
    echo $this->Form->end();
?>
<br>









