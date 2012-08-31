<?php
/**
 * Description of DocAttachmentBlock
 * Формирует блок приложений к документу. 
 * Если в режиме редактирования, выводит форму добавления приложений
 * 
 * @author v.kriuchkov
 */
class DocAttachmentBlock extends CWidget{
    public $model;
    public $title;
    public $parent_id;
    public function run() {
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');
   
//    $cs->registerScript('uploadifyinit',
//    '$(function() {
//        $("#upload").uploadify({
//        "swf":"/js/uploadify/uploadify.swf",
//        "uploader":"'.Yii::app()->createUrl("/dogovor_archiv/scancopies/editfile").'",
//        "fileObjName":"attachments",
//        "formData":{"parent_document":"'.(string)$this->model->_id.'"}
//        });})');
//    $cs->registerCssFile(Yii::app()->request->baseUrl.'/css/uploadify.css');
//    $cs->registerCoreScript('jquery');
    
//      
        if ($this->model)
        {
         $parent_id=  $this->model->_id;
        }  
        elseif (isset($this->parent_id)) {
            $parent_id = $this->parent_id;
        }
        else
        {
            throw new CException('Должно быть установлено свойство $model или $parent_id');
        }
        
        $criteria = new EMongoCriteria;
        
        $criteria->addCond('parent_document', '==', (string)$parent_id);
        $attachments = new EMongoDocumentDataProvider('Scancopies',
                    array(
                    'criteria' => $criteria,
                    'keyField'=>"_id",
                    'pagination' => array('pageSize' => 50),
                        )
                );
        $this->render('doc_attachment_block_view',array('attachments'=>$attachments,'title'=>$this->title,'model'=>  $this->model,'parent_document'=>$this->model->_id));
        }
}

?>
