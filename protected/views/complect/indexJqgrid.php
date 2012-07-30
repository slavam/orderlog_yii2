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
 
 var data = [[48803, "DSK1", "", "02200220", "OPEN"], [48769, "APPR", "", "77733337", "ENTERED"]];

var subgridData = [[1,"Item 1",3],[2,"Item 2",5]];

var globalSubGridNames = [];

$("#grid").jqGrid({
//jQuery("#grid").jqGrid( {
    datatype: "local",
    height: 250,
    colNames: ['Inv No', 'Thingy', 'Blank', 'Number', 'Status'],
    colModel: [{
        name: 'id',
        index: 'id',
        width: 60,
        sorttype: "int"},
    {
        name: 'thingy',
        index: 'thingy',
        width: 90,
        sorttype: "date"},
    {
        name: 'blank',
        index: 'blank',
        width: 30},
    {
        name: 'number',
        index: 'number',
        width: 80,
        sorttype: "float"},
    {
        name: 'status',
        index: 'status',
        width: 80,
        sorttype: "float"}
    ],
    pager: 'pagerId',
    caption: "Stack Overflow Subgrid Example",
    subGrid: true,
    subGridOptions: { "plusicon" : "ui-icon-triangle-1-e",
                      "minusicon" :"ui-icon-triangle-1-s",
                      "openicon" : "ui-icon-arrowreturn-1-e",
                      "reloadOnExpand" : false,
                      "selectOnExpand" : true },
    subGridRowExpanded: function(subgrid_id, row_id) {
        var subgrid_table_id, pager_id; subgrid_table_id = subgrid_id+"_t";
        pager_id = "p_"+subgrid_table_id;
        $("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
        $("#"+subgrid_table_id).jqGrid({
            datatype: "local",
            colNames: ['No','Item','Qty'],
            colModel: [ {name:"num",index:"num",width:80,key:true},
                        {name:"item",index:"item",width:130},
                        {name:"qty",index:"qty",width:70,align:"right"}], 
            rowNum:20,
            pager: pager_id,
            sortname: 'num',
            sortorder: "asc", height: '100%' });
         $("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:false});
        
         var subNames = ["num", "item", "qty"];
         var mysubdata = [];
         for (var i = 0; i < subgridData.length; i++) {
            mysubdata[i] = {};
            for (var j = 0; j < subgridData[i].length; j++) {
                mysubdata[i][subNames[j]] = subgridData[i][j];
             }
         }
         for (var i = 0; i <= mysubdata.length; i++) {
           $("#"+subgrid_table_id).jqGrid('addRowData', i + 1, mysubdata[i]);
         }
    }
});

var names = ["id", "thingy", "blank", "number", "status"];
var mydata = [];

for (var i = 0; i < data.length; i++) {
    mydata[i] = {};
    for (var j = 0; j < data[i].length; j++) {
        mydata[i][names[j]] = data[i][j];
    }
}

for (var i = 0; i <= mydata.length; i++) {
    $("#grid").jqGrid('addRowData', i + 1, mydata[i]);
}



$("#grid").jqGrid('setGridParam', {ondblClickRow: function(rowid,iRow,iCol,e){alert('double clicked');}});
​    
</script> 
<div> 
    <table id="grid"></table>
    <?php // include ("C:/Sites/yii/demos/ordertest/protected/views/complect/grid.php");?> 
</div> 