<div class="checklimits-descripition">
<p>Период: <?php echo Period::model()->findByPk($period_id)->NAME ?></p>
<p>Направление: <?php echo Direction::model()->findByPk($direction_id)->name ?></p>
<p>Отделение: <?php echo Division::model()->findByPk($division_id)->NAME ?></p>
</div>
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
<script type="text/javascript">
   $.jgrid.no_legacy_api = true;
   $.jgrid.useJSON = true;
</script>

<table id="list"></table> 
<div id="pager"></div> 

<script type="text/javascript">
$(function() {
    var grid=$("#list");
    var direction_id = <?echo $direction_id;?>;
    var period_id = <?echo $period_id;?>;
    var division_id = <?echo $division_id;?>;
    grid.jqGrid( {
        url : 'getLimits?direction_id='+direction_id+'&period_id='+period_id+'&division_id='+division_id,
        datatype : 'json',
        width : '1160',
        height : '400',
        mtype : 'GET',
        colNames : ['ID','period_id','division_id','direction_id','Отделение','Статья бюджета','Лимит','Сумма','Отклонение'],
        colModel : [
            {name:'id',index:'id', width:20, hidden:true},
            {name:'period_id',index:'period_id', width:20, hidden:true},
            {name:'division_id',index:'division_id', width:20, hidden:true},
            {name:'direction_id',index:'direction_id', width:20, hidden:true},
            {name:'division',index:'division', width:200, sortable:false, hidden:true},
//            {name:'article',index:'article', width:300, sortable:false},
            {name: 'article', width: 500, edittype:'select', formatter:"select", editoptions: {value:<?echo Helpers::BuildEditOptionsWithModel(BudgetItem::model()->get3LevelAllNameBudgetItemOptionList(), array('key'=>'ID','value'=>'NAME'))?>}  },
            {name:'limit',index:'limit', width:70, sortable:true},
            {name:'sum',index:'sum', width:70},
            {name:'delta',index:'delta', width:70},
           
        ],
        caption : 'Контроль лимитов',
        rowNum : 300000,
        pgbuttons: false,     // disable page control like next, back button
        pgtext: null,  
        viewrecords: true,
        sortorder: "asc",
        sortname: "name",
        pager: '#pager',
        subGrid: true,
        loadonce: true,
        subGridRowExpanded: function (subgridDivId, rowId) {
            var article_id = $('#list').getCell(rowId, 'id');
            var period_id = $('#list').getCell(rowId, 'period_id');
            var division_id = $('#list').getCell(rowId, 'division_id');
            var direction_id = $('#list').getCell(rowId, 'direction_id');
            var subgridTableId = subgridDivId + "_t";
            var pager_id = "p_"+subgridTableId;
            $(".subgrid-cell").css('background','#ddd');
            $(".subgrid-data").css('background','#ddd');
            $("#" + subgridDivId).html("<table id='"+subgridTableId+"' class='scroll'></table><div id='"+ pager_id +"' class='scroll'></div>");
            $("#" + subgridTableId).jqGrid({
                url : "getClaimLinesByArticle?article_id="+article_id+'&period_id='+period_id+'&division_id='+division_id+'&direction_id='+direction_id,
                datatype : 'json',
                height : 'auto',
                width : '1000',
                loadonce:true,
                colNames: ['claim_id','Заявка','Тип','Название','Ед. изм.','Количество','Цена','Сумма','Примечание','Просмотр'],
                colModel: [
                    {name: 'claim_id', width: 50, hidden:true },
                    {name: 'claim_num', width: 50 },
                    {name: 'type', width: 50 },
                    {name:'name',index:'name', width:300},
                    {name: 'unit', width: 40, frozen:false, /*editable:true,*/ edittype:'select', formatter:"select", editoptions: {value:<?echo Helpers::BuildEditOptions(Unit::model(), array('key'=>'id','value'=>'sign'))?>} },
                    {name: 'quantity', width: 70 },
                    {name: 'cost', width: 60 },
                    {name: 'amount', width: 60 },
                    {name: 'description', width: 200 },
                    {name:'link',index:'link', width:70,sortable:false,editable:false,
                        formatter:function(cellvalue,options,rowObject){
                            
                            var clid = rowObject[0];
                            return '<a href="<?echo Yii::app()->createUrl('/claim/indexJqgrid');?>?claim_id='+clid+'" target="_blank" title="Перейти к заявке"><?echo CHtml::image(Yii::app()->request->baseUrl.'/images/link.png');?></a>';
                        }
                    },
                ],
            pager: null, //pager_id,
            pgbuttons: false,     // disable page control like next, back button
            pgtext: null,  
            viewrecords: false,
            ondblClickRow: function(id) {
//                $_GET['claim_id'] = $("#" + subgridTableId).getCell(id, 'claim_id');
                var clid = $("#" + subgridTableId).getCell(id, 'claim_id');
                window.location.href = "<?echo Yii::app()->createUrl('/claim/indexJqgrid');?>"+"?claim_id="+clid
                    
//                window.location.href = "<?//echo Yii::app()->createUrl('/claim/show');?>"+"?id="+
//                    $("#" + subgridTableId).getCell(id, 'claim_id'); //claim_id;
            },
            gridComplete: function () {
//                $(".subgrid-data").css('background','#ddd');
            }
            });
        },
        
        gridComplete: function () {
            grid.setGridParam({datatype:'local'});
            var rows = grid.jqGrid('getDataIDs');
            var cl;
            for( i=0; i < rows.length; i++){
                row = grid.jqGrid('getRowData',rows[i]);
                var delta = row['delta'];

                if(delta >= 0 ) cl="";
                else cl="red";
                grid.jqGrid('setCell',rows[i],'delta','',{'color':cl});
            } 
        },
    	loadError: function(xhr, status, error) {alert(status +error)}
    }).navGrid('#pager',{view:false, del:false, add:false, edit:false, refresh:false},
    {}, // default settings for edit
    {}, // default settings for add
    {}, // delete
    {closeOnEscape: true, multipleSearch: true, 
       sopt:['cn','eq','ne','bw','bn'],
         closeAfterSearch: true }, // search options
    {}
    ); //, cloneToTop:true});
});
</script>
