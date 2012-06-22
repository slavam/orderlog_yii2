<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'claim-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
            <b>Отделение</b>
            <br>
            <?php echo $form->dropDownList($model,'division_id', Division::All());?> 
            <?php echo $form->error($model,'division_id'); ?>
	</div>

	<div class="row">
            <b>Направление</b>
            <br>
            <?php echo $form->dropDownList($model,'direction_id', Direction::findDirections());?> 
            <?php echo $form->error($model,'direction_id'); ?>
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