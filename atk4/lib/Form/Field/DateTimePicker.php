<?php
/**
 * Text input with Javascript Date picker
 * It draws date in locale format (taken from $config['locale']['date'] setting) and stores it in
 * MySQL acceptable date format (YYYY-MM-DD)
 */
class Form_Field_DateTimePicker extends Form_Field_Line {
	public $options=array();
	function init(){
		parent::init();
		$this->addButton('',array('options'=>array('text'=>false)))
		->setHtml('&nbsp;')
		->setIcon('ui-icon-calendar')
		->js('click',$this->js()->datetimepicker('show'));
		//$this->js('focus', $this->js()->datetimepicker('show'));
	}
	function getInput($attr=array()){
		// $this->value contains date in MySQL format
		// we need it in locale format

		$this->js(true)->datetimepicker(array_merge(array(
                        'duration'=>0,
                        'showOn'=>'none',
		//          'buttonImage'=>$this->api->locateURL('images','calendar.gif'),
		//      'buttonImageOnly'=> true,
                        'changeMonth'=>true,
                        'changeYear'=>true,
                        'dateFormat'=>$this->api->getConfig('locale/date_js','mm/dd/yy')
		),$this->options));

		return parent::getInput(array_merge(
		array(
                        'value'=>$this->value?(date($this->api->getConfig('locale/datetime','m/d/Y H:i'), strtotime($this->value))):'',
		),$attr
		));
	}
	function set($value){
		// value can be valid date format, as in config['locale']['date']
		if(!$value)return parent::set(null);
		if (strpos($value, '-') != 4) {
			@list($m,$d,$y)=explode('/',$value);
			if($y) {
				@list($y, $time)=explode(' ',$y);
				if ($time) {
					//echo 'time: ' . $value . '<br/>';
					$value=join('/',array($m,$d,$y)).' '.$time;
				} else {
					$value=join('/',array($m,$d,$y));
				}
				 
			}
			elseif($m)$value=join('/',array($m,$d));
			//echo 'before: ' . $value . '<br/>';
			$value=date('Y-m-d H:i', strtotime($value));
			//echo 'after: ' . $value . '<br/>';
		}

		return parent::set($value);
	}
	function get(){
		$value=parent::get();
		// date cannot be empty string
		if($value=='')return null;
		return $value;
	}
}
