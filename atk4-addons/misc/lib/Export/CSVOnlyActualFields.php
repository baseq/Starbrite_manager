<?php

namespace misc;

class Export_CSVOnlyActualFields extends Export_BasicActualFields{
	protected $buttonCSV;
	protected $buttonXLS;

    function init(){
        parent::init();
        $this->buttonCSV = $this->add("misc/Export_Parser_CSV");
    }
}


