<?php
class Form_Field_DPlus extends Form_Field_DropDown {
    function init(){
        parent::init();
    }
    function setInfo($model, $token, $field){
        $b=$this->add("Button", null, "after_field")->set("+");
        $this->js("reload$token",
                $this->owner->js()->atk4_form("reloadField",$field, null, null, null, array("$token" =>
                    $this->js()->_selector("body")->attr($token))
            ))->_selector("body");
        $b->js("click", $this->js()->univ()->frameURL("+++",
            $this->api->url("manageentity", array("m" => $model, "me" => $token))));
        if ($_GET[$token]){
            $this->set($_GET[$token]);
            $this->owner->getModel()->set($field, $this->get());
        }
        return $this;
    }
}
