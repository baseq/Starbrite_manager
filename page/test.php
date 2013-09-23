<?php
class page_test extends Page {
	function init(){
		parent::init();
		
		$this->add('BasicAuth')->allow('Starbrite','Star2013')->check();

		$crud=$this->add('CRUD');
		$crud->setModel('Suplier');
		
		if ($crud->grid) {
			$crud->grid->addPaginator(10);
			$crud->grid->addQuickSearch(array('firstname', 'lastname'));
		}
	}
}