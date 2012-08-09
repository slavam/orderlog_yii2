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
        width : '900',
        height : 'auto',
        mtype : 'GET',
        colNames : ['ID','Название'],
        colModel : [
            {name:'id',index:'id', width:20}, //, hidden:true},
            {name:'name',index:'name', width:100},
        ],
        caption : 'Шаблоны',
        rowList:[15,30,50],
        rowNum : 15,
        viewrecords: true,
        sortorder: "asc",
        sortname: "name",
        pager: '#pager',
        subGrid: true,
        subGridRowExpanded: function (subgridDivId, rowId) {
            var cont = $('#list').getCell(rowId, 'id');
            var subgridTableId = subgridDivId + "_t";
            $("#" + subgridDivId).html("<table >" + 
                "<tr><td><b>First Name</b></td></tr>" + 
                "</table>");
        },
    	loadError: function(xhr, status, error) {alert(status +error)}

    }).navGrid('#pager',{search:false, view:false, del:true, add:true, edit:false, cloneToTop:true});

grid.jqGrid('navSeparatorAdd','#pager');
		function after_restore(rowid) {
			if(new_node){
//				alert(rowid);
				grid.delTreeNode(rowid);
			}
		};

		function add_success(rowid, response) {
//			if(new_node){
				alert("!");
//			}
		};

		function after_save(rowID, response ) {
			  var ret_iddb = $.parseJSON(response.responseText);
//			  alert(ret_iddb);
			  grid.jqGrid('setCell',rowID,'iddb',ret_iddb);
		  }



});

//alert("!");

</script>
