<?php
class page_register extends Page
{
    function init()
    {
        parent::init();

        if($this->api->auth->isLoggedIn())$this->api->redirect('index');
        $this->addField('Ceva bun');
    }
}