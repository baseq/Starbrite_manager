<?php
class page_register extends Page
{
    function init()
    {
        parent::init();

        $this->allow('Starbrite', 'Star2013');
        $this->addField('Ceva bun');
    }
}