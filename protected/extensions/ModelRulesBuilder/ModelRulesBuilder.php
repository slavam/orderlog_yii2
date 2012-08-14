<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelRulesBuilder
 *
 * @author v.kriuchkov
 */
class ModelRulesBuilder extends CApplicationComponent{
    public static $required_rules;
    public static $length_rules;
    
    /**
     * 
     * 
     */
    public static function build_rules($rules)
    {
        if (is_array($rules))
        {
            foreach ($rules as $item => $item_rules) {
                if ($item_rules !== null)
                {
                    foreach ($item_rules as $rule_name => $rule_value) {
                        if (self::setRule($rule_name,$item, $rule_value) !== false)
                            $builded_rules[] = self::setRule($rule_name,$item, $rule_value);
                    }
                }
            }
        }
        return $builded_rules;
    }
    
    public static function setRule($rule_name,$field,$data)
    {
        if (isset($field) && isset($data) && $data !=false)
        {
            
            $rule=array($field,$rule_name);
            
            if (is_array($data))
            {
                foreach ($data as $key=>$value)
                {
                    $rule[$key]=$value;
                }
            }
        }
        else $rule =false;
        
        return $rule;
    }
    
}

?>
