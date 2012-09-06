<?php
/**
 * Description of Helpers
 *
 * @author v.kriuchkov
 */
class Helpers extends CApplicationComponent{

    /**
     * @param model 
     * Model for building
     * @param attributes array
     * attributes to build 
     */
    public static function BuildEditOptionsForGrid($model=null,$attributes=array('key'=>'id','value'=>null),$order='id')
    {
        $result=array();
        if (($model=$model->findAll(array('order' => $order))))
        {
            foreach ($model as $key=>$value)
            {
                $result[]= $value->$attributes['key'].':'.$value->$attributes['value'];
            }   
            $result = implode(';',$result);
            return CJSON::encode($result);
        }
        else return false;
    }
    
}

?>
