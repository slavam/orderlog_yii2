<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Field
 *
 * @author v.kriuchkov
 */
class Field extends EMongoDocument{
    public $caption;
    public $system_name;
    public $type;
    public $weight;
//    public $attributes=array('minlength','maxlength','readonly','size');
    public $attributes;
    public $reference;
    public $items;
    private $default_rules=array();
    private $default_attributes=array();
    public $rules;
    public $add_rule;

//    public $minlength;

    function __construct($scenario = 'insert') {
        $this->default_rules = CValidator::$builtInValidators;
        $this->default_attributes = array('minlength','maxlength','readonly','size','empty');
        parent::__construct($scenario);
    }
    
    function __get($name) {
        
//    if ($this->_id)
//    {
        if (is_array($this->attributes) && in_array($name, $this->attributes))
        {
            return $this->attributes[$name];
        }
        elseif (is_array($this->attributes) && key_exists($name, $this->attributes)) 
        {
            return $this->attributes[$name];
        }
        elseif (in_array($name, $this->default_attributes))
        {
          return $this->default_attributes[$name];
        }
        elseif (is_array($this->rules) && key_exists($name, $this->rules)) 
        {
            return $this->rules[$name];
        }
        elseif (in_array($name, $this->default_rules)){
            return $this->rules[$name];
        }
         elseif (key_exists($name, $this->default_rules)){
            return $this->rules[$name];
        }
        
//    else
//    {
//        if (in_array($name, $this->default_attributes))
//        {
//            return $this->default_attributes[$name];
//        }
        elseif (in_array($name, $this->default_rules)){
            return $this->default_rules[$name];
        }
//    }
    
    return parent::__get($name);
    
}
function __set($name, $value) {
    if (in_array($name, $this->default_attributes))
    {
        $this->attributes[$name]=$value;
    }
else    
    parent::__set($name, $value);
}


public function getCollectionName()
    {
        return 'field';
    }

public static function model($className=__CLASS__)
{
    return parent::model($className);
}

public function rules()
{
    return array(
        array('caption,system_name,type,weight,attributes,rules,reference,minlength,safe,maxlength,empty,default,add_rule,readonly,size,items','safe')
        );
}

function getAllFields($existing_fields=null)
{
    if ($existing_fields !== null)
    {
        $existing_fields = $existing_fields->rawData;
        foreach ($existing_fields as $key=>$value)
        {
            $crit_fields[]=$value['system_name'];
        }
        $criteria = new EMongoCriteria();
        $criteria->addCond('system_name', "notin", $crit_fields);
    }
    else $criteria=null;
    if (count($allfields = $this->findAll($criteria))>0)
    {
        foreach ($allfields as $key=>$field)
        {
            $f_array = $field->toArray();
            $result[(string)$f_array['_id']] =$f_array['caption']; 
        }
        return $result;
    }
    return array(0);
}
}

?>
