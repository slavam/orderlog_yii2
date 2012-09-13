<?

class Document extends EMongoDocument // Notice: We extend EMongoDocument class instead of CActiveRecord {
{
    private $expired_time = 30;
    public $builded_rules;
    public $templ_id;
    public $templ_name;
    public $templ_description;
    public $form_weights;
    public $form_rules;
    public $form;
    public $form_reference;
    public $attrs = array();
    public $dop_sogl;
    public $scancopies;
    private $references = array('status', 'pay_system', 'dog_kind', 'tarif_type');


    function __construct($scenario='insert') {

        parent::__construct($scenario);
    }
    
    function afterConstruct() {

        if (isset($_GET['templ_id'])) {
            $this->templ_id = new MongoId($_GET['templ_id']);
        }
        //$this->templ_id = new MongoId('4fcdf930e5d131dc12000002');
        if (isset($this->templ_id)) {
            $template = Template::model()->findByPk($this->templ_id);
            $this->form = $template->fields;
            $this->form_rules = $template->rules;
            $this->form_reference = $template->reference;
            $this->form_weights = $template->weights;
            $this->templ_name=$template->name;
            $this->templ_description=$template->description;
        } else {
                if (!isset($this->form)) {
                    $this->form = array(
        //                    'doc_type',
                        'dog_kind',
                        'provider',
                        'okpo',
                        'dog_number',
                        'dog_date',
                        'start_date',
                        'stop_date',
                        'branch',
                        'author_login',
                        'status',
                        'pay_system',
                        'note',
                    );
                }
                $this->form_rules = array(
                    'dog_number' => array('safe' => true, 'required' => true),
                    'dog_date' => array('safe' => true, 'required' => true),
                    'okpo' => array('safe' => true, 'required' => true),
                    'branch' => array('safe' => true, 'required' => true),
    //                'doc_type' => array('safe' => true, 'required' => true,'default'=>array('value' => $this->templ_description)),
                    'dog_kind' => array('safe' => true, 'required' => true),
                    'start_date' => array('safe' => true, 'compare' => array('compareAttribute' => 'stop_date', 'operator' => '<'), 'date' => array('allowEmpty' => false, 'format' => 'dd.mm.yyyy'),),
                    'stop_date' => array('safe' => true, 'compare' => array('compareAttribute' => 'start_date', 'operator' => '>'), 'date' => array('allowEmpty' => false, 'format' => 'dd.mm.yyyy')),
                    'provider' => array('safe' => true, 'required' => true),
                    'author_login' => array('default' => array('value' => 'v.kriuchkov')),
                    'pay_system' => array('safe' => true,),
                    'note' => array(
                        'required' => true,
                    )
                ); 
            }
        parent::afterConstruct();
    }

    function __set($name, $value) {

        if (isset($this->form) && key_exists($name, $this->form)) {
            $this->attrs[$name] = $value;
        }
        else
            parent::__set($name, $value);
    }

    function __get($name) {
        //$this->form = Template::model()->findAllByPk($_GET['template'])->fields;
        $value = '';
        if (Yii::app()->request->isAjaxRequest && isset($_REQUEST['Document'][$name]) && $_REQUEST['Document'][$name] != '') {
            $value = $this->attrs[$name] ? $this->attrs[$name] : $_REQUEST['Document'][$name];
            //$value = $this->attrs[$name];
        }
        if ((is_array($this->form) && (key_exists($name, $this->form) || in_array($name, $this->form))) || key_exists($name, $this->attrs)) {
            if (isset($this->attrs[$name]) && $value == '') {
                $value = $this->attrs[$name];
            }
            return $value;
        }
        return parent::__get($name);
    }

    function afterValidate() {

        parent::afterValidate();
        $data = explode('=', $_POST['Document']['status']);
        if ($data[1]==0) {
            $this->clearErrors();
        }
    }

    public function afterFind() {
        if ($this->scenario == 'update') {
            $template = Template::model()->findByPk($this->templ_id);
            if (count($template) > 0) {
                $this->form = $template->fields;
                $this->templ_id = $template->_id;
                $this->templ_name = $template->name;
                $this->templ_description = $template->description;
                $this->form_rules = $template->rules;
                $this->form_reference = $template->reference;
                $this->form_weights = $template->weights;
            }
        }
        parent::afterFind();
    }
    

    public function behaviors()
    {
        return array(
            'embeddedArrays' => array(
                'class'=>'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName'=>'dop_sogl',       // name of property, that will be used as an array
                'arrayDocClassName'=>'document'    // class name of embedded documents in array
            ),
        );
    }

    /**
     * This method have to be defined in every Model
     * @return string MongoDB collection name, witch will be used to store documents of this model
     */
    public function getCollectionName() {
        return 'documents';
    }

    public function rules() {

        $this->builded_rules = ModelRulesBuilder::build_rules($this->form_rules);
        array_push($this->builded_rules, array('dop_sogl','safe'));
        return $rules = $this->builded_rules;
    }

    public function attributeLabels() {

        return array(
            'provider' => 'Контрагент',
            'provider_contact' => 'Контрагент-контактное лицо',
            'dog_fact_date' => 'Дата получения',
            'dog_date' => 'Дата заключения договора',
            'dog_type' => 'Тип договора',
            'dog_kind' => 'Вид договора',
            'tarif_type' => 'Тип тарифа',
            'note' => 'Примечание',
            'start_date' => 'Начало действия',
            'stop_date' => 'Окончание действия',
            'author_login' => 'Логин',
            'status' => 'Статус',
//            'doc_type' => 'Документ',
            'dog_number' => 'Номер договора',
            'summ' => 'Сумма',
            'recipient' => 'Получатель',
            'storage' => 'Место хранения',
            'subject' => 'Предмет договора',
            'delegation' => 'Делегирование',
            'login' => 'Идентификатор пользователя',
            'reestr' => 'Реестр',
            'tarif' => 'Тариф',
            'inside_number' => 'Внутрений номер',
            'dog_period' => 'Срок действия договора',
            'reward_percent' => '% вознаграждения',
            'okpo' => 'ОКПО',
            'branch' => 'Отделение',
            'pay_system' => 'Система',
        );
    }

    public function search($caseSensitive = false) {

        $criteria = new EMongoCriteria;

        if (isset($_REQUEST['id'])) {
            //return Document::model()->findByPk(new Mongoid($_GET['id']));
            $criteria->addCond('_id', '==', new MongoId($_REQUEST['id']));
        } else {
            if (Yii::app()->request->isAjaxRequest) {
                if (isset($_REQUEST['Document'])) {
                    foreach ($_REQUEST['Document'] as $field => $value) {
                        if ($value !== '') {
                            $criteria->addCond('attrs.' . $field, '==', $value);
                            if ($field == 'provider') {
                                $r = new MongoRegex('/' . $value . '.*/i');
                                $criteria->addCond('attrs.' . $field, '==', $r);
                            }
                        }
                    }
                }
                /*Выполняем разбор правил поиска и добавляем критерии*/
                if ($_REQUEST['_search'] == 'true') {

                    $rules = CJSON::decode($_GET['filters']);
                    foreach ($rules['rules'] as $key => $data) {
                        
                        if ($data['op'] != 'cn') {
                            $criteria->addCond('attrs.' . $data['field'], $data['op'], $data['data']);
                        } else {
                            $r = new MongoRegex('/' . $data['data'] . '.*/i');
                            $criteria->addCond('attrs.' . $data['field'], '==', $r);
                        }
                    }
                }
                /*Устанавливаем переменную сортировки для правильной разборки в дата*/
                if (isset($_REQUEST['sidx'])) {
                    $_GET['Document_sort'] = $_REQUEST['sord'] == 'desc' ? $_REQUEST['sidx'].'.desc' : $_REQUEST['sidx'];
                }
            }
            
            }
            return new EMongoDocumentDataProvider('Document',
                array(
                    'criteria' => $criteria,
                    'keyField'=>"_id",
                    'pagination' => array('pageSize' => 50),
                    //'sort'=>$sort,
                    'sort' => array(
                        'defaultOrder' => 'attrs.doc_date asc',
                        'attributes' => array(
                            'dog_number' => array('asc' => 'attrs.dog_number', 'desc' => 'attrs.dog_number desc'),
                            'okpo' => array('asc' => 'attrs.okpo', 'desc' => 'attrs.okpo desc'),
                            'provider' => array('asc' => 'attrs.provider', 'desc' => 'attrs.provider desc'),
                            'start_date' => array('asc' => 'attrs.start_date', 'desc' => 'attrs.start_date desc'),
                            'stop_date' => array('asc' => 'attrs.stop_date', 'desc' => 'attrs.stop_date desc'),
                            'dog_kind' => array('asc' => 'attrs.dog_kind', 'desc' => 'attrs.dog_kind desc')
                        ),
                    ),
                )
            );
        
    }

    public function checkExpiredDate($date_stop) {
        if (isset($date_stop->attrs['stop_date']) && strlen($date_stop->attrs['stop_date']) > 0) {
            if ($d2 = DateTime::createFromFormat('d.m.Y', $date_stop->attrs['stop_date'])) {
                $date_diff = date_diff(DateTime::createFromFormat('d.m.Y', date('d.m.Y')), DateTime::createFromFormat('d.m.Y', $date_stop->attrs['stop_date']), false)->days;
                if ($date_diff <= 30) {
                    return true;
                }
            }
        }
        return false;
    }

    public function jqformbuilder() {
        //uksort($this->form, 'Document::form_sort');
//    $grid['cols'][0]="";
//    $grid['colModel'][0]="";
        $grid['cols'][0]="";
        $grid['colModel'][0]=$this->setColElementModel('additional',array('width'=>40,'editable'=>false,'search'=>false));
        $grid['cols'][1]="Документ";
        $grid['colModel'][1]=$this->setColElementModel('doc_type');
        foreach ($this->form as $key => $element) {
            $grid['cols'][] = $this->model()->getAttributeLabel($element);
            $parameters=null;
            if ($element=='dog_kind' || $element == 'status' || $element == 'pay_system')
            {
                $reference = Reference::getReferenceByName($element);
                $reference=  Reference::setReferenceToGridSearch($reference);
                $parameters['searchoptions']=array('value'=>$reference);
                $parameters['stype']='select';
            }
            $grid['colModel'][] = $this->setColElementModel($element,$parameters);
        }
        return $grid;
    }

    public function setColElementModel($element,$parameters=null) {
        $col['name'] = $element;
        $col['index'] = $element;
        $col['editable'] = isset($parameters['editable'])?$parameters['editable']:true;
        $col['search'] = isset($parameters['search'])?$parameters['search']:true;
        if ($parameters['searchoptions'])
        {
            $col['searchoptions'] = $parameters['searchoptions'];
        }
        $col['stype']=$parameters['stype'];
        if (is_array($parameters))
        {
        $col['width']=$parameters['width'];
        }
        //if ($element == 'stop_date') $col["classes"] =$this->checkExpiredDate($element)? "expired" : "unexpired";
        return $col;
    }

    public function form_builder($action='update') {
        uksort($this->form, 'Document::form_sort');
        $complete_form['title'] = 'Создание нового договора';
        $complete_form['activeForm'] = array(
            'id' => 'document-form', // Важный момент.
            'class' => 'CActiveForm',
            'enableAjaxValidation' => false
        );

        foreach ($this->form as $ElementKey => $ElementData) {

//    if (!isset($ElementData['hide']) || $ElementData['hide'] !== true)
//    {
            if (is_array($ElementData) && $ElementData['type'] !=="string") {
                if (!isset($this->form_reference[$ElementKey]['section'])) {
                    $complete_form['elements'][$ElementKey] = array(
                        'type' => $ElementData['type'],
                        'attributes' => $ElementData['attributes'],
                    );
                        
                    //Проверяем экшн, если это просмотр, блокируем поля
                    if ($action=='view')
                    {
                        $complete_form['elements'][$ElementKey]['attributes']['disabled']=true;
                    }
                    
                    if (isset($ElementData['items'])) {
                        $complete_form['elements'][$ElementKey]['items'] = $ElementData['items'];
                    }
                    if (isset($ElementData['visible'])) {
                        $complete_form['elements'][$ElementKey]['visible'] = $ElementData['visible'];
                    }
                } else 
                {
                    $complete_form['elements'][$this->form_reference[$ElementKey]['section']]['elements'][$ElementKey] = array(
                        'type' => $ElementData['type'],
                        'attributes' => $ElementData['attributes'],
                    );
                    if (isset($ElementData['items'])) {
                        $complete_form['elements'][$this->form_reference[$ElementKey]['section']]['elements'][$ElementKey]['items'] = $ElementData['items'];
                    }
                    if (isset($ElementData['visible'])) {
                        $complete_form['elements'][$this->form_reference[$ElementKey]['section']]['elements'][$ElementKey]['visible'] = $ElementData['visible'];
                    }

                    if (!isset($complete_form['elements'][$this->form_reference[$ElementKey]['section']]['title']) && !isset($complete_form['elements'][$this->form_reference[$ElementKey]['section']]['type'])) {
                        $complete_form['elements'][$this->form_reference[$ElementKey]['section']]['title'] = 'dogovor_' . $this->form_reference[$ElementKey]['section'];
                        $complete_form['elements'][$this->form_reference[$ElementKey]['section']]['type'] = 'form';
                    }
                }
            }
            else
            {
                if (is_array($ElementData)){
                    $complete_form['elements'][$ElementKey] = $ElementData['data'];
                }
            }
        }

        $complete_form['buttons'] = array(
            'submit' => array(
                'type' => 'submit',
                'label' => 'Сохранить',
            )
        );

        return $complete_form;
    }

    

    function gettarif_type() {
        return array('----', 'С получателя', 'С плательщика');
    }

    static function getdog_kind() {
        return array('Агентский', 'Социальный', 'Услуги', 'Платежи');
    }

    static function getpay_system() {
        return array('----', 'MoneyGram', 'PrivateMoney', 'WesternUnion');
    }

    public function checkPaySystems($status) {
        $statuses = self::getPaySystems();
        if (is_object($status)) {
            $s = $status->attrs['pay_system'];
        }
        else
            $s = $status;
        return $statuses[$s];
    }

    public function checkReference($field, $value) {
        if (method_exists($this, 'get' . $field)) {
            $reference = call_user_func(array($this, 'get' . $field), $value);
        }
        if ($reference) {
            return $reference[$value];
        }
        return $this->attrs[$field];
    }

    public function checkStatus($status) {

        $statuses = self::getStatuses();

        if (is_object($status)) {
            $s = $status->attrs['status'];
        }
        else
            $s = $status;
        return $statuses[$s];
    }

    public function checkReestr($data) {
        $reestr = ($data->attrs['reestr'] == 0) ? 'НЕТ' : 'Да';

        return $reestr;
    }

    public function checkDogKind($data) {
        $kinds = self::getDogKinds();

        if (is_object($data)) {
            $s = $data->attrs['dog_kind'];
        }
        else
            $s = $data;
        return $kinds[$s];
    }

    /* Проверяем, чтоб начальная дата не была больше конечной. Правило валидтора */

    public function checkDateInterval($attribute, $params) {
        if (DateTime::createFromFormat('d.m.Y', $_REQUEST['Document'][$attribute]) > DateTime::createFromFormat('d.m.Y', $_REQUEST['Document']['stop_date'])) {
            $this->addError('start_date', 'Дата начала больше даты окончания договора');
        }
    }

    /**
     * This method have to be defined in every model, like with normal CActiveRecord
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function form_sort($a, $b) {

        $weights = $this->form_weights;

        if (isset($weights) && key_exists($a, $weights) && key_exists($b, $weights)) {
            if ($weights[$a] < $weights[$b]) {
                $status = -1;
                //break;
            } elseif ($weights[$a] > $weights[$b]) {
                $status = 1;
                //break;
            } else {
                $status = 0;
            }
        }
        return $status;
    }

}
