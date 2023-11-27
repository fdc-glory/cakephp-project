
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Message</title>
</head>
<body>
    <?php
        echo $this->Form->create("Chat", ['url' => ['controller' => 'chats', 'action' => 'add']]); 
    ?>
    <div class="search-wrapper">
        <!-- <label for="search" class="search">Search User</label> -->
        <?= $this->Form->input('search', array('type' => 'search', 'id' => 'search', 'data-search' => true)); ?>
        <?= $this->Form->input('user_id', ['type' => 'hidden', 'id' => 'search-id']) ?>

    </div>
    <div class="user-cards" data-user-cards-container></div>
    <template data-user-template>
        <div class="card">
            <div class="header" data-header></div>
            <div class="body" data-body></div>
        </div>
    </template>
    
    <?php 
        echo $this->Form->textarea("chat_text", ['style' => 'margin-bottom: 10px;']);
        echo $this->Form->end("Send"); 
    ?>
</body>
</html>



<script>
    // SEARCH USER
    const userCardTemplate = document.querySelector("[data-user-template]")
    const userCardContainer = document.querySelector("[data-user-cards-container]")

    const searchInput = document.querySelector("[data-search]")

    let users = []
    searchInput.addEventListener("input", e => {
        const value = e.target.value.toLowerCase()
        // console.log(value)
        
        users.forEach(user => {
            const isVisible = 
            (user.user_id && user.user_id.toLowerCase().includes(value)) ||
            (user.user_name && user.user_name.toLowerCase().includes(value))
            user.element.classList.toggle("hide", !isVisible)
        })
        
    })

    $(function() {

        $("#search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller' => 'chats', 'action' => 'autocomplete')); ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        users = data.map(user => {
                            const card = userCardTemplate.content.cloneNode(true).children[0]
                            const header = card.querySelector("[data-header]")
                            const body = card.querySelector("[data-body]")
                            header.textContent = user.User.user_name
                            // console.log(user)
                            body.textContent = user.User.email 

                            card.addEventListener("click", function() {
                                // Access the user_id from the clicked card's data
                                const userName = user.User.user_name;
                                const userId = user.User.user_id
                                
                                $("#search").val(userName);
                                $("#search-id").val(userId);
                            });

                            userCardContainer.append(card)

                            return { user_name: user.user_name, email: user.email, element: card }
                        });
                    

                    }
                });
            },
            minLength: 2 
        });

        
    });

    // END SEARCH USER
</script>

<style>

    .search-wrapper {
        display: flex;
        flex-direction: column;
        gap: .25rem;
    }

    input {
        font-size: 1rem;
    }

    .user-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: .25rem;
        margin-top: 1rem;
    }

    .card {
        border: 1px solid black;
        background-color: white;
        padding: .5rem;
    }

    .card > .header {
        margin-bottom: .25rem;
    }

    .card > .body {
        font-size:  .8rem;
        color: #777;
    }

    .hide {
        display: none;
    }

</style>