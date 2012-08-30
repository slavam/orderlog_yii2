
<script type="text/javascript">
   $.jgrid.no_legacy_api = true;
   $.jgrid.useJSON = true;
</script>

<script type="text/javascript">
    var lastSel;
    var request = false;
    try {
     request = new XMLHttpRequest();
   } catch (trymicrosoft) {
     try {
       request = new ActiveXObject("Msxml2.XMLHTTP");
     } catch (othermicrosoft) {
       try {
         request = new ActiveXObject("Microsoft.XMLHTTP");
       } catch (failed) {
         request = false;
       }  
     }
   }

   if (!request)
     alert("Error initializing XMLHttpRequest!");
 
    function getDepartments() {
        var template_id = document.getElementById("Asset_asset_template_id").value;
        var url = 'GetTemplateByAsset/?template_id='+template_id;
        request.open("GET", url, true);
        request.onreadystatechange = updateDepartments;
        request.send(null);
    }
    function updateDepartments() {
        
         $("#asset_group_id").val('');                                           // Clear for empty change

      if (request.readyState == 4) {
            if (request.status == 200) {
                
         var response = JSON.parse(request.responseText);
 
         $("#asset_group_id").html('');
         $("#asset_group_id").val(response['asset_group_id']);
         $("#ware_type_id").val(response['ware_type_id']);
       } else
         alert("status is " + request.status);
     }
   }
</script>
<?php 
      $groupmodel = AssetGroup::model()->findByPk($model->asset_group_id);
      
?>

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

<table style="padding: 0px !important;">
	<tr>
		<td>
<table class="table_edit">
	<tr>
		<td><b>Шаблон</b></td>
		<td colspan="3" align="left"><?php echo $form->dropDownList($model,'asset_template_id',AssetTemplate::model()->findAssetTemplates(), array('empty' => '<Выбор шаблона>','onChange'=>'getDepartments()')); ?>
                    <?php echo $form->error($model,'asset_template_id'); ?></td>
	</tr>
	<tr>
                <td><b>Группа</b></td>
		<td align="left"><?php echo CHtml::textField('asset_group_id',$model->asset_group_id> 0 ? $groupmodel->block->name.' => '.$groupmodel->name:"" , array('size'=>80,'disabled'=>true)); ?></td>
                <td><b>Направление</b></td>
		<td align="left"><?php echo CHtml::textField('direction_id', $model->direction_id> 0 ? $groupmodel->block->name.' => '.$groupmodel->name:"" , array('disabled'=>true)); ?></td>
	</tr>
	<tr>
                
                <td><b>Статьи</b></td>
		<td align="left"><?php echo CHtml::textField('budget_item_id', Yii::app()->user->name, array('size'=>80,'disabled'=>true)); ?></td>
		<td><b>Тип</b></td>
		<td align="left"><?php echo CHtml::textField('ware_type_id','', array('disabled'=>true)); ?></td>
	</tr>
	<tr>
		<td><b>Дополнительная информация</b></td>
		<td colspan="3"><?php echo CHtml::textField('info', Yii::app()->user->name, array('disabled'=>true)); ?></td>
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
		<td colspan="2"></td>
		<td><b>Кол-во</b></td>
		<td><?php echo $form->textField($model,'quantity',array('size'=>10)); ?>
		<?php echo $form->error($model,'cost'); ?></td>
		<td><b>Тип Кол-ва</b></td>
		<td><?php echo $form->dropDownList($model,'quantity_type_id', QuantityTypes::All());?> 
		<?php echo $form->error($model,'quantity_type_id'); ?></td>
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
                                      echo CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать расположение');?></td>
	</tr>
	<tr>
		<td><b>Производитель</b></td>
		<td colspan="5"><?php echo "&nbsp"."&nbsp";
                                      echo CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать расположение');?></td>
	</tr>
	<tr>
		<td><b>Продукты</b></td>
		<td colspan="5"><?php echo "&nbsp"."&nbsp";
                                      echo CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать расположение');?></td>
	</tr>
	<tr>
		<td><b>Характеристики</b></td>
		<td colspan="5"><?php echo "&nbsp"."&nbsp";
                                      echo CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать расположение');?></td>
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

        <?php /*  echo $form->dropDownList($model, 'parent_id', 
                CHtml::listData(Section::model()->getList()->getData(), 'id', 'title'), 
                array('encode' => false, 
                      'onchange'=>Chtml::ajax(array('type'=>'POST','url' => CController::createUrl('sectionType'),
                      'update' => '#'.CHtml::activeId($model, 'comments_allowed'))),
                      'empty'=>t('Выберите раздел для публикации'))); 
         */ ?>
    <?php // echo $form->checkBox($model, 'comments_allowed',  array()); ?>

    
<?php $this->endWidget(); ?>

</div><!-- form -->