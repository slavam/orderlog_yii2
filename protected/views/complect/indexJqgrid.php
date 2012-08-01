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
//    var lastSel;
//    var sel_id;
//    var new_node;
    var grid=$("#list")
    grid.jqGrid( {
        url : 'getDataForGrid',
        datatype : 'json',
        width : '900',
        height : 'auto',
        mtype : 'GET',
        colNames : [ 'ID', 'Тип', 'Название'],
        colModel : [
            {name:'id',index:'id', width:20, hidden:true},
            {name:'type',index:'type', width:100},
            {name:'name',index:'name', width:300},
        ],
        caption : 'Комплекты',
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
            $("#" + subgridDivId).html("<table id='" + subgridTableId + "'></table>");
            $("#" + subgridTableId).jqGrid({
                url : "getDataForSubGrid?line_id="+cont,
                datatype : 'json',
                height : 'auto',
                colNames: ['Тип', 'Название', 'Количество'],
                colModel: [
                    {name: 'c1', width: 50 },
                    {name:'name',index:'name', width:300},
                    {name: 'c3', width: 100 }
                ],
            caption : 'Строки комплекта'
            });
        },
    	loadError: function(xhr, status, error) {alert(status +error)}

//    }).navGrid('#pager',{search:false, view:false, del:true, add:true, edit:false, cloneToTop:true});
    }).navGrid('#pager',
     {view:true}, //options
      {height:290,reloadAfterSubmit:false, jqModal:false, closeOnEscape:true, bottominfo:"Fields marked with (*) are required"}, // edit options
      {height:290,reloadAfterSubmit:false,jqModal:false, closeOnEscape:true,bottominfo:"Fields marked with (*) are required"}, // add options
      {reloadAfterSubmit:false,jqModal:false, closeOnEscape:true}, // del options
      {closeOnEscape:true}, // search options
      {height: 250, jqModal: false, closeOnEscape: true} // view options
      );

        grid.jqGrid('navSeparatorAdd','#pager');
//        grid.jqGrid('navButtonAdd','#pager',{
//            caption: '',
//            title: 'Добавить комплект',
//            buttonicon: 'ui-icon-plusthick',
//            onClickButton: function()
//            {
////            					var last_row_id = grid.getGridParam("reccount");
////
////	                            var _node = {"rows":[{"id":last_row_id+1,"iddb":123456,"name":"","comment":"","stamp":"","dir":"","parent":null,"isLeaf":true,"expanded":true,"loaded":true}]};
////				                grid.jqGrid ('addChildNode',last_row_id+1, _node.rows[0].parent, _node.rows[0]);
////								new_node = true; // flag delete tree node in after_resotre
////
////								if (lastSel) grid.restoreRow(lastSel);
////								grid.setColProp('dir',{editable:true});
////								grid.jqGrid('setGridParam', {editurl:'addRow'});
////				                grid.editRow(last_row_id+1, true, null, null, null, {}, after_save, null, after_restore);
//////				                lastSel = last_row_id+1 ;
//            }
//            //position:'last'
//        });
//        

//        grid.jqGrid('navButtonAdd','#pager',{
////            caption: '',//'РџРѕРґРіСЂСѓРїРїР°',
////            title: 'Title',
//            buttonicon: 'ui-icon-plus',
//    	loadError: function(xhr, status, error) {alert(status +error)},
//            onClickButton: function()
//            {
//              alert("!!");
////            	var sel_ = grid.getGridParam('selrow');
////            	if(sel_) {
////
////            		var parent_ = grid.getCell(sel_, 'parent');
////
////	            	if(parent_=="null"||parent_=="") {
////
////            					var last_row_id = grid.getGridParam("reccount");
////
////	                            var _node = {"rows":[{"id":last_row_id+1,"iddb":123456,"name":"","comment":"","stamp":"","dir":"","parent":sel_,"isLeaf":false,"expanded":false,"loaded":true}]};
////				                grid.jqGrid ('addChildNode',last_row_id+1, _node.rows[0].parent, _node.rows[0]);
//////				                grid.setSelection(last_row_id+1, true);
////								new_node = true; // flag delete tree node in after_resotre
////
////								if (lastSel) grid.restoreRow(lastSel);
////								grid.setColProp('dir',{editable:false});
////								grid.jqGrid('setGridParam', {editurl:'addRow?iddb='+grid.getCell(sel_, 'iddb')});
////								grid.setColProp('dir',{editable:false});
////				                grid.editRow(last_row_id+1, true, null, null, null, {}, after_save, null, after_restore);
//////				                lastSel = last_row_id+1 ;
////	            	
////	            	} else alert("Р’С‹Р±РµСЂРёС‚Рµ РіСЂСѓРїРїСѓ!");
////            		
////            	} else alert("Р’С‹Р±РµСЂРёС‚Рµ РіСЂСѓРїРїСѓ!");
////
//            }
//        });
//        grid.jqGrid('navButtonAdd','#pager',{
////            caption: '',//'РџРѕРґРіСЂСѓРїРїР°',
////            title: 'РР·РјРµРЅРёС‚СЊ РїСЂРёРІСЏР·РєСѓ',
//            buttonicon: 'ui-icon-extlink',
//            onClickButton: function()
//            {
////
////            	var sel_ = grid.getGridParam('selrow');
////            	if(sel_) {
////
////           		var parent_ = grid.getCell(sel_, 'parent');
////
////            	if(parent_!="null"&&parent_!="") {
////
////            	 var iddb_ = grid.getCell(sel_, 'iddb');
////
////
////            	 $("#relink").load('getBlocks');
////
////            	 $("#dialog-relink").dialog({
////                        height:200,
////                        width:400,
////                        modal:true,
////                        buttons:{
////                            'OK': function(){
////                                //alert($("#supergroups-list").val());
////
////                                $.ajax({
////                                    'type': "POST",
////                                    'url':  "relinkRow",
////                                    'data': { 'iddb': iddb_,
////                                        	  'block_id': $("#supergroups-list").val(),
////                                    },
////                                    'dataType': "json",
////                                    'success': function(msg){
////
////                                    	var rowData = grid.getRowData();
////                                    	var new_parent_iddb = $("#supergroups-list").val();
////                                    	var new_parent_id;
////										for(var index in rowData) {
////											  if(rowData[index]['iddb']==new_parent_iddb&&(rowData[index]['parent']=="null"||rowData[index]['parent']=="")) {
////											   		new_parent_id = ++index;
////											   		break;
////											   }
////
////										}
////                                    	var rowData = grid.getRowData(sel_);
////										grid.delTreeNode(sel_);
////										var last_row_id = grid.getGridParam("reccount");
////						                grid.jqGrid ('addChildNode',last_row_id+1, new_parent_id, rowData);
////						                grid.setSelection(last_row_id+1, true);
////
////                                    },
////                                    'error': function(res, status, exeption) {
////                                        alert("error:"+res.responseText);
////                                    },
////                                    'cache'  :false
////                                });
////                                
////                                $(this).dialog('close');
////                            },
////                            'РћС‚РјРµРЅР°': function(){
////                                $(this).dialog('close');
////                            }
////                        }
////                    });
////                } else alert("Р’С‹Р±РµСЂРёС‚Рµ РїРѕРґРіСЂСѓРїРїСѓ!");
////              }//if sel_
////              else alert("Р’С‹Р±РµСЂРёС‚Рµ РїРѕРґРіСЂСѓРїРїСѓ!");
////
//            }
//            //position:'last'
//        });

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
