<?php
class Model_Product extends Model_Table {
	public $table='starbr_zoo_item';
	
	protected $products;
	protected $productKey;
	protected $cnt = 10;
	protected $shift = 0;
	protected $index = 0;
	//public $entity_code='starbr_zoo_item';
	function init() {
		parent::init();
		$this->addField("name");
		$this->addField("elements")->readonly();
		//$this->addExpression('product_key', array($this, 'getProductKey'));
		//$this->addCondition($field)
	}

	function getZooElementData($item_id, $element_identifier, $element_child) {
		$elements_json = json_decode($this->get('elements'));
		if (isset($elements_json->$element_identifier)) {
			if (isset($elements_json->$element_identifier->$item_id)) {
				return $elements_json->$element_identifier->$item_id->$element_child;
			}
		}
		return false;
	}
	
	function getProductKey() {
		return $this->getZooElementData('0', 'f7a48574-b1a7-4fc7-86c4-5140971dd0a6', 'value');
	}
	
	function addProductKeyFilter($products) {
		if (is_array($products)) {
			$this->products = $products;
		} else {
			$this->products = split(',', $products);
		}
	}
	
	function count() {
		if (isset($this->products)) {
			$count = 0;
			foreach ($this as $p) {
				$count++;
			}
			return $count;
		} else {
			return parent::count();
		}
	}
	
 	function _preexec() {
 		if (isset($this->products)) {
 			return $this;
 		} else {
 			return parent::_preexec();
 		}
    }
    
    function limit($cnt, $shift = 0) {
    	$this->cnt = $cnt;
    	$this->shift = $shift;
    }
    
	function calcFoundRows(){
        return $this;
    }
    
    function foundRows() {
    	$cnt = $this->cnt;
    	$shift = $this->shift;
    	$this->cnt = 0;
    	$this->shift = 0;
    	$count = $this->count();
    	$this->cnt = $cnt;
    	$this->shift = $shift;
    	return $count;
    }
    
	function next() {
		parent::next();
		if (isset($this->products)) {
			while($this->loaded()) {
				$this->productKey = '' . $this->getProductKey();
				$this->set('elements', $this->productKey);
				if (empty($this->productKey) || !$this->checkFilter()) {
					parent::next();
				} else {
					$this->index = $this->index + 1;
					if ($this->index >= $this->shift) {
						break;
					}
				}
			}
		}
	}
	function valid() {
		$valid = parent::valid();
		if ($this->cnt > 0 && $this->index > $this->cnt + $this->shift) {
			return false;
		}
		return $valid;
	}
 	function rewind(){
        parent::rewind();
        $this->index = 0;
    }
	
	function checkFilter() {
		foreach ($this->products as $product) {
			if (strstr($product, $this->productKey) != false) {
				return true;
			}
		}
		return false;
	}
}
