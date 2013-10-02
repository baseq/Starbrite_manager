<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Famjenescu
 * Date: 9/29/13
 * Time: 3:50 PM
 * To change this template use File | Settings | File Templates.
 */

class page_selectProducts extends page_products
{

    function init()
    {
        parent::init();

        //refresh the page (code on main page)
        //        $b=$p->add('Button')->set('Open Dialog');
        //
        //        $b->js('click')->univ()
        //            ->dialogURL('Sample',$this->api
        //                    ->getDestinationURL('./subpage'),
        //                array('width'=>1000)
        //            );
        //
        //        $l=$p->add('LoremIpsum')->setLength(1,20);
        //
        //        $b->js('my_reload',$l->js()->reload());
        //
        //refresh the page code on dialog page
        //
        //        $f=$p->add('Form');
        //        $f->addField('line','surname');
        //        if($f->isSubmitted()){
        //            $f->js()->univ()->closeDialog()
        //                ->getjQuery()->trigger('my_reload')
        //                ->execute();
        //}

    }

}