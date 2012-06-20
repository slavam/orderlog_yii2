<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'claim-line-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'claim_id'); ?>
		<?php echo $form->textField($model,'claim_id'); ?>
		<?php echo $form->error($model,'claim_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'count'); ?>
		<?php echo $form->textField($model,'count'); ?>
		<?php echo $form->error($model,'count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'for_whom'); ?>
		<?php echo $form->textField($model,'for_whom'); ?>
		<?php echo $form->error($model,'for_whom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state_id'); ?>
		<?php echo $form->textField($model,'state_id'); ?>
		<?php echo $form->error($model,'state_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'change_date'); ?>
		<?php echo $form->textField($model,'change_date'); ?>
		<?php echo $form->error($model,'change_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'budget_item_id'); ?>
		<?php echo $form->textField($model,'budget_item_id'); ?>
		<?php echo $form->error($model,'budget_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'asset_id'); ?>
		<?php echo $form->textField($model,'asset_id'); ?>
		<?php echo $form->error($model,'asset_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cost'); ?>
		<?php echo $form->textField($model,'cost'); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'business_id'); ?>
		<?php echo $form->textField($model,'business_id'); ?>
		<?php echo $form->error($model,'business_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->