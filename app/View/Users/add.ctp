<?php

    // echo "Registration here";

    echo $this->Form->create("User");
    echo $this->Form->input("user_name", array('required' => true));
    echo $this->Form->input("email", array('required' => true));
    echo $this->Form->input("password", array('required' => true));
    echo $this->Form->input("password_confirmation", array('type' => 'password', 'required' => true));
    echo $this->Form->end("Register");

?>

