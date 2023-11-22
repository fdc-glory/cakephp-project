<?php
    echo "<div style='margin-top: 20px;'></div>";

    echo $this->Form->create("Message", ['url' => ['controller' => 'messages', 'action' => 'add']]);
    
    echo $this->Form->select('receiver_id', $userData, ['style' => 'margin-bottom: 10px;']);
    echo "<br>";
    echo $this->Form->textarea("msg_content", ['style' => 'margin-bottom: 10px;']);
    echo $this->Form->end("Send");
?>
