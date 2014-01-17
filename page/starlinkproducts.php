<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Famjenescu
 * Date: 9/29/13
 * Time: 3:50 PM
 * To change this template use File | Settings | File Templates.
 */

class page_starlinkproducts extends Page
{
    function init(){
        parent::init();
        $this->add('HtmlElement')
            ->setElement('h1')
            ->set('Products');
        $columns = array('product_code', 'product_number', 'product_name', 'product_size',
            'description', 'featured', 'grade', 'country');
        $this->js(true)->_load('wizard/page_wizard');
        $this->js(true)->tooltip();

        $props = array('allow_add' => true, 'allow_edit' => false, 'allow_del' => true);
        //$fields = array('productNumbers', 'redeemCode', 'firstName', 'lastName');

        $c = $this->add("CRUD", $props);
        $this->crud = $c;
        $c->setClass('template-master-details-grid template-master-details-grid-rows');
        $c->setModel("Starlinkproducts");

        if ($c->grid){
            foreach ($c->grid->columns as $name => $column) {
                if ('delete' != $name) {
                    $c->grid->getColumn($name)->makeSortable();
                }
            }
            $c->grid->addFormatter('product_code','grid/inline');
            $c->grid->addFormatter('product_name','grid/inline');
            $c->grid->addFormatter('product_size','grid/inline');
            $c->grid->addFormatter('description','grid/inline');
            $c->grid->addFormatter('featured','grid/inline');
            $c->grid->addFormatter('grade','grid/inline');
            $c->grid->addFormatter('country','grid/inline');
            $c->grid->addPaginator(30);
        }
        $export = $c->add("StarlinkExport");
        /*$quick_search = $g->addQuickSearch(array('name', 'elements'))->setStyle('float','left !important');
        $quick_search->search_field->setAttr('placeholder', 'Name, Product Family');*/

    }
}