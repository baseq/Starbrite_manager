<?php
class minijqplot extends View {
    public $series=array();
    public $opts=array();

 function init(){
        parent::init();
    }

    function setAxisDefaults($opts) {
        $this->opts['axisDefaults']=$opts;
        return $this;
    }

    function setTitle($t) {
       $this->opts['title']=$t;
       return $this;
    }

    function set($key,$value){
        $this->opts[$key]=$value;
        return $this;
    }

    function setSeries($series){
        $this->series=$series;
        return $this;
    }

    function render()
    {
        $this->js(true)->univ()->jqplot($this->series, $this->opts);
        parent::render();
    }
}
