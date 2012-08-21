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
//    $assetpath = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/jqgrid';
    $cs=Yii::app()->getClientScript();
//    $cs->registerScriptFile($assetpath.'/jquery.jqGrid.min.js',CClientScript::POS_HEAD);
//    $cs->registerCssFile($assetpath.'/themes/redmond/jquery-ui-custom.css');
//    $cs->registerCssFile($assetpath.'/themes/ui.jqgrid.css');
//    $cs->registerScriptFile($assetpath.'/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);
//    $cs->registerScriptFile($assetpath.'/grid.common.js',CClientScript::POS_HEAD);
//    $cs->registerScriptFile($assetpath.'/jquery-ui-custom.min.js',CClientScript::POS_HEAD);
//    $cs->registerScriptFile($assetpath.'/jqDnR.js',CClientScript::POS_HEAD);
//    $cs->registerScriptFile($assetpath.'/jqModal.js',CClientScript::POS_HEAD);
//    $cs->registerCoreScript('jquery');
    
 
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);

$cs = Yii::app()->clientScript;    

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
    $cs->registerCoreScript('jquery');
    
    
    if ($form->submitted('login')) {
        $model->attributes = $_POST['Document'];
//        $model->doc_type=$model->templ_description;

        if ($model->validate()) {
            $model->save(false);
            $this->redirect(Yii::app()->createUrl('dogovor_archiv/documents/view'));
        }
    }
    
    if ($this->getViewFile($model->templ_name.'_form'))
    {
        $this->render($model->templ_name.'_form', array('form' => $form,'model'=>$model));
    }
    else $this->render('document_form', array('form' => $form,'model'=>$model));
}
    
    
function actionAdd() 
{

$model =new Document;

$form = new CForm($model->form_builder(),$model);

if ($form->submitted('login')) {
    $result = false;
    if (method_exists($this,$model->templ_name.'_edit'))
    {
      $result = call_user_func(array($this, $model->templ_name.'_edit'));
      
    }
    else
        {
            $model->attributes = $_POST['Document'];
            if ($model->validate()) {
                if ($model->save())
                    $result = true;
            }
        }
     if ($result == true)
      {
          $this->redirect(Yii::app()->createUrl('dogovor_archiv/documents/view'));
      }
   }
   
    $this->renderDocumentPage(array('form'=>$form,'model'=>$model));
}

private function renderDocumentPage($attributes=array())
{
    if (isset($_GET['templ_id'])) {
        if ($this->getViewFile($attributes['model']->templ_name . '_form')) {
            $this->render($attributes['model']->templ_name . '_form', array('form' => $attributes['form'], 'model' => $attributes['model']));
        }
        else
            $this->render('document_form', array('form' => $attributes['form'], 'model' => $attributes['model']));
        }
   else {
        $templates = Template::model()->findAll();
        $this->render('document_template_select', array('templates' => $templates));
    }
}

private function dop_soglashenie_edit()
{
    if ($_POST['Document']['parent_id'])
    {
    $parent_model = $this->loadModel($_POST['Document']['parent_id']);
    if (is_array($parent_model->dop_sogl) && count($parent_model->dop_sogl)>0)
    {
        $index=count($parent_model->dop_sogl);
    }else $index = 0;
    
    $id= new MongoId();
    $parent_model->dop_sogl[$index]=new Document;
    $parent_model->dop_sogl[$index]->attributes = $_POST['Document'];
    $parent_model->dop_sogl[$index]->templ_id ='501a648de5d1316813000000';
    $parent_model->dop_sogl[$index]->_id = (string)$id;
    
    if ($parent_model->validate())
    {
        if ($parent_model->save())
        {
            Yii::app()->user->setFlash('notice','Документ сохранен');
            return true;
        }
        else return false;
    }
    }
    else {
        Yii::app()->user->setFlash('notice','Не выбран главный документ');
          return false;
         }
}


public function actionDelete()
{
    if(Yii::app()->request->isPostRequest)
    {
        $model = $this->loadModel();
        $data = explode('=', $model->status);
        if ($data[1]=='0'){
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            $model->delete();
            if(!Yii::app()->request->isAjaxRequest)
            {
                    $this->redirect(array('index'));
            }
            else echo 'Документ удален';
        }
        else echo 'Нельзя удалять документ';
    }
    else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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