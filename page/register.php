<?php
class page_register extends Page
{
	private $form;
	
    function init()
    {
        parent::init();
        $this->add('HtmlElement')
            ->setElement('h1')
            ->set('Register');
        $this->js(true)->_load('wizard/page_wizard');
        $model = $this->setModel('NewStoreRegister');

       	$f = $this->add('Form');
        $this->form = $f;
        $f->setModel($model);
        $f->setClass('template-master-details-grid template-master-details-grid-rows atk-row');

        $selectBtn = $f->add('Button', 'button')->set('+')->setStyle(array('margin-left'=>'350px', 'top'=>'-98px'));
        $selectBtn->js('click')->univ()->frameURL('Select Products',$this->api->getDestinationURL('selectProducts', array('page_reg'=>$this->name)));

        $label1 = $f->add('HtmlElement')
            ->setElement('h4')
            ->set('CONTACT INFO');
        $label2 = $f->add('HtmlElement')
            ->setElement('h4')
            ->set('DEALER INFO');

        $f->template->trySet('fieldset','span4');
        $sep1 = $f->addSeparator('span4');
        $sep2 = $f->addSeparator('span4');

        $f->add('Order')->move($label1, 'before', 'cb_storeno')->move($label2, 'before', 'cb_itemnumber')->now();
        $f->add('Order')->move($sep1, 'before', $label2)->move($selectBtn, 'after', 'cb_itemnumber')->now();

        //$f->add('Order')->move($sep1, 'before', 'cb_dist1')->move($sep2, 'before', 'cb_address1')->move($selectBtn, 'after', 'cb_itemnumber')->now();
        
        
        //$selectBtn->grid->add('Button', 'press');
        
        //$this->js('addSelectedText', $f->js()->atk4_form('reloadField', 'cb_itemnumber'))->_selector('body');
        
       //$f->getElement('cb_dealno')->setProperty('size', 40);
        $f->getElement('cb_email')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_storeno')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_phone1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_phone2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('website')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        //$f->getElement('cb_type')->setProperty('size', 40)->setProperty('style','width:218px;');
        //$f->getElement('cb_notes')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_fax')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        //$f->getElement('cb_onlinesell')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist1sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist2sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        //$f->getElement('cb_code')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_trade')->setProperty('size', 40)->setProperty('style','width:218px;');
        $f->getElement('cb_storenumber')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_address1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_address2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_city')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        if($this->api->recall('flag')){
            $f->getElement('cb_itemnumber')->set($this->api->recall('selected_record'));
            $this->api->forget('flag');
        } else {
            if ($f->get('cb_itemnumber')) {
                $this->api->memorize('selected_record', $f->get('cb_itemnumber'));
            } else {
                $this->api->forget('selected_record');
            }
        }        //TO DO: make this happen
        $country_list = $f->model->countryList();
        $region_list = $f->model->regionList();

        // country field
        $f->getElement('cb_country')
            ->setProperty('style', 'width:220px')
            ->setProperty('style','text-transform:uppercase;')
            ->setProperty('style','width:218px;')
            ->setValueList($country_list);

        // state field
        $f->getElement('cb_state')
            ->setProperty('style', 'width:220px')
            ->setProperty('style','text-transform:uppercase;')
            ->setProperty('style','width:218px;');


        $country = $f->get('cb_country');
        $region = $f->get('cb_state');
        $countryIndex = null;
        if(isset($_POST[$f->getElement('cb_country')->name])) {
            $f->getElement('cb_country')->set($_POST[$f->getElement('cb_country')->name]);
            $countryIndex = $f->get('cb_country');
        } else if(isset($_GET['country'])){
            $countryIndex = $_GET['country'];
        }
        if ($countryIndex == null) {
            foreach ($country_list as $k => $c) {
                if (strcmp($country, $c) == 0) {
                    $countryIndex = $k;
                    break;
                }
            }
        }
        if($countryIndex==null) $countryIndex = 236;
        if (isset($region_list[$countryIndex])) {
            $regionIndex = null;
            foreach ($region_list[$countryIndex] as $k => $r) {
                if (strcmp($region, $r) == 0) {
                    $regionIndex = $k;
                    break;
                }
            }

            $f->getElement('cb_state')->setValueList($region_list[$countryIndex]);
            if ($regionIndex != null) {
                $f->set('cb_state', $regionIndex);
            }
            $f->getElement('cb_state')->js(true)->parent()->parent()->show();
        } else {
            $f->getElement('cb_state')->js(true)->parent()->parent()->hide();
        }
        if($countryIndex!=null){
            $f->set('cb_country', $countryIndex);
        }
        else {
            $f->set('cb_country', 236);
        }

        $f->getElement('cb_country')->js('change', $f->js()->atk4_form('reloadField', 'cb_state', array(
                $this->api->url(),
                'country' => $f->getElement('cb_country')->js()->val())
        ));

        $f->getElement('cb_zip')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_itemnumber')->setProperty('cols', 42);
        //$f->getElement('cb_itemnumber')->setProperty('readonly', 'true');
        $f->addSubmit('Submit');

        if($f->isSubmitted()) {

            //replace all non digits or comma from the cb_itemnumber field
            $str = nl2br($f->get('cb_itemnumber'));

            $str = str_replace('<br />',',',$str);
            $str = str_replace(', ',',',$str);
            $str = str_replace(' ,',',',$str);
            $str = preg_replace('/ +/',',',$str);
            $str = preg_replace('/[^0-9,]/','', $str);
            $str = preg_replace('/,+/',',',$str);
            $str = preg_replace('/,$/','',$str);

            $f->set('cb_itemnumber', $str);

            $fields = array('cb_email', 'cb_storeno', 'cb_phone1', 'cb_phone2', 'website', 'cb_fax',
                'cb_dist1', 'cb_dist2', 'cb_dist1sale', 'cb_dist2sale', 'cb_trade', 'cb_storenumber', 'cb_address1',
                'cb_address2', 'cb_city');
            foreach ($fields as $value){
                $f->set($value, strtoupper($f->get($value)));
            }

            $pass = base64_encode(pack("H*", sha1('gicule')));
            $cbdealno_comprof = $this->api->db->getOne('SELECT MAX(cb_dealno) FROM starbr_comprofiler where cb_dealno like \'A%\'');
            $cbdealno_comprof = str_replace('A', '', $cbdealno_comprof);
            $cbdealno_storeregister = $this->api->db->getOne('SELECT MAX(cb_dealno) FROM starbr_store_registration where cb_dealno like \'A%\'');
            $cbdealno_storeregister = str_replace('A', '', $cbdealno_storeregister);

            $cbdealno = max(intval($cbdealno_comprof), intval($cbdealno_storeregister)) + 1;
            $cbdealno = 'A'.str_pad($cbdealno, 6, '0', STR_PAD_LEFT);

            $f->model->set('cb_dealno',  $cbdealno);
            $f->model->set('firstname', $f->get('cb_storeno'));
            $f->model->set('lastname', " - ".$f->get('cb_storenumber')." ".$f->get('cb_city').", ".$region_list[$f->get('cb_country')][$f->get('cb_state')]);
            $f->model->set('username', $cbdealno);
            $f->model->set('password', $pass);
            $f->model->set('id', max(intval($cbdealno_comprof), intval($cbdealno_storeregister)) + 1);
            if (!$f->get('cb_email')) {
                $f->model->set('email', $cbdealno.'@invalid.com');
            } else {
                $f->model->set('email', $f->get('cb_email'));
            }

            $f->model->set('firstname', $f->get('cb_storeno'));
            $f->model->set('lastname', " - ".$f->get('cb_storenumber')." ".$f->get('cb_city').", ".$f->get('cb_state'));

            $f->update();
            $this->api->redirect('thankyou');
        }
    }
    
    function render()
    {
    	parent::render();

    	$this->js('addSelectedText', $this->form->js()->atk4_form('reloadField', 'cb_itemnumber'));
    	 
    }
}