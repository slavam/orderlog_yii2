<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<b>Супергруппа</b>
                <br>
		<?php echo $form->dropDownList($model,'block_id',  Block::findBlocks());?> 
		<?php echo $form->error($model,'block_id'); ?>
	</div>

	<div class="row">
		<b>Группа</b>
                <br>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->