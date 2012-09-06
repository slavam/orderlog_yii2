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
<table id="list"></table> 
<div id="pager"></div> 

<div style="display:none;" id="dialog-relink" title="Изменить привязку подгруппы">
<span><p>Выберите новую группу для подгруппы: </p></span>
<span id="relink"></span>
</div>


<script type="text/javascript">
$(function() {
    var lastSel;
    var sel_id;
    var new_node;
    var grid=$("#list")
    grid.jqGrid( {
        url : 'getDataForGrid',
        datatype : 'json',
        width : '1160',
        height : 'auto',
        mtype : 'GET',
        colNames : [ 'IDDB', 'Группа','Комментарий', 'Код', 'Направление' /*, ''*/  ],
        colModel : [
         { name : 'iddb',   index : 'iddb',   width : 20, hidden: true },
         { name : 'name', index : 'name', width : 150, editable: true, sortable:false, editrules:{required:true} },
         { name : 'comment', index : 'comment', width : 200, editable: true, sortable:false },
         { name : 'stamp', index : 'stamp', width : 20, editable: true, sortable:false, editrules:{required:true} },                         /* editrules:{required:true, number:true}, */
         { name : 'dir', index : 'dir', width : 50, editable: true, sortable:false, edittype: 'select', editoptions: {value:<?echo Helpers::BuildEditOptionsForGrid(Direction::model(), array('key'=>'id','value'=>'short_name'))?>}},
/*		 { name : 'btns', index : 'btns', width : 25, sortable:false,formatter:'actions', formatoptions:{keys:true,delbutton:false}},*/
        ],
        caption : 'Группы товаров',
        treeGrid: true,
        treeGridModel: 'adjacency',
        ExpandColumn: 'name',
//        ExpandColClick: true,
        rowNum : 0,
        pager: '#pager',

    	loadError: function(xhr, status, error) {alert(status +error)},

//    	gridComplete: function(){
//      		grid.setColProp('dir',{edittype:select,editoptions:{value:"AA:aa;BB:bb"}});
//		},

        ondblClickRow: function(id) {                                                                                  
            if (id && id != lastSel) { 
            	sel_id= grid.getCell(id, 'iddb');
            	new_node = false;
                grid.restoreRow(lastSel);
            	grid.jqGrid('setGridParam', {editurl:'updateRow?iddb='+sel_id});
          		var parent_ = grid.getCell(id, 'parent');
            	if(parent_=="null"||parent_=="") {
					grid.setColProp('dir',{editable:true});
            	} else grid.setColProp('dir',{editable:false});
                grid.editRow(id, true);
                lastSel = id;
            }
        }

    }).navGrid('#pager',{search:false, view:false, del:false, add:false, edit:false, cloneToTop:true, refresh:false});
//        grid.jqGrid('navSeparatorAdd','#pager');
        grid.jqGrid('navButtonAdd','#pager',{
            caption: '',//'Группа',
            title: 'Добавить группу',
            buttonicon: 'ui-icon-plusthick',
            onClickButton: function()
            {
     					var last_row_id = grid.getGridParam("reccount");
	                            var _node = {"rows":[{"id":last_row_id+1,"iddb":123456,"name":"","comment":"","stamp":"","dir":"","parent":null,"isLeaf":true,"expanded":true,"loaded":true}]};
        		                grid.jqGrid ('addChildNode',last_row_id+1, _node.rows[0].parent, _node.rows[0]);
//			                grid.setSelection(last_row_id+1, true);
                                        new_node = true; // flag delete tree node in after_resotre
                                        if (lastSel) grid.restoreRow(lastSel);
                                        grid.setColProp('dir',{editable:true});
                                        grid.jqGrid('setGridParam', {editurl:'addRow'});
                                        grid.editRow(last_row_id+1, true, null, null, null, {}, after_save, null, after_restore);
//				                lastSel = last_row_id+1 ;
            },
            //position:'last'
        });
        grid.jqGrid('navButtonAdd','#pager',{
            caption: '',//'Подгруппа',
            title: 'Добавить подгруппу',
            buttonicon: 'ui-icon-plus',
            onClickButton: function()
            {
            	var sel_ = grid.getGridParam('selrow');
            	if(sel_) {

            		var parent_ = grid.getCell(sel_, 'parent');

	            	if(parent_=="null"||parent_=="") {

            					var last_row_id = grid.getGridParam("reccount");

	                            var _node = {"rows":[{"id":last_row_id+1,"iddb":123456,"name":"","comment":"","stamp":"","dir":"","parent":sel_,"isLeaf":false,"expanded":false,"loaded":true}]};
				                grid.jqGrid ('addChildNode',last_row_id+1, _node.rows[0].parent, _node.rows[0]);
//				                grid.setSelection(last_row_id+1, true);
								new_node = true; // flag delete tree node in after_resotre

								if (lastSel) grid.restoreRow(lastSel);
								grid.setColProp('dir',{editable:false});
								grid.jqGrid('setGridParam', {editurl:'addRow?iddb='+grid.getCell(sel_, 'iddb')});
								grid.setColProp('dir',{editable:false});
				                grid.editRow(last_row_id+1, true, null, null, null, {}, after_save, null, after_restore);
//				                lastSel = last_row_id+1 ;
	            	
	            	} else alert("Выберите группу!");
            		
            	} else alert("Выберите группу!");

            },
        });
        grid.jqGrid('navButtonAdd','#pager',{
            caption: '',//'Подгруппа',
            title: 'Изменить привязку',
            buttonicon: 'ui-icon-extlink',
            onClickButton: function()
            {

            	var sel_ = grid.getGridParam('selrow');
            	if(sel_) {

           		var parent_ = grid.getCell(sel_, 'parent');

            	if(parent_!="null"&&parent_!="") {

            	 var iddb_ = grid.getCell(sel_, 'iddb');


            	 $("#relink").load('getBlocks');

            	 $("#dialog-relink").dialog({
                        height:200,
                        width:400,
                        modal:true,
                        buttons:{
                            'OK': function(){
                                //alert($("#supergroups-list").val());

                                $.ajax({
                                    'type': "POST",
                                    'url':  "relinkRow",
                                    'data': { 'iddb': iddb_,
                                        	  'block_id': $("#supergroups-list").val(),
                                    },
                                    'dataType': "json",
                                    'success': function(msg){

                                    	var rowData = grid.getRowData();
                                    	var new_parent_iddb = $("#supergroups-list").val();
                                    	var new_parent_id;
										for(var index in rowData) {
											  if(rowData[index]['iddb']==new_parent_iddb&&(rowData[index]['parent']=="null"||rowData[index]['parent']=="")) {
											   		new_parent_id = ++index;
											   		break;
											   }

										}
                                    	var rowData = grid.getRowData(sel_);
										grid.delTreeNode(sel_);
										var last_row_id = grid.getGridParam("reccount");
						                grid.jqGrid ('addChildNode',last_row_id+1, new_parent_id, rowData);
						                grid.setSelection(last_row_id+1, true);

                                    },
                                    'error': function(res, status, exeption) {
                                        alert("error:"+res.responseText);
                                    },
                                    'cache'  :false
                                });
                                
                                $(this).dialog('close');
                            },
                            'Отмена': function(){
                                $(this).dialog('close');
                            }
                        }
                    });
                } else alert("Выберите подгруппу!");
              }//if sel_
              else alert("Выберите подгруппу!");

            },
            //position:'last'
        })

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
<!--<h1>Группы товаров</h1>-->
