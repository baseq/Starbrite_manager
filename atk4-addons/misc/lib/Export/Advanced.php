<?php

namespace misc;
class Export_Advanced extends Export_Basic{
    function init(){
        parent::init();
        $this->buttonCSV = $this->add("misc/Export_Parser_CSV");
        $this->buttonXLS = $this->add("misc/Export_Parser_XLS");
    }
}