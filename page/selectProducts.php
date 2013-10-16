<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Famjenescu
 * Date: 9/29/13
 * Time: 3:50 PM
 * To change this template use File | Settings | File Templates.
 */

class page_selectProducts extends Page
{

    function init()
    {
        parent::init();
        $model = $this->add('Model_Product');
        $g = $this->add('GridExt\Grid_Extended');
        $f = $this->add('Form');
        $f->addField('line','selected');
        /*$f->getElement('selected')->js(true)->closest('div')->prev()->hide();
        $f->getElement('selected')->js(true)->closest('input')->hide();*/
        $g->addSelectable($f->getElement('selected'));
        $submit = $f->addSubmit('Done');

        //$model->addExpression('selected')->set(function($model,$select) {return 'N';});
        $g->setModel($model);

        if (isset($g)) {
            $g->addPaginator(10);
            $quick_search = $g->addQuickSearch(array('name', 'elements'))->setStyle('float','left !important');
            $quick_search->search_field->setAttr('placeholder', 'Name, Elements');
        }
        if ($f->isSubmitted()) {

        }

    }

}