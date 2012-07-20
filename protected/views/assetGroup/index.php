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
        url : 'getDataForGrid',
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
<<<<<<< HEAD
            	$("#list").jqGrid('setGridParam', {editurl:'updateRow/iddb='+sel_id});
=======
            	$("#list").jqGrid('setGridParam', {editurl:'updateRow?iddb='+sel_id});
>>>>>>> 3be56cdb9fbdaf9e6a25ca1328ccb1df36aa8724
//            	alert(sel_id);
                jQuery("#list").restoreRow(lastSel);
                jQuery("#list").editRow(id, true);
                lastSel = id;
            }
            
        },
<<<<<<< HEAD
        editurl: 'assetGroup/updateRow'
=======
//        editurl: '/assetGroup/updateRow'
>>>>>>> 3be56cdb9fbdaf9e6a25ca1328ccb1df36aa8724


    });

});

//alert("!");

</script>
<!--<h1>Группы товаров</h1>-->
