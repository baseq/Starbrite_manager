<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Famjenescu
 * Date: 9/28/13
 * Time: 10:20 AM
 * To change this template use File | Settings | File Templates.
 */

class page_rebates_redeemCode extends Page
{
    function init()
    {
        parent::init();

        $props = array('allow_add' => false, 'allow_edit' => false, 'allow_del' => true);

        $m = $this->add('Model_Rebates')->addCondition('id', '=', $_GET['id']);
        $crud = $this->add('CRUD', $props);
        $crud->setModel($m, array('store', 'store_city', 'store_st', 'purchase_date',
            'postmarkdate', 'type', 'size', 'make', 'comments1', 'comments2'));

    }
}