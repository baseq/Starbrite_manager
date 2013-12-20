<?php

class Model_NewStoreRegister extends Model_Table
{
    public $table = 'starbr_store_registration';
    protected $typeExpression = "";


    function init()
    {
        parent::init();

        $this->addField("cb_dealno")->system(true);
        $this->addField("username")->system(true);
        $this->addField("password")->system(true);
        $this->addField("email")->system(true);
        //$this->addField('middlename')->caption('Middle name');
        $this->addField("firstname")->system(true);
        $this->addField('lastname')->system(true);
        $this->addField("cb_email")->caption("Contact Email");//->mandatory('Email is required');
        $this->addField("cb_storeno")->caption("Store Name");
        $this->addField("cb_phone1")->caption("Phone 1");
        $this->addField("cb_phone2")->caption("Phone 2");
        $this->addField("website")->caption("Website");
        $this->addField("cb_type")->caption("Type")->type('list')->setValueList($this->getDistinctTypes());
        $this->addField("cb_notes")->caption("Notes");
        $this->addField("cb_fax")->caption("Fax");
        $this->addField("cb_onlinesell")->caption("Do you sell online?")->datatype('boolean');
        $this->addField("cb_dist1")->caption("Primary Distributor");
        $this->addField("cb_dist2")->caption("Secondary Distributor");
        $this->addField("cb_dist1sale")->caption("Primary Distributor Salesman");
        $this->addField("cb_dist2sale")->caption("Secondary Distributor Salesman");
        $this->addField("cb_code")->caption("Code");
        $this->addField("cb_trade")->caption("Type of Trade")->type('list')->setValueList($this->getDistinctTrade());;
        $this->addField("cb_storenumber")->caption("Store Number");
        $this->addField("cb_itemnumber")->mandatory('Select at least one item number')->caption("Products");
        $this->addField("cb_address1")->caption('Address 1');
        $this->addField("cb_address2")->caption('Address 2');
        $this->addField("cb_city")->caption('City');
        $this->addField("cb_country")->caption('Country')->type('list');
        $this->addField("cb_state")->caption('State')->type('list');
        $this->addField("cb_zip")->caption('Zip Code');
        $this->addField("cb_fieldsetname")->system(true);
        //$this->addField('password')->display(array('form'=>'password'))->mandatory('Type your password');
    }

    function getDistinctTypes() {
        $valueList = array();
        $q = $this->dsql();
        $expr = ('SELECT DISTINCT(cb_type) FROM starbr_comprofiler');
        $q->useExpr($expr);
        foreach ($q as $row) {
            $valueList[$row['cb_type']] = $row['cb_type'];
        }
        return $valueList;
    }
    function getDistinctTrade() {
        $valueList = array();
        $q = $this->dsql();
        $expr = ('SELECT DISTINCT(cb_trade) FROM starbr_comprofiler');
        $q->useExpr($expr);
        foreach ($q as $row) {
            $valueList[$row['cb_trade']] = $row['cb_trade'];
        }
        return $valueList;
    }
}