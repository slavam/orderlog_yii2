<?

class Template extends EMongoDocument
{
    public $name;
    public $description;
    public $form;
    public $fields;
    public $weights;
    public $reference;
    public $items;
    public $attributes=array('minlength','maxlength','readonly','size');
//    public $caption;
//    public $system_name;
    public $type;
    public $weight;
    public $rules=array();
    public $index;
//    private $default_rules=array();
//    private $default_attributes=array();

//    public $minlength;

    function __construct($scenario = 'insert') {
//        $this->default_rules = CValidator::$builtInValidators;
//        $this->default_attributes = array('minlength','maxlength','readonly','size');
        parent::__construct($scenario);
    }
    function __get($name) {
        
//    if ($this->_id)
//    {
        if (key_exists($name, $this->attributes))
        {
            return $this->attributes[$name];
        }
        elseif (key_exists($name, $this->rules)){
            return $this->rules[$name];
        }
//        elseif (in_array($name, $this->default_attributes)) 
//        {
//            return $this->default_attributes[$name];
//        }
//    }
//    else
//    {
//        if (in_array($name, $this->default_attributes))
//        {
//            return $this->default_attributes[$name];
//        }
//        elseif (in_array($name, $this->default_rules)){
//            return $this->default_rules[$name];
//        }
//    }
    
   return parent::__get($name);
    
}

function __set($name, $value) {
    
    if (in_array($name, $this->attributes))
    {
        $this->attributes[$name]=$value;
    }
    elseif(in_array($name, array('caption','system_name','weight','templ_id','type',))){
        
            $this->form[$this->index][$name]=$value;
       
    }
else    
    parent::__set($name, $value);
}
//public function behaviors()
//{
//  return array(
//    array(
//      'class'=>'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
//      'arrayPropertyName'=>'form', // name of property
//      'arrayDocClassName'=>'Field' // class name of documents in array
//    ),
//  );
//}
//function toArray($flag=null) {
//    $start_array = parent::toArray();
//    if (isset ($_REQUEST['Field']))
//    {
//        foreach ($start_array['form'] as $key=>$value)
//        {
//            $result['form.'.$value['system_name']]=$value;
//        }
//        
//        return $result;
//    }else
//   return parent::toArray();
//}

public function getCollectionName()
{
    return 'template';
}
public static function model($className=__CLASS__)
{
    return parent::model($className);
}
 
public function rules()
{
    return array(
    array('form,name,description', 'safe'),
    array('caption,system_name,type,weight,f,attributes,rules,reference,minlength,safe,maxlength,empty,default,add_rule,readonly,size,items','safe')
    );
}
    
    protected function afterFind() {
        
        $this->parseTemplate($this);
        parent::afterFind();
    }
    
    private function parseTemplate($template)
    {
       if (is_object($template) && isset($template->form))
       {
           foreach ($template->form as $element => $data) {
             $form[$data['system_name']]['type'] = $data['type'];
             if($data['attributes'] !==null)
             {
                $form[$data['system_name']]['attributes'] = $data['attributes'];
             }
             if($data['data'] !==null)
             {
                $form[$data['system_name']]['data'] = $data['data'];
             }
             if (isset($data['items'])) {$form[$data['system_name']]['items'] = $data['items'];}
             if (isset($data['visible'])){$form[$data['system_name']]['visible'] = $data['visible'];}
             $rules[$data['system_name']]=$data['rules'];
             $weight[$data['system_name']]['weight']=$data['weight'];
             $section[$data['system_name']]['section']=$data['reference'];
           }
           $this->fields = $form;
           $this->rules = $rules;
           $this->weights =$weight;
           $this->reference = $section;
       }
    }
}
?>