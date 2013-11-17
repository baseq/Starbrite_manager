<?php

class Model_StoreRegister extends Model_Table
{
    public $table = 'starbr_store_registration';

    function init()
    {
        parent::init();

        $this->addField('cb_goldstore')->visible(false)->editable(true)->datatype('boolean')->caption('Gold Star');
        $this->addField('cb_expiredate')->visible(false)->editable(true)->datatype('date')->caption('Expire Date');
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
        $this->addField("cb_type")->caption("Type");
        $this->addField("cb_notes")->caption("Notes");
        $this->addField("cb_fax")->caption("Fax");
        $this->addField("cb_onlinesell")->caption("Online Sell");
        $this->addField("cb_dist1")->caption("Dist 1");
        $this->addField("cb_dist2")->caption("Dist 2");
        $this->addField("cb_dist1sale")->caption("Dist 1 Sale");
        $this->addField("cb_dist2sale")->caption("Dist 2 Sale");
        $this->addField("cb_code")->caption("Code");
        $this->addField("cb_trade")->caption("Trade");
        $this->addField("cb_storenumber")->caption("Store Number");
        $this->addField("cb_itemnumber")->mandatory('Select at least one item number')->caption("Products");
        $this->addField("cb_address1")->caption('Address 1');
        $this->addField("cb_address2")->caption('Address 2');
        $this->addField("cb_city")->caption('City');
        $this->addField("cb_state")->caption('State');
        $this->addField("cb_country")->caption('Country');
        $this->addField("cb_zip")->caption('Zip Code');
        $this->addField("cb_fieldsetname")->system(true);
        //$this->addField('password')->display(array('form'=>'password'))->mandatory('Type your password');
   }
}