<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'complect-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<b>Тип</b>
                <br>
		<?php echo $form->dropDownList($model,'complect_type_id',  ComplectType::findComplectTypes());?> 
		<?php echo $form->error($model,'complect_type_id'); ?>
	</div>

	<div class="row">
		<b>Название</b>
                <br>
		<?php echo $form->textField($model,'name',array('size'=>80)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<b>Комментарий</b>
                <br>
		<?php echo $form->textField($model,'comment',array('size'=>100)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->