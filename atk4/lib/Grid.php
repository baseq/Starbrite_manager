<?php
/***********************************************************
  ..

  Reference:
  http://agiletoolkit.org/doc/ref

==ATK4===================================================
   This file is part of Agile Toolkit 4
    http://agiletoolkit.org/

   (c) 2008-2013 Agile Toolkit Limited <info@agiletoolkit.org>
   Distributed under Affero General Public License v3 and
   commercial license.

   See LICENSE or LICENSE_COM for more information
=====================================================ATK4=*/
class Grid extends Grid_Advanced {

    function addSelectable($field){
        $this->js_widget=null;
        $this->js(true)
            ->_load('ui.atk4_checkboxes')
            ->atk4_checkboxes(array('dst_field'=>$field));
        $this->addColumn('checkbox','selected');

        $this->addOrder()
            ->useArray($this->columns)
            ->move('selected','first')
            ->now();
    }
}
