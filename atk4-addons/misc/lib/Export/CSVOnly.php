<?php

namespace misc;

class Export_CSVOnly extends Export_Basic{
	protected $buttonCSV;
	protected $buttonXLS;

    function init(){
        parent::init();
        $this->buttonCSV = $this->add("misc/Export_Parser_CSV");
    }
}


