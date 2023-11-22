<h2>Message Details</h2>

<?php foreach ($chat_details as $chat_detail): ?>

    <div class="chats">
        <div class="chat-content">
            <p><?= h($chat_detail["ChatHistory"]["msg_content"]) ?></p>
            <small><?= h($chat_detail["ChatHistory"]["created_at"]) ?></small>
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
        overflow: hidden; 
    }

    .chat-content {
        float: left; 
        width: calc(100% - 120px); 
    }

    img.profile-img {
        width: 75px;
        height: 75px;
        margin-left: 10px; 
        float: right; 
    }
</style>