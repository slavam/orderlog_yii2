<?php

/**
 * Description of DocumentsController
 *
 * @author v.kriuchkov
 */
class DocumentsController extends Controller {

    public $_model;

function actionIndex() {
    $this->actionView();
}
    
function filters() {
        return array(
                array('application.filters.XssFilter','clean' => 'all')
            );
    }
    
    
function actionView() {
$cs = Yii::app()->clientScript;    
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);




    $criteria = new EMongoCriteria();
    $atr_array=array();
    $template='documents_index';
    $this->_model=new Document;   
        if (isset($_GET['id']))
        {
            $template='documents_single';
        }
    $atr_array['model']=$this->_model;
    $grid = $this->_model->jqformbuilder();
    
    $atr_array['colModel'] = CJSON::encode($grid['colModel']);
    $atr_array['cols']=CJSON::encode($grid['cols']);
    
    if (Yii::app()->request->isAjaxRequest)
    {
        $this->renderPartial($template, $atr_array,false,true);
        Yii::app()->end();
    }
    $this->render($template, $atr_array);
}

function actionJqgrid()
{
    $model = new Document;
    $dataProvider = $model->search();
    $form = $model->jqformbuilder($dataProvider);
    $responce = new stdClass();
    $responce->page = $_GET['page'];
    $responce->records = $dataProvider->getTotalItemCount();
    $responce->total = ceil($responce->records/10);
    $model->setScenario('view');
    $rows = $dataProvider->getData();
    
    if ($_REQUEST['get']=='subgrid')
    {
        if ($rows[0]['dop_sogl']!==null)
        {
            $rows=$rows[0]['dop_sogl'];
        }else yii::app ()->end ();
    }
    foreach ($rows as $i=>$row) {
        $row->attrs['status'] = Reference::model()->getReferenceItemById($row->attrs['status'],'name');
        $row->attrs['dog_kind'] = Reference::model()->getReferenceItemById($row->attrs['dog_kind']);
        $row->attrs['pay_system'] = Reference::model()->getReferenceItemById($row->attrs['pay_system']);
        $row->attrs['doc_type'] = $row->templ_description;
        $row->attrs['additional']= CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/attachment.png','Прикрепленные файлы',array('width'=>'18')),  Yii::app()->createUrl('/dogovor_archiv/scancopies/FilesList',array('parent_id'=>$row->_id)));
        $responce->rows[$i]['id'] = (string)$row['_id'];
        
        foreach ($form['colModel'] as $index=>$colkey)
        {
            if (array_key_exists($colkey['name'], $row->attributes['attrs']))
            {
                    $responce->rows[$i]['cell'][]=$row[$colkey['name']];
            }
            else $responce->rows[$i]['cell'][]='';
        }
        
    }
    echo CJSON::encode($responce);
}

public function actionUpdate()
{
    
    $model=$this->loadModel();
    $form = new CForm($model->form_builder(), $model);
    $cs = Yii::app()->clientScript;   
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lightbox/js/jquery.lightbox-0.5.min.js', CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lightbox/lightboxinit.js' ,CClientScript::POS_END);
    $cs->registerCssFile(Yii::app()->request->baseUrl.'/js/lightbox/css/jquery.lightbox-0.5.css');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');
    $cs->registerCoreScript('jquery');
    
    
    if ($form->submitted()) {
        $model->attributes = $_POST['Document'];
//        $model->doc_type=$model->templ_description;

        if ($model->validate()) {
            if ($result=$model->save(false))
            {
             $this->redirect(Yii::app()->createUrl('dogovor_archiv/documents/update',array('id'=>$result)));
            }
        }
    }
    
    if ($this->getViewFile($model->templ_name.'_form'))
    {
        $this->render($model->templ_name.'_form', array('form' => $form,'model'=>$model));
    }
    else $this->render('document_form', array('form' => $form,'model'=>$model));
}
    
    

//Оригинальный метод, бекап
//function actionAdd() 
//{
//
//$model =new Document;
//
//$form = new CForm($model->form_builder(),$model);
//
//if ($form->submitted('login')) {
//    $result = false;
//    if (method_exists($this,$model->templ_name.'_edit'))
//    {
//      $result = call_user_func(array($this, $model->templ_name.'_edit'));
//    }
//    else
//        {
//            $model->attributes = $_POST['Document'];
//            if ($model->validate()) {
//                if ($model->save())
//                    $result = true;
//            }
//        }
//     if ($result == true)
//      {
//          $this->redirect(Yii::app()->createUrl('dogovor_archiv/documents/view'));
//      }
//   }
//   
//    $this->renderDocumentPage(array('form'=>$form,'model'=>$model));
//}


function actionAdd() 
{
    $cs = Yii::app()->clientScript;   
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lightbox/js/jquery.lightbox-0.5.min.js', CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lightbox/lightboxinit.js' ,CClientScript::POS_END);
    $cs->registerCssFile(Yii::app()->request->baseUrl.'/js/lightbox/css/jquery.lightbox-0.5.css');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');
    $cs->registerCoreScript('jquery');
    if (($id=$_REQUEST['id']) || ($id=$_REQUEST['Document']['parent_doc_id']))
    {
        $model = Document::model()->findByPk(new MongoId($id));
    }
    else
    $model =new Document;
    
    $result = false;
    if (method_exists($this,$model->templ_name.'_edit'))
    {
      call_user_func(array($this, $model->templ_name.'_edit'),array('form'=>$form,'model'=>$model));
    }
    else
        {
        $form = new CForm($model->form_builder(),$model);
        if ($form->submitted()) {
            $result = $this->default_document_edit($model);

            if ($result == true)
            {
                $this->redirect(Yii::app()->createUrl('dogovor_archiv/documents/view'));
            }
        }
        $this->renderDocumentPage(array('form'=>$form,'model'=>$model));
    }
}
private function default_document_edit($model)
{
if ($model)
{
    $model->attributes = $_POST['Document'];
            if ($model->validate()) {
                if ($result=$model->save(true,array('templ_name','templ_id','templ_description','attrs','dop_sogl')))
                {
                    $this->redirect(Yii::app()->createUrl('dogovor_archiv/documents/update',array('id'=>$result)));
                }
            }
            else $result=false;
}
else $result =false;

    return $result;
}

private function dogovor_edit($arguments=null)
{
    
if ($_REQUEST['sub_document'] || $_REQUEST['Document']['parent_doc_id'])
    {
        if (isset($arguments['model']->dop_sogl))
        {
         $sub_document =null;   
            foreach ($arguments['model']->dop_sogl as $key=>$value)
            {
                if ($value->_id !== null && $value->_id == $_REQUEST['sub_document'])
                {
                    $sub_document=$value;
                    $index =$key;
                }
            }
        }
        
        if ($sub_document == null && $index == null)
        {
            $sub_document = new Document;
            $index = null;
        }
        
    call_user_func(array($this,$sub_document->templ_name.'_edit'),array('parent_doc_model'=>$arguments['model'],'sub_document_model'=>$sub_document,'index'=>$index));
    Yii::app()->end();
    }
    else
    {
        $form = new CForm($arguments['model']->form_builder(),$arguments['model']);
        
        if ($form->submitted())
        {
            $this->default_document_edit($arguments['model']);
        }
    }
$this->renderDocumentPage(array('form'=>$form,'model'=>$arguments['model']));
}

private function dop_soglashenie_edit($arguments=null)
{
    
    
    if ($arguments['parent_doc_model'])
    {
        $parent_model = $arguments['parent_doc_model'];
        $parent_doc_id = $parent_model->_id;
    }
    else
        if (($parent_doc_id = $_POST['Document']['parent_doc_id']) || ($parent_doc_id = $_REQUEST['id']))
        {
            $parent_model = $this->loadModel($parent_doc_id);
        }

        if ($arguments['sub_document_model']){
            
            $sub_document_template = Template::model()->findByPk(new MongoId($arguments['sub_document_model']->templ_id));
           
//          $arguments['sub_document_model']->_id;
//            $parent_model->attrs=$arguments['sub_document_model']->attrs;
//            $parent_model->parent_doc_id=$id;
//            $parent_model->templ_name=$arguments['sub_document_model']->templ_name;
//            $parent_model->templ_description=$arguments['sub_document_model']->templ_description;
//            $parent_model->templ_id=(string)$arguments['sub_document_model']->templ_id;
            $arguments['sub_document_model']->form = $sub_document_template->fields;
            $arguments['sub_document_model']->form_rules = $sub_document_template->rules;
            $arguments['sub_document_model']->form_weights = $sub_document_template->weights;
            $arguments['sub_document_model']->parent_doc_id =$parent_doc_id;
        }   
        else $arguments['sub_document_model'] = new Document;
 
        $form = new CForm($arguments['sub_document_model']->form_builder(),$arguments['sub_document_model']);

    if (isset($parent_model))
    {
        if ($form->submitted())
        {
           // $index = 0;
            
            if (!isset($arguments['index']))
            {
                if (is_array($parent_model->dop_sogl) && count($parent_model->dop_sogl)>0)
                {
                    $index=count($parent_model->dop_sogl);
                }
            }
            else {
                $index = $arguments['index'];
                $arguments['sub_document_model']->scenario = 'update';
            }
            
            if ($arguments['sub_document_model']->scenario =='insert')
            {
            $id= new MongoId();
            $arguments['sub_document_model'] = new Document;
            $arguments['sub_document_model']->_id=(string)$id;
            //$parent_model->dop_sogl[$index]=new Document;
//            $parent_model->dop_sogl[$index]->_id = (string)$id;
            }
            
//            $parent_model->dop_sogl[$index]->attributes = $_POST['Document'];
            $arguments['sub_document_model']->attributes=$_POST['Document'];
            $arguments['sub_document_model']->templ_id = '501a648de5d1316813000000';
            $parent_model->dop_sogl[$index] =$arguments['sub_document_model'];
            if ($arguments['sub_document_model']->validate())
            {
                if ($parent_model->save(true,array('templ_name','templ_id','templ_description','attrs','dop_sogl')))
                {
                    Yii::app()->user->setFlash('notice','Документ сохранен');
                    //return true;
                }
                else Yii::app()->user->setFlash('notice','Ошибка сохранения документа');
            }
        }
    }
else Yii::app()->user->setFlash('notice','Не выбран главный документ');
        //Yii::app()->user->setFlash('notice','Не выбран главный документ'); 
$this->renderDocumentPage(array('form'=>$form,'model'=>$arguments['sub_document_model'],'parent_model'=>$parent_model));
        //return false;
}

private function renderDocumentPage($attributes=array())
{
    if (isset($_GET['templ_id']) || $attributes['model']->templ_name) {
        if ($this->getViewFile($attributes['model']->templ_name . '_form')) {
            $this->render($attributes['model']->templ_name . '_form', $attributes);
        }
        else
            $this->render('document_form', $attributes);
        }
   else {
        $templates = Template::model()->findAll();
        $this->render('document_template_select', array('templates' => $templates));
    }
}

public function actionDelete()
{
//    if(Yii::app()->request->isPostRequest)
//    {
        $model = $this->loadModel();
        $data = explode('=', $model->status);
        
        
            
//            $criteria = new EMongoCriteria;
//            $criteria->addCond('attrs.status', '==', )
//            $model->update();
            if (!$_REQUEST['sub_document'])
            {
                if ($data[1]=='0' || $data[1]=='1'){
                $modifier=new EMongoModifier(
                        array(
                            'attrs.status'=>array('set' => '5007fec2e07686101c283352=8')
                        )
                );
                $criteria = new EMongoCriteria();
                $criteria->addCond('_id', '==', $model->_id);

                $model->updateAll($modifier,$criteria);
                
                if(!Yii::app()->request->isAjaxRequest)
                {
                        $this->redirect(array('index'));
                }
                else echo 'Документ удален';
                    }
                    else echo 'Нельзя удалять документ';
            }
            else
            {
                foreach ($model->dop_sogl as $key=>$value)
                {
                    if ($value->_id == $_REQUEST['sub_document'])
                    {
                        $sub_document=$value;
                        $index =$key;
                    }
                }
                $model->dop_sogl[$index]->status ='5007fec2e07686101c283352=8' ;
                if ($model->save())
                {
                 $this->redirect(Yii::app()->createUrl('/dogovor_archiv/documents'));
                }
            }
            
//    }
//    else
//            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}

function actionDeleteAll() {
    $model = new Document;
    $model->deleteAll();
}
    
public function loadModel($id=null)
{
    if($this->_model===null)
    {
        if($id == null && isset($_REQUEST['id']))
        {
           $this->_model=Document::model()->findByPk(new Mongoid($_REQUEST['id']));
        }
        else {
            $this->_model=Document::model()->findByPk(new Mongoid($id));
            }
        
        if($this->_model===null)
               throw new CHttpException(404,'The requested page does not exist.');
    }
    return $this->_model;
}


public function actionCheckExpiredDate()
{
    if (Yii::app()->request->isAjaxRequest)
    {
        if (isset($_REQUEST['stop_date'])&& strlen($_REQUEST['stop_date'])>0)
        {
            if ($d2=DateTime::createFromFormat('d.m.Y',$_REQUEST['stop_date']))
            {
                $date_diff = date_diff(DateTime::createFromFormat('d.m.Y',date('d.m.Y')), DateTime::createFromFormat('d.m.Y',$_REQUEST['stop_date']), false)->days;
                if ($date_diff<=30)
                {
                    echo CJSON::encode(1);
                }
                else echo CJSON::encode(0);
            } 
        }
        else echo CJSON::encode(0);
    }
    else throw new CHttpException(404,'The requested page does not exist.');
}
        
private function generateSearchBlock()
{
    return$this->renderPartial('document_search_block',array('model'=>$this->_model),true);
}

}//class
?>