<?php

/**
 * Description of ReferenceController
 *
 * @author v.kriuchkov
 */
class ReferenceController extends Controller{
    
    function actionView() {

    $cs=Yii::app()->getClientScript();
    $cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
    $cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);
    $cs = Yii::app()->clientScript;  
        
        $model = new Reference;
        
        $dataProvider = $model->search();
        
        $this->render('reference_index');
    }
    
    function actionGrid()
    {
        $model = new Reference;
        $dataProvider = $model->search();
        $responce = new stdClass();
        $responce->page = $_GET['page'];
        $responce->records = $dataProvider->getTotalItemCount();
        $responce->total = ceil($responce->records/10);
        $rows = $dataProvider->getData();
        
        
            foreach ($rows as $i=>$row) {
                if ($_REQUEST['action']=='sub')
                  {
                   foreach ($row['items'] as $index=>$item)
                   {
                    $responce->rows[$index]['id'] = $index;
                    $responce->rows[$index]['cell'][]=$item['name'];
                   }
                  } 
              else { 
                $responce->rows[$i]['id'] = (string)$row['_id'];
                $responce->rows[$i]['cell']=array($row['name'],$row['caption']);
                }
            
        }
        echo CJSON::encode($responce);
    }
    
    function actionAddReferenceItem() {
        if ($_REQUEST['pid'])
        {
            $model = Reference::model()->findByPk(new MongoId($_REQUEST['pid']));
            
            switch ($_REQUEST['oper'])
            {
                case 'add':
                    $model->items[]=array('name'=>$_REQUEST['name']);
                    $response = 'Запись добавлена';
                    break;
                case 'edit':
                    $model->items[$_REQUEST['id']]['name']=$_REQUEST['name'];
                    $response = 'Запись изменена';
                    break;
                case 'del':
                    unset($model->items[$_REQUEST['id']]);
                    $response = 'Запись удалена';
                    break;
           }
           $model->save();
           echo $response;
        }
        else  return;
    }
    
    function actionAddReferenсe() {
        
        $model = new Reference;   
        switch ($_REQUEST['oper'])
            {
                case 'add':
                    $model->name=$_REQUEST['name'];
                    $model->caption = $_REQUEST['caption'];
                    $model->save();
                    $response = 'Запись добавлена';
                    break;
                case 'edit':
                    $model = Reference::model()->findByPk(new MongoId($_REQUEST['id']));
                    $model->name=$_REQUEST['name'];
                    $model->caption = $_REQUEST['caption'];
                    $model->save();
                    $response = 'Запись изменена';
                    break;
                case 'del':
                    $model->deleteByPk(new MongoId($_REQUEST['id']));
                    $response = 'Запись удалена';
                    break;
           }
           echo $response;
    }
    
    function actionIndex()
    {
        $assetpath = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/jqgrid';
         $cs=Yii::app()->getClientScript();
         $cs->registerScriptFile($assetpath.'/jquery.jqGrid.min.js',CClientScript::POS_HEAD);
         $cs->registerCssFile($assetpath.'/themes/redmond/jquery-ui-custom.css');
         $cs->registerCssFile($assetpath.'/themes/ui.jqgrid.css');
         $cs->registerScriptFile($assetpath.'/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);
//         $cs->registerScriptFile($assetpath.'/grid.common.js',CClientScript::POS_HEAD);
         $cs->registerScriptFile($assetpath.'/jquery-ui-custom.min.js',CClientScript::POS_HEAD);
         $cs->registerScriptFile($assetpath.'/jqDnR.js',CClientScript::POS_HEAD);
         $cs->registerScriptFile($assetpath.'/jqModal.js',CClientScript::POS_HEAD);
         $cs->registerCoreScript('jquery');
        $this->render('test');
    }
    
}

?>
