<?php

//$cs = Yii::app()->clientScript;
// 
//$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
//$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
// 
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');

?>

<style type="text/css">
      th.ui-th-column div {
            /* see http://stackoverflow.com/a/7256972/315935 for details */
            word-wrap: break-word;      /* IE 5.5+ and CSS3 */
            white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
            white-space: -pre-wrap;     /* Opera 4-6 */
            white-space: -o-pre-wrap;   /* Opera 7 */
            white-space: pre-wrap;      /* CSS3 */
            overflow: hidden;
            height: auto !important;
            vertical-align: middle;
        }
        .ui-jqgrid tr.jqgrow td {
            white-space: normal !important;
            height: auto;
            vertical-align: middle;
            padding-top: 2px;
            padding-bottom: 2px;
        }
        .ui-jqgrid .ui-jqgrid-htable th.ui-th-column {
            padding-top: 2px;
            padding-bottom: 2px;
        }
        .ui-jqgrid .frozen-bdiv, .ui-jqgrid .frozen-div {
            overflow: hidden;
        }

     #whole-claim-form table {
     	margin-bottom: 0; /*0.2em;*/
     	font-size: 11px !important;
     }
     #whole-claim-form table th, #whole-claim-form table td {
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

<h1>Заявка #<?php echo $model->claim_number.' '.$model->state->stateName->name; ?></h1>

<div class="form">



<script type="text/javascript">
    var request = false;
    try {
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
 
    function getDepartments() {
        var division_id = document.getElementById("Claim_division_id").value;
        var url = 'getDepartmensByDivision/?division_id='+division_id;
        request.open("GET", url, true);
        request.onreadystatechange = updateDepartments;
        request.send(null);
    }
    function updateDepartments() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                
         var response = JSON.parse(request.responseText);
         $("#Claim_department_id").html('');
         $("#Claim_department_id").prepend('<option value=""><Выберите подразделение></option>');
         $.each(response, function(key,value){
             $("#Claim_department_id").append('<option value="'+key+'">'+value+'</option>');
         })
         
       } else
         alert("status is " + request.status);
     }
   }
</script>
    
<? $this->renderPartial('claim_add_form',array('model'=>$model),false,true);?>

<table id="claim_line_list"></table> 
<div id="pager_"></div> 

<div id="create_multiple_dialog" style="display: none;">
        
<table id="create_multiple_dialog_table"></table>
</div>

<!-- <div id="edit_dlg"></div> -->

<script type="text/javascript">
    
    var firstload=true;
    var selected,seldata;
    var plsel= function place_selector_grid_clk(parent_e)
    {
      
       grid_opts = {
//        url : "getDataForMultipleChoice/?id="+id_multiple+'?direction_id='+ id_direction,
//        url : "getDataForMultipleChoice",
        datatype : 'local',
        width : '750',
        height : '480',
        data:<?echo Helpers::BuildSpecificationsGridList(Place::model()->findAllTowns(), array('id','title'));?>,
//        mtype : 'POST',
//        postData : {'multiple_id' : id_multiple, 'direction_id' : id_direction},
//        colNames : [ 'ID','Тип Записи','Тип','Группа','Подгруппа','Наименование','Код','Прайс','Комментарий','Статья Затрат','Код Статьи' ],
        colNames : [ 'ID','Наименование'],
        colModel : [
        { name : 'id', index : 'id', width : 20, hidden:true},
        { name : 'title', index : 'title', width : 250, sortable:true }             /* Наименование */
    ],
        multiselect: false,
        pager : null,
        rowNum : 1000000,
        gridview: true,
        rownumbers: false,
        onSelectRow: function(rowid){
            selected=rowid;
            //alert('selected on select = '+rowid);
        },
        emptyrecords: 'No URLs have been loaded for evaluation.',
        loadComplete: function () {
            //alert('loaded');
//            alert(cell);
//        var _first=false;
//        $("#firstLoad").data('firstLoad', _first);
         // var arr_isset = place_data.val();
          /*
          if (arr_isset) {
             idsOfSelectedRows = place_data.val().split(/[,]/);
          }   
           var $this = $(this), i, count;
           for (i = 0, count = idsOfSelectedRows.length; i < count; i++) {
                $this.jqGrid('setSelection', idsOfSelectedRows[i], false);
           }*/
        },
       gridComplete: function() {
            var cell = $("#claim_line_list").getCell(parent_e,'position_ids');
            $('#create_multiple_dialog_table').jqGrid('setSelection', cell, true);
//            var pos_id = $(parent_e.target).val();
//            alert(parent_e.data);
                /*
                var $td = $(parent_e.target).closest('td'),
                                text = $td.text(),
                                $tr = $td.closest('tr'),
                                rowid = $tr[0].id;
                                alert(rowid);
        */
       //parent_e.replace('?id=','');
      // var v = parseInt(parent_e, 10);
       //alert(v);//
//           $('#create_multiple_dialog_table').jqGrid('setSelection', pos_id, true);
        },
        sortname : 'title',
        sortorder : 'asc',
        caption : false,
        pgbuttons: false,      // disable page control like next, back button
        pgtext: null,          // disable pager text like 'Page 0 of 10'
        viewrecords: false,    // disable current view record text like 'View 1-10 of 100'    
        loadonce: true,         // to enable sorting on client side
        loadui: 'disable'
};
LoadGrid(grid_opts);
        $("#create_multiple_dialog").dialog(
            {
                title: 'Выбор расположения',
                modal:true,
                width:800,
                height:600,
                zIndex: $.maxZIndex()+ 1,
                buttons:{
                    'OK': function(){
                        
                        //don`t work at second time open dialog
                        //selected = $('#create_multiple_dialog_table').jqGrid('getGridParam','selrow');
                        seldata = $('#create_multiple_dialog_table').jqGrid('getRowData',selected);
                        //alert(seldata.id);
                        //alert(seldata.title);
//                        var rowid = $grid.getGridParam('selrow');
                        $("#claim_line_list").setCell(parent_e,'position_ids',seldata.id);
                        $("#claim_line_list").setCell(parent_e,'position',seldata.title);
//                        var pl_rows =[];
//                        $.each(s,function(rk,rv){
//                           pl_rows.push($('#create_multiple_dialog_table').jqGrid('getRowData',rv));
//                        });
//                        
//                        pl_rows=JSON.stringify(pl_rows);
//                        var rowid = $grid.getGridParam('selrow');
//                        
//                        
//                        $grid.setCell(rowid,'position',pl_rows);
                        //$('#create_multiple_dialog_table').jqGrid('GridUnload');
                        $(this).dialog('close');
//                        alert('ok');
                    }
                }
            }
        );
    };
        
//Обрабатываем клик по кнопке "добавить" расположение
function LoadGrid (grid_opts_param) {
//alert(JSON.stringify(grid_opts));

        $("#create_multiple_dialog_table").jqGrid('GridUnload');
        $("#create_multiple_dialog_table").jqGrid('clearGridData');
        $("#create_multiple_dialog_table").jqGrid(grid_opts_param);

//$("#cb_" + grid[0].id).hide();
    
    //emptyMsgDiv.insertAfter($("#create_multiple_dialog_table").parent());
}
$(function() {

//	$([document, window]).unbind('.dialog-overlay');     // temporary solve issue when pressing ESC in inline-edit jqgrid closes the whole dialog
    //var grid_opts;
    var $grid=$("#claim_line_list");

function fill_pane(id)
{
                $(".hint").html("");
                var _m;
    var hint = $grid.getCell(id, 'asset_info');
    $grid.setColProp('name',{formatter:null});
    var name = $grid.getCell(id, 'name');
    $grid.setColProp('name',{formatter:"select"});
    var count = $grid.getCell(id, 'count');
    var unit = $grid.getCell(id, 'unit');
    var amount = $grid.getCell(id, 'amount');
    if(_msg=="[]"||_msg=="[") _m=""; else _m=_msg;
    $(".hint").html('<div><b>'+name+_m+'&nbsp;&nbsp;&nbsp;<span style="color:blue;">'+count+'</span>&nbsp;'+unit+'&nbsp;<span style="color:blue;">'+amount+'</span></b>&nbsp;-&nbsp;<span style="color:red;">'+hint+'</span></div>');
    _msg="[";
};
	function calc_amount(id)
	{
            var count = $grid.getCell(id, 'count');
            var cost = $grid.getCell(id, 'cost');
            var amount = count*cost;
            $grid.setCell(id, 'amount', amount);
	};
        
        function unformat_field(cellvalue, options, cell)
        {
                     return cellvalue;
        };
        
        function delclaimlinerow(rowid)
        {
          var x=$grid.getCell(rowid,'iddb');
          deletedrows.push(x);
          $('#claim_line_list').data('deletedrows',deletedrows);
          $grid.delRowData(rowid);
        };


        
    var pager_selector = "#pager_";
    var worker_id;
    var asset_id;
    var new_line_added=false;
    var deletedrows=[];
   	var _msg="[";
    var lastSel;
    $grid.jqGrid( {
//        url : "getDataForSubGrid?claim_id="+<?php // echo $model->id ?>,
        url : "<?echo Yii::app()->createUrl('claim/getDataForDialogGrid',array('claim_id'=>$model->id))?>",
        datatype : 'json',
        height : '295',
        width : '1070',
        mtype : 'GET',
        shrinkToFit : false,
        loadonce:true,
        colNames: ['ID','Тип','Наименование','Ед.изм','Кол-во','Цена','Сумма',
            'Группа','Цель','Для кого','Для кого','Характеристики','','Продукты','','Расположение','','Примечание','ЦФО','Бизнес',
            'Статья бюджета','Статус',
            'Информация', 'Добавлена'],
        colModel: [

            //TODO: formatter - numeric fields!

            {name: 'iddb',index:'iddb', width:20, hidden:true, frozen:false},
            {name: 'type', width: 25, frozen: false, /*editable:true,*/ edittype:'select',formatter:"select", editrules:{number:true}, editoptions: {value:<?echo Helpers::BuildEditOptions(WareType::model(), array('key'=>'id','value'=>'short_name'))?>} },
            {name: 'name',index:'name', width:220, frozen: false, editable:true, edittype:'select',formatter:"select", editoptions: {value:<?echo Helpers::BuildEditOptions(Asset::model(), array('key'=>'id','value'=>'name'),'name')?>,
            
            				dataInit: function (elem) {
                                var v = $(elem).val();
                                asset_id = v;
                                //alert(v);
                            },
			dataEvents: 
			[
                   {
                       type: 'change',
                       fn: function(e) {
                       		//var v = parseInt($(e.target).val(), 10);
                       		asset_id = $(e.target).val();
                       }
                   }
            ],            
            defaultValue:'222'
            
            }//editoptions
            },//column
            {name: 'unit', width: 40, frozen:false, /*editable:true,*/ edittype:'select', formatter:"select", unformat:unformat_field, editoptions: {value:<?echo Helpers::BuildEditOptions(Unit::model(), array('key'=>'id','value'=>'sign'))?>} },
            {name: 'count', width: 40, frozen:false, editable:true},
            {name: 'cost', width: 40, frozen:false, editable:true},
            {name: 'amount', width: 60, frozen:false }, //calculated!
            {name: 'assetgroup', width: 120, frozen:false,/* editable:true,*/ edittype:'select',formatter:"select",editoptions: {value:<?echo Helpers::BuildEditOptionsWithModel(AssetGroup::model()->getGroupSubgroupStrings(), array('key'=>'id','value'=>'name'))?> } },
            {name: 'goal', width: 60, frozen:false },              //findWorkersWithStaff
            {name: 'for_whom', width: 150, frozen:false, editable:true, edittype:'select', formatter:"select", editoptions: {value:<?echo Helpers::BuildEditOptionsWithModel(Worker::model()->findWorkersWithStaff(), array('key'=>'ID_EMP','value'=>'LASTNAME'))?>,

            				dataInit: function (elem) {
                                var v = $(elem).val();
                                worker_id = v;
                                //alert(v);
                            },
			dataEvents: 
			[
                   {
                       type: 'change',
                       fn: function(e) {
                       		//var v = parseInt($(e.target).val(), 10);
                       		worker_id = $(e.target).val();
                       }
                   }
            ]            
            }//editoptions
            },
            {name: 'for_whom_div', width: 220, frozen:false },
            {name: 'features', width: 100, frozen:false },
            {name: 'features_ids',hidden:true},
            {name: 'products', width: 100, frozen:false },
            {name: 'products_ids', hidden:true},
            {name: 'position', width: 150, frozen:false,
//                        formatter: 'showlink', formatoptions: {
//                        baseLinkUrl: 'javascript:',
//                        showAction: "place_selector_grid_clk('",
//                        idName:'iddb',
//                        addParam: "');"
//                }  
            formatter:function(cellvalue,options,rowObject) {
                return "<a href=\"javascript:plsel("+options.rowId+")\">"+cellvalue+"</a>";
            },
            unformat: function(cellvalue, options, cellobject) {
            return cellvalue;
                }

            },
            {name:'position_ids',hidden:true},
            {name: 'description', width: 110, frozen:false, editable:true, edittype:'text' },
            {name: 'payer', width: 70, frozen:false, editable:true, edittype:'select', formatter:"select", editoptions: {value:<?echo Helpers::BuildEditOptions(Division::model(), array('key'=>'ID','value'=>'NAME'),'CODE')?>} },
            
            {name: 'business', width: 100, frozen:false, editable:true, edittype:'select', formatter:"select", editoptions: {value:<?echo Helpers::BuildEditOptionsWithModel(Business::model()->findBusinessesOptionList(), array('key'=>'ID','value'=>'NAME'))?>} },
            {name: 'budget_item', width: 200, frozen:false, editable:true, edittype:'select', formatter:"select", editoptions: {value:<?echo Helpers::BuildEditOptionsWithModel(BudgetItem::model()->get3LevelAllNameBudgetItemOptionList(), array('key'=>'ID','value'=>'NAME'))?>}  },
            {name: 'status', width: 50, frozen: false, editable:true, edittype:'select', formatter:"select", editoptions: {value:<?echo Helpers::BuildEditOptions(Status::model(), array('key'=>'id','value'=>'short_name'))?>} },
            {name: 'asset_info', width: 300, frozen:false, hidden:true},
            {name: 'created', width: 100, frozen:false, /*editable:true,*/ edittype:'select', formatter:"select", editoptions: {value:<?echo Helpers::BuildEditOptions(CreationMethods::model(), array('key'=>'id','value'=>'name'))?>} }
        ],
        pager: pager_selector,
        pgbuttons: false,     // disable page control like next, back button
        pgtext: null,  
        viewrecords: false,
        loadComplete: function () {
            $grid.setGridParam({datatype:'local'});
            //$grid.setGridParam({});
            ////проверка статуса при удалении, пока отключаем
           <? //if ($model->id) :?> 
           //var state = <?// echo $model->state->id;?>;
//           if(state !== 1 & state !==5) 
//           {
//                var gid = $grid.jqID($grid.id);
                //var $td = $('#del_claim_line_list');
               // $td.hide();
//           }
           <?//endif;?>
           $(".ui-dialog-buttonpane").append('<div class="hint"></div>');
            
        },
                //----------------------------------------------------
                beforeSelectRow: function (rowid) {
                    if ((rowid !== lastSel)&&(!new_line_added)) { //
                        $(this).jqGrid('restoreRow', lastSel);
						$(".ui-dialog-buttonpane button:contains('OK')").attr("disabled", false).removeClass("ui-state-disabled");
                        //fixPositionsOfFrozenDivs.call(this);
                       	fill_pane(rowid);
                        lastSel = rowid;
                    } 
                    if ((rowid!=lastSel)&&new_line_added) {
   	                    		$grid.delRowData(lastSel);
	                    		new_line_added=false;
                    }

                    
                    return true;
                },
                //----------------------------------------------------
                // 
                
         gridComplete: function() {
            $('.imgclickable').click(function(rowid) {
              //  this.parentNode.click();
              place_selector_grid_clk(rowid);
            });
        },       
                
        ondblClickRow: function (rowid, iRow, iCol, e) {

            	$grid.setGridParam({editurl:'#'});
                $(".ui-dialog-buttonpane button:contains('OK')").attr("disabled", true ).addClass("ui-state-disabled");

                    $(this).jqGrid('editRow', rowid, true, function () 
                        {
                            $('#'+rowid+'_name').focus(); //
                    	},
                    	null,
                    	'',
                    	null, 
                    	function(){/*aftersave*/
	
         $.ajax({
        url: "findWorkerDepForList?id="+worker_id
            })
            .done(function(data) { 
				$grid.setCell(rowid,'for_whom_div',data);
            });
         $.ajax({
        url: "getAssetFieldsForGrid?asset_id="+asset_id
            })
            .done(function(data) { 
            	var xdata = $.parseJSON(data);
				$grid.setCell(rowid,'unit',xdata["unit_id"]);
				$grid.setCell(rowid,'type',xdata["ware_type_id"]);
				$grid.setCell(rowid,'assetgroup',xdata["asset_group_id"]);
				$grid.setCell(rowid,'asset_info',xdata["info"]);

				if(xdata["quantity_type_id"]!=1)
				{
					$grid.setCell(rowid,'count',xdata["quantity"]);
					_msg+="К";
				}
				if(xdata["price_type_id"]!=2)
				{
					$grid.setCell(rowid,'cost',xdata["cost"]);
					_msg+="Ц";
				}
				_msg+="]";

                    		calc_amount(rowid);
                    		fill_pane(rowid);
                    		new_line_added=false;
					
				//if(_msg!="") alert(_msg);
            });
            $(".ui-dialog-buttonpane button:contains('OK')").attr("disabled", false).removeClass("ui-state-disabled");
                    	}, 
                    	null, 
	                    function () {/*afterrestore*/
	                    	/*fixPositionsOfFrozenDivs.call(this)*/
	                    	if(new_line_added)
	                    	{
	                    		$grid.delRowData(rowid);
	                    		new_line_added=false;
	                    	}
							$(".ui-dialog-buttonpane button:contains('OK')").attr("disabled", false).removeClass("ui-state-disabled");

	                    } 
                    );
                       // $grid.setCell(rowid,'position','<?//echo CHtml::image(Yii::app()->request->baseUrl.'/images/add.png','');?>');
                        //Устанавливаем кнопки для выбора из справочников в ячейки
                    return;
        },
       	loadError: function(xhr, status, error) {alert(status +error)}
    }).navGrid('#pager_',{view:false, add:false, del:false,  edit:false, refresh:false,search:false},{},{},{},{});

   $grid.jqGrid('navButtonAdd',pager_selector,{
            caption: '',//'Группа',
            title: 'Добавить строку',
            buttonicon: 'ui-icon-plusthick',
            onClickButton: function()
            {
            /*
            	if(new_line_added){ //catch double addition
            	               new_line_added=true;
            	               var last_row_id = $grid.getGridParam("reccount");
            	               $grid.delRowData(last_row_id);
				}*/

                $grid.jqGrid('restoreRow', lastSel);

				if(new_line_added)
				{
                        $grid.delRowData(rowid);
                        //fixPositionsOfFrozenDivs.call(this);
				}
	

               var last_row_id = $grid.getGridParam("reccount");
               lastSel=rowid=last_row_id+1;
               var row = {                      "iddb":null,
						"type":"",
						"name":"",
						"unit":"",
						"count":"",
						"cost":"",
						"amount":"",
						"assetgroup":"",
						"goal":"",
						"for_whom":"",
						"for_whom_div":"",
						"features":"",
						"products":"",
						"position":"",
						"description":"",
						"payer":"",
						"business":"",
						"budget_item":"",
						"status":"",
						"asset_info":"",
						"created":""
               		     };

             
	           	$grid.setGridParam({editurl:'#'});
				//$grid.setGridParam({datatype:'json'});

               $grid.addRowData(rowid,row,"last");
               $grid.setSelection(rowid, true);

				new_line_added=true;	

					$(".ui-dialog-buttonpane button:contains('OK')").attr("disabled", true ).addClass("ui-state-disabled");

                    $(this).jqGrid('editRow', rowid, true, function () {
//                        $("input, select, e.target").focus(); //
                        $('#'+rowid+'_name').focus(); //
                   	},
                    	null,
                    	'',
                    	null, 
                    	function(){/*aftersave*/

                    		
         $.ajax({
        url: "findWorkerDepForList?id="+worker_id
            })
            .done(function(data) { 
				$grid.setCell(rowid,'for_whom_div',data);
            });

         $.ajax({
        url: "getAssetFieldsForGrid?asset_id="+asset_id
            })
            .done(function(data) { 
            	var xdata = $.parseJSON(data);
            	var _msg="";
				$grid.setCell(rowid,'unit',xdata["unit_id"]);
				$grid.setCell(rowid,'type',xdata["ware_type_id"]);
				$grid.setCell(rowid,'assetgroup',xdata["asset_group_id"]);
				$grid.setCell(rowid,'asset_info',xdata["info"]);

				$grid.setCell(rowid,'cost',xdata["cost"]);
				$grid.setCell(rowid,'count',xdata["quantity"]);
				if(xdata["quantity_type_id"]!=1)
					_msg+="К";
				if(xdata["quantity_type_id"]!=2)
					_msg+="Ц";

				_msg+="]";
                    		calc_amount(rowid);
                    		fill_pane(rowid);
                    		new_line_added=false;
				
				//if(_msg!="") alert(_msg);
            });

					$(".ui-dialog-buttonpane button:contains('OK')").attr("disabled", false).removeClass("ui-state-disabled");
                    	}, 
                    	null, 
	                    function () {/*afterrestore*/
	                    	/*fixPositionsOfFrozenDivs.call(this)*/
	                    	if(new_line_added)
	                    	{
	                    		$grid.delRowData(rowid);
	                    		new_line_added=false;
	                    	}
							$(".ui-dialog-buttonpane button:contains('OK')").attr("disabled", false).removeClass("ui-state-disabled");

	                    } 
                    );


               //xedit(rowid,null,null,null);
               //$('#'+rowid+' .jqgrow').get(0).dblclick();

//               alert('#'+rowid+'_name');
//               $('#'+rowid+' .jqgrow').click();
//               $grid.click();

//			alert('#'+rowid+' .jqgrow');

              // $grid.trigger('jqGridDblClickRow');
//               var e = $.Event("dblclick");
//               $grid.trigger(e);


               /*
                    $(this).jqGrid('editRow', rowid, true, function () {
                        $("input, select").focus();
                    	},
                    	null,
                    	'',
                    	null, 
                    	function(){//aftersave
                    		fill_pane(rowid);
                    		calc_amount(rowid);
                    		
         $.ajax({
        url: "findWorkerDepForList?id="+worker_id
            })
            .done(function(data) { 
				$grid.setCell(rowid,'for_whom_div',data);
            });

                    	}, 
                    	null, 
	                    function () {//
                   			   $grid.delRowData(rowid);

	                    } 
                    );*/

                    return;
       

            } 
         });

 
    
    //Кнопка удаления
    $grid.jqGrid('navButtonAdd',pager_selector,{
                caption: '',//'Группа',
                title: 'Удалить строку',
                buttonicon: 'ui-icon-trash',
                onClickButton:function()
                {
                    var rowid = $grid.getGridParam('selrow');
                    if(rowid)
                    {
                        delclaimlinerow(rowid);
                    }
                    else alert('Выберите запись');
                }
    });

		function after_save(rowID, response ) 
		{
//			  var ret_iddb = $.parseJSON(response.responseText);
//			  alert(ret_iddb);
//			  $('#feature-grid-table').jqGrid('setCell',rowID,'iddb',ret_iddb.iddb);
//                          iddb=ret_iddb;
		}
                
    
});


</script>

</div><!-- form -->