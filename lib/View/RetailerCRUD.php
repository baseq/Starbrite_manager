<?php // vim:ts=4:sw=4:et:fdm=marker
/*
 * Undocumented
 *
 * @link http://agiletoolkit.org/
 *//*
 ==ATK4===================================================
 This file is part of Agile Toolkit 4
 http://agiletoolkit.org/

 (c) 2008-2013 Agile Toolkit Limited <info@agiletoolkit.org>
 Distributed under Affero General Public License v3 and
 commercial license.

 See LICENSE or LICENSE_COM for more information
 =====================================================ATK4=*/
class View_RetailerCRUD extends View_CRUD {

	public $productGrid;
	/**
	 * {@inheritdoc}
	 *
	 * CRUD's init() will create either a grid or form, depending on
	 * isEditing(). You can then do the necessary changes after
	 *
	 * Note, that the form or grid will not be populated until you
	 * call setModel()
	 *
	 * @return void
	 */
	function init()
	{
		parent::init();

		if ($this->isEditing()) {
			$this->virtual_page->getPage()->removeElement('form');
			$tabs = $this->virtual_page
			->getPage()->add('Tabs');
			$tabDetails = $tabs->addTab('Retailer Details');
			$this->form = $tabDetails->add($this->form_class);

			$tabProducts = $tabs->addTab('Products');
			$this->productGrid = $tabProducts->add('Grid');
			$this->productGrid->addPaginator(5);
			$productModel = $this->productGrid->setModel('Product');

			return;
		}
	}

	function setModel($model, $fields = null, $grid_fields = null) {
		parent::setModel($model, $fields, $grid_fields);
		if ($this->productGrid) {
			$this->productGrid->getModel()->addProductKeyFilter($this->getModel()->get('cb_itemnumber'));
		}
	}

}
