<?php
$cs = Yii::app()->clientScript;
 
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
 
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jqModal.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jqDnR.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');

$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js');

$this->breadcrumbs=array(
	'Товары',
);
?>


<script type="text/javascript">
$(document).ready(function(){
  $('#Asset_cost').live('change', function () {
    var my_id = "";
    $(this).next().each(function(){my_id = this.value });
    var q ='?r=asset/UpdateGrid&id='+my_id;
    jQuery.ajax({'url'    :q,
                 'data'   :{'Asset[cost]':$(this).val()},
                 'type'   :'post',
                 'success':function(){alert('Поле обновлено');},
                 'error'  :function(){alert('error');},
                 'cache'  :false});
  })
});
</script> 


<script type="text/javascript">
   $.jgrid.no_legacy_api = true;
   $.jgrid.useJSON = true;
</script>
<div id="direction_choser">
Направление:<span id="dir_select"></span>
</div>
<table id="list"></table> 
<div id="pager"></div> 


<script type="text/javascript">
$(function() {
    var lastSel;
    jQuery("#list").jqGrid( {
        url : 'getDataForGrid',
        datatype : 'json',
        width : '900',
        height : 'autoheight',
        mtype : 'GET',
        colNames : [ 'ID', 'Группа', 'Подгруппа','Тип','Наименование', 'Прайс', 'Код', 'Статья Б.' ],
        colModel : [
        { name : 'id', index : 'id', width : 20, hidden:true},
        { name : 'supergroup', index : 'supergroup', width : 150 }, 
        { name : 'group', index : 'group', width : 150 }, 
        { name : 'type', index : 'type', width : 30 }, 
        { name : 'name', index : 'name', width : 150 },
        { name : 'price', index : 'price', width : 50 }, 
        { name : 'code', index : 'code', width : 50 }, 
        { name : 'article', index : 'article', width : 150 }, 
        ],
        pager : '#pager',
        rowNum : 0,
        rowList : [ 10, 20, 50, 100, 500, 1000 ],
        sortname : 'name',
        sortorder : 'asc',
//        viewrecords : true,
        caption : 'Товары',

//  loadonce: true, // to enable sorting on client side

/*
  grouping:true, 
  groupingView : { 
     groupField : ['supergroup','group'],
     groupOrder : ['asc','asc'],
     groupText : ['<b>{0}</b>','<b>{0}</b>'],
     //groupColumnShow : [false,false],
     groupCollapse : [true],
     groupSummary: [false,false]
  },
  */

    /*             	
    loadonce: true, // to enable sorting on client side
	sortable: true, //to enable sorting

gridComplete: function () {
$("#list").setGridParam({datatype:'local'});
},

onPaging : function(which_button) {
$("#list").setGridParam({datatype:'json'});
}
*/

	/*loadComplete: function() {
    	jQuery("#list").trigger("reloadGrid"); // Call to fix client-side sorting
	}*/
	
   
/*	    
        ondblClickRow: function(id) {
            if (id ) { //&& id != lastSel
                jQuery("#list").restoreRow(lastSel);
                jQuery("#list").editRow(id, true);
                lastSel = id;
            }
            
        },
*/
        
//        editurl: 'index.php/?r=assetGroup/updateRow'

    }).navGrid('#pager',{view:false, del:false, add:true, edit:false},
      {
        
      }, // default settings for edit
      {

      }, // default settings for add
      {}, // delete instead that del:false we need this
      {
          closeOnEscape:true, multipleSearch:true, closeAfterSearch:true,
          sopt:['eq','cn']
      }, // search options

      {
      } /* view parameters*/
      );

      $("#dir_select").load('getDirectionsForSelect');
      $("#dir_select").change(function(){
      	alert("!");
      });

});
</script>


<?php echo CHtml::link('Добавить товар', Yii::app()->createUrl("asset/create"))?>