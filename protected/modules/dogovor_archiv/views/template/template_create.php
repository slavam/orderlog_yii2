<h1>Создать шаблон</h1>
<?php
$this->breadcrumbs=array(
	'templates',
);
?>

<?php if(Yii::app()->user->hasFlash('documents')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('documents'); ?>
</div>

<?php else: ?>

<div class="form">

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'template-add-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'description'); ?>
        </div>
        <?if ($model->form):?>
        <fieldset>
            <legend>Поля</legend>
            <?
            
            foreach ($model->form as $field_key=>$field_value)
            {
                echo CHtml::tag('p',array(),  CHtml::link($field_value->caption,'/field/editfield/?templ_id='.$model->_id.'&field_id='.$field_value->_id));
            }
            
            ?>
        </fieldset>
        <?endif; ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>