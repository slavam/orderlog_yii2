<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'part_number'); ?>
		<?php echo $form->textField($model,'part_number'); ?>
		<?php echo $form->error($model,'part_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ware_type_id'); ?>
		<?php echo $form->textField($model,'ware_type_id'); ?>
		<?php echo $form->error($model,'ware_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'budget_item_id'); ?>
		<?php echo $form->textField($model,'budget_item_id'); ?>
		<?php echo $form->error($model,'budget_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cost'); ?>
		<?php echo $form->textField($model,'cost'); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direction_id'); ?>
		<?php echo $form->textField($model,'direction_id'); ?>
		<?php echo $form->error($model,'direction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'asset_group_id'); ?>
		<?php echo $form->textField($model,'asset_group_id'); ?>
		<?php echo $form->error($model,'asset_group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'info'); ?>
		<?php echo $form->textField($model,'info'); ?>
		<?php echo $form->error($model,'info'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_id'); ?>
		<?php echo $form->textField($model,'unit_id'); ?>
		<?php echo $form->error($model,'unit_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->