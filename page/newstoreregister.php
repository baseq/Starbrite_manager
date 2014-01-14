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
        /*TO DO: fix it Jenescu
         * $f->setClass('template-master-details-grid template-master-details-grid-rows atk-row');
         * */
        $f->setClass('template-master-details-grid template-master-details-grid-rows atk-row')->setStyle('width', '800px');
        $label1 = $f->add('HtmlElement')
            ->setElement('h4')
            ->set('CONTACT INFO');
        $label2 = $f->add('HtmlElement')
            ->setElement('h4')
            ->set('DEALER INFO');
        $label3 = $f->add('HtmlElement')
            ->setElement('h4')
            ->set('INTERNAL USE ONLY');

        if($this->api->recall('new_flag')){
            $f->getElement('cb_itemnumber')->set($this->api->recall('new_selected_record'));
            $this->api->forget('new_flag');
        } else {
            if ($f->get('cb_itemnumber')) {
                $this->api->memorize('new_selected_record', $f->get('cb_itemnumber'));
            } else {
                $this->api->forget('new_selected_record');
            }
        }
        $selectBtn = $f->add('Button', 'button')->set('+')->setStyle(array('margin-left'=>'350px', 'top'=>'-98px'));
        $selectBtn->js('click')->univ()->frameURL('Select Products',$this->api->url('selectProducts2', array('page_newreg'=>$this->name)));

        $f->template->trySet('fieldset','span4');
        $sep1 = $f->addSeparator('span4');
        //$sep2 = $f->addSeparator('span4');
        $f->add('Order')->move($label1, 'before', 'cb_storeno')->move($label2, 'before', 'cb_itemnumber')->move($label3, 'before', 'cb_goldstore')->now();
        $f->add('Order')->move($sep1, 'before', $label2)->move($selectBtn, 'after', 'cb_itemnumber')->now();



        //$selectBtn->grid->add('Button', 'press');

        //$this->js('addSelectedText', $f->js()->atk4_form('reloadField', 'cb_itemnumber'))->_selector('body');

        //$f->getElement('cb_dealno')->setProperty('size', 40);
        $f->getElement('cb_email')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_storeno')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_phone1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_phone2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('website')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_type')->setProperty('size', 40)->setProperty('style','width:218px;');
        $f->getElement('cb_notes')->setProperty('cols', 42)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_fax')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_onlinesell');
        $f->getElement('cb_dist1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist1sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist2sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        //$f->getElement('cb_code')->setProperty('style','display:none');
        $f->getElement('cb_trade')->setProperty('size', 40)->setProperty('style','width:218px;');
        $f->getElement('cb_storenumber')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_address1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_address2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_city')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');

        $country_list = $f->model->countryList();
        $region_list = $f->model->regionList();

        // country field
        $f->getElement('cb_country')
            ->setProperty('style', 'width:220px')
            ->setProperty('style','text-transform:uppercase;')
            ->setProperty('style','width:218px;')
            ->setValueList($country_list);

        // state field
        $f->getElement('cb_state')
            ->setProperty('style', 'width:220px')
            ->setProperty('style','text-transform:uppercase;')
            ->setProperty('style','width:218px;');


        $country = $f->get('cb_country');
        $region = $f->get('cb_state');
        $countryIndex = null;
        if(isset($_POST[$f->getElement('cb_country')->name])) {
            $f->getElement('cb_country')->set($_POST[$f->getElement('cb_country')->name]);
            $countryIndex = $f->get('cb_country');
        } else if(isset($_GET['country'])){
            $countryIndex = $_GET['country'];
        }
        if ($countryIndex == null) {
            foreach ($country_list as $k => $c) {
                if (strcmp($country, $c) == 0) {
                    $countryIndex = $k;
                    break;
                }
            }
        }
        if($countryIndex==null) $countryIndex = 236;
        if (isset($region_list[$countryIndex])) {
            $regionIndex = null;
            foreach ($region_list[$countryIndex] as $k => $r) {
                if (strcmp($region, $r) == 0) {
                    $regionIndex = $k;
                    break;
                }
            }

            $f->getElement('cb_state')->setValueList($region_list[$countryIndex]);
            if ($regionIndex != null) {
                $f->set('cb_state', $regionIndex);
            }
            $f->getElement('cb_state')->js(true)->parent()->parent()->show();
        } else {
            $f->getElement('cb_state')->js(true)->parent()->parent()->hide();
        }
        if($countryIndex!=null){
            $f->set('cb_country', $countryIndex);
        }
        else {
            $f->set('cb_country', 236);
        }

        $f->getElement('cb_country')->js('change', $f->js()->atk4_form('reloadField', 'cb_state', array(
                $this->api->url(),
                'country' => $f->getElement('cb_country')->js()->val())
        ));

        $f->getElement('cb_zip')->setProperty('size', 40);
        $f->getElement('cb_itemnumber')->setProperty('cols', 42);//->setProperty('readonly', 'true');
//        $f->getElement('cb_itemnumber')
//            ->setProperty('style', 'width:210px')->setProperty('readonly', 'true');
        $f->getElement('cb_expiredate')->setProperty('size', 34);
        if($this->api->recall('selected_record2')){
            $f->getElement('cb_itemnumber')->set($this->api->recall('selected_record2'));
            //$this->api->forget('selected_record');
        }
        $f->addSubmit('Submit');

        if($f->isSubmitted()) {
            //replace all non digits or comma from the cb_itemnumber field
            $str = nl2br($f->get('cb_itemnumber'));
            $str = str_replace('<br />',',',$str);
            $str = str_replace(', ',',',$str);
            $str = str_replace(' ,',',',$str);
            $str = preg_replace('/ +/',',',$str);
            $str = preg_replace('/[^0-9,]/','', $str);
            $str = preg_replace('/,+/',',',$str);
            $str = preg_replace('/,$/','',$str);
            $f->set('cb_itemnumber', $str);

            $fields = array('cb_email', 'cb_storeno', 'cb_phone1', 'cb_phone2', 'website', 'cb_type', 'cb_notes', 'cb_fax',
                'cb_dist1', 'cb_dist2', 'cb_dist1sale', 'cb_dist2sale', 'cb_trade', 'cb_storenumber', 'cb_address1',
                'cb_address2', 'cb_city');
            foreach ($fields as $value){
                $f->set($value, strtoupper($f->get($value)));
            }
            $pass = base64_encode(pack("H*", sha1('gicule')));
            $id_comprof = $this->api->db->getOne('SELECT MAX(id) + 1 FROM starbr_comprofiler');
            $cbdealno_comprof = $this->api->db->getOne('SELECT MAX(cb_dealno) FROM starbr_comprofiler where cb_dealno like \'A%\'');
            $cbdealno_comprof = str_replace('A', '', $cbdealno_comprof);
            $cbdealno_storeregister = $this->api->db->getOne('SELECT MAX(cb_dealno) FROM starbr_store_registration where cb_dealno like \'A%\'');
            $cbdealno_storeregister = str_replace('A', '', $cbdealno_storeregister);

            $cbdealno = max(intval($cbdealno_comprof), intval($cbdealno_storeregister));
            $cbdealno = $cbdealno + 1;
            $cbdealno = 'A'.str_pad($cbdealno, 6, '0', STR_PAD_LEFT);

            $f->model->set('cb_dealno',  $cbdealno);
            $f->model->set('firstname', $f->get('cb_storeno'));
            $f->model->set('lastname', " - ".$f->get('cb_storenumber')." ".$f->get('cb_city').", ".$region_list[$f->get('cb_country')][$f->get('cb_state')]);
            $f->model->set('username', $cbdealno);
            $f->model->set('password', $pass);
            if (!$f->get('cb_email')) {
                $f->model->set('email', $cbdealno.'@invalid.com');
            } else {
                $f->model->set('email', $f->get('cb_email'));
            }
            $f->model->set('approved',  1);
            $country = $f->get('cb_country');
            $region = $f->get('cb_state');
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
                $joomlausers_id = $this->api->db->getOne('SELECT MAX(id) FROM starbr_users');

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
                //$comprof->set('cb_code', $f->model->get('cb_code'));
                $comprof->set('cb_trade', $f->model->get('cb_trade'));
                $comprof->set('cb_storenumber', $f->model->get('cb_storenumber'));
                $comprof->set('cb_itemnumber', $f->model->get('cb_itemnumber'));
                $comprof->set('cb_address1', $f->model->get('cb_address1'));
                $comprof->set('cb_address2', $f->model->get('cb_address2'));
                $comprof->set('cb_city', $f->model->get('cb_city'));
                $comprof->set('cb_state', $region);
                $comprof->set('cb_country', $country);
                $comprof->set('cb_zip', $f->model->get('cb_zip'));
                $comprof->set('cb_fieldsetname', $f->model->get('cb_fieldsetname'));
                $comprof->set('registeripaddr', '98.249.236.206');
                $comprof->set('id', intval($id_comprof));
                $comprof->set('user_id', intval($joomlausers_id));
                $comprof->update();
            }


            /*$sql1 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
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
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is not null and cb_notes <> '')
              ";

            //update cb_fieldsetname for stores with missing notes, but with phone
            $sql3 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                 END
                                where (cb_notes is null or cb_notes = '') and (cb_phone1 is not null and cb_phone1 <> '')
              ";

            //update cb_fieldsetname for stores with notes and with phone
            $sql4 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                        WHERE  ( cb_notes IS NOT NULL AND cb_notes <> '' ) AND ( cb_phone1 IS NOT NULL AND cb_phone1 <> '' )
              ";*/

            $sql5 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is null or cb_notes = '')
              ";

            //update cb_fieldsetname for stores with missing phone, but with notes
            //
            $sql6 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is not null and cb_notes <> '')
              ";

            //update cb_fieldsetname for stores with missing notes, but with phone
            $sql7 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                 END
                                where (cb_notes is null or cb_notes = '') and (cb_phone1 is not null and cb_phone1 <> '')
              ";

            //update cb_fieldsetname for stores with notes and with phone
            $sql8 = "UPDATE starbr_comprofiler
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                        WHERE  ( cb_notes IS NOT NULL AND cb_notes <> '' ) AND ( cb_phone1 IS NOT NULL AND cb_phone1 <> '' )
              ";
            //delete record from the temporary stores table after approved (and moved to the approved stores table)
            $sql9 = "DELETE FROM starbr_store_registration WHERE cb_dealno = '" . $cbdealno ."'";

            try {
/*                $q = $this->api->db->query($sql1);
                $q = $this->api->db->query($sql2);
                $q = $this->api->db->query($sql3);
                $q = $this->api->db->query($sql4);*/
                $q = $this->api->db->query($sql5);
                $q = $this->api->db->query($sql6);
                $q = $this->api->db->query($sql7);
                $q = $this->api->db->query($sql8);
                $q = $this->api->db->query($sql9);
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

        $this->js('addSelectedText2', $this->form->js()->atk4_form('reloadField', 'cb_itemnumber'));

    }
}