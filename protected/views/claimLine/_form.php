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

        <?php if (!$model->isNewRecord) {        
            echo '<div class="row">';
            echo '<b>Цена ('.$model->asset->priceType->name.')</b><br>';
            echo $form->textField($model,'cost');
            echo '</div>';
        }; ?>

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

	<div class="row">
		<b>Расположение</b>
                <br>
		<?php echo $form->dropDownList($model,'position_id',  Place::findAllPlaces());?> 
		<?php echo $form->error($model,'position_id'); ?>
	</div>
        <?php if (!$model->isNewRecord):?>
            <div class="row">
                <b>Продукты</b>
                <br>
                <?php if ($model->findProductsAsString($model->id) > '') { 
                        echo CHtml::link(CHtml::encode($model->findProductsAsString($model->id)), array('claimLineProduct/indexByLine','claim_line_id'=>$model->id));
                    } else {
                        echo CHtml::link('Добавить продукт', array('claimLineProduct/create','direction_id'=>$model->claim->direction_id, 'claim_line_id'=>$model->id));
                } ?> 
                <?php echo $form->error($model,'product_id'); ?>
            </div>
            <div class="row">
                <b>Характеристики</b>
                <br>
                <?php if ($model->findFeaturesAsString($model->id) > '') { 
                        echo CHtml::link(CHtml::encode($model->findFeaturesAsString($model->id)), array('claimLineFeature/featuresByClaimLine','claim_line_id'=>$model->id));
                    } else {
                        echo CHtml::link('Добавить характеристику', array('claimLineFeature/create','direction_id'=>$model->claim->direction_id, 'claim_line_id'=>$model->id));
                } ?> 
                <?php echo $form->error($model,'feature_id'); ?>
            </div>
        <?php endif;?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->