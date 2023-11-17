<h1>Welcome to Message board</h1>

<?php
    echo $this->HTML->link("Logout", array('controller'=>'users', 'action'=>'logout'));

?>

<br>

<?php
    echo $this->HTML->link("Update account", array('controller'=>'users', 'action'=>'edit'));

?>