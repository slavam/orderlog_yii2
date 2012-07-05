<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'claim-line-form',
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
		<?php echo $form->textField($model,'count'); ?>
		<?php echo $form->error($model,'count'); ?>
	</div>

        <div class="row">
		<b><?php echo $model->asset->priceType->name; ?></b>
                <br>
		<?php echo $form->textField($model,'cost'); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>

	<div class="row">
		<b>Примечание</b>
                <br>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<b>Для кого</b>
                <br>
		<?php echo $form->dropDownList($model,'for_whom',Worker::findWorkers());?> 
		<?php echo $form->error($model,'for_whom'); ?>
	</div>

	<div class="row">
		<b>Бизнес</b>
                <br>
		<?php echo $form->dropDownList($model,'business_id',Business::findBusinesses());?> 
		<?php echo $form->error($model,'business_id'); ?>
	</div>
    
        <div class="row">
		<b>Статус</b>
                <br>
		<?php echo $form->dropDownList($model,'status_id', Status::findStatuses());?> 
		<?php echo $form->error($model,'status_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->