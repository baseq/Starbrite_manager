<?php
class RebatesExport extends misc\Export {
   function init(){
	function export() {
		if (isset($_GET[$this->buttonCSV->button->name]) || isset($_GET[$this->buttonXLS->button->name])) {