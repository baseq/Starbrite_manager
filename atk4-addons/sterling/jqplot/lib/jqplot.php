<?php
class jqplot extends View {
    public $series=array();
    public $opts=array();
    public $h='';
    public $w='600px';

 function init(){
        parent::init();
    }

    function includeJQ($tag, $inc) {
       switch ($tag) {
       case 'css': $file=$this->api->locateURL('css',$inc);
                   $this->template->append('css_include', '<link type="text/css" href="'.$file.'" rel="stylesheet" />'."\n");
                   break;
          default: $file=$this->api->locateURL('js',$inc);
                   $this->template->append('js_include', '<script type="text/javascript" src="'.$file.'"></style>'."\n");
                   break;
       }
       return $this;
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

    function setSize($high, $wide){
        $this->h=$high;
        $this->w=$wide;
        return $this;
    }

    function render()
    {
        $this->template->set('height',$this->h);
        $this->template->set('width', $this->w);

        $this->js(true)->univ()->jqplot($this->series, $this->opts);
        parent::render();
    }
    function defaultTemplate(){
        return array('view/chartTab');
    }
}
