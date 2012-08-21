<div class="form">
<?
echo CHtml::beginForm(Yii::app()->createUrl('/dogovor_archiv/scancopies/editfile'),'post',array('enctype'=>'multipart/form-data'));
echo CHtml::hiddenField('parent_document',$_REQUEST['parent_id']);
echo CHtml::hiddenField('image_id',$_REQUEST['image_id']);
//Выводим в диалог
if ($model->scenario=='insert')
{
echo CHtml::label('Выберите файлы для прикрепления', 'attachments');
echo CHtml::fileField('attachments');
}
echo CHtml::label('Описание файла', 'filedescription');
echo CHtml::textField('filedescription',$model->metadata['description']);
echo CHtml::submitButton();
echo CHtml::endForm();
?>
</div>