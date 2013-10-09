<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Famjenescu
 * Date: 10/5/13
 * Time: 6:28 PM
 * To change this template use File | Settings | File Templates.
 */

class page_thankyou extends Page {
    function init(){
        parent::init();

        // Adding view box with another view object inside with my custom HTML template
        //$this->add('View_Info')->add('View',null,null,array('view/myinfobox'));

        // Paste any Agile Toolkit examples BELOW THIS LINE. You can remove what I have here:

        // Adding a View and chaining example
        $this->add('H1')->set('Thank you for your submission');
        //$this->add('P')->set('Press Manager button from menu to continue!');

        // Assign reference to your object into variable $button
        //$button = $page->add('Button')->setLabel('Refresh following text with AJAX');

        // You can store multiple references, different views, will have different methods
        //$lorem_ipsum = $this->add('LoremIpsum')->setLength(1,200);

        // Bind button click with lorem_ipsum text reload
        //$button->js('click',$lorem_ipsum->js()->reload());


        //$this->add('Form')->addField('line','foo')->validateNotNull();

        // Oh and thanks for giving Agile Toolkit a try! You'll be excited how simple
        // it is to use.
    }
}
