<?php

class page_suppliers extends page_base {
	function init() {
		parent::init();
		
		$this->js(true)->_load('wizard/page_wizard');
		$this->js(true)->tooltip();
		
		$rootModel = $this->add('Model_Supplier');
		$id = null;
		if (isset($_GET['selected-id'])) {
			$id = $_GET['selected-id'];
		} elseif($this->recall('selected-id')==null) {
			$rootModel->tryLoadAny();
			$id = $rootModel['id'];
		} else{
			$id = $this->recall('selected-id');
		}

		if(!$rootModel->loaded() && $id!=null){
			$rootModel->tryLoad($id);
			if(!$rootModel->loaded()){
				$rootModel->tryLoadAny();
				$id = $rootModel['id'];
			}
		}
		$this->memorize('selected-id', $id);
		$crud = $this->add('View_SupplierCRUD', array('grid_class' => 'Grid_Page_Wizard_MasterDetails', 'allow_edit' => false));
		$crud->setClass('template-master-details-grid template-master-details-grid-rows');
		$model = $crud->setModel('Supplier');
		$rootModel->addCondition('id', '=', $id);
		$tabs = $this->add('Tabs');
		$tabDetails = $tabs->addTab('Supplier Details');
		$formDetails = $tabDetails->add('Form');
		$formDetails->setModel($rootModel);

		$tabProducts = $tabs->addTab('Products');
		$productGrid = $tabProducts->add('Grid');
		$productGrid->addPaginator(5);
		$productModel = $productGrid->setModel('Product');
		$productModel->addProductKeyFilter($rootModel->get('cb_itemnumber'));
		if ($crud->grid) {
			$crud->grid->addPaginator(5);
			$quick_search = $crud->grid->addQuickSearch(array('lastname', 'firstname'));
			$quick_search->search_field->setAttr('placeholder', 'Search by Name');
			
			$crud->grid->js('click', $this->js()->_selectorThis()->gridMasterDetails(true))->_selector('#' . $crud->grid->name . ' tr');
			$crud->grid->js('gridClick', $this->js()->reload(array(
                'selected-id' => $this->js(null, 'arguments[arguments.length-1]'),
                'selected-tab' => $tabs->js()->tabs('option', 'selected')
			)))->_selector('#' . $crud->grid->name . ' tr');
			$crud->grid->js(true)->_selector('#' . $crud->grid->name . ' tr[data-id="'.$id.'"]')->gridMasterDetails(false);
		}
		
		
		
		/*$this->js(true)->_load('wizard/page_wizard');
		$this->js(true)->tooltip();

		$root_model = array('model'=>'Doctor', 'fields'=>array('first_name','last_name','specialty','status'), 'real_fields'=>array('first_name','last_name','specialty_id','status_id'), 'details'=>1, 'enable_edit'=>array('enable_edit'=>1, 'buttons_position'=>1), 'paginate'=>array('check'=>0, 'length'=>10));
		$tabs_model = array(0=>array('model'=>'Doctor', 'fields'=>array('first_name','last_name','specialty_id','phone','fax','email','status_id','notes','referredby_id','points','percentage'), 'enable_edit'=>1),1=>array('model'=>'RelatedFacility', 'plural'=>'Facilities', 'column'=>'facilitydoctor.doctor_id', 'fields'=>array('name', 'code', 'type', 'status'), 'real_fields'=>array(), 'rows_per_page'=>10, 'enable_edit'=>array('enable_edit'=>1, 'buttons_position'=>1), 'detail_page'=>array()), );
		//        $parent_models = $#parent_models$;
		//        $child_models = $#child_models$;
		$column_arrangement = 1;
		$searchClass = '';

		$rootModel = $this->add('Model_'.$root_model['model']);

		$id = null;
		if (isset($_GET['selected-id'])) {
			$id = $_GET['selected-id'];
		} elseif($this->recall('selected-id')==null) {
			$rootModel->tryLoadAny();
			$id = $rootModel['id'];
		} else{
			$id = $this->recall('selected-id');
		}

		if(!$rootModel->loaded() && $id!=null){
			$rootModel->tryLoad($id);
			if(!$rootModel->loaded()){
				$rootModel->tryLoadAny();
				$id = $rootModel['id'];
			}
		}
		$this->memorize('selected-id', $id);

		$this->add('H3')->set('Doctors');

		$column1 = $this;
		$column2 = $this;
		// vertical arrangement

		$searchClass = 'span4';
		//}

		$root_model_editing = array();
		$root_model_editing['form_class'] = 'Form_Doctor_DoctorForm';
		$root_model_editing['grid_class'] = 'Grid_Page_Wizard_MasterDetails';
		//if($root_model['enable_edit']['enable_edit'] == false){
		$root_model_editing['allow_add'] = true;
		$root_model_editing['allow_edit'] = false;
		$root_model_editing['allow_del'] = $this->isOwner();
		//}
		$crud = $column1->add('CRUD', $root_model_editing)->setClass('template-master-details-grid template-master-details-grid-rows');

		$tabs = $column2->add('Tabs')->setClass('master-details-tabs');

		// populate CRUD from model
		if($crud->isEditing()){
			$crud->setModel($root_model['model']);
		} else {
			$crud->setModel($root_model['model'], $root_model['fields']);
		}

		if ($crud->grid) {
			$quick_filter = $crud->grid->add('QuickFilter', null, 'quick_search')->useWith($crud->grid)->useFields(array('status_id'))->addClass($searchClass);
			$quick_search = $crud->grid->addQuickSearch(array('last_name', 'first_name'))->addClass($searchClass);
			$quick_search->search_field->setAttr('placeholder', 'Search by Name');

			//$crud->grid->addExtendedSearch($root_model['real_fields'])->addClass($searchClass.' master-details-extended-search');


			// make sortable columns
			foreach($root_model['fields'] as $f){
				$crud->grid->getColumn($f)->makeSortable();
			}

			if($root_model['paginate']['check']){
				// create pagination
				if($root_model['paginate']['length']>0)
				$crud->grid->addPaginator($root_model['paginate']['length']);
			} else {
				$crud->grid->addPaginator(5);
			}
			$crud->grid->js('click', $this->js()->_selectorThis()->gridMasterDetails(true))->_selector('#' . $crud->grid->name . ' tr');
			$crud->grid->js('gridClick', $this->js()->reload(array(
                'selected-id' => $this->js(null, 'arguments[arguments.length-1]'),
                'selected-tab' => $tabs->js()->tabs('option', 'selected')
			)))->_selector('#' . $crud->grid->name . ' tr');
			$crud->grid->js(true)->_selector('#' . $crud->grid->name . ' tr[data-id="'.$id.'"]')->gridMasterDetails(false);
		}

		foreach($tabs_model as $t){
			$tabName = $t['model'];
			$pos = strrpos($tabName, '*');
			if($pos){
				$tabName = substr($tabName, 0, $pos);
				$parentModelId = $rootModel[$t['column']];
				$addModel = $this->add('Model_' . $tabName);
				$add_tab = $tabs->addTab($tabName)->addClass('master-details-tabs-form');

				if ($parentModelId != null) {
					$addModel->load($parentModelId);
					if ($t['enable_edit'] == false) {
						$tabForm = $add_tab->add('Form')->setStyle('margin: 20px 10px 20px 10px;');
						$tabForm->template->tryDel('button_row');
					} else {
						$tabForm = $add_tab->add('FormAndSave')->setStyle('margin: 20px 10px 20px 10px;');
					}

					$tabForm->setModel($addModel, $t['fields']);
				} else {
					$add_tab->add('Hint')->setTitle('No Record Found')->set(null);
				}
			} elseif(!$pos && $tabName!=$root_model['model']) {
				$addModel = $this->add('Model_' . $t['model']);
				$column = substr($t['column'], strpos($t['column'], '.')+1);
				$addModel->addCondition($column, '=', $id);
				$plural = $t['plural'];
				$plural[0] = strtoupper($plural[0]);
				$add_tab = $tabs->addTab($plural)->addClass('master-details-tabs-grid');

				$tabCrud_editing = array();
				$tabCrud_editing['form_class'] = 'Form_Facility_FacilityForm';
				$tabCrud_editing['grid_class'] = 'Grid_Page_Wizard_MasterDetails';
				//if ($t['enable_edit']['enable_edit'] == false) {
				$tabCrud_editing['allow_add'] = true;
				$tabCrud_editing['allow_edit'] = false;
				$tabCrud_editing['allow_del'] = true;
				//}
				$tabCrud = $add_tab->add('CRUD', $tabCrud_editing)->setClass('template-master-details-grid');
				$tabCrud->entity_name = 'Facility';
				// populate CRUD form model
				if ($tabCrud->isEditing()) {
					$tabCrud->setModel($addModel, $t['real_fields']);
				} else {
					$tabCrud->setModel($addModel, $t['fields']);
				}

				if (isset($tabCrud->grid)) {
					if ($t['detail_page'] != null) {
						foreach($t['detail_page'] as $dp){
							$pos = strrpos($dp, '.');
							$detail_page = substr($dp, 0, $pos);
							$pos = strrpos($detail_page, '/');
							$columnName = substr($detail_page, $pos+1);
							$detail_page = str_replace('/', '_', $detail_page);
							$tabCrud->grid->getColumn(strtolower($columnName));
							$tabCrud->grid->addFormatter(strtolower($columnName), 'link', array('page' => $detail_page));
						}

					}

					// add basic search
					//$quick_search = $tabCrud->grid->addQuickSearch(array('name'))->addClass($searchClass);
					//$quick_search->search_field->setAttr('placeholder', 'Search by name');
					// add advance search
					//$tabCrud->grid->addExtendedSearch($t['real_fields'])->addClass($searchClass . ' master-details-extended-search');

					if ($t['enable_edit']['enable_edit'] == true) {
						if ($t['enable_edit']['buttons_position'] == self::Front) {
							$tabCrud->grid->addOrder()
							->move('edit', 'first')
							->move('delete', 'after', 'edit')
							->now();
						}
					}

					$frame = $this->js()
                                ->univ()
                                ->frameURL('Welcome to select doctors Wizard', $this->api->url('prosaris_SelectFacilities',array('doctorId'=>$id)) );
					$selectBtn = $tabCrud->grid->addButton('Select Facilities');
					$selectBtn->js('click', array(
                                'window.scrollTo(window.pageXOffset, 0);',
                                $frame
                            ));
                    $this->js("reload_t",$tabCrud->grid->js()->reload())->_selector("body");
					foreach ($t['fields'] as $f) {
						$tabCrud->grid->getColumn($f)->makeSortable();
					}
					if ($t['rows_per_page'] > 0)
					$tabCrud->grid->addPaginator($t['rows_per_page']);
				}
			} else {
				//                  $details_btn = $crud->grid->add('Button', null, 'bottom_2')->setLabel('Details')->setStyle('margin-top: 10px;');
				$rootModel->addCondition('id', '=', $id);
				$detailsTab = $tabs->addTab("Doctor Details")->addClass('master-details-tabs-form');
				if ($t['enable_edit']) {
					$form_details = $detailsTab->add('Form_Doctor_DoctorForm');
                    $form_details->grid = $crud->grid;
				} else {
					$form_details = $detailsTab->add('Form');
					$form_details->template->tryDel('button_row');
				}

				//                $detailsTab->js('click', $form_details->js()->toggle());
				$form_details->setModel($rootModel, $t['fields']);

			}
		}
		$tabs->setOption('selected', $_GET['selected-tab']);*/
	}

}