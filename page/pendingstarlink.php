<?php
class page_pendingstarlink extends page_base
{
    private $form;
    function init()
    {
        parent::init();
        $this->add('HtmlElement')
            ->setElement('h1')
            ->set('Pending Retailers');
        $columns = array('cb_plug_lat', 'cb_plug_lng', 'email', 'cb_name', 'confirmed', 'username', 'cb_dealno', 'cb_fieldsetname');
        $this->js(true)->_load('wizard/page_wizard');
        $this->js(true)->tooltip();
        $rootModel = $this->add('Model_Pendingstarlink');
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
        $crud = $this->add('CRUD', array('grid_class' => 'Grid_Page_Wizard_MasterDetails', 'allow_edit' => false, 'allow_add' => false));
        $crud->setClass('template-master-details-grid template-master-details-grid-rows');
        $crud->setModel('Pendingstarlink');
        foreach($columns as $column) {
            $crud->grid->removeColumn($column);
        }
        $rootModel->addCondition('id', '=', $id);
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
        $formDetails->add('Order')->move($sep1, 'before', 'cb_notes')->move($sep2, 'before', 'cb_address1')->now();

        //field size
        $formDetails->getElement('firstname')->setProperty('size', 40);
        $formDetails->getElement('lastname')->setProperty('size', 40);
        $formDetails->getElement('cb_email')->setProperty('size', 40);
        $formDetails->getElement('cb_storeno')->setProperty('size', 40);
        $formDetails->getElement('cb_phone1')->setProperty('size', 40);
        $formDetails->getElement('cb_phone2')->setProperty('size', 40);
        $formDetails->getElement('website')->setProperty('size', 40);
        $formDetails->getElement('cb_type')->setProperty('size', 40);
        $formDetails->getElement('cb_notes')->setProperty('size', 40);
        $formDetails->getElement('cb_fax')->setProperty('size', 40);
        $formDetails->getElement('cb_onlinesell')->setProperty('size', 40);
        $formDetails->getElement('cb_dist1')->setProperty('size', 40);
        $formDetails->getElement('cb_dist2')->setProperty('size', 40);
        $formDetails->getElement('cb_dist1sale')->setProperty('size', 40);
        $formDetails->getElement('cb_dist2sale')->setProperty('size', 40);
        $formDetails->getElement('cb_code')->setProperty('size', 40);
        $formDetails->getElement('cb_trade')->setProperty('size', 40);
        $formDetails->getElement('cb_storenumber')->setProperty('size', 40);
        $formDetails->getElement('cb_address1')->setProperty('size', 40);
        $formDetails->getElement('cb_address2')->setProperty('size', 40);
        $formDetails->getElement('cb_city')->setProperty('size', 40);
        $formDetails->getElement('cb_state')->setProperty('size', 40);
        $formDetails->getElement('cb_country')->setProperty('size', 40);
        $formDetails->getElement('cb_zip')->setProperty('size', 40);
        $formDetails->getElement('cb_itemnumber')->setProperty('size', 40)->setProperty('readonly', 'true');
        $formDetails->getElement('cb_expiredate')->setProperty('size', 34);
        if($this->api->recall('flag')){
            $formDetails->getElement('cb_itemnumber')->set($this->api->recall('selected_record'));
            $this->api->forget('flag');
        } else {
            $this->api->memorize('selected_record', $formDetails->get('cb_itemnumber'));
        }

        $selectBtn = $formDetails->add('Button', 'button')->set('+')->setStyle(array('margin-left'=>'320px', 'top'=>'-31px', 'margin-bottom'=>'-31px'));
        $selectBtn->js('click')->univ()->frameURL('Select Products', $this->api->url('selectProducts'));
        $formDetails->getElement('approved')->empty_text = null;
        $formDetails->template->trySet('fieldset','span4');
        $sep1 = $formDetails->addSeparator('span4');
        $formDetails->add('Order')->move($selectBtn, 'after', 'cb_itemnumber')->now();


        if ($crud->grid) {
            $crud->grid->addButton('Add Store')->js('click')->univ()->frameURL('Register New Store',$this->api->getDestinationURL('newstoreregister'));
            $crud->grid->addPaginator(5);
            $quick_search = $crud->grid->addQuickSearch(array('cb_phone1', 'cb_phone2', 'email'))->addClass('small-form-search');
            $quick_search->search_field->setAttr('placeholder', 'Email, Phone');

            $quick_search = $crud->grid->addQuickSearch(array('cb_address2', 'cb_address1', 'cb_city', 'cb_state', 'cb_zip'))->addClass('small-form-search');
            $quick_search->search_field->setAttr('placeholder', 'Address, City, State, Zip');

            $quick_search = $crud->grid->addQuickSearch(array('cb_storeno'))->addClass('small-form-search');
            $quick_search->search_field->setAttr('placeholder', 'Store Name');

            $quick_filter = $crud->grid->add('DuplicatesFilter', null, 'quick_search')->useWith($crud->grid)->useFields(array('address'));
            $crud->grid->js('click', $this->js()->_selectorThis()->gridMasterDetails(true))->_selector('#' . $crud->grid->name . ' tr');
            $crud->grid->js('gridClick', $this->js()->reload(array(
                'selected-id' => $this->js(null, 'arguments[arguments.length-1]'),
                'selected-tab' => $tabs->js()->tabs('option', 'selected')
            )))->_selector('#' . $crud->grid->name . ' tr');
            $crud->grid->js(true)->_selector('#' . $crud->grid->name . ' tr[data-id="' . $id . '"]')->gridMasterDetails(false);
        }
        $export = $crud->add("StarlinkExport");
        $this->js("reload", $this->js()->reload())->_selector("body");
        if ($formDetails->model->get('approved') == 1) {
            $formDetails->getElement('approved')->disable();
        }

        if ($formDetails->isSubmitted()) {
            $formDetails->update();

            if ($formDetails->get('approved') == 1) {

                $comprof = $this->add('Model_Retailer');

                $joomlausers = $this->add('Model_JoomlaUsers');
                if ($formDetails->model->get('approved') == 1) {
                    $joomlausers->addCondition('username', $formDetails->model->get('username'));
                    $joomlausers->tryLoadAny();
                    //$joomlausers->load($formDetails->model->get('user_id'));
                    if($formDetails->model->get('cb_email')) {
                        $joomlausers->set('email', $formDetails->model->get('cb_email'));
                    }
                    else {
                        $joomlausers->set('email', $formDetails->model->get('email'));
                        $joomlausers->set('email', $formDetails->model->get('email'));
                    }
                }
                $joomlausers->set('name', $formDetails->model->get('firstname').$formDetails->model->get('lastname'));
                $joomlausers->set('username', $formDetails->model->get('username'));
                $joomlausers->set('password', $formDetails->model->get('password'));
                $joomlausers->set('registerDate', date('Y-m-d h:i'));
                $joomlausers->set('params', '{}');
                $joomlausers->save();
                $user_id = $joomlausers->get('id');

                $isApproved = false;
                if ($formDetails->model->get('approved') == 1) {
                    $comprof->addCondition('cb_dealno', $formDetails->model->get('cb_dealno'));
                    $comprof->tryLoadAny();
                    $isApproved = true;
                }
                $comprof->set('approved', $formDetails->model->get('approved'));
                $comprof->set('cb_goldstore', $formDetails->model->get('cb_goldstore'));
                $comprof->set('cb_expiredate', $formDetails->model->get('cb_expiredate'));
                $comprof->set('cb_dealno', $formDetails->model->get('cb_dealno'));
                $comprof->set('firstname', $formDetails->model->get('firstname'));
                $comprof->set('lastname', $formDetails->model->get('lastname'));
                $comprof->set('cb_email', $formDetails->model->get('cb_email'));
                $comprof->set('cb_storeno', $formDetails->model->get('cb_storeno'));
                $comprof->set('cb_phone1', $formDetails->model->get('cb_phone1'));
                $comprof->set('cb_phone2', $formDetails->model->get('cb_phone2'));
                $comprof->set('website', $formDetails->model->get('website'));
                $comprof->set('cb_type', $formDetails->model->get('cb_type'));
                $comprof->set('cb_notes', $formDetails->model->get('cb_notes'));
                $comprof->set('cb_fax', $formDetails->model->get('cb_fax'));
                $comprof->set('cb_onlinesell', $formDetails->model->get('cb_onlinesell'));
                $comprof->set('cb_dist1', $formDetails->model->get('cb_dist1'));
                $comprof->set('cb_dist2', $formDetails->model->get('cb_dist2'));
                $comprof->set('cb_dist1sale', $formDetails->model->get('cb_dist1sale'));
                $comprof->set('cb_dist2sale', $formDetails->model->get('cb_dist2sale'));
                $comprof->set('cb_code', $formDetails->model->get('cb_code'));
                $comprof->set('cb_trade', $formDetails->model->get('cb_trade'));
                $comprof->set('cb_storenumber', $formDetails->model->get('cb_storenumber'));
                $comprof->set('cb_itemnumber', $formDetails->model->get('cb_itemnumber'));
                $comprof->set('cb_address1', $formDetails->model->get('cb_address1'));
                $comprof->set('cb_address2', $formDetails->model->get('cb_address2'));
                $comprof->set('cb_city', $formDetails->model->get('cb_city'));
                $comprof->set('cb_state', $formDetails->model->get('cb_state'));
                $comprof->set('cb_country', $formDetails->model->get('cb_country'));
                $comprof->set('cb_zip', $formDetails->model->get('cb_zip'));
                $comprof->set('cb_fieldsetname', $formDetails->model->get('cb_fieldsetname'));
                $comprof->set('registeripaddr', '98.249.236.206');
                if (!$comprof->loaded()) {
                    $comprof->set('id', $user_id);
                    $comprof->set('user_id', $user_id);
                }

                $comprof->save();
            }
            //update cb_fieldsetname for stores with missing phone and missing notes
            $sql1 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is null or cb_notes = '')
              ";

            //update cb_fieldsetname for stores with missing phone, but with notes
            //
            $sql2 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is not null and cb_notes <> '')
              ";

            //update cb_fieldsetname for stores with missing notes, but with phone
            $sql3 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                 END
                                where (cb_notes is null or cb_notes = '') and (cb_phone1 is not null and cb_phone1 <> '')
              ";

            //update cb_fieldsetname for stores with notes and with phone
            $sql4 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                        WHERE  ( cb_notes IS NOT NULL AND cb_notes <> '' ) AND ( cb_phone1 IS NOT NULL AND cb_phone1 <> '' )
              ";
            $sql5 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is null or cb_notes = '')
              ";

            //update cb_fieldsetname for stores with missing phone, but with notes
            //
            $sql6 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is not null and cb_notes <> '')
              ";

            //update cb_fieldsetname for stores with missing notes, but with phone
            $sql7 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                 END
                                where (cb_notes is null or cb_notes = '') and (cb_phone1 is not null and cb_phone1 <> '')
              ";

            //update cb_fieldsetname for stores with notes and with phone
            $sql8 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                        WHERE  ( cb_notes IS NOT NULL AND cb_notes <> '' ) AND ( cb_phone1 IS NOT NULL AND cb_phone1 <> '' )
              ";
            try {
                $q = $this->api->db->query($sql1);
                $q = $this->api->db->query($sql2);
                $q = $this->api->db->query($sql3);
                $q = $this->api->db->query($sql4);
                $q = $this->api->db->query($sql5);
                $q = $this->api->db->query($sql6);
                $q = $this->api->db->query($sql7);
                $q = $this->api->db->query($sql8);
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

        $this->js('addSelectedText', $this->form->js()->atk4_form('reloadField', 'cb_itemnumber'))->_selector('body');

    }
}
