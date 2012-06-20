<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'part_number'); ?>
		<?php echo $form->textField($model,'part_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ware_type_id'); ?>
		<?php echo $form->textField($model,'ware_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'budget_item_id'); ?>
		<?php echo $form->textField($model,'budget_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cost'); ?>
		<?php echo $form->textField($model,'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'direction_id'); ?>
		<?php echo $form->textField($model,'direction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'asset_group_id'); ?>
		<?php echo $form->textField($model,'asset_group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'info'); ?>
		<?php echo $form->textField($model,'info'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unit_id'); ?>
		<?php echo $form->textField($model,'unit_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->