<?php
class page_newstoreregister extends Page
{
    private $form;

    function init()
    {
        parent::init();

        $this->js(true)->_load('wizard/page_wizard');
        $model = $this->setModel('StoreRegister');

        $f = $this->add('Form');
        $this->form = $f;
        $f->setModel($model);
        $f->setClass('template-master-details-grid template-master-details-grid-rows atk-row');

        $selectBtn = $f->add('Button', 'button')->set('+')->setStyle(array('margin-left'=>'320px', 'top'=>'-31px', 'margin-bottom'=>'-31px'));
        $selectBtn->js('click')->univ()->frameURL('Select Products',$this->api->getDestinationURL('selectProducts'));

        $f->template->trySet('fieldset','span4');
        $sep1 = $f->addSeparator('span4');
        //$sep2 = $f->addSeparator('span4');
        $f->add('Order')->move($sep1, 'before', 'cb_dist1sale')->move($selectBtn, 'after', 'cb_itemnumber')->now();


        //$selectBtn->grid->add('Button', 'press');

        //$this->js('addSelectedText', $f->js()->atk4_form('reloadField', 'cb_itemnumber'))->_selector('body');

        if($this->api->recall('selected_record')){
            $f->getElement('cb_itemnumber')->set($this->api->recall('selected_record'));
            $this->api->forget('selected_record');
        }

        //$f->getElement('cb_dealno')->setProperty('size', 40);
        $f->getElement('cb_email')->setProperty('size', 40);
        $f->getElement('cb_storeno')->setProperty('size', 40);
        $f->getElement('cb_phone1')->setProperty('size', 40);
        $f->getElement('cb_phone2')->setProperty('size', 40);
        $f->getElement('website')->setProperty('size', 40);
        $f->getElement('cb_type')->setProperty('size', 40);
        $f->getElement('cb_notes')->setProperty('size', 40);
        $f->getElement('cb_fax')->setProperty('size', 40);
        $f->getElement('cb_onlinesell')->setProperty('size', 40);
        $f->getElement('cb_dist1')->setProperty('size', 40);
        $f->getElement('cb_dist2')->setProperty('size', 40);
        $f->getElement('cb_dist1sale')->setProperty('size', 40);
        $f->getElement('cb_dist2sale')->setProperty('size', 40);
        $f->getElement('cb_code')->setProperty('size', 40);
        $f->getElement('cb_trade')->setProperty('size', 40);
        $f->getElement('cb_storenumber')->setProperty('size', 40);
        $f->getElement('cb_address1')->setProperty('size', 40);
        $f->getElement('cb_address2')->setProperty('size', 40);
        $f->getElement('cb_city')->setProperty('size', 40);
        $f->getElement('cb_state')->setProperty('size', 40);
        $f->getElement('cb_country')->setProperty('size', 40);
        $f->getElement('cb_zip')->setProperty('size', 40);
        $f->getElement('cb_itemnumber')->setProperty('size', 40);
        $f->getElement('cb_itemnumber')
            ->setProperty('style', 'width:210px')->setProperty('readonly', 'true');
        $f->addSubmit('Submit');

        if($f->isSubmitted()) {
            $pass = base64_encode(pack("H*", sha1('gicule')));
            $cbdealno = $this->api->db->getOne('SELECT MAX(id) FROM starbr_store_registration');
            $cbdealno = intval($cbdealno) + 1;
            $cbdealno = 'A'.str_pad($cbdealno, 5, '0', STR_PAD_LEFT);

            $f->model->set('cb_dealno',  $cbdealno);
            $f->model->set('firstname', $f->get('cb_storeno'));
            $f->model->set('lastname', " - ".$f->get('cb_storenumber')." ".$f->get('cb_city').", ".$f->get('cb_state'));
            $f->model->set('username', $cbdealno);
            $f->model->set('password', $pass);
            if (!$f->get('cb_email')) {
                $f->model->set('email', $cbdealno.'@invalid.com');
            } else {
                $f->model->set('email', $f->get('cb_email'));
            }

            $f->update();

            $sql1 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is null or cb_notes = '')
              ";

            //update cb_fieldsetname for stores with missing phone, but with notes
            //
            $sql2 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is not null and cb_notes <> '')
              ";

            //update cb_fieldsetname for stores with missing notes, but with phone
            $sql3 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                 END
                                where (cb_notes is null or cb_notes = '') and (cb_phone1 is not null and cb_phone1 <> '')
              ";

            //update cb_fieldsetname for stores with notes and with phone
            $sql4 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                        WHERE  ( cb_notes IS NOT NULL AND cb_notes <> '' ) AND ( cb_phone1 IS NOT NULL AND cb_phone1 <> '' )
              ";

            try {
                $q = $this->api->db->query($sql1);
                $q = $this->api->db->query($sql2);
                $q = $this->api->db->query($sql3);
                $q = $this->api->db->query($sql4);
            }
            catch(Exeption $e) {
                $f->js()->univ()->alert("Failed to save.")->execute();
            }
            $this->js(null, $this->api->js()->_selector('body')
                ->trigger('reload'))->univ()->closeDialog()->execute();
        }
    }

    function render()
    {
        parent::render();

        $this->js('addSelectedText', $this->form->js()->atk4_form('reloadField', 'cb_itemnumber'))->_selector('body');

    }
}