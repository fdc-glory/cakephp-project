<?php
    echo "<div style='margin-top: 20px;'></div>";

    echo $this->Form->create("Chat", ['url' => ['controller' => 'chats', 'action' => 'add']]);
    
    // echo $this->Form->select('user_id', $userData, ['style' => 'margin-bottom: 10px;']);
    echo $this->Form->search('user_name', ['id' => 'autocomplete-user', 'label' => 'User Name', 'style' => 'margin-bottom: 10px;']);
    echo "<br>";
    echo $this->Form->textarea("chat_text", ['style' => 'margin-bottom: 10px;']);
    echo $this->Form->end("Send");

?>


<script>
    $(function() {
        $("#autocomplete-user").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller' => 'chats', 'action' => 'autocomplete')); ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        $jsonResponse = data;
                        //dkwjf
                        console.log($jsonResponse);
                    }
                });
            },
            minLength: 2 
        });
    });
</script>