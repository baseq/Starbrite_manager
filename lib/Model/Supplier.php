<?php
class Model_Supplier extends Model_Table {
	public $table='starbr_comprofiler';
	//public $entity_code='starbr_comprofiler';
	function init(){
		parent::init();
		$this->addField("user_id");
		$this->addField("firstname");
		$this->addField("lastname");
		$this->addField("hits");
		$this->addField("message_last_sent");
		
		
		$this->addField("cb_itemnumber")->type('text');
		/*$this->addField("message_last_sent");
		$this->addField("message_last_sent");
		$this->addField("message_last_sent");
		$this->addField("message_last_sent");*/
	}
}