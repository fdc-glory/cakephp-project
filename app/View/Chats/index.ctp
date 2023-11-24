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
            <button 
                class="close-btn" 
                onclick="deleteChat(<?= h($chat["Chat"]["chat_id"]); ?>)"
            >
                delete
            </button>

        </div>
        
        <?php if (!empty($chat['u']['profile_img'])): ?>
            <img class="profile-img" src="<?= ('../cakephp-project/app/webroot/img/uploads/' . $chat['u']['profile_img']) ?>" alt="Profile Image">
        <?php else: ?>
            <!-- If no profile image is available, display a default image -->
        <?php endif; ?>
        
    </div>
<?php endforeach; 
    echo $this->Paginator->prev(__('« previous '));
    echo $this->Paginator->numbers();
    echo $this->Paginator->next(__(' next »'));
?>

<script>

    function deleteChat(chatId) {
        $.ajax({
            type: 'POST',
            url: '/apps/cakephp-project/chats/delete',
            data: {chatId:chatId},
            success: function(response) {
                console.log('Response:', response);
            },
            error:function (xhr, textStatus, errorThrown) {
                console.error('Error submitting delete:', errorThrown);
            }
        });
    }

</script>

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

    p {
        margin: 0; 
    }

    small {
        display: block; 
        margin-top: 5px;
    }

    img.profile-img {
        width: 75px;
        height: 75px;
        margin-left: 10px; 
        float: right; 
    }
    .close-btn {
        margin-top: 20px; 
        margin-left: 5px;
        cursor: pointer;
        border: 1px;
        font-size: 12px;
        color: #333;
        float: left; 
    }

</style>











