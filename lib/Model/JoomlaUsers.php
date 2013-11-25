<?php

class Model_JoomlaUsers extends Model_Table
{
    public $table = 'starbr_users';

    function init()
    {
        parent::init();

        $this->addField("name");
        $this->addField("username");
        $this->addField("email");
        $this->addField("password");
        $this->addField("registerDate");
        $this->addField("params");
    }
}