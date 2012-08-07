<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'complect-line-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>
    <?php if ($type == 'ware'):?>
	<div class="row">
		<b>Товар</b>
                <br>
		<?php echo $form->dropDownList($model,'asset_id',Asset::findAssets());?> 
		<?php echo $form->error($model,'asset_id'); ?>
	</div>
    <?php else:?>
	<div class="row">
		<b>Шаблон</b>
                <br>
		<?php echo $form->dropDownList($model,'asset_template_id',AssetTemplate::findAssetTemplates());?> 
		<?php echo $form->error($model,'asset_template_id'); ?>
	</div>
    <?php endif;?>

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