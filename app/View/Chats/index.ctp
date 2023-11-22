<h2>Welcome to Message List</h2>
<?php
    // echo $user_id; 

    echo $this->Html->link("View profile", ['controller' => 'users', 'action' => 'view', $user_id]);

    echo $this->Form->create(null, ['url' => ['controller' => 'Chats', 'action' => 'add'], 'class' => 'button-form']);
    echo $this->Form->button('New Message', ['type' => 'submit', 'class' => 'button-class']);
    echo $this->Form->end();
?>

<h3>Chat Messages</h3>

<?php foreach ($chats as $chat): ?>
    <div class="chat-list">
        <div class="chat-content">
            <p><?= h($chat["Chat"]["last_message_sent"]) ?></p>
        </div>
    </div>
<?php endforeach; ?>











