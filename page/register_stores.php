<?php
class page_signup extends Page
{
    function init()
    {
        parent::init();

/*        if ($this->api->auth->isLoggedIn()) {

        }*/

        $this->addField('Ceva bun');
    }
}