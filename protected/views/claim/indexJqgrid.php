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

<div id="create_dialog" style="display:none;">
<!--    <table class="ui-jqgrid" id="create_dialog_table"></table> -->
</div>

<div id="create_dialog_edit_whole_claim" style="display:none;">
<!--    <table class="ui-jqgrid" id="create_dialog_table"></table> -->
</div>

<div id="create_claim_view" style="display:none;">
<!--    <table class="ui-jqgrid" id="create_dialog_table"></table> -->
</div>

<div id="create_del_dialog" style="display:none;">
<!--    <table class="ui-jqgrid" id="create_dialog_table"></table> -->
</div>

<table id="list"></table> 
<div id="pager"></div> 


<script type="text/javascript">
$(function() {
    var grid=$("#list");
    var pager_selector = "#pager";
    grid.jqGrid( {
        url : 'getDataForGrid',
        datatype : 'json',
        width : '1160',
        height : '400',
        mtype : 'GET',
        colNames : ['ID','Период','Номер','Статус','Отделение','Подразделение','Комментарий'],
        colModel : [
            {name:'id',index:'id', width:20, hidden:true},
            {name:'period',index:'period', width:100, sortable:false},
            {name:'name',index:'name', width:100, sortable:true},
            {name:'state',index:'state', width:100},
            {name:'division',index:'division', width:300},
            {name:'department',index:'department', width:300, sortable:false},
            {name:'comment',index:'comment', width:300, sortable:false},
        ],
        caption : 'Журнал регистрации заявок',
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
//            grid.setCell (row,col,val,{background:'#ff0000'});
            var cont = $('#list').getCell(rowId, 'id');
            var subgridTableId = subgridDivId + "_t";
            var pager_id = "p_"+subgridTableId;
            var subgrid_pager_selector = pager_id;
            $(".subgrid-cell").css('background','#ddd');
            $(".subgrid-data").css('background','#ddd');
            $("#" + subgridDivId).html("<table id='"+subgridTableId+"' class='scroll'></table><div id='"+ pager_id +"' class='scroll'></div>");
            $("#" + subgridTableId).jqGrid({
                url : "getDataForSubGrid?claim_id="+cont,
                datatype : 'json',
                height : 'auto',
                width : '1000',
//                loadonce:true,
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
            pager: null, //pager_id,
            pgbuttons: false,     // disable page control like next, back button
            pgtext: null,  
            viewrecords: false,
            gridComplete: function () {
//                $(".subgrid-data").css('background','#ddd');

            }
            });
//            jQuery("#"+subgridTableId).jqGrid("navGrid","#"+pager_id,{edit:false,add:false,del:false,search:false});
            
        },
        
        gridComplete: function () {
            grid.setGridParam({datatype:'local'});
            $(".subgrid-data").css('background','#ddd');
        },
//        onPaging : function(which_button) {
//            grid.setGridParam({datatype:'json'});
//            alert('onPaging')
//        },
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
    
    

    top_bottom_pager_ButtonAdd = function(options) {
        grid.jqGrid('navButtonAdd',pager_selector,options);
    };

    top_bottom_pager_ButtonAdd ({
        caption: '',
        title: 'Редактировать заявку со строками',
        buttonicon: 'ui-icon-pencil',
        onClickButton: function()
        {
            var sel_ = grid.getGridParam('selrow');
            if(sel_) 
                var id_ = grid.getCell(sel_, 'id');
            if(id_) {

            //lysenko 1!!!?!?!?!?!
//                $("#alertmod").detach();

                $("#create_dialog_edit_whole_claim").load('editClaimWithLinesJq?id='+id_);
                $("#create_dialog_edit_whole_claim").dialog({
                    title: 'Редактировать заявку и строки',
                    modal:true,
                    width:1100,
                    height:600,
                    buttons:{
                        'OK': function(){
                            var rows= jQuery("#claim_line_list").jqGrid('getRowData');
                            var lines=new Array();
                            for(var i=0;i<rows.length;i++){
                                var row=rows[i];
                                lines.push(row);
                            } 
                            //JSON.stringify(row)
                            //  alert(paras[0]['name']);
                            var values = {};
                            var x = $.makeArray(lines);
                            $.each($('#whole-claim-form').serializeArray(), function(i, field) {
//                                alert(field.name.substr(6,field.name.length-7));
                                values[field.name.substr(6,field.name.length-7)] = field.value;
                            });

                            $.ajax( {                                //'f2[]':$("#whole-claim-form").serialize()
//                                'data': {'ClaimLines[]':JSON.stringify(paras), 'Claim[]':values}, 
                                'data': {'ClaimLines':x, 'Claim[]':values}, 
                                'url': "editWholeClaim?id="+id_,
                                'type': "POST",
                                'dataType': "json",
                                'error': function(res, status, exeption) {
                                    alert("error:"+res.responseText);
                                },
                                'success':  function(data) {

                                        $("#create_dialog_edit_whole_claim").dialog('close');
//                                        $(this).dialog('close');

                                    }
                            }); 

                            //$.ajax(options); 
//                            $('#claim_line_list').ajaxSubmit(options); 
                        },
                        'Close': function(){
                            $(this).dialog('close');
                        }
                    }
                });
                //alert("!");
            } else 
                alert('Выберите заявку!');
            }
        });

        top_bottom_pager_ButtonAdd ({
        caption: '',
        title: 'Удалить заявку со строками!',
        buttonicon: 'ui-icon-trash',
        onClickButton: function()
        {
            var sel_ = grid.getGridParam('selrow');
            if(sel_) 
                var id_ = grid.getCell(sel_, 'id');
            if(id_) {
                $("#create_del_dialog").dialog({
                    title: 'Удалить заявку?',
                    modal:true,
                    width:200,
                    height:100,
                    buttons:{
                        'Да': function(){
                        ///!!!lysenko
                        /*
                            var options = { 
                                url: '<?php  echo Yii::app()->createUrl('claim/delete',array('id'=>''))?>'+id_,
                                type: 'post',
                                dataType: 'json',
                                error: function(res, status, exeption) {
                                    alert("error:"+res.responseText);
                                },
                                success:  function(data) {
                                    grid.jqGrid('delRowData',sel_);
                                    $(this).dialog('close');
                                }
                            }; 
                            $('#claim-form').ajaxSubmit(options); 
                            */
                        },
                        'Нет': function(){
                            $(this).dialog('close');
                        }
                    }
                });

                };
        }
        });


});
</script>
