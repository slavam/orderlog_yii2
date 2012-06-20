<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'claim-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'claim_number'); ?>
		<?php echo $form->textField($model,'claim_number'); ?>
		<?php echo $form->error($model,'claim_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'division_id'); ?>
		<?php echo $form->textField($model,'division_id'); ?>
		<?php echo $form->error($model,'division_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date'); ?>
		<?php echo $form->error($model,'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'budgetary'); ?>
		<?php echo $form->checkBox($model,'budgetary'); ?>
		<?php echo $form->error($model,'budgetary'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direction_id'); ?>
		<?php echo $form->textField($model,'direction_id'); ?>
		<?php echo $form->error($model,'direction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state_id'); ?>
		<?php echo $form->textField($model,'state_id'); ?>
		<?php echo $form->error($model,'state_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'period_id'); ?>
		<?php echo $form->textField($model,'period_id'); ?>
		<?php echo $form->error($model,'period_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment'); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->