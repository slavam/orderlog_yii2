<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>'editAsset',
	'id'=>'asset-form',
//	'enableAjaxValidation'=>true,
                               'enableClientValidation' => true,
//                               'clientOptions' => array(
//                                    'validateOnSubmit' => true,
//                                    'validateOnChange' => false,
//                                ),


//,array('readonly'=>true)

)); ?>

    <table>
    </table>


    <?php echo $form->errorSummary($model); ?>

        <div class="row">
		<b>Тип</b>
                <br>
		<?php echo $form->dropDownList($model,'ware_type_id',WareType::model()->findWareTypes());?> 
		<?php echo $form->error($model,'ware_type_id'); ?>
	</div>    
	<div class="row">
		<b>Группа</b>
                <br>
                <?php echo $form->dropDownList($model,'asset_group_id', AssetGroup::model()->findAssetGroups());?> 
		<?php echo $form->error($model,'asset_group_id'); ?>
	</div>
	<div class="row">
		<b>Название</b>
                <br>
		<?php echo $form->textField($model,'name',array('size'=>80)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<b>Цена</b>
                <br>
		<?php echo $form->textField($model,'cost',array('size'=>10)); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>

        <div class="row">
		<b>Тип цены</b>
                <br>
                <?php echo $form->dropDownList($model,'price_type_id', PriceType::model()->findPriceTypes());?> 
		<?php echo $form->error($model,'price_type_id'); ?>
	</div>
	<div class="row">
		<b>Номенклатурный номер</b>
                <br>
		<?php echo $form->textField($model,'part_number'); ?>
		<?php echo $form->error($model,'part_number'); ?>
	</div>
	<div class="row">
		<b>Статья бюджета</b>
                <br>
                <?php echo $form->dropDownList($model,'budget_item_id',  BudgetItem::model()->findBudgetItems());?> 
		<?php echo $form->error($model,'budget_item_id'); ?>
	</div>
	<div class="row">
		<b>Направление</b>
                <br>
                <?php echo $form->dropDownList($model,'direction_id', Direction::model()->findDirections());?> 
		<?php echo $form->error($model,'direction_id'); ?>
	</div>
	<div class="row">
		<b>Единица измерения</b>
                <br>
                <?php echo $form->dropDownList($model,'unit_id', Unit::model()->findUnits());?>
		<?php echo $form->error($model,'unit_id'); ?>
	</div>
	<div class="row">
		<b>Дополнительная информация</b>
                <br>
		<?php echo $form->textField($model,'info',array('size'=>80)); ?>
		<?php echo $form->error($model,'info'); ?>
	</div>
	<div class="row">
		<b>Комментарий</b>
                <br>
		<?php echo $form->textField($model,'comment',array('size'=>80)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>
	<div class="row">
		<b>Расположение</b>
                <br>
		<?php echo $form->listBox($model,'selection',Place::model()->findAllTowns(),array('multiple'=>TRUE,'size'=>'10')); ?>
		<?php echo $form->error($model,'place_id'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->