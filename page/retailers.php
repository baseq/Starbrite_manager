<?php
class page_retailers extends page_base
{

    function init()
    {
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
        $crud = $this->add('View_RetailerCRUD', array('grid_class' => 'Grid_Page_Wizard_MasterDetails', 'allow_edit' => false));
        $crud->setClass('template-master-details-grid template-master-details-grid-rows');
        $model = $crud->setModel('Retailer');
        $rootModel->addCondition('id', '=', $id);
        $tabs = $this->add('Tabs');
        $tabDetails = $tabs->addTab('Retailer Details');


        $formDetails = $tabDetails->add('FormAndSave');
        $formDetails->setModel($rootModel);
        $formDetails->setClass('template-master-details-grid template-master-details-grid-rows atk-row');
        $isGold = array("gold" => "Gold", "" => "Please Select");
        $gold = $formDetails->addField('Dropdown', 'Gold')->setValueList($isGold)->setCaption("Gold member");

        $gold->js('change',$formDetails->js()->get('cb_fieldsetname'));


        $formDetails->template->trySet('fieldset', 'span4');
        $sep1 = $formDetails->addSeparator('span4');
        $sep2 = $formDetails->addSeparator('span4');
        $formDetails->add('Order')->move($sep1, 'before', 'cb_fax')->move($sep2, 'before', 'cb_address1')->now();

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
            $crud->grid->addPaginator(5);
            $quick_search = $crud->grid->addQuickSearch(array('name', 'cb_phone1', 'cb_phone2', 'cb_email'))->addClass('small-form-search');
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
    }
    function isGold($form){
        if ('Gold' == $_GET['Gold Members']) {
            echo "papadie".$form->get('cb_fieldsetname');
            //echo $formDetails->get('cb_fieldsetname');
            //$formDetails->rootModel->set('cb_fieldsetname', $crud->str_replace("</strong></td>", "</strong><img src=http://www.starbrite.com/images/comprofiler/favorite.png></td>", get('cb_fieldsetname')));
        }
    }
}
