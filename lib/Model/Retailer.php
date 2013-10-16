<?php


class Model_Retailer extends Model_Table {


	public $table='starbr_comprofiler';
	protected $duplicateExpression = "CONCAT(cb_address1, ' ', cb_address2, ', ' , cb_city, ', ', cb_state, ', ', cb_country)";

	//public $entity_code='starbr_comprofiler';


	function init(){


		parent::init();


        $this->addField('cb_goldstore')->visible(false)->editable(true)->datatype('boolean')->caption('Gold Star');
        $this->addField("user_id")->visible(false)->editable(true);
		$this->addField("cb_dealno")->editable(false)->caption("Deal No");
		$this->addField("firstname")->visible(false);
		$this->addField("lastname")->visible(false);
		$this->addExpression("name", "firstname" + "lastname")->editable(false)->caption("Name");
		$this->addField("cb_email")->caption("Contact Email");
		$this->addExpression("email", "cb_dealno" + "@invalid.com")->caption("Email");
		$this->addField("cb_storeno")->caption("Store Name");
		$this->addField("cb_phone1")->caption("Phone1")->defaultValue('');
		$this->addField("cb_phone2")->caption("Phone2")->defaultValue('');
		$this->addField("website")->visible(false)->caption("Website");
		$this->addField("cb_type")->visible(false)->caption("Type");
		$this->addField("cb_notes")->visible(false)->caption("Notes");
		$this->addField("cb_fax")->visible(false)->caption("Fax");
		$this->addField("cb_onlinesell")->visible(false)->caption("Online Sell");
		$this->addField("cb_dist1")->visible(false)->caption("Dist1");
		$this->addField("cb_dist2")->visible(false)->caption("Dist2");
		$this->addField("cb_dist1sale")->visible(false)->caption("Dist1 Sale");
		$this->addField("cb_dist2sale")->visible(false)->caption("Dist2 Sale");
		$this->addField("cb_code")->visible(false)->caption("Code");
		$this->addField("cb_trade")->visible(false)->caption("Trade");
		$this->addField("cb_storenumber")->visible(false)->caption("Store Number");
		$this->addField("cb_itemnumber")->type('text')->visible(false)->editable(false);
		$this->addField("cb_address1")->caption('Address 1');
		$this->addField("cb_address2")->caption('Address 2');
		$this->addField("cb_city")->caption('City');
		$this->addField("cb_state")->caption('State');
		$this->addField("cb_country")->caption('Country');
		$this->addField("cb_zip")->caption('Zip Code');
		$this->addField('address')->calculated($this->duplicateExpression)->visible(false);
        $this->addField('cb_fieldsetname')->system(true);
		$this->join('starbr_users', 'user_id');

	}
	
	function getDuplicatesValueList() {
		$valueList = array();
		$q = $this->dsql();
		//$where = $q->where('count(*)', '>', 1);
		$expr = 'SELECT ' . $this->duplicateExpression . ' AS address FROM starbr_comprofiler GROUP BY ' . $this->duplicateExpression . ' HAVING count(*) > 1';
		//echo $expr;
		//$q->field($q->expr($expr), null, 'address')->group('address')->having('count(*) > 1');
		$q->useExpr($expr);
		//echo 'sfdsfdsf ' . $q;
		foreach ($q as $row) {
			//echo 'sfdsfdsf ' . $row['address'];
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