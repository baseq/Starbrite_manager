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
    
        function init(){
        parent::init();
        
        $this->api->stickyGET('page_reg');
        $productkey = $this->api->recall('selected_record');
        
        $model = $this->add('Model_Product');
        $ids = array();
        if($productkey){
            $productskeys = explode(',', $productkey);
            foreach ($model as $junk) {
                $model->load($junk['id']);
                $val = $model->getProductKey();
                if(in_array($val, $productskeys, true)) {
                    $ids[] = $junk['id'];
                }
            }
        }
        $g = $this->add('Grid_Select');
        $g->addPaginator(10);
        $quick_search = $g->addQuickSearch(array('name', 'elements'))->setStyle('float','left !important');
        $quick_search->search_field->setAttr('placeholder', 'Name, Product Family');
        
        if (isset($_GET['Add'])) {
            // save in session
            $ids[] = $_GET['Add'];
            $value = '';
            $prefix = '';
            if($productkey!='') {
                $value = $productkey;
                $prefix = ',';
            }
            foreach ($ids as $id) {
                $model->load($id);
                $pk = $model->getProductKey();
                if (isset($productskeys)) {
                    if (!in_array($pk, $productskeys)) {
                        $value .= $prefix . $pk;
                        $prefix = ',';
                    }
                } else {
                    $value .= $prefix . $pk;
                    $prefix = ',';
                }
            }
            
            $this->api->memorize('selected_record', $value);
            $this->api->memorize('flag', $value);
            $js[] = $g->js()->reload();
            $js[] = $this->js()->_selector('#'.$_GET['page_reg'])->trigger($this->trigger);
            $this->js(null, $js)->execute();
        }
        
        if(!empty($ids)) $model->addCondition('id', 'not in', $this->api->db->dsql()->expr('('.implode(',',$ids).')'));
        $g->setModel($model);
    }
    
//    function init()
//    {
//        parent::init();
//        $productkey = $this->api->recall('selected_record');
//        $model = $this->add('Model_Product');
//        $g = $this->add('Grid');
//        $f = $this->add('Form');
//        $field = $f->addField('line','selected');
//        $f->getElement('selected')->js(true)->closest('div')->prev()->hide();
//        $f->getElement('selected')->js(true)->closest('input')->hide();
//        $g->addSelectable($f->getElement('selected'));
//        $submit = $f->addSubmit('Done');
//
//        //echo 'trigger: ' . $this->trigger;
//        //$model->addExpression('selected')->set(function($model,$select) {return 'N';});
//        $ids = array();
//        if($productkey){
//        	$productskeys = explode(',', $productkey);
//        	//$i='ddd';
//        	foreach ($model as $junk) {
//        		$model->load($model->get('id'));
//        		$val = $model->getProductKey();
//				if(in_array($val, $productskeys, true)) {
//					$ids[] = $model->get('id');
//				}
//			}
//        }
//        $g->setModel($model);
//		$field->set(json_encode($ids));
//
//		if (isset($g)) {
//            $g->addPaginator(10);
//            $quick_search = $g->addQuickSearch(array('name', 'elements'))->setStyle('float','left !important');
//            $quick_search->search_field->setAttr('placeholder', 'Name, Product Family');
//        }
//        if ($f->isSubmitted()) {
//        	$ids = json_decode($field->get());
//        	$value = '';
//        	$prefix = '';
//        	foreach($ids as $id) {
//        		$model->load($id);
//                $productkey = $model->getProductKey();
//        		if ($productkey) {
//        			$value .= $prefix . $productkey;
//        			$prefix = ',';
//        		}
//        	}
//        	$this->api->memorize('selected_record', $value);
//            $this->api->memorize('flag', true);
//        	$this->js(null, $this->api->js()->_selector('body')
//        			->trigger($this->trigger))->univ()->closeDialog()->execute();
//        }
//
//    }

}