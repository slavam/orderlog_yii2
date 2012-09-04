
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
 
    function getTemplates() {
        var template_id = document.getElementById("Asset_asset_template_id").value;
        var url = 'GetTemplateByAsset/?template_id='+template_id;
        request.open("GET", url, true);
        request.onreadystatechange = updateTemplates;
        request.send(null);
    }
    function updateTemplates() {

      if (request.readyState == 4) {
            if (request.status == 200) {
                
         var response = JSON.parse(request.responseText);
         $("#asset_group_id").html('');
         $("#asset_group_id").val(response['asset_group_id']);
         $("#budget_item_id").val(response['budget_item_id']);
         $("#direction_id").val(response['direction_id']);
         $("#ware_type_id").val(response['ware_type_id']);
         $("#info").val(response['info']);
       } else
         alert("status is " + request.status);
     }
   }
</script>
<?php 
      
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
		<td colspan="3" align="left"><?php echo $form->dropDownList($model,'asset_template_id',AssetTemplate::model()->findAssetTemplates(), array('empty' => '<Выбор шаблона>','onChange'=>'getTemplates()')); ?>
                    <?php echo $form->error($model,'asset_template_id'); ?></td>
	</tr>
	<tr>
                <td><b>Группа</b></td>
		<td align="left"><?php echo CHtml::textField('asset_group_id',$model->assettemplate->asset_group_id > 0 ? $model->assettemplate->assetgroup->block->name.' => '.$model->assettemplate->assetgroup->name:"" , array('size'=>120,'disabled'=>true)); ?></td>
                <td><b>Направление</b></td>
		<td align="left"><?php echo CHtml::textField('direction_id', $model->assettemplate->direction_id > 0 ? $model->assettemplate->direction->short_name:"" , array('size'=>8,'disabled'=>true)); ?></td>
	</tr>
	<tr>
                
                <td><b>Статьи</b></td>
		<td align="left"><?php 
                       $article=BudgetItem::model()->findByPk($model->assettemplate->budget_item_id);
                       $article_code = $article->CODE;
                    echo CHtml::textField('budget_item_id', $model->assettemplate->budget_item_id > 0 ? $article->get2LevelNameBudgetItem($model->assettemplate->budget_item_id)." => ".$article_code:"", array('size'=>120,'disabled'=>true)); ?></td>
		<td><b>Тип</b></td>
		<td align="left"><?php echo CHtml::textField('ware_type_id',$model->assettemplate->waretype->short_name, array('size'=>8,'disabled'=>true)); ?></td>
	</tr>
	<tr>
		<td><b>Дополнительная информация</b></td>
		<td colspan="3"><?php echo CHtml::textField('info', $model->assettemplate->info, array('size'=>174,'disabled'=>true)); ?></td>
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td>

<table class="table_edit">
	<tr>
		<td><b>Наименование</b></td>
		<td><?php echo $form->textField($model,'name',array('size'=>80)); ?>
		<?php echo $form->error($model,'name'); ?></td>
		<td><b>Код</b></td>
		<td><?php echo $form->textField($model,'part_number'); ?>
		<?php echo $form->error($model,'part_number'); ?></td>
		<td><b>Единица измерения</b></td>
		<td><?php echo $form->dropDownList($model,'unit_id', Unit::model()->findUnits());?>
		<?php echo $form->error($model,'unit_id'); ?></td>
                
	</tr>
	<tr>
		<td><b>Примечание</b></td>
		<td><?php echo $form->textField($model,'comment',array('size'=>80)); ?>
		<?php echo $form->error($model,'comment'); ?></td>
           	<td><b>Цена</b></td>
		<td><?php echo $form->textField($model,'cost',array('size'=>10)); ?>
		<?php echo $form->error($model,'cost'); ?></td>
		<td><b>Тип цены</b></td>
		<td><?php echo $form->dropDownList($model,'price_type_id', PriceType::model()->findPriceTypes(), array('empty' => '<Выбор типа>'));?> 
		<?php echo $form->error($model,'price_type_id'); ?></td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td><b>Кол-во</b></td>
		<td><?php echo $form->textField($model,'quantity',array('size'=>10)); ?>
		<?php echo $form->error($model,'cost'); ?></td>
		<td><b>Тип Кол-ва</b></td>
		<td><?php echo $form->dropDownList($model,'quantity_type_id', QuantityTypes::All());?> 
		<td><?php // echo $form->dropDownList($model,'quantity_type_id', QuantityTypes::All(), array('empty' => '<Выбор типа>'));?> 
		<?php echo $form->error($model,'quantity_type_id'); ?></td>

	</tr>
	<tr>
		<td><b>Статья бюджета</b></td>
		<td colspan="5"><?php echo $form->dropDownList($model,'budget_item_id',  BudgetItem::model()->get3LevelAllNameBudgetItem(),array('empty' => '<Выбор статьи бюджета>'));?> 
		<?php echo $form->error($model,'budget_item_id'); ?></td>

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