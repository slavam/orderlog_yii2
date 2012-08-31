<?php
/**
 * Description of jqgrid
 * Build grid by CActiveDataProvider fields
 *
 * @author v.kriuchkov
 */
class jqgrid extends CWidget {
    public $dataProvider;
    public $gridId;
    public $options=array();
    public $cols;
    
public function run() {
    $cs = Yii::app()->clientScript;   
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');
    $cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
    $cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);
    $cs->registerCoreScript('jquery');
    
    if (!$this->dataProvider)
    {
        throw new CException('Должно быть установлено свойство $dataProvider');
    }
        
    $grid=  $this->generateGridBase();
    
$this->render('/jqgrid/index',array('grid'=>$grid,'widget'=>$this));       
}

private function generateGridBase()
    {
        $result = '$(function() {';
        
        $result .= '$('.$this->gridId.').jqGrid({';
        $result .= $this->generateGridOprions();
        
        $result .='})';
        return $result;
    }
    
private function generateGridOprions()
{
    $result='';
    $result.=$this->generateGridCols();
//    foreach ($this->options as $option=>$value)
//    {
//        $result .='\''.$option.':'.$value.'\'';
//    }
    return CJSON::encode($result);
}
    
private function generateGridCols()
{
    if ($this->cols && is_array($this->cols))
    {
        foreach ($this->form as $key => $element) {
            $grid['cols'][] = $this->dataProvider->model->getAttributeLabel($element);
            
            $grid['colModel'][] = $this->setColElementModel($element);
        }
    }
    else
    {
        foreach ($this->dataProvider->model->attributes as $attribute)
        {
            $grid['cols'][] = $this->dataProvider->model->getAttributeLabel($attribute);
            
            $grid['colModel'][] = $this->setColElementModel($attribute);
        }
    }
    return $grid;
}


//public function jqformbuilder() {
//        //uksort($this->form, 'Document::form_sort');
////    $grid['cols'][0]="";
////    $grid['colModel'][0]="";
//        $grid['cols'][0]="";
//        $grid['colModel'][0]=$this->setColElementModel('additional',array('width'=>40));
//        
//        $grid['cols'][1]="Документ";
//        
//        $grid['colModel'][1]=$this->setColElementModel('doc_type');
//        foreach ($this->form as $key => $element) {
//            $grid['cols'][] = $this->model()->getAttributeLabel($element);
//            $grid['colModel'][] = $this->setColElementModel($element);
//        }
//        return $grid;
//    }

    public function setColElementModel($element,$parameters=null) {
        $col['name'] = $element['name']?$element['name']:$element;
        $col['index'] = $element['index']?$element['index']:$element;
        if (is_array($parameters))
        {
            foreach ($parameters as $parameter=>$value)
            {
                $col[$parameter]=$value;
            }
        }
        //if ($element == 'stop_date') $col["classes"] =$this->checkExpiredDate($element)? "expired" : "unexpired";
        return $col;
    }


}
?>

<!--        datatype : 'json',
        mtype : 'GET',
        width:'100%',
        height:'auto',
        hoverrows:false,
        sortable:true,
        autowidth:true,
        ignoreCase:true,
        colNames : // //echo $cols; ?>,
        colModel : // //echo $colModel; ?>,
        //        colNames : ['id','11'],
        //        colModel : [{name:'id'},{name:'22'}],
        pager : '#pager',
        rowNum : 0,
        pgbuttons: false,     // disable page control like next, back button
        pgtext: '',         // disable pager text like 'Page 0 of 10'
        viewrecords: false,
        sortname : 'dog_date',
        sortorder : 'asc',
        caption : 'Документы',
        subGrid: true,'-->