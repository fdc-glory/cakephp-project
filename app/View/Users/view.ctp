<?php 
    // debug($user['User']['profile_img']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img {
            float: left; /* Float the image to the left */
            margin-right: 10px; /* Add some margin to separate the image from the text */
        }

        h3 {
            display: inline-block; /* Display the heading as an inline block */
        }
        p.user-details {
            line-height: 1.75; /* You can use unitless values, percentages, or specific units like "em" or "px" */
        }
        p{
            line-height: 1.25;;
        }
    </style>

</head>
<body>
    
    <?php
        echo $this->Html->image(
            'uploads/' . $user['User']['profile_img'],
            [
                'alt' => 'Profile Image',
                'width' => 150, 
                'height' => 170, 
            ]
        );
    ?>
    <h3  class="user"><?php echo $user["User"]["user_name"] ?></h3>
    <h5><?php echo $user["User"]["email"] ?></h5>
    <br>
    <p class="user-details">
        Birthdate: <?php echo $user["User"]["birthdate"] ?>
        <br>
        Gender: <?php echo $user["User"]["gender"] ?>
        <br>
        Joined: <?php echo $user["User"]["date_joined"] ?>
        <br>
        Last login: <?php echo $user["User"]["last_login_time"] ?>      
    </p>
    <p>Hubby: <br> <?php echo $user["User"]["hubby"] ?> </p>

    <?php echo $this->Html->link("Update profile", ['controller' => 'users', 'action' => 'edit', $user["User"]["user_id"] ]); ?>
     
    

</body>
</html>