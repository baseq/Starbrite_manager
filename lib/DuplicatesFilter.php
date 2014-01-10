<?php

class DuplicatesFilter extends QuickFilter {



    public $icon='ui-icon-search'; // to configure icon



    function init(){

        parent::init();

    }

    

    function useFields($fields) {

    	parent::useFields($fields);



        $this->addField('dropdown', 'address', 'Duplicates')->attr['allow_new_value'] = true;

       

        return $this;

    }

    

    function addField($type,$name,$caption=null,$attr=null) {

    	$valueList = null;

    	//dfsd();

    	if (method_exists($this->getModel(), 'getDuplicatesValueList')) {

    		$type = 'dropdown';

    		$valueList = $this->getModel()->getDuplicatesValueList($name);

    	}

    	$field = parent::addField($type, $name, $caption, $attr);

    	if ($valueList) {

    		$field->setValueList($valueList);

    	}

    	

  		return $field;

    }

    //function addField($type, $name)

}

