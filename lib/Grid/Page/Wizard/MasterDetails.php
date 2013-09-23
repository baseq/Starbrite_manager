<?php
class Grid_Page_Wizard_MasterDetails extends GridExt\Grid_Extended {

	function defaultTemplate() {
		parent::defaultTemplate();
		return array('grid/masterDetailsGridExt');
	}

	function _move_delete($grid, $field) {
		//        parent::_move_delete($grid, $field);
	}

	function init_link($field){
		$this->setTemplate('<a href="<?'.'$_link?'.'>" target="_blank"><?'.'$'.$field.'?'.'></a>');
	}

	function format_link($field, $formatter) {
		//        parent::format_link($field);
		//        $this->current_row['_link'] = $this->api->url('./'.$field,array('id'=>$this->current_id));
		//        $this->current_row['_link'] = $this->api->url($formatter['page'],array('id'=>$this->current_id));
		$this->current_row['_link'] = $this->api->url($formatter['page'],array('id'=>$this->current_row[$field.'_id']));
		return $this->format_template($field);
	}

	function format_number($field) {
		$this->setTDParam($field,'align','right');
		//return
	}

	protected $odd_even=null;
	function formatRow(){
		parent::formatRow();
		$this->odd_even=$this->odd_even=='odd'?'even':'odd';
		$this->current_row['odd_even']=$this->odd_even;
	}
}
