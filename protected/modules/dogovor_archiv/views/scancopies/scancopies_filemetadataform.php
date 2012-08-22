<div class="form">
<?
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/dogovor_archiv/scancopies/editfile'),
	'id'=>'fileedit_form',
        'enableClientValidation' => true,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        
));
//echo CHtml::beginForm(Yii::app()->createUrl('/dogovor_archiv/scancopies/editfile'),'post',array('enctype'=>'multipart/form-data','id'=>'fileedit_form'));
echo CHtml::hiddenField('parent_document',$_REQUEST['parent_id']);
echo CHtml::hiddenField('image_id',$_REQUEST['image_id']);
//Выводим в диалог
if ($model->scenario=='insert')
{
echo $form->labelEx($model,'filename');
echo CHtml::fileField('filename');
echo $form->error($model,'filename');
}
echo $form->labelEx($model,'filedescription');
echo $form->textField($model,'filedescription');
echo $form->error($model,'filedescription');

$this->endWidget();
?>
</div>