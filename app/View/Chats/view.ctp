

<h2>Message Details</h2>



<?php 

    echo $this->Form->create(null, ['id' => 'replyForm']);
    echo $this->Form->control('msg_content', ['id' => 'msg_content']);
    echo $this->Form->submit('Reply Message', ['id'=>'replyBtn']);
    echo $this->Form->end();


    foreach ($chat_details as $chat_detail): ?>

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

<script>
    $(document).ready(function () {
        $('#replyBtn').click(function (e) {
            e.preventDefault();
            
            var replyContent = $('#msg_content').val();
            <?php echo "var chatId = " . json_encode($chat_id) . ";"; ?>

            $('#msg_content').val("");
            
            $.ajax({
                type: 'POST',
                url: '/apps/cakephp-project/chats/reply',
                data: {replyContent: replyContent, chatId: chatId},
                success: function (data) {

                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error('Error submitting reply:', errorThrown);
                }
            });
        });
    });
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

    img.profile-img {
        width: 75px;
        height: 75px;
        margin-left: 10px; 
        float: right; 
    }

</style>