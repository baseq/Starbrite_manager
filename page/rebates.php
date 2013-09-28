<?php
class page_rebates extends page_base {
	function init(){
		parent::init();
		$columns = array('store', 'store_city', 'store_st', 'purchase_date',
            'postmarkdate', 'type', 'size', 'make', 'comments1', 'comments2');
        $this->js(true)->_load('wizard/page_wizard');
		$props = array('allow_add' => false, 'allow_edit' => false, 'allow_del' => true);
		$fields = array('productNumbers', 'redeemCode', 'firstName', 'lastName');

		$c=$this->add("CRUD", $props);
		$c->setClass('template-master-details-grid template-master-details-grid-rows');
		$c->setModel("Rebates");//, $fields);
		//$refresh = $c->add('Button')->set('Refresh Grid')->js('click', $this->js()->reload());

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

            $c->grid->addFormatter("redeemCode", "expander");
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