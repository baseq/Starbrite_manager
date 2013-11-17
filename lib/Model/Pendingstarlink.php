<?php

class Model_Pendingstarlink extends Model_Table {

    public $table='starbr_store_registration';
    protected $duplicateExpression = "CONCAT(cb_address1, ' ', cb_address2, ', ' , cb_city, ', ', cb_state, ', ', cb_country)";

    //public $entity_code='starbr_comprofiler';


    function init(){


        parent::init();


        $this->addField('cb_goldstore')->visible(false)->editable(true)->datatype('boolean')->caption('Gold Star');
        $this->addField('cb_expiredate')->visible(false)->editable(true)->datatype('date')->caption('Expire Date');
        //$this->addField("user_id")->visible(false)->editable(true);
        $this->addField("cb_dealno")->editable(false)->caption("Deal No");
        $this->addField("firstname")->visible(false);
        $this->addField("lastname")->visible(false);
        //$this->addExpression("name", "firstname" + "lastname")->editable(false)->caption("Name");
        $this->addField("cb_email")->caption("Contact Email");
        //$this->addExpression("email", "cb_dealno" + "@invalid.com")->caption("Email");
        $this->addField("cb_storeno")->caption("Store Name");
        $this->addField("cb_phone1")->caption("Phone1")->defaultValue('');
        $this->addField("cb_phone2")->caption("Phone2")->defaultValue('');
        $this->addField("website")->caption("Website");
        $this->addField("cb_type")->caption("Type");
        $this->addField("cb_notes")->caption("Notes");
        $this->addField("cb_fax")->caption("Fax");
        $this->addField("cb_onlinesell")->caption("Online Sell");
        $this->addField("cb_dist1")->caption("Dist1");
        $this->addField("cb_dist2")->caption("Dist2");
        $this->addField("cb_dist1sale")->caption("Dist1 Sale");
        $this->addField("cb_dist2sale")->caption("Dist2 Sale");
        $this->addField("cb_code")->caption("Code");
        $this->addField("cb_trade")->caption("Trade");
        $this->addField("cb_storenumber")->caption("Store Number");
        $this->addField("cb_address1")->caption('Address 1');
        $this->addField("cb_address2")->caption('Address 2');
        $this->addField("cb_city")->caption('City');
        $this->addField("cb_state")->caption('State');
        $this->addField("cb_country")->caption('Country');
        $this->addField("cb_zip")->caption('Zip Code');
        $this->addField("cb_itemnumber")->caption("Products");
        $this->addField('cb_fieldsetname')->system(true);
        $this->addField('address')->calculated($this->duplicateExpression)->visible(false);
        //$this->join('starbr_users', 'user_id');

    }

    function getDuplicatesValueList() {
        $valueList = array();
        $q = $this->dsql();

        $expr = 'SELECT ' . $this->duplicateExpression . ' AS address FROM starbr_store_registration GROUP BY ' . $this->duplicateExpression . ' HAVING count(*) > 1';
        //echo $expr;
        //$q->field($q->expr($expr), null, 'address')->group('address')->having('count(*) > 1');
        $q->useExpr($expr);

        foreach ($q as $row) {

            $valueList[$row['address']] = $row['address'];
        }
        return $valueList;
    }

    /** Return value of the field. If unspecified will return array of all fields.  */
    function get($name=null){
        $value = parent::get($name);
        if($value == "NULL") {
            $value = "";
        }
        return $value;
    }
}