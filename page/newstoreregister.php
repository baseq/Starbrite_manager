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
        $selectBtn->js('click')->univ()->frameURL('Select Products',$this->api->url('selectProducts2'));

        $f->template->trySet('fieldset','span4');
        $sep1 = $f->addSeparator('span4');
        //$sep2 = $f->addSeparator('span4');
        $f->add('Order')->move($sep1, 'before', 'cb_dist1sale')->move($selectBtn, 'after', 'cb_itemnumber')->now();


        //$selectBtn->grid->add('Button', 'press');

        //$this->js('addSelectedText', $f->js()->atk4_form('reloadField', 'cb_itemnumber'))->_selector('body');

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
//        $f->getElement('cb_itemnumber')
//            ->setProperty('style', 'width:210px')->setProperty('readonly', 'true');
        $f->getElement('cb_expiredate')->setProperty('size', 34);
        if($this->api->recall('selected_record')){
            $f->getElement('cb_itemnumber')->set($this->api->recall('selected_record'));
            $this->api->forget('selected_record');
        }
        $f->addSubmit('Submit');

        if($f->isSubmitted()) {

            $pass = base64_encode(pack("H*", sha1('gicule')));
            $cbdealno_comprof = $this->api->db->getOne('SELECT MAX(id) FROM starbr_comprofiler');
            $cbdealno_storeregister = $this->api->db->getOne('SELECT MAX(id) FROM starbr_store_registration');

            $cbdealno = max(intval($cbdealno_comprof), intval($cbdealno_storeregister));
            $cbdealno = $cbdealno + 1;
            $cbdealno = 'A'.str_pad($cbdealno, 6, '0', STR_PAD_LEFT);

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
            $f->model->set('approved',  1);
            $f->update();

            if ($f->model->get('approved') == 1) {

                //add new user to joomla users database table
                $joomlausers = $this->add('Model_JoomlaUsers');
                $joomlausers->set('name', $f->model->get('firstname').$f->model->get('lastname'));
                $joomlausers->set('username', $f->model->get('username'));
                $joomlausers->set('email', $f->model->get('email'));
                $joomlausers->set('password', $f->model->get('password'));
                $joomlausers->set('registerDate', date('Y-m-d h:i'));
                $joomlausers->set('params', '{}');
                $joomlausers->update();

                //add new record in joomla com_profiler database table
                $comprof = $this->add('Model_Retailer');
                $comprof->set('approved', $f->model->get('approved'));
                $comprof->set('cb_goldstore', $f->model->get('cb_goldstore'));
                $comprof->set('cb_expiredate', $f->model->get('cb_expiredate'));
                $comprof->set('cb_dealno', $cbdealno);
                $comprof->set('firstname', $f->model->get('firstname'));
                $comprof->set('lastname', $f->model->get('lastname'));
                $comprof->set('cb_email', $f->model->get('cb_email'));
                $comprof->set('cb_storeno', $f->model->get('cb_storeno'));
                $comprof->set('cb_phone1', $f->model->get('cb_phone1'));
                $comprof->set('cb_phone2', $f->model->get('cb_phone2'));
                $comprof->set('website', $f->model->get('website'));
                $comprof->set('cb_type', $f->model->get('cb_type'));
                $comprof->set('cb_notes', $f->model->get('cb_notes'));
                $comprof->set('cb_fax', $f->model->get('cb_fax'));
                $comprof->set('cb_onlinesell', $f->model->get('cb_onlinesell'));
                $comprof->set('cb_dist1', $f->model->get('cb_dist1'));
                $comprof->set('cb_dist2', $f->model->get('cb_dist2'));
                $comprof->set('cb_dist1sale', $f->model->get('cb_dist1sale'));
                $comprof->set('cb_dist2sale', $f->model->get('cb_dist2sale'));
                $comprof->set('cb_code', $f->model->get('cb_code'));
                $comprof->set('cb_trade', $f->model->get('cb_trade'));
                $comprof->set('cb_storenumber', $f->model->get('cb_storenumber'));
                $comprof->set('cb_itemnumber', $f->model->get('cb_itemnumber'));
                $comprof->set('cb_address1', $f->model->get('cb_address1'));
                $comprof->set('cb_address2', $f->model->get('cb_address2'));
                $comprof->set('cb_city', $f->model->get('cb_city'));
                $comprof->set('cb_state', $f->model->get('cb_state'));
                $comprof->set('cb_country', $f->model->get('cb_country'));
                $comprof->set('cb_zip', $f->model->get('cb_zip'));
                $comprof->set('cb_fieldsetname', $f->model->get('cb_fieldsetname'));
                $comprof->set('registeripaddr', '98.249.236.206');
                $comprof->set('id', intval($cbdealno_comprof) + 1);
                $comprof->set('user_id', intval($cbdealno_comprof) + 1);
                $comprof->update();
            }


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

            //closes the entire form dialog
            $this->js(null, $this->api->js()->_selector('body')
                ->trigger('reload'))->univ()->closeDialog()->execute();
        }
    }

    function render()
    {
        parent::render();

        $this->js('addSelectedText2', $this->form->js()->atk4_form('reloadField', 'cb_itemnumber'))->_selector('body');

    }
}