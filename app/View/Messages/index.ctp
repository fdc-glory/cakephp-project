<h2>Welcome to Message List</h2>
<?php
    // echo $user_id; 

    echo $this->Html->link("View profile", ['controller' => 'users', 'action' => 'view', $user_id]);

    echo $this->Form->create(null, ['url' => ['controller' => 'Messages', 'action' => 'add'], 'class' => 'button-form']);
    echo $this->Form->button('New Message', ['type' => 'submit', 'class' => 'button-class']);
    echo $this->Form->end();
?>
<br>

<h3>Chat Messages</h3>


<?php foreach ($messages as $message): ?>
    <div class="message-list">
        <div class="text-content">
            <p><?= h($message['m']['msg_content']) ?></p>
            <small><?= h($message['m']['timestamp']) ?></small>
        </div>
        
        <?php if (!empty($message['u_receiver']['receiver_profile_img'])): ?>
            <img class="profile-img" src="<?= ('img/uploads/' . $message['u_receiver']['receiver_profile_img']) ?>" alt="Profile Image">
        <?php else: ?>
            <!-- If no profile image is available, display a default image -->
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<style>
    .message-list {
        border: 2px solid #333; 
        padding: 5px; 
        margin-top: 2px;
        overflow: hidden; /* Clear the float to contain the image within the container */
    }

    .text-content {
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





