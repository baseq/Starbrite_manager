<?php
class page_register extends Page
{
    function init()
    {
        parent::init();
        $this->js(true)->_load('wizard/page_wizard');


        $f = $this->add('Form');
        $f->setModel('Model_Store');
        $f->setClass('template-master-details-grid template-master-details-grid-rows atk-row');

        $f->template->trySet('fieldset','span4');
        $sep1 = $f->addSeparator('span4');
        $sep2 = $f->addSeparator('span4');
        $f->add('Order')->move($sep1, 'before', 'cb_fax')->move($sep2, 'before', 'cb_address1')->now();

        $f->addSubmit('Submit');
        $f->getElement('cb_itemnumber')->addButton('Buton');
    }
}