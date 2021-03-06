<?php
class page_rebates extends page_base {
	function init(){
		parent::init();
		$this->js(true)->_load('wizard/page_wizard');
		$props = array('allow_add' => false, 'allow_edit' => false, 'allow_del' => true);
		$fields = array('productNumbers', 'redeemCode', 'firstName', 'lastName');
		
		$c=$this->add("CRUD", $props);
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

			$quick_search = $c->grid->addQuickSearch(array('productNumbers', 'redeemCode'))->addClass('small-form-search');
			$quick_search->search_field->setAttr('placeholder', 'Product, Redeem Code');
			
			$quick_search = $c->grid->addQuickSearch(array('firstName', 'lastName', 'email', 'phone'))->addClass('small-form-search');
			$quick_search->search_field->setAttr('placeholder', 'Name, Email, Phone');

			$quick_search = $c->grid->addQuickSearch(array('address', 'city', 'state', 'zip'))->addClass('small-form-search');
			$quick_search->search_field->setAttr('placeholder', 'Address, City, Zip, State');

			//$quick_search = $c->grid->addQuickSearch(array('phone'))->addClass('small-form');
			//$quick_search->search_field->setAttr('placeholder', 'Phone');
			
			$quick_filter = $c->grid->add('QuickFilter', null, 'quick_search')->useWith($c->grid)->useFields(array('formName'));
			$quick_filter = $c->grid->add('QuickFilter', null, 'quick_search')->useWith($c->grid)->useFields(array('status'));
		}
				
		$export = $c->add("RebatesExport");
	}
}