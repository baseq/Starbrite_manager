<?php

class page_products extends Page {
	function init() {
		parent::init();
		$props = array('allow_add' => false, 'allow_edit' => false, 'allow_del' => false);
		$crud = $this->add('CRUD', $props);
		
		$model = $crud->setModel('Product');
		if ($crud->grid) {
			$crud->grid->addPaginator(10);
		}
	}
}