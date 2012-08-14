<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of field
 *
 * @author v.kriuchkov
 */
class fieldController extends Controller {
    
    public $system_name;
    function actionIndex()
    {
        $assetpath = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/jqgrid';
        $cs=Yii::app()->getClientScript();
        $cs->registerScriptFile($assetpath.'/jquery.jqGrid.min.js',CClientScript::POS_HEAD);
        $cs->registerCssFile($assetpath.'/themes/redmond/jquery-ui-custom.css');
        $cs->registerCssFile($assetpath.'/themes/ui.jqgrid.css');
        $cs->registerScriptFile($assetpath.'/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);
        $cs->registerScriptFile($assetpath.'/grid.common.js',CClientScript::POS_HEAD);
        $cs->registerScriptFile($assetpath.'/jquery-ui-custom.min.js',CClientScript::POS_HEAD);
        $cs->registerScriptFile($assetpath.'/jqDnR.js',CClientScript::POS_HEAD);
        $cs->registerScriptFile($assetpath.'/jqModal.js',CClientScript::POS_HEAD);
        $cs->registerCoreScript('jquery');

        
        $this->render('field_index');
    }
    
function actionGetFieldList()
{
    
    $dataProvider = Field::model()->search();
    $dataProvider->setPagination(false);
    $responce->page = $_GET['page'];
    $responce->records = $dataProvider->getTotalItemCount();
    $responce->total = ceil($responce->records/10);
    $rows = $dataProvider->getData();

    foreach ($rows as $i=>$row) {
        $responce->rows[$i]['id'] = (string)$row['_id'];
        
        $responce->rows[$i]['cell'][]=array($row->caption);
    }
    echo CJSON::encode($responce);
}

    
    function actionEditField($field_id=null,$templ_id=null)
    {
        $criteria = new EMongoCriteria;
        if (Yii::app()->request->isPostRequest)
        {
         if(!isset($field_id)) $field_id = $_POST['field'];
         if (!isset($templ_id)) $templ_id = $_POST['templ_id'];
        }
        if ($field_id)
        {
            $field_model = Field::model()->findByPk(new MongoId(($field_id)));
            $model = $field_model;
            if ($templ_id)
            {
                $criteria=new EMongoCriteria;
                $criteria->addCond('_id','==',new MongoId($templ_id));
                $template_model = Template::model()->find($criteria);
                
                $template_field = $template_model->toArray();
                
                $this->system_name = $field_model->system_name;
                $i=0;
                $editing_field=null;
                while ($i<=count($template_field['form']))
                {
                    if ($template_field['form'][$i]['system_name'] == $this->system_name)
                    {
                        $editing_field = $template_field['form'][$i];
                        $template_model->index = $i;
                        break;
                    }
                    $i++;
                }
                if ($template_model->index ==null){$template_model->index=count($template_field['form'])+1 ;}
                if ($editing_field == null)
                {
                    $editing_field = $field_model->toArray();
                }
                $field_model->setAttributes($editing_field);
                $model= $template_model;
            }
        }
        else {
            $field_model = $model = new Field;
        }
        
        $form = new CForm($this->field_form_build(array('action'=>'/field/editfield/?templ_id='.$templ_id.'&field_id='.$field_id)),$field_model);
        
        if ($form->submitted('save_field'))
        {
            $model->system_name = $_REQUEST['Field']['system_name'];
            $model->caption = $_REQUEST['Field']['caption'];
            if ($_REQUEST['Field']['type']) {
                $model->type = $_REQUEST['Field']['type'];
            }
            if (strlen($_REQUEST['items_list']) > 0 && $_REQUEST['items_reference'] == '') {
                $model->items = explode("\n", str_replace("\r", '', $_REQUEST['items_list']));
            } elseif (isset($_REQUEST['items_reference'])) {
                $model->items = $_REQUEST['items_reference'];
            }
            $sys_name = $_REQUEST['Field']['system_name'];
            unset ($_REQUEST['Field']['system_name']);
            unset ($_REQUEST['Field']['caption']);
            unset ($_REQUEST['Field']['type']);
            
            
            if ($model instanceof Template)
            {
                
                $model->form[$template_model->index]['attributes'] = $_REQUEST['Field'];
                $update_attributes = array('form.'.$sys_name);
                
                if ($model->update(array('form','name','description')))
                {
                    $this->redirect('/template/');
                }
                else throw new CHttpException(404,'Проблема сохранения поля');
            }
            elseif ($model instanceof Field) 
                {
                    $model->attributes = $_REQUEST['Field'];
                    if ($model->save())
                    {
                        $this->redirect('/dogovor_archiv/template/');
                    }
                    else throw new CHttpException(404,'Проблема сохранения поля');
                }
        }
        $this->render('field_form',array('model'=>$model,'form'=>$form));
    }
    
    static function filtertemplatefield($value)
    {
        if ($value['system_name'] == $_REQUEST[''])
        return true;
    }

//    function actionCopyfields($templ_id)
//    {       
//        $template = Template::model()->findByPk(new MongoId($templ_id))->toArray();
//        foreach ($template['form'] as $key=>$value)
//        {
//            $field = new Field;
//            $field->attributes=$value['attributes'];
//            $field->rules=$value['rules'];
//            $field->type=$value['type'];
//            $field->weight=$value['weight'];
//            $field->reference=$value['reference'];
//            
//            if ($value['items'] !==null ){
//                $field->items=$value['items'];
//            }
//            $field->system_name=$key;
//            $field->caption= Template::model()->getAttributeLabel($key);
//            
//            $field->save();
//        }
//        
//        $fields= Field::model()->findAll();
//        
////        foreach($fields as $key=>$value)
////        {
////            $template = Template::model()->findByPk(new MongoId($templ_id));
////            $arr= $template->toArray();
////            foreach($arr['form'] as $t_key=>$t_value)
////            {
////                if ($t_key == $value->system_name)
////                {
////                    $template->form[$t_key]['field_id'] = (string)$value["_id"];
////                    $template->save();
////                }
////                
////            }
////       }
//        
//    }
    
    function field_form_build($config=array())
    {
        
      Yii::app()->clientScript->registerScript(
      "test",
      
      'function gettypeform(){'.
         CHtml::ajax(array(
        'id'=>'ajax-div',
        'type'=>'POST',
        'url'=>CController::createUrl('/field/GetFieldTypeForm'),
        'update'=>'#ajax-div',
        'data'=>array('element_type'=>'js:$("#Field_type").val()'),  // only send element name, not whole form
        )).'}',
      CClientScript::POS_HEAD
  );
        $form = array(
            'title'=>'Свойства поля',
            'action'=>$config['action'],
            'elements'=>array(
                'system_name'=>array('type'=>'text','readonly'=>$_REQUEST['field_id']?true:false),
                'type'=>array(
                    'type'=>'dropdownlist',
                    'disabled'=>$_REQUEST['field_id']?true:false, 
                    'items'=>array('text'=>'Текстовое поле','dropdownlist'=>'Выпадающий список'),
                    'attributes'=>array('onchange'=>'{gettypeform();}')
                ),
                'caption'=>array('type'=>'text'),
                '<div id="ajax-div"></div>',
                'attributes'=>array(
                    'type'=>'form',
                    'title'=>'Атрибуты',
                    'elements'=>array(
                        'minlength'=>array('type'=>'text'),
                        'maxlength'=>array('type'=>'text'),
                        'size'=>array('type'=>'text'),
                        'readonly'=>array('type'=>'checkbox'),
                    ),
                ),
//                'rules'=>array(
//                    'type'=>'form',
//                    'title'=>'Правила валидации',
//                    'elements'=>array(
//                        'rules'=>array('type'=>'juiButton'),
//                    ),
//                ),
            ),
            'buttons'=>array(
            'save_field'=>array(
                'type'=>'submit',
                'label'=>'Сохранить',
                )
            ),
        );
//        foreach($field=$field->toArray() as $field_key=>$field_value)
//        {
//            $form['elements'][$field_key]=$this->field_element_build($field_key, $field_value);
//        }
        return $form;
    }
    
   function actionGetFieldTypeForm()
   {
//       if (Yii::app()->request->isAjaxRequest)
//       {
           $type = $_REQUEST['element_type'];
           switch ($type)
           {
               case 'dropdownlist':
                    $form = $this->renderPartial('field_types/dropdownlist',null,true);
                   break;
           }
           echo $form;
//       }
   }
    
    function actionField_validator_form_build()
    {
        $validator_name = $_REQUEST['validator'];
        $form='';
        switch ($validator_name)
        {
            case 'required':
                $form = CHtml::tag('p',array(),'Поле обязательное');
                $form .=CHtml::hiddenField('rules['.$validator_name.']',true);
                break;
            case 'length':
                $form = '<div>';
                $form .=CHtml::label('Максимальная длина', 'rules['.$validator_name.'][max]');
                $form .=CHtml::textField('rules['.$validator_name.'][max]');
                $form .=CHtml::label('Миниммальная длина', 'rules['.$validator_name.'][min]');
                $form .=CHtml::textField('rules['.$validator_name.'][min]');
                $form .=CHtml::label('Сообщение об ошибке', 'rules['.$validator_name.'][message]');
                $form .=CHtml::textField('rules['.$validator_name.'][message]');
                $form .=CHtml::label('Сообщение об ошибке, если строка слишком короткая', 'rules['.$validator_name.'][tooShort]');
                $form .=CHtml::textField('rules['.$validator_name.'][tooShort]');
                $form .=CHtml::label('Сообщение об ошибке, если строка слишком длинная', 'rules['.$validator_name.'][tooLong]');
                $form .=CHtml::textField('rules['.$validator_name.'][tooLong]');
                $form .= '</div>';
                break;
        }
        echo $form;
    }

    function field_element_build($field_key,$field_value)
    {
        if (is_array($field_value))
        {
            $element=array(
                'type'=>'form',
                'title'=>$field_key
            );
            foreach ($field_value as $key=>$value)
            {
                if (is_array($value))
                {
                    $element['elements'][$key]=array('type'=>  $this->getFieldType($key),'value'=>  is_array($value)?current($value):$value);
                }else
                {
                    $element['elements'][$key]=array('type'=>$this->getFieldType($key));
                }
            }
        }
        else 
            $element=array('type'=>$this->getFieldType($field_key));
        
        return $element;
    }
    
    function getFieldType($key)
    {
        $field_types = array(
            'default'=>'text',
            'safe'=>'checkbox'
        );
        return $field_types[$key]?$field_types[$key]:'text';
    }
}

?>
