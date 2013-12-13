<?php

class StarlinkExport extends misc\ExportCSVActualFields {

    function init(){
        parent::init();
        //$this->buttonCSV->button->js('click', $this->owner->grid->js()->reload()->execute());

        //$this->owner->grid->js()->reload()->execute();
    }

    function export() {

        if (isset($_GET[$this->buttonCSV->button->name])) {
            if ($this->owner->getModel()) {
                foreach ($this->owner->getModel() as $row) {
                    $this->owner->getModel()->set('status', 'Exported');
                    $this->owner->getModel()->set('date_exported', date("Y-m-d"));
                    $this->owner->getModel()->update();
                }
            }
        }
        parent::export();
    }
}
