<?php


class Model_Retailer extends Model_Table {


	public $table='starbr_comprofiler';
	protected $duplicateExpression = "CONCAT(cb_address1, ' ', cb_address2, ', ' , cb_city, ', ', cb_state, ', ', cb_country)";

	//public $entity_code='starbr_comprofiler';


	function init(){


		parent::init();


        //$this->addField('approved')->visible(false)->editable(false)->datatype('boolean')->caption('Approved');
        $this->addField("cb_storeno")->caption("Store Name");
        $this->addField("cb_storenumber")->visible(false)->caption("Store Number");
        $this->addField("cb_address1")->caption('Address 1');
        $this->addField("cb_address2")->caption('Address 2');
        $this->addField("cb_city")->caption('City');
        $this->addField("cb_country")->caption('Country')->type('list');
        $this->addField("cb_state")->caption('State')->type('list');
        $this->addField("cb_zip")->caption('Zip Code');
        $this->addField("cb_email")->caption("Contact Email");
        $this->addField("cb_phone1")->caption("Phone1")->defaultValue('');
        $this->addField("cb_phone2")->caption("Phone2")->defaultValue('');
        $this->addField("cb_fax")->visible(false)->caption("Fax");
        $this->addField("website")->visible(false)->caption("Website");
        $this->addField("cb_itemnumber")->caption("Products")->type('text')->visible(false)->editable(true);
        $this->addField("cb_onlinesell")->visible(false)->caption("Do you sell online?")->datatype('boolean')->enum(array('Y', 'N'));
        $this->addField("cb_trade")->visible(false)->caption("Type of Trade")->type('list')->setValueList($this->getDistinctTrade());
        $this->addField("cb_dist1")->visible(false)->caption("Primary Distributor");
        $this->addField("cb_dist1sale")->visible(false)->caption("Primary Distributor Salesman");
        $this->addField("cb_dist2")->visible(false)->caption("Secondary Distributor");
        $this->addField("cb_dist2sale")->visible(false)->caption("Secondary Distributor Salesman");
        $this->addField('cb_goldstore')->visible(false)->editable(true)->datatype('boolean')->caption('Gold Star');
        $this->addField('cb_expiredate')->visible(false)->editable(true)->datatype('date')->caption('Expire Date');
        $this->addField("cb_type")->visible(false)->caption("Type")->type('list')->setValueList($this->getDistinctTypes());
        $this->addField("cb_notes")->visible(false)->caption("Notes");
		$this->addField("firstname")->visible(false);
		$this->addField("lastname")->visible(false);
        $this->addField("user_id")->visible(true)->editable(true);
        $this->addField("cb_dealno")->caption("Deal No");
		$this->addExpression("name", "CONCAT(firstname, lastname)")->editable(false)->caption("Name");
		$this->addExpression("email", "CONCAT(cb_dealno, '@invalid.com')")->caption("Email");
		$this->addField("cb_code")->visible(false)->editable(false)->caption("Code");
		$this->addField('address')->calculated($this->duplicateExpression)->visible(false);
        $this->addField('cb_fieldsetname')->system(true);
        $this->addField('registeripaddr')->system(true);
		//$this->join('starbr_users', 'user_id');
        //$this->join('starbr_users', 'id');
	}
	
	function getDuplicatesValueList() {
		$valueList = array();
		$q = $this->dsql();
		$expr = 'SELECT ' . $this->duplicateExpression . ' AS address FROM starbr_comprofiler GROUP BY ' . $this->duplicateExpression . ' HAVING count(*) > 1';
		//$q->field($q->expr($expr), null, 'address')->group('address')->having('count(*) > 1');
		$q->useExpr($expr);

		foreach ($q as $row) {
			$valueList[$row['address']] = $row['address'];
		}
		return $valueList;
	}
	
	/** Return value of the field. If unspecified will return array of all fields.  */
    function get($name = null){
        $value = parent::get($name);
        if($value == "NULL") {
        	$value = "";
        }
        return $value;
    }
    function delete($id=null){
        if(!is_null($id))$this->load($id);
        if(!$this->loaded())throw $this->exception('Unable to determine which record to delete');

        $users = $this->add('Model_JoomlaUsers');
        $users->delete($this->get('user_id'));
        parent::delete();
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