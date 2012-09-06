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
        <td><b>Направление</b></td>
        <td><?php echo $form->dropDownList($model,'direction_id',Direction::model()->findDirections());?> 
            <?php echo $form->error($model,'direction_id'); ?></td>
        <td><b>Период</b></td>
        <td><?php echo $form->dropDownList($model,'period_id', Period::model()->findPeriods());?> 
            <?php echo $form->error($model,'period_id'); ?></td>

    </tr>
<tr>
        <td><b>Подразделение</b></td>
        <td>
            <?php if ($model->division_id>0) {
                echo $form->dropDownList($model,'department_id', Department::model()->findDepartmentsByDivision($model->division_id));
            } else {
                echo $form->dropDownList($model,'department_id', Department::model()->findDepartments());
            }
            ?> 
            <?php echo $form->error($model,'department_id'); ?>
        </td>
        <td><b>Описание</b></td>
        <td>
            <?php echo $form->textArea($model,'description',array('rows'=>5, 'cols'=>60)); ?>
		<?php echo $form->error($model,'description'); ?>
        </td>

</tr>    
    <tr>
        <td><b>Отделение</b></td>
        <td>
            <?php echo $form->dropDownList($model,'division_id', Division::model()->All(),array('onChange'=>'getDepartments()'));?> 
            <?php echo $form->error($model,'division_id'); ?>
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

<table id="claim_line_list"></table> 
<div id="pager_"></div> 
<?php $this->endWidget(); ?>


<script type="text/javascript">
$(function() {
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
//========================================================================================================================
//    var pager_selector = "#pager_";
    $grid.jqGrid( {
        url : "getDataForSubGrid?claim_id="+<?php echo $model->id ?>,
        datatype : 'json',
        height : '200',
        width : '1070',
        mtype : 'GET',
        shrinkToFit : false,
        loadonce:true,
        colNames: ['ID','Тип','Наименование','Ед.изм','Кол-во','Цена','Сумма',
            'Группа','Цель','Для кого','Для кого','ЦФО','Бизнес',
            'Статья бюджета','Характеристики','Продукты','Расположение','Примечание',
            'Информация', 'Добавлена'],
        colModel: [
            {name: 'iddb',index:'iddb', width:20, hidden:true, frozen:false},
            {name: 'type', width: 25, frozen: false},
            {name: 'name',index:'name', width:300, frozen: false},
            {name: 'unit', width: 40, frozen:false },
            {name: 'count', width: 40, frozen:false, editable:true},
            {name: 'cost', width: 40, frozen:false },
            {name: 'amount', width: 60, frozen:false },
            {name: 'assetgroup', width: 200, frozen:false },
            {name: 'goal', width: 60, frozen:false },
            {name: 'for_whom', width: 300, frozen:false },
            {name: 'for_whom_div', width: 300, frozen:false },
            {name: 'payer', width: 100, frozen:false },
            {name: 'business', width: 100, frozen:false },
            {name: 'budget_item', width: 300, frozen:false },
            {name: 'features', width: 300, frozen:false },
            {name: 'products', width: 300, frozen:false },
            {name: 'position', width: 300, frozen:false },
            {name: 'description', width: 200, frozen:false },
            {name: 'asset_info', width: 300, frozen:false },
            {name: 'created', width: 100, frozen:false }
        ],
        pager: null, //pager_id,
        pgbuttons: false,     // disable page control like next, back button
        pgtext: null,  
        viewrecords: false,
        onSelectRow: function(id){ 
            var hint = $grid.getCell(id, 'asset_info');
            var name = $grid.getCell(id, 'name');
            var count = $grid.getCell(id, 'count');
            var unit = $grid.getCell(id, 'unit');
            var amount = $grid.getCell(id, 'amount');
            $(".hint").html('<div><b>'+name+'&nbsp;'+count+unit+'&nbsp;'+amount+'</b>&nbsp;-&nbsp;<span style="color:red;">'+hint+'</span></div>');
        },
        gridComplete: function () {
            $grid.setGridParam({datatype:'local'});
            $(".ui-dialog-buttonpane").append('<div class="hint"></div>');
        },
                //----------------------------------------------------
                beforeSelectRow: function (rowid) {
                    if (rowid !== lastSel) {
                        $(this).jqGrid('restoreRow', lastSel);
                        fixPositionsOfFrozenDivs.call(this);
                        lastSel = rowid;
                    }
                    return true;
                },
                //----------------------------------------------------
        ondblClickRow: function(rowid, iRow, iCol, e) {

            	$grid.setGridParam({editurl:'#'});
				$grid.setGridParam({datatype:'json'});

                    $(this).jqGrid('editRow', rowid, true, function () {
                        $("input, select", e.target).focus();
                    }, null, '', null, null, null, function () {fixPositionsOfFrozenDivs.call(this)} );
                    fixPositionsOfFrozenDivs.call(this);
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
    });//.navGrid('#pager_',{view:false, del:false, add:false, edit:false, refresh:false,search:false});
           

});
</script>

</div><!-- form -->