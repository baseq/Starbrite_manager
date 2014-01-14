<?php
class page_retailers extends page_base
{
    private $form;
    function init()
    {
        parent::init();
        $this->add('HtmlElement')
            ->setElement('h1')
            ->set('Retailers');
        $this->js(true)->_load('wizard/page_wizard');
        $this->js(true)->tooltip();

        $rootModel = $this->add('Model_Retailer');
        $id = null;

        if (isset($_GET['selected-id'])) {
            $id = $_GET['selected-id'];
        } elseif ($this->recall('selected-id') == null) {
            $rootModel->tryLoadAny();
            $id = $rootModel['id'];
        } else {
            $id = $this->recall('selected-id');
        }

        if (!$rootModel->loaded() && $id != null) {
            $rootModel->tryLoad($id);
            if (!$rootModel->loaded()) {
                $rootModel->tryLoadAny();
                $id = $rootModel['id'];
            }
        }
        $this->memorize('selected-id', $id);
        $crud = $this->add('View_RetailerCRUD', array('grid_class' => 'Grid_Page_Wizard_MasterDetails', 'allow_edit' => false, 'allow_add' => false));
        $crud->setClass('template-master-details-grid template-master-details-grid-rows');
        $modelino = $crud->setModel('Retailer');

        //$rootModel->addCondition('id', '=', $id);
        $tabs = $this->add('Tabs');
        $tabDetails = $tabs->addTab('Retailer Details');


        $formDetails = $tabDetails->add('Form');
        $this->form = $formDetails;
        $formDetails->addSubmit("Save");
        $formDetails->setModel($rootModel);
        $formDetails->setClass('ignore_changes template-master-details-grid template-master-details-grid-rows atk-row');

        $formDetails->template->trySet('fieldset', 'span4');
        $sep1 = $formDetails->addSeparator('span4');
        $sep2 = $formDetails->addSeparator('span4');

        if($this->api->recall('flag')){
            $formDetails->getElement('cb_itemnumber')->set($this->api->recall('retailers_selected_record'));
            $this->api->forget('flag');
        } else {
            $this->api->memorize('retailers_selected_record', $formDetails->get('cb_itemnumber'));
        }

        $selectBtn = $formDetails->add('Button', 'button')->set('+')->setStyle(array('margin-left'=>'350px', 'top'=>'-98px'));
        $selectBtn->js('click')->univ()->frameURL('Select Products', $this->api->url('selectProductsRetailers', array('page_ret'=>$this->name)));
        $label1 = $formDetails->add('HtmlElement')
            ->setElement('h4')
            ->set('CONTACT INFO');
        $label2 = $formDetails->add('HtmlElement')
            ->setElement('h4')
            ->set('DEALER INFO');
        $label3 = $formDetails->add('HtmlElement')
            ->setElement('h4')
            ->set('INTERNAL USE ONLY');
        $formDetails->add('Order')->move($label1, 'before', 'cb_storeno')
            ->move($label2, 'before', 'cb_itemnumber')
            ->move($label3, 'before', 'cb_goldstore')
            ->now();
        $formDetails->add('Order')->move($sep1, 'before', 'cb_fax')
            ->move($sep2, 'before', 'cb_dist2')
            ->move($selectBtn, 'after', 'cb_itemnumber')
            ->now();

        //field size
        $formDetails->getElement('firstname')->js(true)->parent()->parent()->hide();
        $formDetails->getElement('lastname')->js(true)->parent()->parent()->hide();
        $formDetails->getElement('user_id')->js(true)->parent()->parent()->hide();
        $formDetails->getElement('cb_email')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_dealno')->js(true)->parent()->parent()->hide();
        $formDetails->getElement('cb_storeno')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_phone1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_phone2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('website')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_type')->setProperty('size', 40)->setProperty('style','width:218px;');
        $formDetails->getElement('cb_notes')->setProperty('cols', 42)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_fax')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_onlinesell')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_dist1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_dist2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_dist1sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_dist2sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        //$formDetails->getElement('cb_code')->setProperty('display','none');
        $formDetails->getElement('cb_trade')->setProperty('size', 40)->setProperty('style','width:218px;');
        $formDetails->getElement('cb_storenumber')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_address1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_address2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_city')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_expiredate')->setProperty('size', 34);
        //$formDetails->getElement('user_id')->setProperty('size', 40);

        $country_list = $formDetails->model->countryList();
        $region_list = $formDetails->model->regionList();

        // country field
        $formDetails->getElement('cb_country')
            ->setProperty('style', 'width:220px')
            ->setProperty('style','text-transform:uppercase;')
            ->setProperty('style','width:218px;')
            ->setValueList($country_list);

        // state field
        $formDetails->getElement('cb_state')
            ->setProperty('style', 'width:220px')
            ->setProperty('style','text-transform:uppercase;')
            ->setProperty('style','width:218px;');


        $country = $formDetails->get('cb_country');
        $region = $formDetails->get('cb_state');
        $countryIndex = null;

        if(isset($_POST[$formDetails->getElement('cb_country')->name])) {
            $formDetails->getElement('cb_country')->set($_POST[$formDetails->getElement('cb_country')->name]);
            $countryIndex = $formDetails->get('cb_country');
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

            $formDetails->getElement('cb_state')->setValueList($region_list[$countryIndex]);
            if ($regionIndex != null) {
                $formDetails->set('cb_state', $regionIndex);
            }
            $formDetails->getElement('cb_state')->js(true)->parent()->parent()->show();
        } else {
            $formDetails->getElement('cb_state')->js(true)->parent()->parent()->hide();
        }
        if($countryIndex!=null){
            $formDetails->set('cb_country', $countryIndex);
        }

        $formDetails->getElement('cb_country')->js('change', $formDetails->js()->atk4_form('reloadField', 'cb_state', array(
                $this->api->url(),
                'country' => $formDetails->getElement('cb_country')->js()->val())
        ));

        $formDetails->getElement('cb_zip')->setProperty('size', 40);
        $formDetails->getElement('cb_itemnumber')->setProperty('cols', 42);//->setProperty('readonly', 'true');


        $tabProducts = $tabs->addTab('Products');
        $productGrid = $tabProducts->add('Grid');
        $productGrid->addPaginator(5);
        $productModel = $productGrid->setModel('Product');
        $productModel->addProductKeyFilter($rootModel->get('cb_itemnumber'));

        if ($crud->grid) {
            //$crud->grid->addButton('Add Store')->js('click')->univ()->frameURL('Register New Retailer',$this->api->getDestinationURL('register'));

            $crud->grid->addButton('Add Store')->js('click')->univ()->frameURL('Register New Store',$this->api->getDestinationURL('newstoreregister'));

            $crud->grid->addPaginator(5);
            $crud->grid->removeColumn('user_id');
            $crud->grid->removeColumn('email');

            //$crud->grid->getColumn('cb_dealno')->makeSortable();
            //$grid->addQuickSearch('name,phone,email','QuickSearch',array('show_cancel'=>true));

            $qs1 = $crud->grid->addQuickSearch(array('name', 'cb_phone1', 'cb_phone2', 'email'))->addClass('small-form-search');
            $qs1->search_field->setAttr('placeholder', 'Name, Email, Phone');

            $qs2 = $crud->grid->addQuickSearch(array('cb_address2', 'cb_address1', 'cb_city', 'cb_state', 'cb_zip'))->addClass('small-form-search');
            $qs2->search_field->setAttr('placeholder', 'Address, City, State, Zip');

            $qs3 = $crud->grid->addQuickSearch(array('cb_storeno'))->addClass('small-form-search');
            $qs3->search_field->setAttr('placeholder', 'Store Name');

            $qf = $crud->grid->add('DuplicatesFilter', null, 'quick_search')->useWith($crud->grid)->useFields(array('address'));

            $qs = array($qs1, $qs2, $qs3, $qf);

            $button = $crud->grid->addButton('Reset', 'resetbutton');
            $button->js('click', $crud->grid->js()->reload(array('reset'=>1)));

            if(isset($_GET['reset'])) {
                foreach ($qs as $q) {
                    $q->forget();
                }
                $qf->forget();
            }

            $crud->grid->js('click', $this->js()->_selectorThis()->gridMasterDetails(true))->_selector('#' . $crud->grid->name . ' tr');
            $crud->grid->js('gridClick', $this->js()->reload(array(
                'selected-id' => $this->js(null, 'arguments[arguments.length-1]'),
                'selected-tab' => $tabs->js()->tabs('option', 'selected')
            )))->_selector('#' . $crud->grid->name . ' tr');
            $crud->grid->js(true)->_selector('#' . $crud->grid->name . ' tr[data-id="' . $id . '"]')->gridMasterDetails(false);
        }


        if ($formDetails->isSubmitted()) {
            //replace all non digits or comma from the cb_itemnumber field
            $str = nl2br($formDetails->get('cb_itemnumber'));

            $str = str_replace('<br />',',',$str);
            $str = str_replace(', ',',',$str);
            $str = str_replace(' ,',',',$str);
            $str = preg_replace('/ +/',',',$str);
            $str = preg_replace('/[^0-9,]/','', $str);
            $str = preg_replace('/,+/',',',$str);
            $str = preg_replace('/,$/','',$str);

            $formDetails->set('cb_itemnumber', $str);

            $fields = array('cb_email', 'cb_storeno', 'cb_phone1', 'cb_phone2', 'website', 'cb_type', 'cb_notes', 'cb_fax',
                'cb_dist1', 'cb_dist2', 'cb_dist1sale', 'cb_dist2sale', 'cb_trade', 'cb_storenumber', 'cb_address1',
                'cb_address2', 'cb_city');
            foreach ($fields as $value){
                $formDetails->set($value, strtoupper($formDetails->get($value)));
            }
            //update cb_fieldsetname for stores with missing phone and missing notes
            $sql1 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is null or cb_notes = '')
              ";

            //update cb_fieldsetname for stores with missing phone, but with notes
            //
            $sql2 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is not null and cb_notes <> '')
              ";

            //update cb_fieldsetname for stores with missing notes, but with phone
            $sql3 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                 END
                                where (cb_notes is null or cb_notes = '') and (cb_phone1 is not null and cb_phone1 <> '')
              ";

            //update cb_fieldsetname for stores with notes and with phone
            $sql4 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                        WHERE  ( cb_notes IS NOT NULL AND cb_notes <> '' ) AND ( cb_phone1 IS NOT NULL AND cb_phone1 <> '' )
              ";

//</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px>
            try {
                $formDetails->update();
                $joomlausers = $this->add('Model_JoomlaUsers');
                $joomlausers->load($formDetails->model->get('user_id'));
                $joomlausers->set('name', $formDetails->model->get('firstname').$formDetails->model->get('lastname'));
                if($formDetails->model->get('cb_email')) {
                    $joomlausers->set('email', $formDetails->model->get('cb_email'));
                }
                $joomlausers->save();
                $q = $this->api->db->query($sql1);
                $q = $this->api->db->query($sql2);
                $q = $this->api->db->query($sql3);
                $q = $this->api->db->query($sql4);
                $this->api->forget('retailers_selected_record');
                $formDetails->js()->univ()->successMessage("Saved.")->execute();
            }
            catch(Exeption $e) {
                $formDetails->js()->univ()->alert("Failed to save.")->execute();
            }
        }
    }
    function render()
    {
        parent::render();

        $this->js('addSelectedText', $this->form->js()->atk4_form('reloadField', 'cb_itemnumber'));

    }
}