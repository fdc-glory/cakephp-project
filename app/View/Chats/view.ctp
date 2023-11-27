

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
            <button class="delete-btn" id="deleteBtn" value="<?= h($chat_detail["ChatHistory"]["ch_id"]) ?>">delete</button>
        </div>

        <?php if (!empty($chat['u']['profile_img'])): ?>
            <img class="profile-img" src="<?= ('img/uploads/' . $chat['u']['profile_img']) ?>" alt="Profile Image">
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
    $(document).ready(function () {

        var chatId;

        <?php echo "chatId = " . json_encode($chat_id) . ";"; ?>

        $('#replyBtn').click(function () {
            
            var replyContent = $('#msg_content').val();

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

        $('#deleteBtn').click(function() {
            var chId = $(this).val();

            var confirmDelete = confirm('Are you sure you want to delete?'); 

            if (confirmDelete) {
                $.ajax({
                    type: 'POST',
                    url: '/apps/cakephp-project/chats/deleteChatDetail',
                    data: {chId:chId, chatId:chatId},
                    success: function(response){

                        location.reload(); // Reload the page
                        
                    },
                    error: function(error) {
                        console.error('Error in delete: ', error);
                    }
                })
            }
            
        })
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

    .delete-btn{
        margin-top: 25px; 
        margin-left: 5px;
        cursor: pointer;
        border: 1px;
        font-size: 10px;
        color: #333;
        float: left; 
    }
    

</style>