<?php
class page_register extends Page
{
    function init()
    {
        parent::init();
        $this->js(true)->_load('wizard/page_wizard');
        $model = $this->setModel('StoreRegister');

        $f = $this->add('Form');
        $f->setModel($model);
        $f->setClass('template-master-details-grid template-master-details-grid-rows atk-row');

        $f->template->trySet('fieldset','span4');
        $sep1 = $f->addSeparator('span4');
        $sep2 = $f->addSeparator('span4');
        $f->add('Order')->move($sep1, 'before', 'cb_fax')->move($sep2, 'before', 'cb_address1')->now();

        $selectBtn = $f->getElement('cb_itemnumber')->addButton('Select Products')
            ->js('click')->univ()->dialogURL('Select Products',$this->api->getDestinationURL('selectProducts'));

        $f->addSubmit('Submit');

        if($f->isSubmitted()) {
            $f->model->set('firstname', $f->get('cb_storeno'));
            $f->model->set('lastname', " - ".$f->get('cb_storenumber')." ".$f->get('cb_city').", ".$f->get('cb_state'));
            $f->update();
            $this->api->redirect('thankyou');
        }
    }
}