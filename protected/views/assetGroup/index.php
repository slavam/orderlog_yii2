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
<b>INFO: работает только редактирование названий групп/подгрупп и комментариев по двойному клику!</b>
</div>
<table id="list"></table> 
<div id="pager"></div> 


<script type="text/javascript">
$(function() {
    var lastSel;
    var sel_id;
    var subcategories = ["football", "formel 1", "physics", "mathematics"];
    jQuery("#list").jqGrid( {
        url : 'getDataForGrid',
        datatype : 'json',
        width : '900',
        height : 'auto',
        mtype : 'GET',
        colNames : [ 'IDDB', 'Группа','Комментарий', 'Код', 'Направление', '' ],
        colModel : [
         { name : 'iddb',   index : 'iddb',   width : 20, hidden: true },
         { name : 'name', index : 'name', width : 150, editable: true, sortable:false, editrules:{required:true} },
         { name : 'comment', index : 'comment', width : 150, editable: true, sortable:false },
         { name : 'stamp', index : 'stamp', width : 50, editable: true, sortable:false },
         { name : 'dir', index : 'dir', width : 50, editable: false, sortable:false },
		 { name : 'btns', index : 'btns', width : 20, sortable:false,formatter:'actions', formatoptions:{keys:true,editbutton:false}},
        ],
        caption : 'Группы товаров',
        treeGrid: true,
        treeGridModel: 'adjacency',
        ExpandColumn: 'name',
//        ExpandColClick: true,
        rowNum : 0,
        pager: '#pager',

//    	loadError: function(xhr, status, error) {alert(status +error)}

        ondblClickRow: function(id) {                                                                                  
            if (id ) { //&& id != lastSel                                                                               
            	sel_id= $('#list').getCell(id, 'iddb');
            	$("#list").jqGrid('setGridParam', {editurl:'updateRow?iddb='+sel_id});
                jQuery("#list").restoreRow(lastSel);
                jQuery("#list").editRow(id, true);
                lastSel = id;
            }
            
        },
    }).navGrid('#pager',{view:false, del:true, add:true, edit:true},
      {
                editfunc: function (rowid) {
                    alert('The "Edit" button was clicked with rowid=' + rowid);
                }
        
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


});

//alert("!");

</script>
<!--<h1>Группы товаров</h1>-->
