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
<script type="text/javascript">
   $.jgrid.no_legacy_api = true;
   $.jgrid.useJSON = true;
</script>

<h1>Заявка #<?php echo $model->claim_number; ?></h1>

<b>Номер :</b>
<?php echo $model->claim_number; ?>
<br />

<b>Направление :</b>
<?php echo $model->direction->name; ?>
<br />

<b>Отделение :</b>
<?php echo $model->division->NAME; ?>
<br />

<b>Подразделение :</b>
<?php echo ($model->findDepartment($model->department_id)); ?>
<br />

<b>Статус :</b>
<?php echo $model->state->stateName->name; ?>
<br />

<b>Период :</b>
<?php echo $model->period->NAME; ?>
<br />

<b>Комментарий :</b>
<?php echo $model->comment; ?>
<br />

<b>Описание :</b>
<?php echo $model->description; ?>
<br />
<br />

<table id="claim_list"></table> 
<div id="claim_pager"></div> 


<script type="text/javascript">
$(function() {
    var grid=$("#claim_list");
    var id_ = <?echo $model->id;?>;
    grid.jqGrid( {
        url : "getDataForSubGrid?claim_id="+id_,
        datatype : 'json',
        width : '800',
        height : 'auto',
        mtype : 'GET',
                colNames: ['ID','Тип','Название','Количество','Цена','Сумма','Примечание'],
                colModel: [
                    {name:'id',index:'id', width:20, hidden:true},
                    {name: 'type', width: 50 },
                    {name:'name',index:'name', width:300},
                    {name: 'quantity', width: 70 },
                    {name: 'cost', width: 60 },
                    {name: 'amount', width: 60 },
                    {name: 'description', width: 200 }
                ],
        caption : 'Строки заявки',
        rowNum : 300000,
        pgbuttons: false,     // disable page control like next, back button
        pgtext: null,  
        viewrecords: true,
        sortorder: "asc",
        sortname: "name",
        pager: '#claim_pager',
        loadonce: true,
        gridComplete: function () {
//            alert("gridComplete");
            grid.setGridParam({datatype:'local'});
        },
    	loadError: function(xhr, status, error) {alert(status +error)}
    }).navGrid('#claim_pager',{search:true, view:false, del:false, add:false, edit:false, refresh:false}); 
    //alert(grid.options['url']);
});
</script>
