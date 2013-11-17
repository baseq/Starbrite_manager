<?php
class page_retailers extends page_base
{

    function init()
    {
        $this->add('HtmlElement')
            ->setElement('h1')
            ->set('Retailers');
        parent::init();
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
        $crud = $this->add('View_RetailerCRUD', array('grid_class' => 'Grid_Page_Wizard_MasterDetails', 'allow_edit' => false, 'allow_add' => true));
        $crud->setClass('template-master-details-grid template-master-details-grid-rows');
        $modelino = $crud->setModel('Retailer');
        $rootModel->addCondition('id', '=', $id);
        $tabs = $this->add('Tabs');
        $tabDetails = $tabs->addTab('Retailer Details');


        $formDetails = $tabDetails->add('Form');
        $formDetails->addSubmit("Save");
        $formDetails->setModel($rootModel);
        $formDetails->setClass('ignore_changes template-master-details-grid template-master-details-grid-rows atk-row');

        $formDetails->template->trySet('fieldset', 'span4');
        $sep1 = $formDetails->addSeparator('span4');
        $sep2 = $formDetails->addSeparator('span4');
        $formDetails->add('Order')->move($sep1, 'before', 'cb_notes')
            ->move($sep2, 'before', 'cb_address1')
            ->now();

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

        $tabProducts = $tabs->addTab('Products');
        $productGrid = $tabProducts->add('Grid');
        $productGrid->addPaginator(5);
        $productModel = $productGrid->setModel('Product');
        $productModel->addProductKeyFilter($rootModel->get('cb_itemnumber'));

        if ($crud->grid) {
            //$crud->grid->addButton('Add Store')->js('click')->univ()->frameURL('Register New Retailer',$this->api->getDestinationURL('register'));
            $crud->grid->addPaginator(5);
            $quick_search = $crud->grid->addQuickSearch(array('name', 'cb_phone1', 'cb_phone2', 'email'))->addClass('small-form-search');
            $quick_search->search_field->setAttr('placeholder', 'Name, Email, Phone');

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


        if ($formDetails->isSubmitted()) {
            //update cb_fieldsetname for stores with missing phone and missing notes
            $sql1 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
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
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is not null and cb_notes <> '')
              ";

            //update cb_fieldsetname for stores with missing notes, but with phone
            $sql3 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                 END
                                where (cb_notes is null or cb_notes = '') and (cb_phone1 is not null and cb_phone1 <> '')
              ";

            //update cb_fieldsetname for stores with notes and with phone
            $sql4 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                        WHERE  ( cb_notes IS NOT NULL AND cb_notes <> '' ) AND ( cb_phone1 IS NOT NULL AND cb_phone1 <> '' )
              ";

//</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px>
            try {
                $formDetails->update();
                $q = $this->api->db->query($sql1);
                $q = $this->api->db->query($sql2);
                $q = $this->api->db->query($sql3);
                $q = $this->api->db->query($sql4);
                $formDetails->js()->univ()->successMessage("Saved.")->execute();
            }
            catch(Exeption $e) {
                $formDetails->js()->univ()->alert("Failed to save.")->execute();
            }
        }
    }
}