<script type="text/javascript">
    $.jgrid.no_legacy_api = true;
    $.jgrid.useJSON = true;
</script>

<h1>Журнал регистрации договоров</h1>
<table id="jqgrid"></table><div id="pager"></div>
<p class="result"></p>

<script type="text/javascript">
    $(function() {
        var main_rowid='';
        var grid = jQuery("#jqgrid");
        jQuery("#jqgrid").jqGrid( {
            url : '<?echo Yii::app()->createUrl('dogovor_archiv/documents/Jqgrid')?>',
            datatype : 'json',
            mtype : 'GET',
            width:'100%',
            height:'auto',
            hoverrows:false,
            sortable:true,
            autowidth:true,
            ignoreCase:true,
            colNames : <? echo $cols; ?>,
            colModel : <? echo $colModel; ?>,
            //        colNames : ['id','11'],
            //        colModel : [{name:'id'},{name:'22'}],
            pager : '#pager',
            rowNum : 0,
            pgbuttons: false,     // disable page control like next, back button
            pgtext: '',         // disable pager text like 'Page 0 of 10'
            viewrecords: false,
            sortname : 'dog_date',
            sortorder : 'asc',
            caption : 'Документы',
            subGrid: true,
//    ondblClickRow:
//        function(rowid){
//            $(location).attr('href','<?echo Yii::app()->createUrl('dogovor_archiv/documents/update',array('id'=>''));?>'+rowid);
//    },
    subGridRowExpanded: 
        function(subgrid_id, row_id) {
	    var subgrid_table_id;
            main_rowid =row_id;
	    subgrid_table_id = subgrid_id+'_t';
	    $('#'+subgrid_id).html('<table id="'+subgrid_table_id+'"></table><div id="'+subgrid_table_id+'_pager"></div>');
	    $('#'+subgrid_table_id).jqGrid({
	        url: '<?echo Yii::app()->createUrl('dogovor_archiv/documents/Jqgrid',array('action'=>'sub'))?>',
	        datatype: 'json',
	        mtype: 'POST',
	        postData: {'get':'subgrid','id':row_id},
	        colNames : <? echo $cols; ?>,
                colModel : <? echo $colModel; ?>,
	        height: 'auto',
	        autowidth: true,
	        rownumWidth: 40,
	        rowNum: 10,
	        sortname: 'name',
	        sortorder: 'asc',
                pgbuttons: false,     // disable page control like next, back button
                pgtext: '',         // disable pager text like 'Page 0 of 10'
                viewrecords: false,
	        pager: $('#'+subgrid_table_id+'_pager'),
	        rowNum:10,
                caption : 'Доп. соглашения'
//                ondblClickRow:
//                    function(rowid,e,iCol,iRow){
//                        //$(location).attr('href','<?//echo Yii::app()->createUrl('dogovor_archiv/documents/update',array('id'=>''));?>'+rowid);
//                        $(this);
//                        alert(e);
//                }
	    }).jqGrid('navGrid', '#'+subgrid_table_id+'_pager',{add: false, del: false, edit: false, search: false},
                {
                    closeAfterEdit: true
                },
                {
                closeAfterAdd:true
                },
                {},
                {
                    closeOnEscape:true,
                    multipleSearch:true,
                    closeAfterSearch:true
                }
            );//end of navgrid options
            $('#'+subgrid_table_id).jqGrid('navButtonAdd','#'+subgrid_table_id+'_pager',{
                    caption: 'Редактировать',
                    title: 'Редактировать запись',
                    buttonicon: 'ui-icon-wrench',
                    onClickButton: function()
                    {
                        var sub_rowid = jQuery('#'+subgrid_table_id).jqGrid('getGridParam','selrow'); 
                        if(sub_rowid){
                            $(location).attr('href','<?echo Yii::app()->createUrl('dogovor_archiv/documents/add');?>?id='+main_rowid+'&sub_document='+sub_rowid);
                        } else { alert("Выберите запись") }
                    },
                    position:'last'
            });
            $('#'+subgrid_table_id).jqGrid('navButtonAdd','#'+subgrid_table_id+'_pager',{
                caption: 'Удалить',
                title: 'Удалить запись',
                buttonicon: 'ui-icon-trash',
                onClickButton: function()
                {
                    var sub_rowid = jQuery('#'+subgrid_table_id).jqGrid('getGridParam','selrow'); 
                    if(sub_rowid){
                        $(location).attr('href','<?echo Yii::app()->createUrl('dogovor_archiv/documents/delete');?>?id='+main_rowid+'&sub_document='+sub_rowid);
                    } else { alert("Выберите запись") }
                },
                position:'last'
            });
    }, //end of subgrid function
    gridComplete:function(){
             var rows = $('#jqgrid').jqGrid('getDataIDs');
             var cl;
             var t1,t2,row;
             t2=new Date().getTime();
                for( i=0; i < rows.length; i++){
                  row = $('#jqgrid').jqGrid('getRowData',rows[i]);
                  //t2 = d2.getTime();
                    var strDate = row['stop_date'];
                    var dateParts = strDate.split(".");

                  t1 = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]).getTime();

                  if( parseInt(Math.abs(t2-t1)/(24*3600*1000)) > 30 ) cl="";
                  else cl="red";
                  $('#jqgrid').jqGrid('setRowData',rows[i],false, {color:cl});
                }
            },
    loadComplete:function(){
        var rows = grid.jqGrid('getDataIDs');
        $.ajax({
        url: '<?echo Yii::app()->createUrl('dogovor_archiv/documents/getAllSubDocuments')?>',
        data:{'rows':rows}
            })
            .done(function(data) { 
                data=jQuery.parseJSON(data);
                $.each(rows, function(i,value){
                    if ($.inArray(value, data) ==-1)
                        {
                             $("#"+value+" td.sgcollapsed",grid[0]).unbind('click').html('');
                        }
                }) 
            });
    },
        editurl: '<?echo Yii::app()->createUrl('dogovor_archiv/documents/update')?>'
        }).jqGrid('navGrid', '#pager',{add: false, del: false, edit: false, search: true},{},{},{},{/*search settings*/closeOnEscape:true, multipleSearch:true, closeAfterSearch:true,sopt:['cn','eq'],groupOps: false});//end of main grid navgrid options
        
        
        $('#jqgrid').jqGrid('navSeparatorAdd','#pager');
        $('#jqgrid').jqGrid('navButtonAdd','#pager',{
            caption: 'Добавить',
            title: 'Создать документ',
            buttonicon: 'ui-icon-plus',
            onClickButton: function()
            {
                $(location).attr('href','<?echo Yii::app()->createUrl('dogovor_archiv/documents/add');?>');
            },
            position:'last'
        });
        $('#jqgrid').jqGrid('navButtonAdd','#pager',{
            caption: 'Редактировать',
            title: 'Редактировать запись',
            buttonicon: 'ui-icon-wrench',
            onClickButton: function()
            {
                var rowid = jQuery("#jqgrid").jqGrid('getGridParam','selrow'); 
                if(rowid){
                    $(location).attr('href','<?echo Yii::app()->createUrl('dogovor_archiv/documents/update',array('id'=>''));?>'+rowid);
                } else { alert("Выберите запись") }
            },
            position:'last'
        })
        $('#jqgrid').jqGrid('navButtonAdd','#pager',{
            caption: 'Удалить',
            title: 'Создать документ',
            buttonicon: 'ui-icon-trash',
            onClickButton: function()
            {
                var rowid = jQuery("#jqgrid").jqGrid('getGridParam','selrow'); 
                if(rowid){
                    $.post('<?echo Yii::app()->createUrl('dogovor_archiv/documents/delete');?>',{id:rowid}, function(data) {alert(data)});
                    jQuery("#jqgrid").jqGrid().trigger('reloadGrid');
                } else { alert("Выберите запись") }
            },
            position:'last'
        })
    });
    

</script>