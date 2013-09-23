<?php
class QuickFilter extends Filter {
    /*
     * Quicksearch represents one-field filter which goes perfectly with a grid
     */
    public $icon='ui-icon-search'; // to configure icon

    function init(){
        parent::init();

        //$this->template->trySet('fieldset','atk-row');
        $this->template->tryDel('button_row');
        //$this->search_field=$this->addField('dropdown','status','')->setNoSave();
        /*$this->search_field->addButton('',array('options'=>array('text'=>false)))
            ->setHtml('&nbsp;')
            ->setIcon($this->icon)
            ->js('click',$this->js()->submit());*/
    }
    
 	/*function useWith($view) {
 		parent::useWith($view);
        // Apply our condition on the view
       
        return $this;
    }*/
    function useFields($fields) {
    	$span = 2 * count($fields) + 2;
    	$this->addClass('float-right span' . $span . ' atk-row atk-quicksearch');
        $this->fields=$fields;
        $this->setModel($this->view->getModel(), $this->fields);
        $this->addClass('small-form');
        return $this;
    }
    function postInit(){
    	$q=$this->view->model->_dsql();
        $and=$q->andExpr();
        foreach($this->elements as $x=>$field){
            if($field instanceof Form_Field){

                $field->set($val=$this->recall($x));

                //if($field->no_save)continue;
                if(!$field->get())continue;
				
                // also apply the condition
                if($this->view->model && $this->view->model->hasElement($x) ){
                	if (strcmp('datetime', $this->view->model->getField($x)->type) == 0) {
                		if (strcmp('future', $field->get()) == 0) {
            				$and->where("DATEDIFF(NOW(), $x) < 0");
            				$q->having($and);
                		} else if (strcmp('today', $field->get()) == 0) {
                			$and->where("DATE_FORMAT(NOW(), '%m-%d-%Y') = DATE_FORMAT($x, '%m-%d-%Y')");
            				$q->having($and);
                		} else if (strcmp('last_week', $field->get()) == 0) {
                			$and->where("DATEDIFF(NOW(), $x) <= 7 AND DATEDIFF(NOW(), $x) >= 0");
            				$q->having($and);
                		} else if (strcmp('last_month', $field->get()) == 0) {
                			$and->where("DATEDIFF(NOW(), $x) <= 30 AND DATEDIFF(NOW(), $x) >= 0");
            				$q->having($and);
                		}
                	} else {
                		if($this->view->model->addCondition($x,$field->get())); // take advantage of field normalization
                	}
                }
            }
        }
        $this->hook('applyFilter',array($this->view->model));
    }
    function addField($type,$name,$caption=null,$attr=null) {
    	$valueList = null;
    	
    	if (strcmp($type, 'DateTimePicker') == 0) {
    		$type = 'dropdown';
    		$valueList = array('future' => 'Future', 'today' => 'Today', 'last_week' => 'Last Week', 'last_month' => 'Last Month');
    	}
    	$field = parent::addField($type, $name, $caption, $attr);
    	if ($valueList) {
    		$field->setValueList($valueList);
    	}
    	$field->setNoSave();
    	if (count($this->fields) == 1) {
    		$this->template->trySet('fieldset','span1 float-right');
    	} else {
    		$this->template->trySet('fieldset','span1');
    	}
    	if ($name != $this->fields[count($this->fields) - 1]) {
	    	$sep = $this->addSeparator('span1');
	  		$this->add('Order')->move($sep, 'after', $name)->now();
    	} 
	  	$field->js('change',$this->js()->submit());
  		return $field;
    }
    //function addField($type, $name)
}
