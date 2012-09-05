<div class="form">

<?php 
 Yii::app()->clientScript->registerScript(
      "test",
      '
          $(function(){
          getassetgroupbydirection();
});
function getassetgroupbydirection(){
         $.ajax({
        url: "'.Yii::app()->createUrl('/assetgroup/GetAssetGroupsByDirection').'",
        data:{"dir":$("#AssetTemplate_direction_id").val()}
            })
            .done(function(data) { 
//                data=jQuery.parseJSON(data);
                $("#AssetTemplate_asset_group_id").html(data);
            });
        }',
      CClientScript::POS_HEAD
  );
 

$form=$this->beginWidget('CActiveForm', array(
	'action'=>'create',
	'id'=>'asset-template-form',
//	'enableAjaxValidation'=>true,
                               'enableClientValidation' => true,
//                               'clientOptions' => array(
//                                    'validateOnSubmit' => true,
//                                    'validateOnChange' => false,
//                                ),


//,array('readonly'=>true)

)); ?>

    <?php echo $form->errorSummary($model); ?>

<table style="padding: 0px;">
	<tr>
		<td>
<table class="table_edit">
	<tr>
		<td>
			<b>Название шаблона</b>
	                <br>
			<?php echo $form->textField($model,'name',array('size'=>80)); ?>
			<?php echo $form->error($model,'name'); ?>
		</td>
		<td>
			<b>Тип</b>
	                <br>
			<?php echo $form->dropDownList($model,'ware_type_id',Waretype::model()->findWareTypes());?> 
			<?php echo $form->error($model,'ware_type_id'); ?>
		</td>    
	</tr>
	<tr>
	<td>
		<b>Направление</b>
                <br>
                <?php echo $form->dropDownList($model,'direction_id', Direction::model()->findDirections(),array('empty'=>'<Выберите направление>','onchange'=>'{getassetgroupbydirection();}','onload'=>'{getassetgroupbydirection();}'));?> 
		<?php echo $form->error($model,'direction_id'); ?>
	</td>
		<td>
			<b>Группа</b>
	                <br>
	                <?php echo $form->dropDownList($model,'asset_group_id', array(),array('empty'=>'<Выберите группу>'));?> 
			<?php echo $form->error($model,'asset_group_id'); ?>
		</td>
	</tr>
	<tr>
	<td>
		<b>Статья бюджета</b>
                <br>
                <?php echo $form->dropDownList($model,'budget_item_id',  BudgetItem::model()->findBudgetItems());?> 
		<?php echo $form->error($model,'budget_item_id'); ?>
	</td>
		<td>
		<b>Номенклатурный номер</b>
                <br>
		<?php echo $form->textField($model,'part_number'); ?>
		<?php echo $form->error($model,'part_number'); ?>
		</td>

	</tr>
</table>
</td>
</tr>
<!--
<tr>
<td>
<table class="table_edit">
		<td>
			<b>Цена</b>
	                <br>
			<?php echo $form->textField($model,'cost',array('size'=>10)); ?>
			<?php echo $form->error($model,'cost'); ?>
		</td>

        <td>
		<b>Тип цены</b>
	                <br>
	                <?php echo $form->dropDownList($model,'price_type_id', PriceType::model()->findPriceTypes());?> 
					<?php echo $form->error($model,'price_type_id'); ?>
		</td>
	<td>
		<b>Единица измерения</b>
                <br>
                <?php echo $form->dropDownList($model,'unit_id', Unit::model()->findUnits());?>
		<?php echo $form->error($model,'unit_id'); ?>
	</td>
</table>
</td>
</tr>
-->
<tr>
<td>
<table class="table_edit">
	<tr>

	<td>
		<b>Дополнительная информация</b>
                <br>
		<?php echo $form->textArea($model,'info',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'info'); ?>
	</td>
	<td>
		<b>Комментарий</b>
                <br>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</td>
</table>
</td>
</tr>

</table><!-- main -->

<?php $this->endWidget(); ?>

</div><!-- form -->