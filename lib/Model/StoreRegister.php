<?php

class Model_StoreRegister extends Model_Table
{
    public $table = 'starbr_store_registration';

    function init()
    {
        parent::init();

        $this->addField("cb_storeno")->caption("Store Name");
        $this->addField("cb_storenumber")->caption("Store Number");
        $this->addField("cb_address1")->caption('Address 1');
        $this->addField("cb_address2")->caption('Address 2');
        $this->addField("cb_city")->caption('City');
        $this->addField("cb_country")->caption('Country')->type('list');
        $this->addField("cb_state")->caption('State/Province')->type('list');
        $this->addField("cb_zip")->caption('Zip Code');
        $this->addField("cb_email")->caption("Contact Email");//->mandatory('Email is required');
        $this->addField("cb_phone1")->caption("Phone 1");
        $this->addField("cb_phone2")->caption("Phone 2");
        $this->addField("cb_fax")->caption("Fax");
        $this->addField("website")->caption("Website");
        $this->addField("cb_onlinesell")->caption('Do you sell online?')->datatype('boolean')->enum(array('Y', 'N'));
        $this->addField("cb_itemnumber")->mandatory('Select at least one item number')->caption("Products")->type('text');
        $this->addField("cb_trade")->caption("Type of Trade")->type('list')->setValueList($this->getDistinctTrade());
        $this->addField("cb_dist1")->caption("Primary Distributor");
        $this->addField("cb_dist1sale")->caption("Primary Distributor Salesman");
        $this->addField("cb_dist2")->caption("Secondary Distributor");
        $this->addField("cb_dist2sale")->caption("Secondary Distributor Salesman");
        $this->addField('cb_goldstore')->visible(false)->editable(true)->datatype('boolean')->caption('Gold Star');
        $this->addField('cb_expiredate')->visible(false)->editable(true)->datatype('date')->caption('Expire Date');
        $this->addField("cb_notes")->caption("Notes")->type('text');
        $this->addField("cb_type")->caption("Type")->type('list')->setValueList($this->getDistinctTypes());
        $this->addField("cb_dealno")->system(true);
        $this->addField("username")->system(true);
        $this->addField("password")->system(true);
        $this->addField("email")->system(true);
        //$this->addField('middlename')->caption('Middle name');
        $this->addField("firstname")->system(true);
        $this->addField('lastname')->system(true);
        $this->addField("cb_code")->caption("Code")->system(true);
        $this->addField("cb_fieldsetname")->system(true);
        $this->addField('approved')->system(true);
        //$this->addField('password')->display(array('form'=>'password'))->mandatory('Type your password');
        $this->addHook('beforeSave', $this);
   }
    function beforeSave(){
        $countryList = $this->countryList();
        $regionList = $this->regionList();
        if(isset($regionList[$this['cb_country']])) $this['cb_state'] = $regionList[$this['cb_country']][$this['cb_state']];
        else $this['cb_state'] = '-';
        $this['cb_country'] = $countryList[$this['cb_country']];
    }
    function getDistinctTypes() {
        $valueList = array();
        $q = $this->dsql();
        $expr = ('SELECT DISTINCT(cb_type) FROM starbr_comprofiler');
        $q->useExpr($expr);
        foreach ($q as $row) {
            $valueList[$row['cb_type']] = $row['cb_type'];
        }
        return $valueList;
    }
    function getDistinctTrade() {
        $valueList = array();
        $q = $this->dsql();
        $expr = ('SELECT DISTINCT(cb_trade) FROM starbr_comprofiler');
        $q->useExpr($expr);
        foreach ($q as $row) {
            $valueList[$row['cb_trade']] = $row['cb_trade'];
        }
        return $valueList;
    }
    function countryList(){
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
            236=>'USA',237=>'UNITED STATES MINOR OUTLYING ISLANDS',238=>'URUGUAY',239=>'UZBEKISTAN',240=>'VANUATU',
            241=>'VENEZUELA, BOLIVARIAN REPUBLIC OF',242=>'VIET NAM',243=>'VIRGIN ISLANDS, BRITISH',244=>'VIRGIN ISLANDS, U.S.',
            245=>'WALLIS AND FUTUNA',246=>'WESTERN SAHARA',247=>'YEMEN',248=>'ZAMBIA',249=>'ZIMBABWE');
        return $country_list;
    }

    function regionList() {
        $region_list=array(
            40=>array('ON','QC','NS','NB','MB','BC','PE','SK','AB','NL','NT','YT','NU'),
            236=>array('AL','AK','AS','AZ','AR','CA','CO',
                'CT','DE','DC','FL','GA','GU','HI','ID','IL','IN',
                'IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO',
                'MT','NE','NV','NH','NJ','NM','NY','NC','ND',
                'MP','OH','OK','OR','PA','PR','RI',
                'SC','SD','TN','TX','UT','VT','VI','VA','WA',
                'WV','WI','WY'),

        );

        return $region_list;
    }
}