<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Famjenescu
 * Date: 9/29/13
 * Time: 3:50 PM
 * To change this template use File | Settings | File Templates.
 */

class page_selectProductsRetailers extends Page
{
    protected $trigger = 'addSelectedText';
    function init()
    {
        parent::init();
        $productkey = $this->api->recall('retailers_selected_record');
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
        $ids = array();
        if($productkey){
            $productskeys = explode(',', $productkey);
            //$i='ddd';
            foreach ($model as $junk) {
                $model->load($model->get('id'));
                $val = $model->getProductKey();
                if(in_array($val, $productskeys, true)) {
                    $ids[] = $model->get('id');
                }
            }
        }
        $g->setModel($model);
        $field->set(json_encode($ids));

        if (isset($g)) {
            $g->addPaginator(10);
            $quick_search = $g->addQuickSearch(array('name', 'elements'))->setStyle('float','left !important');
            $quick_search->search_field->setAttr('placeholder', 'Name, Product Family');
        }
        if ($f->isSubmitted()) {
        	$ids = json_decode($field->get());
        	$value = '';
        	$prefix = '';
        	foreach($ids as $id) {
        		$model->load($id);
                $productkey = $model->getProductKey();
        		if ($productkey) {
        			$value .= $prefix . $productkey;
        			$prefix = ',';
        		}
        	}
        	$this->api->memorize('retailers_selected_record', $value);
        	$this->api->memorize('flag', $value);
        	$this->js(null, $this->api->js()->_selector('body')
        			->trigger($this->trigger))->univ()->closeDialog()->execute();
        }

    }

}