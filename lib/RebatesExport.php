<?php
class RebatesExport extends misc\Export {
   function init(){        parent::init();    }
	function export() {
		if (isset($_GET[$this->buttonCSV->button->name]) || isset($_GET[$this->buttonXLS->button->name])) {			if ($this->owner->getModel()) {				foreach ($this->owner->getModel() as $row) {					$this->owner->getModel()->set('status', 'Exported');					$this->owner->getModel()->set('date_exported', date("Y-m-d"));					$this->owner->getModel()->update();				}			}		}		parent::export();	}}