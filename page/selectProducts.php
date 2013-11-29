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
    protected $trigger = 'addSelectedText';
    function init()
    {
        parent::init();
        $model = $this->add('Model_Product');
        $g = $this->add('Grid');
        $f = $this->add('Form');
        $field = $f->addField('line','selected');
        $f->getElement('selected')->js(true)->closest('div')->prev()->hide();
        $f->getElement('selected')->js(true)->closest('input')->hide();
        $g->addSelectable($f->getElement('selected'));
        $submit = $f->addSubmit('Done');

        //echo 'trigger: ' . $this->trigger;
        //$model->addExpression('selected')->set(function($model,$select) {return 'N';});
        $g->setModel($model);

        if (isset($g)) {
            $g->addPaginator(10);
            $quick_search = $g->addQuickSearch(array('name', 'elements'))->setStyle('float','left !important');
            $quick_search->search_field->setAttr('placeholder', 'Name, Elements');
        }
        if ($f->isSubmitted()) {
        	$ids = json_decode($field->get());
        	$value = '';
        	$prefix = '';
        	foreach($ids as $id) {
        		$model->load($id);
        		$prodKey = $model->getProductKey();
        		if ($prodKey) {
        			$value .= $prefix . $prodKey;
        			$prefix = ',';
        		}
        	}
        	$this->api->memorize('selected_record', $value);
        	$this->js(null, $this->api->js()->_selector('body')
        			->trigger($this->trigger))->univ()->closeDialog()->execute();
        }

    }

}