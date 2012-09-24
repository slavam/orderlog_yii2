<style type="text/css">

    #asset-form table {
     	margin-bottom: 0; /*0.2em;*/
     	font-size: 11px !important;
     }
     #asset-form table th, #asset-form table td {
     	padding: 0px 10px 0px 5px;
     }
</style>

<script type="text/javascript">
   $.jgrid.no_legacy_api = true;
   $.jgrid.useJSON = true;

$.maxZIndex = $.fn.maxZIndex = function(opt) {
    /// <summary>
    /// Returns the max zOrder in the document (no parameter)
    /// Sets max zOrder by passing a non-zero number
    /// which gets added to the highest zOrder.
    /// </summary>    
    /// <param name="opt" type="object">
    /// inc: increment value, 
    /// group: selector for zIndex elements to find max for
    /// </param>
    /// <returns type="jQuery" />
    var def = { inc: 10, group: "*" };
    $.extend(def, opt);    
    var zmax = 0;
    $(def.group).each(function() {
        var cur = parseInt($(this).css('z-index'));
        zmax = cur > zmax ? cur : zmax;
    });
    if (!this.jquery)
        return zmax;

    return this.each(function() {
        zmax += def.inc;
        $(this).css("z-index", zmax);
    });
}

</script>

<script type="text/javascript">
    var lastSel;
    var place_text = $("#place_id_selector");
    var place_data = $("#Asset_selection");

    var request = false;
    var newmodel = <? echo ($model->isNewRecord ? 'true' : 'false' )?>;
    var grid=$("#create_multiple_dialog_table");
    var id_multiple=1;
    var id_direction=1;
    
    var idsOfSelectedRows = [],
        updateIdsOfSelectedRows = function (id, isSelected) {
           var index = $.inArray(id, idsOfSelectedRows);
           if (!isSelected && index >= 0) {
                idsOfSelectedRows.splice(index, 1); // remove id from the list
           } else if (index < 0) {
                idsOfSelectedRows.push(id);
           }
        };

    var location_data  =<?echo Helpers::BuildSpecificationsGridList(Place::model()->findAllTowns(), array('id','title'));?>;
    var product_data=<?echo Helpers::BuildSpecificationsGridList(Product::model()->findAll(), array('id','name'));?>;
    var product_data_dirs=<?echo Helpers::BuildSpecificationsGridList(Product::model()->findAll(), array('id','direction_id'));?>;
    var feature_data=<?echo Helpers::BuildSpecificationsGridList(Feature::model()->findAll(), array('id','name'));?>;
    var feature_data_dirs=<?echo Helpers::BuildSpecificationsGridList(Feature::model()->findAll(), array('id','direction_id'));?>;

    var title_colModel=[
        { name : 'id', index : 'id', width : 20, hidden:true },
        { name : 'title', index : 'title', width : 250, sortable:true }             /* Наименование */
		];
    var name_colModel=[
        { name : 'id', index : 'id', width : 20, hidden:true },
        { name : 'name', index : 'name', width : 250, sortable:true }             /* Наименование */
		];

var grid_opts = {
        datatype : 'local',
        width : '750',
        height : '480',
        data: place_data,
        colNames : [ 'ID','Наименование'],
        colModel : name_colModel,
        multiselect: true,
        pager : null,
        rowNum : 1000000,
        gridview: true,
        rownumbers: true,
        onSelectRow: updateIdsOfSelectedRows,
        emptyrecords: 'No URLs have been loaded for evaluation.',
        
        loadComplete: function () {
                var _first=false;
                $("#firstLoad").data('firstLoad', _first);
          var arr_isset = place_data.val();
          
          if (arr_isset) {
             idsOfSelectedRows = place_data.val().split(/[,]/);;
          } 
                
           var $this = $(this), i, count;
           for (i = 0, count = idsOfSelectedRows.length; i < count; i++) {
                $this.jqGrid('setSelection', idsOfSelectedRows[i], false);
           }
        },
        
       gridComplete: function() {
          var recs = parseInt($("#create_multiple_dialog_table").getGridParam("records"),10);
        
    },
    
        sortname : 'name',
        sortorder : 'asc',
        caption : false,
        pgbuttons: false,      // disable page control like next, back button
        pgtext: null,          // disable pager text like 'Page 0 of 10'
        viewrecords: false,    // disable current view record text like 'View 1-10 of 100'    
        loadonce: true,         // to enable sorting on client side
 
        loadui: 'disable'

};

function FilterDataByDirection(data,data_dirs,dir_id)
{
	var do_them_all=false;
	if (dir_id.length==0) do_them_all=true;
            var ret_array=[];
            $.each(data,function(i,v){
                    if(data_dirs[i].direction_id==dir_id||do_them_all)
                    {
                        ret_array.push(v);
                    }
            });
            return ret_array;
}

function LoadGrid(id_multiple,id_direction) {

    idsOfSelectedRows.length = 0;

    $("#create_multiple_dialog_table").jqGrid('GridUnload');
    $("#create_multiple_dialog_table").jqGrid('clearGridData');

switch (id_multiple) {
  case 1:
    grid_opts.data=location_data;
    grid_opts.colModel=title_colModel;
    break;
  case 2:
//    strtitle = 'Редактировать фирму производителя';
    break;
  case 3:
    grid_opts.data=FilterDataByDirection(product_data,product_data_dirs,id_direction);
    grid_opts.colModel=name_colModel;
    break;
  case 4:
    grid_opts.data=FilterDataByDirection(feature_data,feature_data_dirs,id_direction);
    grid_opts.colModel=name_colModel;
    break;
  default:
    alert('Я таких значений не знаю')
    }


    $("#create_multiple_dialog_table").jqGrid( grid_opts );
    $("#cb_" + grid[0].id).hide();
    
    function getTemplates() {
        
    var template_id = document.getElementById("Asset_asset_template_id").value;
        
  $.ajax({
       'type': "POST",
        'url': 'GetTemplateByAsset',
        data : {'template_id':template_id, 'newrecord': newmodel}     
        })
       .done(function(data) { 

         var response = JSON.parse(data);
         
         $("#asset_group_id").html('');
         $("#asset_group_id").val(response['asset_group_id']);
         $("#Asset_asset_group_id").val(response['asset_group_id_val']);
         $("#budget_item_id").val(response['budget_item_id']);
         $("#Asset_budget_item_id").val(response['budget_item_id_val']);
         $("#direction_id").val(response['direction_id']);
         $("#Asset_direction_id").val(response['direction_id_val']);
         $("#ware_type_id").val(response['ware_type_id']);
         $("#Asset_ware_type_id").val(response['ware_type_id_val']);
         $("#info").val(response['info']);
         $("#Asset_part_number").val(response['part_number']);
             
            });

function send(id_multiple_param){
      id_multiple=id_multiple_param;            //set global var
    
      id_temlate = $("#Asset_asset_template_id").val();
      if(id_temlate) {
          
      id_direction = $("#Asset_direction_id").val();

    var strtitle;

  
switch (id_multiple_param) {
  case 1:
    strtitle = 'Редактировать расположение';
    place_text = $("#place_id_selector");
    place_data = $("#Asset_place_id");
    break;
  case 2:
    place_text = $("#man_id_selector");
    place_data = $("#Asset_manufacturer_id");
    strtitle = 'Редактировать фирму производителя';
    break;
  case 3:
    place_text = $("#prod_id_selector");
    place_data = $("#Asset_product_id");
    strtitle = 'Редактировать продукты';
    break;
  case 4:
    place_text = $("#feat_id_selector");
    place_data = $("#Asset_feature_id");
    strtitle = 'Редактировать характеристики';
    break;
  default:
    alert('Я таких значений не знаю')
    }    
    	LoadGrid(id_multiple,id_direction);
             	$("#create_multiple_dialog").dialog({
             		title: strtitle,
                        modal:true,
                        width:800,
                        height:600,
                        zIndex: $.maxZIndex()+ 1,
                        buttons:{
                            'OK': function(){
                            var asset_id = $("#create_dialog").data("parent_id");
                 $.ajax({
                  'type': "POST",
                   'url': 'editMultipleChoice',
                   data : {'id':asset_id, 'multiple_arr': idsOfSelectedRows,'type_data':id_multiple}
                  }).done(function (data){

                       var contact = JSON.parse(data);
                       
                      place_text.html(contact.text_place);
                      place_data.val(contact.data_place);
                      
                  });


                      $(this).dialog('close');
                     },
                            'Отмена': function(){
                                $(this).dialog('close');
                            }
                        }

                    });

    } else alert('Выберите шаблон!');   // end if(id_direction)

}
</script>

<div class="form">
    
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>'editAsset',
	'id'=>'asset-form',
        'enableClientValidation' => true,

)); ?>

    <?php echo $form->errorSummary($model); ?>


<!-- <table width="100%" cellpadding="2" cellspacing="0" border="0">  -->

<table style="padding: 7px !important;">
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
		<td align="left"><?php echo CHtml::textField('asset_group_id',$model->assettemplate->asset_group_id > 0 ? $model->assettemplate->assetgroup->block->name.' => '.$model->assettemplate->assetgroup->name:"" , array('size'=>120,'disabled'=>true)); 
                                       echo $form->hiddenField($model,'asset_group_id', array('value'=>$model->assettemplate->asset_group_id, 'style'=>'display: none;')); ?></td>
                <td><b>Направление</b></td>
		<td align="left"><?php echo CHtml::textField('direction_id', $model->assettemplate->direction_id > 0 ? $model->assettemplate->direction->short_name: "" , array('size'=>8,'disabled'=>true)); 
                                      // if ($model->asset_template_id) 
                                       echo $form->hiddenField($model,'direction_id', array('value'=>$model->assettemplate->direction_id, 'style'=>'display: none;')); 
//                                      $form->hiddenField($model,'direction_id_val', array('value'=>$model->asset_template_id  > 0 ? $model->assettemplate->direction_id:'', 'style'=>'display: none;')); 
//                                       else echo $form->hiddenField($model,'direction_id_val', array('value'=>$model->assettemplate->direction_id, 'style'=>'display: none;'));
                                       ?></td>
	</tr>
	<tr>
                
                <td><b>Статьи</b></td>
		<td align="left"><?php 
                       $article=BudgetItem::model()->findByPk($model->assettemplate->budget_item_id);
                       $article_code = $article->CODE;
                       echo CHtml::textField('budget_item_id', $model->assettemplate->budget_item_id > 0 ? $article->get2LevelNameBudgetItem($model->assettemplate->budget_item_id)." => ".$article_code:"", array('size'=>120,'disabled'=>true)); ?></td>
		<td><b>Тип</b></td>
		<td align="left"><?php 
                        echo CHtml::textField('ware_type_id',$model->assettemplate->waretype->short_name, array('size'=>8,'disabled'=>true));
                        echo $form->hiddenField($model,'ware_type_id', array('value'=>$model->assettemplate->ware_type_id, 'style'=>'display: none;')); ?></td>
	</tr>
	<tr>
		<td><b>Дополнительная информация</b></td>
		<td colspan="3"><?php echo CHtml::textField('info', $model->assettemplate->info, array('size'=>174,'disabled'=>true)); ?></td>
	</tr>
</table>
		</td>
	</tr>
	<tr><td><?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/1x1.gif','',array(
                            'width'=>'1',
			    'height'=>'5',
                        )); ?></td>
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
		<td><?php echo $form->dropDownList($model,'price_type_id', PriceType::model()->findPriceTypes());?> 
		<?php echo $form->error($model,'price_type_id'); ?></td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td><b>Кол-во</b></td>
		<td><?php echo $form->textField($model,'quantity',array('size'=>10)); ?>
		<?php echo $form->error($model,'cost'); ?></td>
		<td><b>Тип кол-ва</b></td>
		<td><?php echo $form->dropDownList($model,'quantity_type_id', QuantityTypes::All());?> 
		<td><?php // echo $form->dropDownList($model,'quantity_type_id', QuantityTypes::All(), array('empty' => '<Выбор типа>'));?> 
		<?php echo $form->error($model,'quantity_type_id'); ?></td>

	</tr>
	<tr>
		<td><b>Статья бюджета</b></td>
		<td colspan="5"><?php 
                 echo $form->dropDownList($model,'budget_item_id', CHtml::listData(BudgetItem::model()->get3LevelAllNameBudgetItemOptionList(),'ID','NAME'), array('empty' => '<Выбор статьи бюджета>'));
                ?> 
		<?php echo $form->error($model,'budget_item_id'); ?></td>

	</tr>
	<tr>
        </div>

		<td><b>Расположение</b></td>
		<td colspan="5" ><span id="place_id_selector"><?php  echo ($model->place_id> 0 ? $this->replacementPlace($model->place_id,1):"");?></span>                                      
                      <?php echo "&nbsp"."&nbsp";
                                      
                                      echo CHtml::link(
                                                    CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать расположение', 
                                                    array( 'class'=>$class,'onClick'=>'send(1)',)), array('#'));
//                                                    echo $model->place_id;
                                                    echo $form->hiddenField($model,'place_id', array('value'=>$model->place_id, 'style'=>'display: none;')); 
                                                    //echo CHtml::hiddenField('selection', array('value'=>$model->selection)); ?></td>
	</tr>
<!-- Zabil do lychih vremen  -->
<!--         <tr>  -->
<!-- 		<td><b>Производитель</b></td>   -->
<!--		<td colspan="5"><span id="man_id_selector">  --><?php // echo ($model->manufacturer_id> 0 ? $this->replacementPlace($model->manufacturer_id,2):""); ?><!--  </span>   -->
                                      <?php // echo "&nbsp"."&nbsp";
                                      // echo CHtml::link(
                                      //              CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать фирму производителя', 
                                      //              array( 'class'=>$class,'onClick'=>'send(2)',)), array('#'));
                                      // echo $form->hiddenField($model,'manufacturer_id', array('value'=>$model->manufacturer_id, 'style'=>'display: none;')); ?> <!--  </td>   -->
<!--	</tr>   -->
	<tr>
		<td><b>Продукты</b></td>
		<td colspan="5"><span id="prod_id_selector"><?php echo ($model->product_id > 0 ? $this->replacementPlace($model->product_id,3):""); ?></span>
                                      <?php echo "&nbsp"."&nbsp";
                                      echo CHtml::link(
                                                    CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать продукты', 
                                                    array( 'class'=>$class,'onClick'=>'send(3)',)), array('#'));
                                      echo $form->hiddenField($model,'product_id', array('value'=>($model->product_id > 0 ? $model->product_id: NULL), 'style'=>'display: none;')); ?></td>
	</tr>
	<tr>
		<td><b>Характеристики</b></td>
		<td colspan="5"><span id="feat_id_selector"><?php echo ($model->feature_id> 0 ? $this->replacementPlace($model->feature_id,4):""); ?></span> 
                                      <?php echo "&nbsp"."&nbsp";
                                      echo CHtml::link(
                                                    CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png','Редактировать характеристики товара', 
                                                    array( 'class'=>$class,'onClick'=>'send(4)',)), array('#'));
                                      echo $form->hiddenField($model,'feature_id', array('value'=>$model->feature_id, 'style'=>'display: none;')); ?></td>
	</tr>
</table>
		</td>
	</tr>
</table>
    
<?php $this->endWidget(); ?>
<div id="create_multiple_dialog" style="display: none;">
    <div id="resurection">
<table id="create_multiple_dialog_table">
</table>
    </div>
</div>
</div><!-- form -->