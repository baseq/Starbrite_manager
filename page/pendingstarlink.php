<?php
class page_pendingstarlink extends page_base
{
    private $form;
    function init()
    {
        parent::init();
        $this->add('HtmlElement')
            ->setElement('h1')
            ->set('Pending Retailers');
        $columns = array('cb_plug_lat', 'cb_plug_lng', 'email', 'cb_name', 'confirmed', 'username', 'cb_dealno', 'cb_fieldsetname');
        $this->js(true)->_load('wizard/page_wizard');
        $this->js(true)->tooltip();
        $rootModel = $this->add('Model_Pendingstarlink');
        $id = null;

        if (isset($_GET['selected-id'])) {
            $id = $_GET['selected-id'];
        } elseif ($this->recall('selected-id') == null) {
            $rootModel->tryLoadAny();
            $id = $rootModel['id'];
        } else {
            $id = $this->recall('selected-id');
        }

        if (!$rootModel->loaded() && $id != null) {
            $rootModel->tryLoad($id);
            if (!$rootModel->loaded()) {
                $rootModel->tryLoadAny();
                $id = $rootModel['id'];
            }
        }


        $this->memorize('selected-id', $id);
        $crud = $this->add('CRUD', array('grid_class' => 'Grid_Page_Wizard_MasterDetails', 'allow_edit' => false, 'allow_add' => false));
        $crud->setClass('template-master-details-grid template-master-details-grid-rows');
        $crud->setModel('Pendingstarlink');
        foreach($columns as $column) {
            $crud->grid->removeColumn($column);
        }
        $rootModel->addCondition('id', '=', $id);
        $tabs = $this->add('Tabs');
        $tabDetails = $tabs->addTab('Retailer Details');


        $formDetails = $tabDetails->add('Form');
        $this->form = $formDetails;
        $formDetails->addSubmit("Save");
        $formDetails->setModel($rootModel);
        $formDetails->setClass('ignore_changes template-master-details-grid template-master-details-grid-rows atk-row');

        $formDetails->template->trySet('fieldset', 'span4');
        $label1 = $formDetails->add('HtmlElement')
            ->setElement('h4')
            ->set('CONTACT INFO');
        $label2 = $formDetails->add('HtmlElement')
            ->setElement('h4')
            ->set('DEALER INFO');
        $label3 = $formDetails->add('HtmlElement')
            ->setElement('h4')
            ->set('INTERNAL USE ONLY');

        $sep1 = $formDetails->addSeparator('span4');
        $sep2 = $formDetails->addSeparator('span4');
        $formDetails->add('Order')->move($label1, 'before', 'cb_storeno')->move($label2, 'before', 'cb_itemnumber')->move($label3, 'before', 'cb_goldstore')->now();
        $formDetails->add('Order')->move($sep1, 'before', 'cb_fax')->move($sep2, 'before', 'cb_dist2')->now();

        //field size
        $formDetails->getElement('firstname')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('lastname')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_email')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_storeno')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_phone1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_phone2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('website')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_type')->setProperty('size', 40)->setProperty('style','width:218px;');
        $formDetails->getElement('cb_notes')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_fax')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_dist1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_dist2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_dist1sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_dist2sale')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        //$formDetails->getElement('cb_code')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_trade')->setProperty('size', 40)->setProperty('style','width:218px;');
        $formDetails->getElement('cb_storenumber')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_address1')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_address2')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('cb_city')->setProperty('size', 40)->setProperty('style','text-transform:uppercase;');
        $formDetails->getElement('approved')->setProperty('size', 40)->setProperty('style','width:218px;');


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
        $formDetails->getElement('cb_country')->setProperty('style','text-transform:uppercase;')->setProperty('style','width:218px;')
            ->setValueList($country_list);
        $formDetails->getElement('cb_state')->setProperty('style','text-transform:uppercase;')->setProperty('style','width:218px;')
            ->setValueList($region_list);
        if ($_GET['country']) {
            $formDetails->set('cb_country', $_GET['country']);
        } else {
            $formDetails->set('cb_country', 'UNITED STATES OF AMERICA');
        }
        $country = $formDetails->getElement('cb_country');
        $region = $formDetails->getElement('cb_state');

        if(strcmp($formDetails->get('cb_country'), 'UNITED STATES OF AMERICA') == 0) {
            $region->js(true)->parent()->parent()->show();
            //$region->js(true)->closest('div')->siblings(array(0=>'label'))->show();
        } else {
            $region->js(true)->parent()->parent()->hide();
        }
        $country->js('change',$formDetails->js()->atk4_form('reloadField','cb_state',
            array($this->api->getDestinationURL(),'country'=>$country->js()->val())));


        $formDetails->getElement('cb_zip')->setProperty('size', 40);
        $formDetails->getElement('cb_itemnumber')->setProperty('cols', 42);//->setProperty('readonly', 'true');
        $formDetails->getElement('cb_expiredate')->setProperty('size', 34);
        if($this->api->recall('flag')){
            $formDetails->getElement('cb_itemnumber')->set($this->api->recall('selected_record'));
            $this->api->forget('flag');
        } else {
            $this->api->memorize('selected_record', $formDetails->get('cb_itemnumber'));
        }

        $selectBtn = $formDetails->add('Button', 'button')->set('+')->setStyle(array('margin-left'=>'350px', 'top'=>'-98px'));
        $selectBtn->js('click')->univ()->frameURL('Select Products', $this->api->url('selectProducts', array('page_reg'=>$this->name)));
        $formDetails->getElement('approved')->empty_text = null;
        $formDetails->template->trySet('fieldset','span4');
        $sep1 = $formDetails->addSeparator('span4');
        $formDetails->add('Order')->move($selectBtn, 'after', 'cb_itemnumber')->now();


        if ($crud->grid) {
            //$crud->grid->addButton('Add Store')->js('click')->univ()->frameURL('Register New Store',$this->api->getDestinationURL('newstoreregister'));
            $crud->grid->addPaginator(5);
            $qs1 = $crud->grid->addQuickSearch(array('cb_phone1', 'cb_phone2', 'email'))->addClass('small-form-search');
            $qs1->search_field->setAttr('placeholder', 'Email, Phone');

            $qs2 = $crud->grid->addQuickSearch(array('cb_address2', 'cb_address1', 'cb_city', 'cb_state', 'cb_zip'))->addClass('small-form-search');
            $qs2->search_field->setAttr('placeholder', 'Address, City, State, Zip');

            $qs3 = $crud->grid->addQuickSearch(array('cb_storeno'))->addClass('small-form-search');
            $qs3->search_field->setAttr('placeholder', 'Store Name');

            $qf = $crud->grid->add('DuplicatesFilter', null, 'quick_search')->useWith($crud->grid)->useFields(array('address'));

            $qs = array($qs1, $qs2, $qs3, $qf);

            $button = $crud->grid->addButton('Reset', 'resetbutton');
            $button->js('click', $crud->grid->js()->reload(array('reset'=>1)));

            if(isset($_GET['reset'])) {
                foreach ($qs as $q) {
                    $q->forget();
                }
                $qf->forget();
            }

            $crud->grid->js('click', $this->js()->_selectorThis()->gridMasterDetails(true))->_selector('#' . $crud->grid->name . ' tr');
            $crud->grid->js('gridClick', $this->js()->reload(array(
                'selected-id' => $this->js(null, 'arguments[arguments.length-1]'),
                'selected-tab' => $tabs->js()->tabs('option', 'selected')
            )))->_selector('#' . $crud->grid->name . ' tr');
            $crud->grid->js(true)->_selector('#' . $crud->grid->name . ' tr[data-id="' . $id . '"]')->gridMasterDetails(false);
        }
        $export = $crud->add("StarlinkExport");
        $this->js("reload", $this->js()->reload())->_selector("body");
        if ($formDetails->model->get('approved') == 1) {
            $formDetails->getElement('approved')->disable();
        }

        if ($formDetails->isSubmitted()) {
            //replace all non digits or comma from the cb_itemnumber field
            $str = nl2br($formDetails->get('cb_itemnumber'));

            $str = str_replace('<br />',',',$str);
            $str = str_replace(', ',',',$str);
            $str = str_replace(' ,',',',$str);
            $str = preg_replace('/ +/',',',$str);
            $str = preg_replace('/[^0-9,]/','', $str);
            $str = preg_replace('/,+/',',',$str);
            $str = preg_replace('/,$/','',$str);

            $formDetails->set('cb_itemnumber', $str);

            $fields = array('firstname', 'lastname', 'cb_email', 'cb_storeno', 'cb_phone1', 'cb_phone2', 'website', 'cb_type', 'cb_notes', 'cb_fax',
                'cb_dist1', 'cb_dist2', 'cb_dist1sale', 'cb_dist2sale', 'cb_trade', 'cb_storenumber', 'cb_address1',
                'cb_address2', 'cb_city');
            foreach ($fields as $value){
                $formDetails->set($value, strtoupper($formDetails->get($value)));
            }
            $formDetails->update();

            if ($formDetails->get('approved') == 1) {

                $comprof = $this->add('Model_Retailer');

                $joomlausers = $this->add('Model_JoomlaUsers');
                if ($formDetails->model->get('approved') == 1) {
                    $joomlausers->addCondition('username', $formDetails->model->get('username'));
                    $joomlausers->tryLoadAny();
                    //$joomlausers->load($formDetails->model->get('user_id'));
                    if($formDetails->model->get('cb_email')) {
                        $joomlausers->set('email', $formDetails->model->get('cb_email'));
                    }
                    else {
                        $joomlausers->set('email', $formDetails->model->get('email'));
                        $joomlausers->set('email', $formDetails->model->get('email'));
                    }
                }
                $joomlausers->set('name', $formDetails->model->get('firstname').$formDetails->model->get('lastname'));
                $joomlausers->set('username', $formDetails->model->get('username'));
                $joomlausers->set('password', $formDetails->model->get('password'));
                $joomlausers->set('registerDate', date('Y-m-d h:i'));
                $joomlausers->set('params', '{}');
                $joomlausers->save();
                $user_id = $joomlausers->get('id');

/*                $isApproved = false;
                if ($formDetails->model->get('approved') == 1) {
                    $comprof->addCondition('cb_dealno', $formDetails->model->get('cb_dealno'));
                    $comprof->tryLoadAny();
                    $isApproved = true;
                }*/

                $comprof->set('approved', $formDetails->model->get('approved'));
                $comprof->set('cb_goldstore', $formDetails->model->get('cb_goldstore'));
                $comprof->set('cb_expiredate', $formDetails->model->get('cb_expiredate'));
                $comprof->set('cb_dealno', $formDetails->model->get('cb_dealno'));
                $comprof->set('firstname', $formDetails->model->get('firstname'));
                $comprof->set('lastname', $formDetails->model->get('lastname'));
                $comprof->set('cb_email', $formDetails->model->get('cb_email'));
                $comprof->set('cb_storeno', $formDetails->model->get('cb_storeno'));
                $comprof->set('cb_phone1', $formDetails->model->get('cb_phone1'));
                $comprof->set('cb_phone2', $formDetails->model->get('cb_phone2'));
                $comprof->set('website', $formDetails->model->get('website'));
                $comprof->set('cb_type', $formDetails->model->get('cb_type'));
                $comprof->set('cb_notes', $formDetails->model->get('cb_notes'));
                $comprof->set('cb_fax', $formDetails->model->get('cb_fax'));
                $comprof->set('cb_onlinesell', $formDetails->model->get('cb_onlinesell'));
                $comprof->set('cb_dist1', $formDetails->model->get('cb_dist1'));
                $comprof->set('cb_dist2', $formDetails->model->get('cb_dist2'));
                $comprof->set('cb_dist1sale', $formDetails->model->get('cb_dist1sale'));
                $comprof->set('cb_dist2sale', $formDetails->model->get('cb_dist2sale'));
                //$comprof->set('cb_code', $formDetails->model->get('cb_code'));
                $comprof->set('cb_trade', $formDetails->model->get('cb_trade'));
                $comprof->set('cb_storenumber', $formDetails->model->get('cb_storenumber'));
                $comprof->set('cb_itemnumber', $formDetails->model->get('cb_itemnumber'));
                $comprof->set('cb_address1', $formDetails->model->get('cb_address1'));
                $comprof->set('cb_address2', $formDetails->model->get('cb_address2'));
                $comprof->set('cb_city', $formDetails->model->get('cb_city'));
                $comprof->set('cb_state', $formDetails->model->get('cb_state'));
                $comprof->set('cb_country', $formDetails->model->get('cb_country'));
                $comprof->set('cb_zip', $formDetails->model->get('cb_zip'));
                $comprof->set('cb_fieldsetname', $formDetails->model->get('cb_fieldsetname'));
                $comprof->set('registeripaddr', '98.249.236.206');
                $id_comprof = $this->api->db->getOne('SELECT MAX(id)+1 FROM starbr_comprofiler');
                if (!$comprof->loaded()) {
                    $comprof->set('id', intval($id_comprof));
                    $comprof->set('user_id', $user_id);
                }
                $comprof->save();
                //if ($isApproved) {
                //delete record from the temporary stores table after approved (and moved to the approved stores table)
                $cbdealno = $formDetails->model->get('cb_dealno');
                $sql10 = "DELETE FROM starbr_store_registration WHERE cb_dealno = '" . $cbdealno ."'";
                try {
                    $q = $this->api->db->query($sql10);
                }
                catch(Exeption $e) {
                    $f->js()->univ()->alert("Failed to save.")->execute();
                }
                $this->js(null, $this->api->js()->_selector('body')
                    ->trigger('reload'))->univ()->execute();
                //}
            } else {

            //update cb_fieldsetname for stores with missing phone and missing notes
            $sql1 = "UPDATE starbr_store_registration
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
            $sql2 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
                                                 END
                                where (cb_phone1 is null or cb_phone1 = '') and (cb_notes is not null and cb_notes <> '')
              ";

            //update cb_fieldsetname for stores with missing notes, but with phone
            $sql3 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) >= CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 1 AND DATE(cb_expiredate) < CURDATE() THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                   WHEN cb_goldstore = 0 THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>')
                                                 END
                                where (cb_notes is null or cb_notes = '') and (cb_phone1 is not null and cb_phone1 <> '')
              ";

            //update cb_fieldsetname for stores with notes and with phone
            $sql4 = "UPDATE starbr_store_registration
                        SET    cb_fieldsetname = CASE
                                                   WHEN cb_goldstore = 1 AND cb_expiredate IS NULL THEN CONCAT('<tr><td><strong>', cb_storeno, '</strong>&nbsp;&nbsp;<img src=http://www.starbrite.com/images/comprofiler/favorite.png style=margin-bottom:-3px></td></tr><tr><td>', cb_address1, ', ', cb_city, ' ', cb_state, ' ', cb_zip, '</td></tr>','<tr><td>', cb_phone1, '</td></tr>','<tr><td>', cb_notes, '</td></tr>')
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
                    $formDetails->js()->univ()->successMessage("Saved.")->execute();
                }
                catch(Exeption $e) {
                    $formDetails->js()->univ()->alert("Failed to save.")->execute();
                }
            }

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
            try {
                $q = $this->api->db->query($sql5);
                $q = $this->api->db->query($sql6);
                $q = $this->api->db->query($sql7);
                $q = $this->api->db->query($sql8);
                $formDetails->js()->univ()->successMessage("Saved.")->execute();
            }
            catch(Exeption $e) {
                $formDetails->js()->univ()->alert("Failed to save.")->execute();
            }
        }
    }
    function render()
    {
        parent::render();

        $this->js('addSelectedText', $this->form->js()->atk4_form('reloadField', 'cb_itemnumber'));

    }
}
