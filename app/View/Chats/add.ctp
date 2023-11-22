<?php
    echo "<div style='margin-top: 20px;'></div>";

    echo $this->Form->create("Chat", ['url' => ['controller' => 'chats', 'action' => 'add']]);
    
    echo $this->Form->select('user_id', $userData, ['style' => 'margin-bottom: 10px;']);
    echo "<br>";
    echo $this->Form->textarea("chat_text", ['style' => 'margin-bottom: 10px;']);
    echo $this->Form->end("Send");
?>
