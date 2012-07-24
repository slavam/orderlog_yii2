<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'claim-line-feature-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
        <div class="row">
		<b>Характеристика</b>
                <br>
		<?php echo $form->dropDownList($model,'feature_id',  ClaimLineFeature::findFeaturesByDirection($direction_id));?> 
		<?php echo $form->error($model,'feature_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->