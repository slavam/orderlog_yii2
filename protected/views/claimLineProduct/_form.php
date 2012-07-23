<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'claim-line-product-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
        <div class="row">
		<b>Продукт</b>
                <br>
		<?php echo $form->dropDownList($model,'product_id',  ClaimLineProduct::findProductsByDirection($direction_id));?> 
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->