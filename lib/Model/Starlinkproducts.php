<?php

class Model_Starlinkproducts extends Model_Table
{
    public $table = 'starbr_product';

    function init()
    {
        parent::init();

        $this->addField("product_code");
        $this->addField("product_number");
        $this->addField("product_name");
        $this->addField("product_size");
        $this->addField("description");
        $this->addField("featured")->datatype('boolean')->enum(array('Y', 'N'));
        $this->addField("grade")->datatype('list')->setValueList(array('1', '2', '3', '4', '5'));
        $this->addField("country");

    }
}