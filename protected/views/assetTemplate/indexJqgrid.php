<?php
$cs = Yii::app()->clientScript;
 
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
 
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<style type="text/css">
        .ui-jqgrid tr.jqgrow td {
            word-wrap: break-word; /* IE 5.5+ CSS3 see http://www.w3.org/TR/css3-text/#text-wrap */
            white-space: pre-wrap; /* CSS3 */
            white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
            white-space: -pre-wrap; /* Opera 4-6 */
            white-space: -o-pre-wrap; /* Opera 7 */
            overflow: hidden;
            height: auto;
            vertical-align: middle;
            padding-top: 3px;
            padding-bottom: 3px
        }
    </style>

<script type="text/javascript">
   $.jgrid.no_legacy_api = true;
   $.jgrid.useJSON = true;
</script>

<table id="list"></table> 
<div id="pager"></div> 


<script type="text/javascript">
$(function() {
    var grid=$("#list")
    grid.jqGrid( {
        url : 'getDataForGrid',
        datatype : 'json',
        width : '1160',
        height : 'auto',
        mtype : 'GET',
        colNames : ['ID','Название','Статья Затрат','Код Статьи','Инфо','Комментарий'],
        colModel : [
            {name:'id',index:'id', width:20, hidden:true},
            {name:'name', index:'group', width:150},
            {name:'article',index:'article', width:75},
            {name:'article_code',index:'article_code', width:50},
            {name:'info',index:'info', width:100},
            {name:'comment',index:'comment', width:100},
        ],
        caption : 'Шаблоны',
//        rowList:[15,30,50],
        rowNum : 0,
        viewrecords: false,
        sortorder: "asc",
        sortname: "name",
        pager: '#pager',

        treeGrid: true,
        treeGridModel: 'adjacency',
        ExpandColumn: 'name',

//        subGrid: true,

/*        subGridRowExpanded: function (subgridDivId, rowId) {
            var cont = $('#list').getCell(rowId, 'id');
            var subgridTableId = subgridDivId + "_t";
            $("#" + subgridDivId).html("<table >" + 
                "<tr><td><b>First Name</b></td></tr>" + 
                "</table>");
        },
    	loadError: function(xhr, status, error) {alert(status +error)}
*/

gridComplete: function()
{
	var data=grid.jqGrid('getRowData');
	alert("!");
}

    }).navGrid('#pager',{search:false, view:false, del:true, add:true, edit:false, cloneToTop:true});

grid.jqGrid('navSeparatorAdd','#pager');
		function after_restore(rowid) {
			if(new_node){
//				alert(rowid);
//				grid.delTreeNode(rowid);
			}
		};

		function add_success(rowid, response) {
//			if(new_node){
//				alert("!");
//			}
		};

		function after_save(rowID, response ) {
//			  var ret_iddb = $.parseJSON(response.responseText);
//			  alert(ret_iddb);
//			  grid.jqGrid('setCell',rowID,'iddb',ret_iddb);
		  }



});


</script>
