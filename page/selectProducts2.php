<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Famjenescu
 * Date: 9/29/13
 * Time: 3:50 PM
 * To change this template use File | Settings | File Templates.
 */

class page_selectProducts2 extends Page
{
    protected $trigger = 'addSelectedText2';
    
    function init(){
        parent::init();
        
        $this->api->stickyGET('page_newreg');
        $productkey = $this->api->recall('new_selected_record');
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
            foreach ($ids as $id) {
                $model->load($id);
                $pk = $model->getProductKey();
                if ($pk) {
                    $value .= $prefix . $pk;
                    $prefix = ',';
                }
            }
            
            $this->api->memorize('new_selected_record', $value);
            $this->api->memorize('new_flag', $value);
            $js[] = $g->js()->reload();
            $js[] = $this->js()->_selector('#'.$_GET['page_newreg'])->trigger($this->trigger);
            $this->js(null, $js)->execute();
        }
        
        if(!empty($ids)) $model->addCondition('id', 'not in', $this->api->db->dsql()->expr('('.implode(',',$ids).')'));
        $g->setModel($model);
    }


}