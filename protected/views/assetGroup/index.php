<?php
$cs = Yii::app()->clientScript;
 
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
 
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');

$this->breadcrumbs=array(
	'Группы товаров',
);

/*
$this->menu=array(
	array('label'=>'Create AssetGroup', 'url'=>array('create')),
	array('label'=>'Manage AssetGroup', 'url'=>array('admin')),
);
*/
?>
<script type="text/javascript">
   $.jgrid.no_legacy_api = true;
   $.jgrid.useJSON = true;
</script>
<div>
    <?php //include ("getDataForGrid.php");?>
</div>
<br/> 
<table id="list"></table> 
<div id="pager"></div> 


<script type="text/javascript">
$(function() {
    var lastSel;
    var sel_id;
    jQuery("#list").jqGrid( {
        url : '/assetGroup/getDataForGrid',
        datatype : 'json',
        width : '800',
        height : 'auto',
        mtype : 'GET',
        colNames : [ 'IDDB', /*'Супергруппа',*/ 'Группа' ],
        colModel : [
         { name : 'iddb',   index : 'iddb',   width : 20, hidden: true },
         { name : 'name', index : 'name', width : 150, editable: true } 
        ],
        caption : 'Группы товаров',
        treeGrid: true,
        treeGridModel: 'adjacency',
        ExpandColumn: 'name',
//        ExpandColClick: true,
        rowNum : 0,

//    	loadError: function(xhr, status, error) {alert(status +error)}

        ondblClickRow: function(id) {
            if (id ) { //&& id != lastSel
            	sel_id= $('#list').getCell(id, 'iddb');
//            	$("#list").jqGrid('setGridParam', {editurl:'index.php/?r=assetGroup/updateRow&iddb='+sel_id});
            	$("#list").jqGrid('setGridParam', {editurl:'assetGroup/updateRow&iddb='+sel_id});
//            	alert(sel_id);
                jQuery("#list").restoreRow(lastSel);
                jQuery("#list").editRow(id, true);
                lastSel = id;
            }
            
        },
//        editurl: 'index.php/?r=assetGroup/updateRow'
        editurl: 'assetGroup/updateRow'


    });

});
</script>
<!--<h1>Группы товаров</h1>-->
