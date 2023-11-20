<h1>Welcome to Message board</h1>

<br>

<?php
    // echo $user_id; 

    echo $this->Html->link("View profile", ['controller' => 'users', 'action' => 'view', $user_id]);

?>