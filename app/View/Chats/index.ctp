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
    <div class="chats">
        <div class="chat-content">
            <p><?= $this->HTML->link($chat["Chat"]["last_message_sent"], ['controller' => 'chats', 'action' => 'view', $chat["Chat"]["chat_id"]]) ?></p>
            <small><?= h($chat["ch"]["last_message_created_at"]) ?> </small>
        </div>
        <?php if (!empty($chat['u']['profile_img'])): ?>
            <img class="profile-img" src="<?= ('img/uploads/' . $chat['u']['profile_img']) ?>" alt="Profile Image">
        <?php else: ?>
            <!-- If no profile image is available, display a default image -->
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<style>
    .chats {
        border: 1px solid #333; 
        padding: 5px; 
        margin-top: 2px;
        overflow: hidden; /* Clear the float to contain the image within the container */
    }

    .chat-content {
        float: left; /* Float the text content to the left */
        width: calc(100% - 120px); /* Adjust the width based on the image width and margin */
    }

    p {
        margin: 0; /* Remove default margin from paragraphs */
    }

    small {
        display: block; /* Make the timestamp a block element to appear on a new line */
        margin-top: 5px;
    }

    img.profile-img {
        width: 75px;
        height: 75px;
        margin-left: 10px; /* Optional: Add margin to the left of the image for spacing */
        float: right; /* Float the image to the right */
    }
</style>











