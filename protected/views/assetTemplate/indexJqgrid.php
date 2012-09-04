<?php
$cs = Yii::app()->clientScript;
 
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
 
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');

$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');
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

<div style="display:none;" id="create_dialog">
</div>

<table id="list"></table> 
<div id="pager"></div> 


<script type="text/javascript">
$(function() {
    var grid=$("#list")
    var pager_selector = "#pager";
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
        rowNum : 1000000,
        sortorder: "asc",
        sortname: "name",
        pager: '#pager',
        toppager:true,

        treeGrid: true,
        treeGridModel: 'adjacency',
        ExpandColumn: 'name',

    pgbuttons: false,     // disable page control like next, back button
    pgtext: null,         // disable pager text like 'Page 0 of 10'
    viewrecords: false,    // disable current view record text like 'View 1-10 of 100'

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
    loadonce: true, // to enable sorting on client side

gridComplete: function () {
grid.setGridParam({datatype:'local'});
},
//
onPaging : function(which_button) {
grid.setGridParam({datatype:'json'});
},

    }).navGrid('#pager',{search:false, view:false, del:true, add:false, edit:false, cloneToTop:true, refresh:false},
        {
        },
        {
        },
        {
            onclickSubmit:function(){
                //sel_=grid.getGridParam('selrow');
                //iddb=grid.getCell(sel_, 'iddb');
                //return {"iddb":iddb};
                alert("fuck");
            }
        },
        {
        }
    
    );

	top_bottom_pager_ButtonAdd = function(options) {
        grid.jqGrid('navButtonAdd',pager_selector,options);
        grid.jqGrid('navButtonAdd','#'+grid[0].id+"_toppager",options);
    };

    top_bottom_pager_ButtonAdd ({
            caption: '',//'Подгруппа',
            title: 'Создать шаблон',
            buttonicon: 'ui-icon-plusthick',
            onClickButton: function()
            {
	
                $("#create_dialog").load('createTemplateDlg');
             	$("#create_dialog").dialog({
             			title: 'Создать шаблон',
                        modal:true,
                        width:1160,
                        height:500,
                        buttons:{
                            'OK': function(){

var options = { 
                success: function(data){alert(data);},
                url: 'create',
                type: 'post',
                dataType: 'json',
                error: function(res, status, exeption) {
                                      alert("error:"+res.responseText);
                                    },
                success:  function(data) {

                            var status=data['status'];
                			
                			if(status=="ok"){
//                				alert("ok");
									//!!! OMG, why it uses only associated array!?
									//TODO: try to make for cycle...
//									grid.jqGrid('setRowData',sel_,{'rtype':rd[1],'type':rd[2],'supergroup':rd[3],'group':rd[4],'name':rd[5],'part_number':rd[6],'cost':rd[7],'comment':rd[8],'article':rd[9],'article_code':rd[10]});
                                  var db_ids=grid.jqGrid('getCol','id');
                                  var lvls=grid.jqGrid('getCol','level');
                                  var prnts=grid.jqGrid('getCol','parent');
                                  var rids=grid.jqGrid('getDataIDs');
                                  var start_from=0;
                                  var indx=0;
                                  //dbg
var grid_data=grid.jqGrid('getRowData');

                                  while((indx=$.inArray(data['asset_group_id'],db_ids,start_from))!=-1){
//                                  	indx++;
//									var grid_data=grid.jqGrid('getRowData',indx);

									if(lvls[indx]=="1")//(grid_data['level']=="1") //
									{
										//found sub-group by id
										//todo: insert into sorted list of templates under that group!

										//inserting row
//										var last_row_id = grid.getGridParam("reccount");
										new_row_id = $.jgrid.randId();
										//grid.addRowData(last_row_id+1, {'id':last_row_id+1,'name':data['name'],'article':data['article'],'article_code':data['article_code'],'info':data['info'],'comment':data['comment'],'parent':indx,'loaded':'true','isLeaf':'true','level':'2','expanded':'true'},"after",indx)
										grid.jqGrid ('addChildNode',new_row_id, rids[indx], {'id':data['id'],'name':data['name'],'article':data['article'],'article_code':data['article_code'],'info':data['info'],'comment':data['comment'],'parent':rids[indx],'loaded':'true','isLeaf':'true','level':'2','expanded':'false'});
//										var record = grid.getInd(grid_data['parent'],true);
										var record = grid.getInd(prnts[indx],true);
										record._id_ = record.id;//?!?!?!?!?!?!?!?
										grid.jqGrid('expandRow',record);
										grid.jqGrid('expandNode',record);
						                grid.setSelection(new_row_id, true);
										break;
									}
                                  	start_from=indx;
                                  	start_from++;
                                  }

	                			  $("#create_dialog").dialog('close');

//								    grid.trigger("reloadGrid");

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
                    },

            }; 

                $('#asset-template-form').ajaxSubmit(options); 

                                },
                            'Отмена': function(){
                                $(this).dialog('close');
                            }
                        },


                    });
/*
$.ajax({
          url: 'addAssetDialog', // вообще, не люблю такой мешанины js и php, надобно конечно url получать из тега, так универсальнее
          context: $('#create_dialog'),
          success: function(data){
            $(this).html(data); // тут важно обратить внимание на то, что вставляется полностью ответ. Если брать только какой-то див из ответа, не будут срабатывать скрипты формы.
          }
        });

        return false;*/

            },
        });


    top_bottom_pager_ButtonAdd ({
            caption: '',//'Подгруппа',
            title: 'Редактировать шаблон',
            buttonicon: 'ui-icon-pencil',
            onClickButton: function()
            {	
            	var sel_ = grid.getGridParam('selrow');
            	if(sel_) {

           		var level = grid.getCell(sel_, 'level');

            	if(level=="2") {

            	 var id_ = grid.getCell(sel_, 'id');

                $("#create_dialog").load('updateTemplateDlg/?id='+id_);
             	$("#create_dialog").dialog({
             			title: 'Редактировать шаблон',
                        modal:true,
                        width:1160,
                        height:500,
                        buttons:{
                            'OK': function(){


				var options = { 
                url: 'update/?id='+id_,
                type: 'post',
                dataType: 'json',
                error: function(res, status, exeption) {
                                      alert("error:"+res.responseText);
                                    },
                success:  function(data) {

                            var status=data['status'];
                			
                			if(status=="ok"){
//                				alert("ok");
									//!!! OMG, why it uses only associated array!?
									//TODO: try to make for cycle...
//								grid.jqGrid('setRowData',sel_,{'id':data['id'],'name':data['name'],'article':data['article'],'article_code':data['article_code'],'info':data['info'],'comment':data['comment'],'parent':indx,'loaded':'true','isLeaf':'true','level':'2','expanded':'false'});

                                  var db_ids=grid.jqGrid('getCol','id');
                                  var prnts=grid.jqGrid('getCol','parent');
                                  var lvls=grid.jqGrid('getCol','level');
                                  var rids=grid.jqGrid('getDataIDs');
                                  var start_from=0;
                                  var indx=0;
                                  while((indx=$.inArray(data['asset_group_id'],db_ids,start_from))!=-1){

//                                  	alert(indx);
//                                  	indx++;
//									var grid_data=grid.jqGrid('getRowData',indx);
									if(lvls[indx]=="1")//(grid_data['level']=="1") 
									{
//										var last_row_id = grid.getGridParam("reccount");
										new_row_id = $.jgrid.randId();
										grid.jqGrid ('addChildNode',new_row_id, rids[indx], {'id':data['id'],'name':data['name'],'article':data['article'],'article_code':data['article_code'],'info':data['info'],'comment':data['comment'],'parent':rids[indx],'loaded':'true','isLeaf':'true','level':'2','expanded':'false'});
		  				                grid.delTreeNode(sel_);
										var record = grid.getInd(prnts[indx],true);
										record._id_ = record.id;//?!?!?!?!?!?!?!?
										grid.jqGrid('expandRow',record);
										grid.jqGrid('expandNode',record);
						                grid.setSelection(new_row_id, true);
										break;
									}
                                  	start_from=indx;
                                  	start_from++;
                                  }

	                			  $("#create_dialog").dialog('close');

//								    grid.trigger("reloadGrid");

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
                    },

            }; //options


                $('#asset-template-form').ajaxSubmit(options); 
               },  //ok function
                            'Отмена': function(){
                                $(this).dialog('close');
                            }
                        },


                    });
            }//if level
            else alert("Выберите шаблон!");
            }//if sel_
            else alert("Выберите шаблон!");

            }
	
        });
		
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
