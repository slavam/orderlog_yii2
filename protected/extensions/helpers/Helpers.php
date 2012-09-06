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
    public static function BuildEditOptions($model=null,$attributes=array('key'=>'id','value'=>null),$order='id')
    {
        $result=array();
        if ($model)
        {
            
            $model=$model->findAll(array('order' => $order));
            foreach ($model as $key=>$value)
            {
                $result[]= $value->$attributes['key'].':'.$value->$attributes['value'];
            }   
            $result = implode(';',$result);

            return CJSON::encode($result);
        }
        else return false;
    }
    public static function BuildEditOptionsWithModel($model,$attributes=array('key'=>'id','value'=>null),$order='id')
    {
        $result=array();
        if ($model)
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
