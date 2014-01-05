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
        $selectBtn = $f->add('Button', 'button')->set('+')->setStyle(array('margin-left'=>'320px', 'top'=>'-31px', 'margin-bottom'=>'-31px'));
        $selectBtn->js('click')->univ()->frameURL('Select Products',$this->api->url('selectProducts2'));

        $f->template->trySet('fieldset','span4');
        $sep1 = $f->addSeparator('span4');
        //$sep2 = $f->addSeparator('span4');
        $f->add('Order')->move($sep1, 'before', 'cb_dist1sale')->move($selectBtn, 'after', 'cb_itemnumber')->now();


        //$selectBtn->grid->add('Button', 'press');

        //$this->js('addSelectedText', $f->js()->atk4_form('reloadField', 'cb_itemnumber'))->_selector('body');

        //$f->getElement('cb_dealno')->setProperty('size', 40);
        $f->getElement('cb_email')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_storeno')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_phone1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_phone2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('website')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_type')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_notes')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_fax')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_onlinesell');
        $f->getElement('cb_dist1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist1sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_dist2sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_code')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_trade')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_storenumber')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_address1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_address2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $f->getElement('cb_city')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');

        $country_list=array(1=>'AFGHANISTAN',2=>'ÅLAND ISLANDS',3=>'ALBANIA',4=>'ALGERIA',5=>'AMERICAN SAMOA',
            6=>'ANDORRA',7=>'ANGOLA',8=>'ANGUILLA',9=>'ANTARCTICA',10=>'ANTIGUA AND BARBUDA',11=>'ARGENTINA',
            12=>'ARMENIA',13=>'ARUBA',14=>'AUSTRALIA',15=>'AUSTRIA',16=>'AZERBAIJAN',17=>'BAHAMAS',18=>'BAHRAIN',
            19=>'BANGLADESH',20=>'BARBADOS',21=>'BELARUS',22=>'BELGIUM',23=>'BELIZE',24=>'BENIN',25=>'BERMUDA',
            26=>'BHUTAN',27=>'BOLIVIA, PLURINATIONAL STATE OF',28=>'BONAIRE, SINT EUSTATIUS AND SABA',
            29=>'BOSNIA AND HERZEGOVINA',30=>'BOTSWANA',31=>'BOUVET ISLAND',32=>'BRAZIL',33=>'BRITISH INDIAN OCEAN TERRITORY',
            34=>'BRUNEI DARUSSALAM',35=>'BULGARIA',36=>'BURKINA FASO',37=>'BURUNDI',38=>'CAMBODIA',39=>'CAMEROON',
            40=>'CANADA',41=>'CAPE VERDE',42=>'CAYMAN ISLANDS',43=>'CENTRAL AFRICAN REPUBLIC',44=>'CHAD',45=>'CHILE',
            46=>'CHINA',47=>'CHRISTMAS ISLAND',48=>'COCOS (KEELING) ISLANDS',49=>'COLOMBIA',50=>'COMOROS',51=>'CONGO',
            52=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE',53=>'COOK ISLANDS',54=>'COSTA RICA',55=>'CÔTE D’IVOIRE',56=>'CROATIA',
            57=>'CUBA',58=>'CURAÇAO',59=>'CYPRUS',60=>'CZECH REPUBLIC',61=>'DENMARK',62=>'DJIBOUTI',63=>'DOMINICA',
            64=>'DOMINICAN REPUBLIC',65=>'ECUADOR',66=>'EGYPT',67=>'EL SALVADOR',68=>'EQUATORIAL GUINEA',69=>'ERITREA',
            70=>'ESTONIA',71=>'ETHIOPIA',72=>'FALKLAND ISLANDS (MALVINAS)',73=>'FAROE ISLANDS',74=>'FIJI',75=>'FINLAND',
            76=>'FRANCE',77=>'FRENCH GUIANA',78=>'FRENCH POLYNESIA',79=>'FRENCH SOUTHERN TERRITORIES',80=>'GABON',
            81=>'GAMBIA',82=>'GEORGIA',83=>'GERMANY',84=>'GHANA',85=>'GIBRALTAR',86=>'GREECE',87=>'GREENLAND',
            88=>'GRENADA',89=>'GUADELOUPE',90=>'GUAM',91=>'GUATEMALA',92=>'GUERNSEY',93=>'GUINEA',94=>'GUINEA-BISSAU',
            95=>'GUYANA',96=>'HAITI',97=>'HEARD ISLAND AND MCDONALD ISLANDS',98=>'HOLY SEE (VATICAN CITY STATE)',
            99=>'HONDURAS',100=>'HONG KONG',101=>'HUNGARY',102=>'ICELAND',103=>'INDIA',104=>'INDONESIA',105=>'IRAN, ISLAMIC REPUBLIC OF',
            106=>'IRAQ',107=>'IRELAND',108=>'ISLE OF MAN',109=>'ISRAEL',110=>'ITALY',111=>'JAMAICA',112=>'JAPAN',
            113=>'JERSEY',114=>'JORDAN',115=>'KAZAKHSTAN',116=>'KENYA',117=>'KIRIBATI',118=>'KOREA, DEMOCRATIC PEOPLE’S REPUBLIC OF',
            119=>'KOREA, REPUBLIC OF',120=>'KUWAIT',121=>'KYRGYZSTAN',122=>'LAO PEOPLE’S DEMOCRATIC REPUBLIC',
            123=>'LATVIA',124=>'LEBANON',125=>'LESOTHO',126=>'LIBERIA',127=>'LIBYA',128=>'LIECHTENSTEIN',
            129=>'LITHUANIA',130=>'LUXEMBOURG',131=>'MACAO',132=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
            133=>'MADAGASCAR',134=>'MALAWI',135=>'MALAYSIA',136=>'MALDIVES',137=>'MALI',138=>'MALTA',
            139=>'MARSHALL ISLANDS',140=>'MARTINIQUE',141=>'MAURITANIA',142=>'MAURITIUS',143=>'MAYOTTE',144=>'MEXICO',
            145=>'MICRONESIA, FEDERATED STATES OF',146=>'MOLDOVA, REPUBLIC OF',147=>'MONACO',148=>'MONGOLIA',
            149=>'MONTENEGRO',150=>'MONTSERRAT',151=>'MOROCCO',152=>'MOZAMBIQUE',153=>'MYANMAR',154=>'NAMIBIA',
            155=>'NAURU',156=>'NEPAL',157=>'NETHERLANDS',158=>'NEW CALEDONIA',159=>'NEW ZEALAND',160=>'NICARAGUA',
            161=>'NIGER',162=>'NIGERIA',163=>'NIUE',164=>'NORFOLK ISLAND',165=>'NORTHERN MARIANA ISLANDS',
            166=>'NORWAY',167=>'OMAN',168=>'PAKISTAN',169=>'PALAU',170=>'PALESTINIAN TERRITORY, OCCUPIED',171=>'PANAMA',
            172=>'PAPUA NEW GUINEA',173=>'PARAGUAY',174=>'PERU',175=>'PHILIPPINES',176=>'PITCAIRN',177=>'POLAND',178=>'PORTUGAL',
            179=>'PUERTO RICO',180=>'QATAR',181=>'RÉUNION',182=>'ROMANIA',183=>'RUSSIAN FEDERATION',184=>'RWANDA',185=>'SAINT BARTHÉLEMY',
            186=>'SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA',187=>'SAINT KITTS AND NEVIS',188=>'SAINT LUCIA',189=>'SAINT MARTIN (FRENCH PART)',
            190=>'SAINT PIERRE AND MIQUELON',191=>'SAINT VINCENT AND THE GRENADINES',192=>'SAMOA',193=>'SAN MARINO',194=>'SAO TOME AND PRINCIPE',
            195=>'SAUDI ARABIA',196=>'SENEGAL',197=>'SERBIA',198=>'SEYCHELLES',199=>'SIERRA LEONE',200=>'SINGAPORE',201=>'SINT MAARTEN (DUTCH PART)',
            202=>'SLOVAKIA',203=>'SLOVENIA',204=>'SOLOMON ISLANDS',205=>'SOMALIA',206=>'SOUTH AFRICA',207=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
            208=>'SOUTH SUDAN',209=>'SPAIN',210=>'SRI LANKA',211=>'SUDAN',212=>'SURINAME',213=>'SVALBARD AND JAN MAYEN',214=>'SWAZILAND',
            215=>'SWEDEN',216=>'SWITZERLAND',217=>'SYRIAN ARAB REPUBLIC',218=>'TAIWAN, PROVINCE OF CHINA',219=>'TAJIKISTAN',
            220=>'TANZANIA, UNITED REPUBLIC OF',221=>'THAILAND',222=>'TIMOR-LESTE',223=>'TOGO',224=>'TOKELAU',225=>'TONGA',
            226=>'TRINIDAD AND TOBAGO',227=>'TUNISIA',228=>'TURKEY',229=>'TURKMENISTAN',230=>'TURKS AND CAICOS ISLANDS',
            231=>'TUVALU',232=>'UGANDA',233=>'UKRAINE',234=>'UNITED ARAB EMIRATES',235=>'UNITED KINGDOM',
            'UNITED STATES OF AMERICA'=>'UNITED STATES OF AMERICA',237=>'UNITED STATES MINOR OUTLYING ISLANDS',238=>'URUGUAY',239=>'UZBEKISTAN',240=>'VANUATU',
            241=>'VENEZUELA, BOLIVARIAN REPUBLIC OF',242=>'VIET NAM',243=>'VIRGIN ISLANDS, BRITISH',244=>'VIRGIN ISLANDS, U.S.',
            245=>'WALLIS AND FUTUNA',246=>'WESTERN SAHARA',247=>'YEMEN',248=>'ZAMBIA',249=>'ZIMBABWE');
        $region_list=array('AL','AK','AS','AZ','AR','CA','CO',
            'CT','DE','DC','FL','GA','GU','HI','ID','IL','IN',
            'IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO',
            'MT','NE','NV','NH','NJ','NM','NY','NC','ND',
            'MP','OH','OK','OR','PA','PR','RI',
            'SC','SD','TN','TX','UT','VT','VI','VA','WA',
            'WV','WI','WY');
        //$region_list=$region_list[$_GET['region']]?:array();
        $country_list2 = array();
        foreach($country_list as $k=>$v) {
            $country_list2[$v] = $v;
        }
        $country_list = $country_list2;
        $region_list2 = array();
        foreach ($region_list as $r) {
            $region_list2[$r] = $r;
        }
        $region_list = $region_list2;
        $f->getElement('cb_country')->setProperty('style', 'width:220px')->setProperty('style','text-transform:uppercase;')->setProperty('style','width:218px;')
            ->setValueList($country_list);
        $f->getElement('cb_state')->setProperty('style', 'width:220px')->setProperty('style','text-transform:uppercase;')->setProperty('style','width:218px;')
            ->setValueList($region_list);
        if ($_GET['country']) {
            $f->set('cb_country', $_GET['country']);
        } else {
            $f->set('cb_country', 'UNITED STATES OF AMERICA');
        }
        $country = $f->getElement('cb_country');
        $region = $f->getElement('cb_state');

        if(strcmp($f->get('cb_country'), 'UNITED STATES OF AMERICA') == 0) {
            $region->js(true)->parent()->parent()->show();
            //$region->js(true)->closest('div')->siblings(array(0=>'label'))->show();
        } else {
            $region->js(true)->parent()->parent()->hide();
        }
        $country->js('change',$f->js()->atk4_form('reloadField','cb_state',
            array($this->api->getDestinationURL(),'country'=>$country->js()->val())));

        $f->getElement('cb_zip')->setProperty('size', 40);
        $f->getElement('cb_itemnumber')->setProperty('size', 40);
//        $f->getElement('cb_itemnumber')
//            ->setProperty('style', 'width:210px')->setProperty('readonly', 'true');
        $f->getElement('cb_expiredate')->setProperty('size', 34);
        if($this->api->recall('selected_record2')){
            $f->getElement('cb_itemnumber')->set($this->api->recall('selected_record2'));
            //$this->api->forget('selected_record');
        }
        $f->addSubmit('Submit');

        if($f->isSubmitted()) {
            $fields = array('cb_email', 'cb_storeno', 'cb_phone1', 'cb_phone2', 'website', 'cb_type', 'cb_notes', 'cb_fax',
                'cb_dist1', 'cb_dist2', 'cb_dist1sale', 'cb_dist2sale', 'cb_code', 'cb_trade', 'cb_storenumber', 'cb_address1',
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

        $this->js('addSelectedText2', $this->form->js()->atk4_form('reloadField', 'cb_itemnumber'))->_selector('body');

    }
}