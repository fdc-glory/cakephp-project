<?php

    // echo "Update profile here";
    echo $this->Form->create("User");
    echo $this->Form->input("user_name");
    echo $this->Form->input("birthdate");
    echo $this->Form->input("gender");
    echo $this->Form->input("hubby");
    echo $this->Form->end("Update");
?>