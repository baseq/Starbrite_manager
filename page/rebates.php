<?php
class page_rebates extends page_base {
	protected $crud;
	protected $resetForm;
	protected $doReset;

	function init(){
		parent::init();
		$this->add('HtmlElement')
		->setElement('h1')
		->set('Rebates');
		$columns = array('store', 'store_city', 'store_st', 'purchase_date',
            'postmarkdate', 'type', 'size', 'make', 'comments1', 'comments2');
		$this->js(true)->_load('wizard/page_wizard');
		$props = array('allow_add' => false, 'allow_edit' => false, 'allow_del' => true);
		$fields = array('productNumbers', 'redeemCode', 'firstName', 'lastName');


		
		$c = $this->add("CRUD", $props);
		$this->crud = $c;
		$c->setClass('template-master-details-grid template-master-details-grid-rows');
		$c->setModel("Rebates");//, $fields);

		if ($c->grid){
			
			$c->grid->addPaginator(30);
			//$c->grid->sortby = '0';
			foreach ($c->grid->columns as $name => $column) {
				if ('delete' != $name) {
					$c->grid->getColumn($name)->makeSortable();
				}
			}
			foreach($columns as $column) {
				$c->grid->removeColumn($column);
			}

			$c->grid->columns['redeemCode']['thparam'].=' style="width: 120px;"';
			$c->grid->addFormatter("redeemCode", "expander");
			$quick_search = $c->grid->addQuickSearch(array('productNumbers', 'redeemCode'))->addClass('small-form-search span2');
			$quick_search->search_field->setAttr('placeholder', 'Product, Redeem Code');

			$quick_search = $c->grid->addQuickSearch(array('firstName', 'lastName', 'email', 'phone'))->addClass('small-form-search');
			$quick_search->search_field->setAttr('placeholder', 'Name, Email, Phone');

			$quick_search = $c->grid->addQuickSearch(array('address', 'city', 'state', 'zip'))->addClass('small-form-search');
			$quick_search->search_field->setAttr('placeholder', 'Address, City, Zip, State');

			//$quick_search = $c->grid->addQuickSearch(array('phone'))->addClass('small-form');
			//$quick_search->search_field->setAttr('placeholder', 'Phone');

			$quick_filter = $c->grid->add('QuickFilter', null, 'quick_search')->useWith($c->grid)->useFields(array('formName'));
			$quick_filter = $c->grid->add('QuickFilter', null, 'quick_search')->useWith($c->grid)->useFields(array('status'));
			
			//$this->js('focus', $c->grid->js()->reload()->execute());
		}

		$export = $c->add("RebatesExport");
		//$this->resetForm = $c->grid->elements['grid-buttonset']->add('Form', null, 'grid_buttons')->addClass('float-left');
		$this->resetForm = $c->grid->add('Form', null, 'quick_search')->addClass('small-form-buttons');
		$this->resetForm->addSubmit('Reset');

		
		//$reset->
		//$reset->js('click')->univ()->location($this->api->url(null, array('reset' => "1")));
		$this->doReset = false;
		if ($this->crud->grid) {
			if ($this->resetForm->isSubmitted()) {
				$this->doReset = true;
			}
		}
		
		
	}

	// preRender
	function recursiveRender() {

		// call Lister_Tree default prerendering
		 
		if ($this->doReset) {

			//$resetFlag=$this->api->stickyForget('reset');
			//$resetFlag=$_GET['reset'];
			$model = $this->crud->grid->model;
			foreach ($model as $m) {
				//echo $model->get('address') . ' | ';
				$model->set('status', 'New');
				$model->set('date_exported', NULL);
				$model->update();
			}

			$this->crud->grid->js()->reload()->execute();
				
		}

		parent::recursiveRender();
	}
}