<?php
class page_register extends Page
{
    function init()
    {
        parent::init();
        $this->add('HtmlElement')
            ->setElement('h1')
            ->set('Register');
        $this->js(true)->_load('wizard/page_wizard');
        $model = $this->setModel('StoreRegister');

        $f = $this->add('Form');
        $f->setModel($model);
        $f->setClass('template-master-details-grid template-master-details-grid-rows atk-row');

        $f->template->trySet('fieldset','span4');
        $sep1 = $f->addSeparator('span4');
        $sep2 = $f->addSeparator('span4');
        $f->add('Order')->move($sep1, 'before', 'cb_onlinesell')->move($sep2, 'before', 'cb_address1')->now();

        $selectBtn = $f->getElement('cb_itemnumber')->addButton('+')
            ->js('click')->univ()->frameURL('Select Products',$this->api->getDestinationURL('selectProducts'));
        //$selectBtn->grid->add('Button', 'press');

        $f->getElement('cb_dealno')->setProperty('size', 40);
        $f->getElement('cb_email')->setProperty('size', 40);
        $f->getElement('cb_storeno')->setProperty('size', 40);
        $f->getElement('cb_phone1')->setProperty('size', 40);
        $f->getElement('cb_phone2')->setProperty('size', 40);
        $f->getElement('website')->setProperty('size', 40);
        $f->getElement('cb_type')->setProperty('size', 40);
        $f->getElement('cb_notes')->setProperty('size', 40);
        $f->getElement('cb_fax')->setProperty('size', 40);
        $f->getElement('cb_onlinesell')->setProperty('size', 40);
        $f->getElement('cb_dist1')->setProperty('size', 40);
        $f->getElement('cb_dist2')->setProperty('size', 40);
        $f->getElement('cb_dist1sale')->setProperty('size', 40);
        $f->getElement('cb_dist2sale')->setProperty('size', 40);
        $f->getElement('cb_code')->setProperty('size', 40);
        $f->getElement('cb_trade')->setProperty('size', 40);
        $f->getElement('cb_storenumber')->setProperty('size', 40);
        $f->getElement('cb_address1')->setProperty('size', 40);
        $f->getElement('cb_address2')->setProperty('size', 40);
        $f->getElement('cb_city')->setProperty('size', 40);
        $f->getElement('cb_state')->setProperty('size', 40);
        $f->getElement('cb_country')->setProperty('size', 40);
        $f->getElement('cb_zip')->setProperty('size', 40);
        $f->getElement('cb_itemnumber')->setProperty('size', 40);
        $f->getElement('cb_itemnumber')
            ->setProperty('style', 'width:210px')->setProperty('readonly', 'true');
        $f->addSubmit('Submit');

        if($f->isSubmitted()) {
            $f->model->set('firstname', $f->get('cb_storeno'));
            $f->model->set('lastname', " - ".$f->get('cb_storenumber')." ".$f->get('cb_city').", ".$f->get('cb_state'));
            $f->update();
            $this->api->redirect('thankyou');
        }
    }
}