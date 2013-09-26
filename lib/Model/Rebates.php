<?php

class Model_Rebates extends Model_Table {

	public $table='starbr_redeem';

	//public $entity_code='starbr_comprofiler';

	function init(){

		parent::init();

		$this->addField("productNumbers")->caption("Product Code");//->sortable(true);
		$this->addField("redeemCode")->caption("Redeem Code");
		$this->addField("firstName")->caption("First Name");
		$this->addField("lastName")->caption("Last Name");
		$this->addField("address");
        $this->addField("adress2")->caption("Address2");
		$this->addField("city");
		$this->addField("zip");
		$this->addField("state");
		$this->addField("email");
		$this->addField("phone");
		$this->addField("formName")->caption("Form")->setValueList(array('REDEEM'=>'REDEEM', 'RBSV'=>'RBSV', 'RBKIS'=>'RBKIS'));;
        $this->addField("store");
        $this->addField("store_city");
        $this->addField("store_st");
        $this->addField("purchase_date");
        $this->addField("postmarkdate");
        $this->addField("type");
        $this->addField("size");
        $this->addField("make");
        $this->addField("comments1");
        $this->addField("comments2");
        $this->addField("status")->setValueList(array('New'=>'New', 'Exported'=>'Exported'))->defaultValue('New');
 		$this->addField("date_exported")->datatype('date');

		/*$this->addField("message_last_sent");

		$this->addField("message_last_sent");

		$this->addField("message_last_sent");

		$this->addField("message_last_sent");*/

	}

}