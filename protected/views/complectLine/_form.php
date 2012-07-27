<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'complect-line-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<b>Товар</b>
                <br>
		<?php echo $form->dropDownList($model,'asset_id',Asset::findAssets());?> 
		<?php echo $form->error($model,'asset_id'); ?>
	</div>

	<div class="row">
		<b>Количество</b>
                <br>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->