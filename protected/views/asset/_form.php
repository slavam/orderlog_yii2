<? /*php
$cs = Yii::app()->clientScript;
 
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jq$("#create_multiple_dialog_table").css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.multiselect.css');
 
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jqModal.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jqDnR.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');

$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/ui.multiselect.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/$("#create_multiple_dialog_table").locale-ru.js');
*/?>

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
    var place_data = $("#Asset_place_id");

    var request = false;
    var grid=$("#create_multiple_dialog_table");
    var id_multiple=1;
    var id_direction=1;
//    var emptyMsgDiv = $('<div style="padding: 30px;" ><h3>Для этого напраления нет характеристик !</h3></div>');
    //var firstLoad = true;
    var idsOfSelectedRows = [],
        updateIdsOfSelectedRows = function (id, isSelected) {
           var index = $.inArray(id, idsOfSelectedRows);
           if (!isSelected && index >= 0) {
                idsOfSelectedRows.splice(index, 1); // remove id from the list
           } else if (index < 0) {
                idsOfSelectedRows.push(id);
           }
        };
        
//    alert(id_multiple);
var grid_opts = {
//        url : "getDataForMultipleChoice/?id="+id_multiple+'?direction_id='+ id_direction,
        url : "getDataForMultipleChoice",
        datatype : 'json',
        width : '750',
        height : '480',
        mtype : 'POST',
        postData : {'multiple_id' : id_multiple, 'direction_id' : id_direction},
//        colNames : [ 'ID','Тип Записи','Тип','Группа','Подгруппа','Наименование','Код','Прайс','Комментарий','Статья Затрат','Код Статьи' ],
        colNames : [ 'ID','Наименование'],
        colModel : [
        { name : 'id', index : 'id', width : 20, hidden:true },
        { name : 'name', index : 'name', width : 250, sortable:true }             /* Наименование */
],
        multiselect: true,
        pager : null,
        rowNum : 1000000,
        gridview: true,
        rownumbers: true,
        onSelectRow: updateIdsOfSelectedRows,
        emptyrecords: 'No URLs have been loaded for evaluation.',
        
        loadComplete: function () {
//          var arr_isset = $("#Asset_place_id").val();
//          var recs = parseInt($("#create_multiple_dialog_table").getGridParam("records"),10);          
//          var recs = parseInt($("#create_multiple_dialog_table").getGridParam("records"));          
          //firstLoad = false;
                var _first=false;
                $("#firstLoad").data('firstLoad', _first);
          //request = true;
          //alert('1' + firstLoad + '  ' + request);

//          alert('load complete '+place_data.val());
          var arr_isset = place_data.val();
          
          if (arr_isset) {
//             idsOfSelectedRows = $("#Asset_place_id").val().split(/[,]/);;
             idsOfSelectedRows = place_data.val().split(/[,]/);;
          } 
                
           var $this = $(this), i, count;
           for (i = 0, count = idsOfSelectedRows.length; i < count; i++) {
                $this.jqGrid('setSelection', idsOfSelectedRows[i], false);
           }
        },
        
       gridComplete: function() {
          var recs = parseInt($("#create_multiple_dialog_table").getGridParam("records"),10);
//          var selId    = $("#create_multiple_dialog_table").jqGrid('getGridParam','datatype');
//        var recs = parseInt( $("#create_multiple_dialog_table").getGridParam("records"),10);
//          alert (selId+ ' ' + recs);
//        alert ('gridComplete!  Записей: ' + recs);

        /*
        var count = $("#create_multiple_dialog_table").getGridParam();        
        var ts = grid[0];
        
        if (ts.p.reccount === 0) {
             $("#create_multiple_dialog_table").hide();
             emptyMsgDiv.show();
        } else {
             $("#create_multiple_dialog_table").show();
             emptyMsgDiv.hide();
        }
        */
/*        
        if (isNaN(recs) || recs == 0) {
            $("#gridWrapper").hide();
        }
        else {
            $('#gridWrapper').show();
            alert('records > 0');
        }
*/
        
    },
    
  
//        rowList : [ 50, 100, 500, 1000 ],
        sortname : 'name',
        sortorder : 'asc',
//        recordtext: 'Товар(ы) {0} - {1}',
//        viewrecords : true,
        caption : false,
//        toppager: false,

//        rowList: [],         // disable page size dropdown
        pgbuttons: false,      // disable page control like next, back button
        pgtext: null,          // disable pager text like 'Page 0 of 10'
        viewrecords: false,    // disable current view record text like 'View 1-10 of 100'    
        loadonce: true,         // to enable sorting on client side
 
        loadui: 'disable'

};
 var LoadGrid = function () {

    $("#create_multiple_dialog_table").jqGrid( grid_opts );
    //$("#create_multiple_dialog_table").trigger("reloadGrid");
    //$("#cb_" + grid[0].id).hide();
    
    //emptyMsgDiv.insertAfter($("#create_multiple_dialog_table").parent());
}

/*    try {
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
*/ 

    function getTemplates() {
        
    var template_id = document.getElementById("Asset_asset_template_id").value;
        
  $.ajax({
       'type': "POST",
        'url': 'GetTemplateByAsset',
        data : {'template_id':template_id}     
        })
       .done(function(data) { 
             var response = JSON.parse(data);
         $("#asset_group_id").html('');
         $("#asset_group_id").val(response['asset_group_id']);
         $("#budget_item_id").val(response['budget_item_id']);
         $("#direction_id").val(response['direction_id']);
         $("#Asset_direction_id_val").val(response['direction_id_val']);
         $("#ware_type_id").val(response['ware_type_id']);
         $("#info").val(response['info']);
             
            });

/*        var url = 'GetTemplateByAsset/?template_id='+ template_id;
        request.open("GET", url, true);
        request.onreadystatechange = updateTemplates;
        request.send(null);
*/
    }
/*    function updateTemplates() {

      if (request.readyState == 4) {
            if (request.status == 200) {
                
         var response = JSON.parse(request.responseText);
         $("#asset_group_id").html('');
         $("#asset_group_id").val(response['asset_group_id']);
         $("#budget_item_id").val(response['budget_item_id']);
         $("#direction_id").val(response['direction_id']);
         $("#direction_id_val").val(response['direction_id_val']);
         $("#ware_type_id").val(response['ware_type_id']);
         $("#info").val(response['info']);
         
         alert("direction_id " + response['direction_id_val']);
       } else
         alert("status is " + request.status);
     }
   }
*/

function send(id_multiple_param){
    id_multiple=id_multiple_param;            //set global var
    
//    if(sel_) id_ = $("#create_multiple_dialog_table").getCell(sel_, 'id');

      id_direction = $("#Asset_direction_id_val").val();
      if(id_direction) {

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
    
 //   alert(strtitle);
 //   alert(id_multiple_param);
    
    idsOfSelectedRows.length = 0;
//    $("#create_multiple_dialog_table").jqGrid('setGridParam', {url: 'ggetDataForMultipleChoice?id='+id_multiple_param}).trigger('reloadGrid');
    //$("#create_multiple_dialog_table").jqGrid('GridUnload');
    
      //$("#create_multiple_dialog_table").jqGrid('setGridParam',{datatype:"json", postData : {'multiple_id' : id_multiple, 'direction_id' : id_direction}});     
      //alert(grid);
      //if (!firstLoad) {
          //$("#create_multiple_dialog_table").trigger("reloadGrid");
          //alert ('2 '+firstLoad + '  ' + request);
  //    }
//var selId;
//var _first = $("#firstLoad").data("firstLoad");
//alert("child "+_first);
                //$("#create_multiple_dialog_table").jqGrid('clearGridData');
                //$("#create_multiple_dialog_table").jqGrid('setGridParam',{datatype:"json", postData : {'multiple_id' : id_multiple, 'direction_id' : id_direction}});
                $("#create_multiple_dialog_table").jqGrid('GridUnload');
                grid_opts['datatype']="json";
                grid_opts['postData']={'multiple_id' : id_multiple, 'direction_id' : id_direction};
                //$("#create_multiple_dialog_table").jqGrid(grid_opts);
                var arr = new String(grid_opts);
                
                //alert(arr);
                LoadGrid();
                $("#create_multiple_dialog_table").trigger("reloadGrid");
        //if(!_first){
                //selId = $("#create_multiple_dialog_table").jqGrid('getGridParam','datatype');
                //alert(selId);
                //$("#create_multiple_dialog_table").trigger("reloadGrid");
            
        //}
        //else
        /*
            {
                selId = $("#create_multiple_dialog_table").jqGrid('getGridParam','datatype');
                alert(selId);
                LoadGrid();
            }
    */

//      $("#create_multiple_dialog_table").setGridParam({datatype:"json", url:"getDataForMultipleChoice/?id="+id_multiple+'?direction_id='+ id_direction}).trigger("reloadGrid");
    //$("#create_multiple_dialog_table").setGridParam({datatype:"json", url:"getDataForMultipleChoice/?id="+id_multiple+'?direction_id='+ id_direction}).trigger("reloadGrid");

//    $("#create_multiple_dialog_table").trigger("reloadGrid");
    
    
    //var parent_ = id_;
    
             	$("#create_multiple_dialog").dialog({
             		title: strtitle,
                        modal:true,
                        width:800,
                        height:600,
                        zIndex: $.maxZIndex()+ 1,
                        buttons:{
                            'OK': function(){
                            var asset_id = $("#create_dialog").data("parent_id");
                        
//     alert(idsOfSelectedRows);
//                               alert(asset_id);

//                            alert(asset_id+"   "+idsOfSelectedRows);
                 $.ajax({
                  'type': "POST",
                   'url': 'editMultipleChoice',
                   data : {'id':asset_id, 'multiple_arr': idsOfSelectedRows,'type_data':id_multiple}
                  }).done(function (data){

                       var contact = JSON.parse(data);
                       
//                      $("#place_id_selector").html(contact.text_plase);
//                      $("#Asset_place_id").val(contact.data_plase);
                      place_text.html(contact.text_place);
                      place_data.val(contact.data_place);
                      
//                      $("#Asset_place_id").append(contact.data_plase);
//                      alert(contact);
//                      alert(contact.text_plase);
//                      alert(contact.data_plase);

                  });


/*                           
  var options = {
//                success: function(data){alert(data);},
     url: 'editMultipleChoice/?id='+asset_id+'&plase_arr='+idsOfSelectedRows,
     type: 'post',
     dataType: 'json',
     error: function(res, status, exeption) {
            alert("error:"+res.responseText);
     },
     success:  function(data) {

     var status = data['status'];
                			
     if(status=="ok"){
         
       $("#create_multiple_dialog_table").setGridParam({datatype:'json'});
       rd = data['rows'][0]['cell'];     //row data
					 //!!! OMG, why it uses only associated array!?
					 //TODO: try to make for cycle...
       $("#create_multiple_dialog_table").jqGrid('setRowData',sel_,{'type':rd[1],'supergroup':rd[2],'group':rd[3],'name':rd[4],'part_number':rd[5],'cost':rd[6],'comment':rd[7],'article':rd[8],'article_code':rd[9],'cell_red':rd[10]});
       $("#create_dialog").dialog('close');

      }
      else if(status=="err"){
	      alert("error:"+data['message']);
      }
      
      else
      {
        var response= jQuery.parseJSON (data);

        $.each(response, function(key, value) { 
            $("#"+key+"_em_").show();
            $("#"+key+"_em_").html(value[0]);
        });
      }
      
      }
}; 

*/
//                                alert($("#create_multiple_dialog_table").val());
//                                $response = $("#asset-form").submit();
                                 $(this).dialog('close');
                               },
                            'Отмена': function(){
                                $(this).dialog('close');
                            }
                        }

                    });

    } else alert('Выберите шаблон!');   // end if(id_direction)

}

    //LoadGrid();

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
		<td align="left"><?php echo CHtml::textField('direction_id', $model->assettemplate->direction_id > 0 ? $model->assettemplate->direction->short_name: "" , array('size'=>8,'disabled'=>true)); 
                                      // if ($model->asset_template_id) 
                                      echo $form->hiddenField($model,'direction_id_val', array('value'=>$model->asset_template_id  > 0 ? $model->assettemplate->direction_id:'', 'style'=>'display: none;')); 
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
		<td align="left"><?php echo CHtml::textField('ware_type_id',$model->assettemplate->waretype->short_name, array('size'=>8,'disabled'=>true)); ?></td>
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
		<td colspan="5"><?php 
                 echo $form->dropDownList($model,'budget_item_id', CHtml::listData(BudgetItem::model()->get3LevelAllNameBudgetItemOptionList(),'ID','NAME'), array('empty' => '<Выбор статьи бюджета>'));
//                 echo $form->dropDownList($model,'budget_item_id',  BudgetItem::model()->get3LevelAllNameBudgetItem(),array('empty' => '<Выбор статьи бюджета>'));
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
                                      echo $form->hiddenField($model,'place_id', array('value'=>$model->place_id, 'style'=>'display: none;')); ?></td>
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
                                      echo $form->hiddenField($model,'product_id', array('value'=>$model->product_id, 'style'=>'display: none;')); ?></td>
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

        <?php /*  echo $form->dropDownList($model, 'parent_id', 
                CHtml::listData(Section::model()->getList()->getData(), 'id', 'title'), 
                array('encode' => false, 
                      'onchange'=>Chtml::ajax(array('type'=>'POST','url' => CController::createUrl('sectionType'),
                      'update' => '#'.CHtml::activeId($model, 'comments_allowed'))),
                      'empty'=>t('Выберите раздел для публикации'))); 
         */ ?>
    <?php // echo $form->checkBox($model, 'comments_allowed',  array()); ?>

    
<?php $this->endWidget(); ?>
<div id="create_multiple_dialog" style="display: none;">
    <div id="resurection">
<table id="create_multiple_dialog_table">
</table>
    </div>
</div>
</div><!-- form -->