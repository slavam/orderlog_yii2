<?php
$cs = Yii::app()->clientScript;
 
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
 
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');
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
</script>

<h1>Заявка #<?php echo $model->claim_number.' '.$model->state->stateName->name; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
//    'action'=>'editClaim',
    'id'=>'whole-claim-form',
    'enableAjaxValidation'=>false,
//    'enableClientValidation' => true,
)); ?>
<?php echo $form->errorSummary($model); ?>

<script type="text/javascript">
    var lastSel;
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
         $.each(response, function(key,value){
             $("#Claim_department_id").append('<option value="'+key+'">'+value+'</option>');
         })
       } else
         alert("status is " + request.status);
     }
   }
</script>
    
<table class="table_edit">
    <tr>
    	<td>
    		<table >
    		<tr>
		        <td><b>Направление</b></td>
		        <td><?php echo $form->dropDownList($model,'direction_id',Direction::model()->findDirections(),array('empty'=>'<Выберите направление>'));?> 
		            <?php echo $form->error($model,'direction_id'); ?></td>
            </tr>
            <tr>
		        <td><b>Отделение</b></td>
		        <td>
		            <?php echo $form->dropDownList($model,'division_id', Division::model()->All(),array('onChange'=>'getDepartments()','empty'=>'<Выберите отделение>'));?> 
		            <?php echo $form->error($model,'division_id'); ?>
		        </td>        
            </tr>
            <tr>
		        <td><b>Подразделение</b></td>
		        <td>
		            <?php if ($model->division_id>0) {
		                echo $form->dropDownList($model,'department_id', Department::model()->findDepartmentsByDivision($model->division_id),array('empty'=>'<Выберите подразделение>'));
		            } else {
		                echo $form->dropDownList($model,'department_id', Department::model()->findDepartments(),array('empty'=>'<Выберите подразделение>'));
		            }
		            ?> 
		            <?php echo $form->error($model,'department_id'); ?>
		        </td>
            </tr>
		    <tr>
		        <td><b>Комментарий</b></td>
		        <td>
		            <?php echo $form->textField($model,'comment',array('size'=>60)); ?>
				<?php echo $form->error($model,'comment'); ?>
		        </td>
		    </tr>
            </table>
        </td>
        <td>
        	<table>
        	<tr>
		        <td><b>Период</b></td>
		        <td><?php echo $form->dropDownList($model,'period_id', Period::model()->findPeriods(),array('empty'=>'<Выберите период>'));?> 
		            <?php echo $form->error($model,'period_id'); ?></td>
		    	</td>
        	</tr>
        	<tr>
		        <td><b>Описание</b></td>
		        <td>
		            <?php echo $form->textArea($model,'description',array('rows'=>5, 'cols'=>60)); ?>
				<?php echo $form->error($model,'description'); ?>
		        </td>
        	</tr>
        	</table>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>

<table id="claim_line_list"></table> 
<div id="pager_"></div> 
<div id="edit_dlg"></div>

<script type="text/javascript">
$(function() {

//	$([document, window]).unbind('.dialog-overlay');     // temporary solve issue when pressing ESC in inline-edit jqgrid closes the whole dialog

    var $grid=$("#claim_line_list"),
//=============================================================================================================
                fixPositionsOfFrozenDivs = function () {
                    var $rows;
                    if (typeof this.grid.fbDiv !== "undefined") {
                        $rows = $('>div>table.ui-jqgrid-btable>tbody>tr', this.grid.bDiv);
                        $('>table.ui-jqgrid-btable>tbody>tr', this.grid.fbDiv).each(function (i) {
                            var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
                            if ($(this).hasClass("jqgrow")) {
                                $(this).height(rowHight);
                                rowHightFrozen = $(this).height();
                                if (rowHight !== rowHightFrozen) {
                                    $(this).height(rowHight + (rowHight - rowHightFrozen));
                                }
                            }
                        });
                        $(this.grid.fbDiv).height(this.grid.bDiv.clientHeight);
                        $(this.grid.fbDiv).css($(this.grid.bDiv).position());
                    }
                    if (typeof this.grid.fhDiv !== "undefined") {
                        $rows = $('>div>table.ui-jqgrid-htable>thead>tr', this.grid.hDiv);
                        $('>table.ui-jqgrid-htable>thead>tr', this.grid.fhDiv).each(function (i) {
                            var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
                            $(this).height(rowHight);
                            rowHightFrozen = $(this).height();
                            if (rowHight !== rowHightFrozen) {
                                $(this).height(rowHight + (rowHight - rowHightFrozen));
                            }
                        });
                        $(this.grid.fhDiv).height(this.grid.hDiv.clientHeight);
                        $(this.grid.fhDiv).css($(this.grid.hDiv).position());
                    }
                };
//=============================================================================================================
	function fill_pane(id)
	{
			$(".hint").html("");
            var hint = $grid.getCell(id, 'asset_info');
            var name = $grid.getCell(id, 'name');
            var count = $grid.getCell(id, 'count');
            var unit = $grid.getCell(id, 'unit');
            var amount = $grid.getCell(id, 'amount');
            $(".hint").html('<div><b>'+name+'&nbsp;<span style="color:blue;">'+count+'</span>&nbsp;'+unit+'&nbsp;<span style="color:blue;">'+amount+'</span></b>&nbsp;-&nbsp;<span style="color:red;">'+hint+'</span></div>');
	};
	function calc_amount(id)
	{
            var count = $grid.getCell(id, 'count');
            var cost = $grid.getCell(id, 'cost');
            var amount = count*cost;
            $grid.setCell(id, 'amount', amount);
	};
    var pager_selector = "#pager_";
    var worker_id;
    var new_line_added=false;
    $grid.jqGrid( {
//        url : "getDataForSubGrid?claim_id="+<?php echo $model->id ?>,
        url : "<?echo Yii::app()->createUrl('claim/getDataForDialogGrid',array('claim_id'=>$model->id))?>",
        datatype : 'json',
        height : '295',
        width : '1070',
        mtype : 'GET',
        shrinkToFit : false,
        loadonce:true,
        colNames: ['ID','Тип','Наименование','Ед.изм','Кол-во','Цена','Сумма',
            'Группа','Цель','Для кого','Для кого','Характеристики','Продукты','Расположение','Примечание','ЦФО','Бизнес',
            'Статья бюджета','Статус',
            'Информация', 'Добавлена'],
        colModel: [

            //TODO: formatter - numeric fields!

            {name: 'iddb',index:'iddb', width:20, hidden:true, frozen:false},
            {name: 'type', width: 25, frozen: false, editable:true, edittype:'select', editoptions: {value:<?echo Helpers::BuildEditOptions(WareType::model(), array('key'=>'id','value'=>'short_name'))?>} },
            {name: 'name',index:'name', width:220, frozen: false, editable:true},
            {name: 'unit', width: 40, frozen:false, editable:true, edittype:'select', editoptions: {value:<?echo Helpers::BuildEditOptions(Unit::model(), array('key'=>'id','value'=>'sign'))?>} },
            {name: 'count', width: 40, frozen:false, editable:true},
            {name: 'cost', width: 40, frozen:false, editable:true},
            {name: 'amount', width: 60, frozen:false }, //calculated!
            {name: 'assetgroup', width: 120, frozen:false, editable:true, edittype:'select', editoptions: {value:<?echo Helpers::BuildEditOptionsWithModel(AssetGroup::model()->getGroupSubgroupStrings(), array('key'=>'id','value'=>'name'))?> } },
            {name: 'goal', width: 60, frozen:false },              //findWorkersWithStaff
            {name: 'for_whom', width: 150, frozen:false, editable:true, edittype:'select', editoptions: {value:<?echo Helpers::BuildEditOptionsWithModel(Worker::model()->findWorkersWithStaff(), array('key'=>'ID_EMP','value'=>'LASTNAME'))?>,

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
            {name: 'products', width: 100, frozen:false },
            {name: 'position', width: 150, frozen:false },
            {name: 'description', width: 110, frozen:false, editable:true, edittype:'textarea' },
            {name: 'payer', width: 70, frozen:false, editable:true, edittype:'select', editoptions: {value:<?echo Helpers::BuildEditOptions(Division::model(), array('key'=>'ID','value'=>'NAME'),'CODE')?>} },
            
            {name: 'business', width: 100, frozen:false, editable:true, edittype:'select', editoptions: {value:<?echo Helpers::BuildEditOptionsWithModel(Business::model()->findBusinessesOptionList(), array('key'=>'ID','value'=>'NAME'))?>} },
            {name: 'budget_item', width: 200, frozen:false, editable:true, edittype:'select', editoptions: {value:<?echo Helpers::BuildEditOptionsWithModel(BudgetItem::model()->get3LevelAllNameBudgetItemOptionList(), array('key'=>'ID','value'=>'NAME'))?>}  },
            {name: 'status', width: 50, frozen: false, editable:true, edittype:'select', editoptions: {value:<?echo Helpers::BuildEditOptions(Status::model(), array('key'=>'id','value'=>'short_name'))?>} },
            {name: 'asset_info', width: 300, frozen:false, hidden:true },
            {name: 'created', width: 100, frozen:false, editable:true, edittype:'select', editoptions: {value:<?echo Helpers::BuildEditOptions(CreationMethods::model(), array('key'=>'id','value'=>'name'))?>} }
        ],
        pager: pager_selector,
        pgbuttons: false,     // disable page control like next, back button
        pgtext: null,  
        viewrecords: false,
        loadComplete: function () {
            $grid.setGridParam({datatype:'local'});
            $(".ui-dialog-buttonpane").append('<div class="hint"></div>');
        },
                //----------------------------------------------------
                beforeSelectRow: function (rowid) {
                    if ((rowid !== lastSel)&&(!new_line_added)) {
                        $(this).jqGrid('restoreRow', lastSel);
                        fixPositionsOfFrozenDivs.call(this);
                       	fill_pane(rowid);
                        lastSel = rowid;
                    }
                    return true;
                },
                //----------------------------------------------------
                // 
        ondblClickRow: function (rowid, iRow, iCol, e) {
        
            	$grid.setGridParam({editurl:'#'});
				$grid.setGridParam({datatype:'json'});

                    $(this).jqGrid('editRow', rowid, true, function () {
//                        $("input, select, e.target").focus(); //
                        $('#'+rowid+'_type').focus(); //

                    	},
                    	null,
                    	'',
                    	null, 
                    	function(){/*aftersave*/

                    		new_line_added=false;
                    		calc_amount(rowid);
                    		fill_pane(rowid);
                    		//o.lysenko 6.sep.2012 19:16
                    		//ajax load department of worker
                    		
//                    		alert(worker_id);
                    		
         $.ajax({
        url: "findWorkerDepForList?id="+worker_id
//        data:{"dir":$("#AssetTemplate_direction_id").val()}
            })
            .done(function(data) { 
//                data=jQuery.parseJSON(data);
//                $("#AssetTemplate_asset_group_id").html(data);
//				alert(data);
				$grid.setCell(rowid,'for_whom_div',data);
            });

                    	}, 
                    	null, 
	                    function () {/*afterrestore*/
	                    	/*fixPositionsOfFrozenDivs.call(this)*/
	                    	if(new_line_added)
	                    	{
	                    		$grid.delRowData(rowid);
	                    		new_line_added=false;
	                    	}
	                    } 
                    );

                    /*fixPositionsOfFrozenDivs.call(this);*/
                    return;
       

//            alert(id+' '+lastSel);
//            if (id && id != lastSel) { 
//                $grid.restoreRow(lastSel);
//            	$grid.setGridParam({editurl:'#'});
//				$grid.setGridParam({datatype:'json'});
//                $grid.editRow(id, true);
//                lastSel = id;
//				fixPositionsOfFrozenDivs.call(this);
//            }
        },
       	loadError: function(xhr, status, error) {alert(status +error)},
    }).navGrid('#pager_',{view:false, del:false, add:false, edit:false, refresh:false,search:false});
           
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
                        fixPositionsOfFrozenDivs.call(this);
				}
	
				new_line_added=true;	

               var last_row_id = $grid.getGridParam("reccount");
               var lastSel=rowid=last_row_id+1;
               var row = {"iddb":rowid,
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
				$grid.setGridParam({datatype:'json'});

               $grid.addRowData(rowid,row,"last");
               $grid.setSelection(rowid, true);


                    $(this).jqGrid('editRow', rowid, true, function () {
//                        $("input, select, e.target").focus(); //
                        $('#'+rowid+'_type').focus(); //
                   	},
                    	null,
                    	'',
                    	null, 
                    	function(){/*aftersave*/
                    		new_line_added=false;
                    		calc_amount(rowid);
                    		fill_pane(rowid);
                    		
         $.ajax({
        url: "findWorkerDepForList?id="+worker_id
            })
            .done(function(data) { 
				$grid.setCell(rowid,'for_whom_div',data);
            });

                    	}, 
                    	null, 
	                    function () {/*afterrestore*/
	                    	/*fixPositionsOfFrozenDivs.call(this)*/
	                    	if(new_line_added)
	                    	{
	                    		$grid.delRowData(rowid);
	                    		new_line_added=false;
	                    	}
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