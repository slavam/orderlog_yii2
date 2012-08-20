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

    <?php echo $form->errorSummary($model); ?>


<!-- <table width="100%" cellpadding="2" cellspacing="0" border="0">  -->

<table style="padding: 0px;">
	<tr>
		<td>
<table class="table_edit">
	<tr>
		<td><b>Шаблон</b></td>
		<td><?php echo $form->dropDownList($model,'asset_template_id',AssetTemplate::model()->findAssetTemplates()); ?>
		<?php echo $form->error($model,'asset_template_id'); ?></td>
		<td><b>Направление</b></td>
		<td><?php echo $form->dropDownList($model,'direction_id',Direction::model()->findDirections());?> 
		    <?php echo $form->error($model,'direction_id'); ?></td>
		<td><b>Тип</b></td>
		<td><?php echo $form->dropDownList($model,'ware_type_id',WareType::model()->findWareTypes());?> 
		<?php echo $form->error($model,'ware_type_id'); ?></td>
	</tr>
	<tr>
		<td><b>Дополнительная информация</b></td>
		<td colspan="5"><?php echo $form->textField($model,'info',array('size'=>155)); ?>
		<?php echo $form->error($model,'info'); ?></td>
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td>

<table class="table_edit">
	<tr>
		<td><b>Группа </td>
		<td><?php echo $form->dropDownList($model,'asset_group_id', AssetGroup::model()->findAssetGroups());?> 
		<?php echo $form->error($model,'asset_group_id'); ?></td>
		<td><b>Номенклатурный номер</b></td>
		<td colspan="3"><?php echo $form->textField($model,'part_number'); ?>
		<?php echo $form->error($model,'part_number'); ?></td>
	</tr>
	<tr>
		<td><b>Наименование</b></td>
		<td><?php echo $form->textField($model,'name',array('size'=>80)); ?>
		<?php echo $form->error($model,'name'); ?></td>
		<td><b>Цена</b></td>
		<td><?php echo $form->textField($model,'cost',array('size'=>10)); ?>
		<?php echo $form->error($model,'cost'); ?></td>
		<td><b>Тип цены</b></td>
		<td><?php echo $form->dropDownList($model,'price_type_id', PriceType::model()->findPriceTypes());?> 
		<?php echo $form->error($model,'price_type_id'); ?></td>
	</tr>
	<tr>
		<td><b>Статья бюджета</b></td>
		<td><?php echo $form->dropDownList($model,'budget_item_id',  BudgetItem::model()->findBudgetItems());?> 
		<?php echo $form->error($model,'budget_item_id'); ?></td>
		<td><b>Единица измерения</b></td>
		<td colspan="2"><?php echo $form->dropDownList($model,'unit_id', Unit::model()->findUnits());?>
		<?php echo $form->error($model,'unit_id'); ?></td>

	</tr>
	<tr>
		<td><b>Расположение</b></td>
		<td colspan="5"><?php echo ($model->place_id> 0 ? $this->replacementPlace($model->place_id):""); 
                                      echo "&nbsp"."&nbsp";
                                      echo CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать расположени');?></td>
	</tr>
	<tr>
		<td><b>Производитель</b></td>
		<td colspan="5"><?php echo "&nbsp"."&nbsp";
                                      echo CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать расположени');?></td>
	</tr>
	<tr>
		<td><b>Продукты</b></td>
		<td colspan="5"><?php echo "&nbsp"."&nbsp";
                                      echo CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать расположени');?></td>
	</tr>
	<tr>
		<td><b>Характеристики</b></td>
		<td colspan="5"><?php echo "&nbsp"."&nbsp";
                                      echo CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать расположени');?></td>
	</tr>
	<tr>
		<td><b>Примечание</b></td>
		<td colspan="5"><?php echo $form->textField($model,'comment',array('size'=>80)); ?>
		<?php echo $form->error($model,'comment'); ?></td>
	</tr>
</table>
		</td>
	</tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- form -->