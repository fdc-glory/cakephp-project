<?php

    echo $this->Form->create("User");
    echo $this->Form->input("email", array('required' => true));
    echo $this->Form->input("password", array('required' => true));
    echo $this->Form->end("Login");

?>