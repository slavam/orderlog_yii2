<h1>Поля</h1>
<table id="fields">
</table>
<div id="pager"></div>
<p class="result"></p>
<script type="text/javascript">
    $(function() {
        jQuery("#fields").jqGrid( {
            url : '/dogovor_archiv/field/getfieldlist',
            datatype : 'json',
            mtype : 'GET',
            width:'1200',
            height:'auto',
            hoverrows:false,
            viewrecords:true,
            sortable:true,
            autowidth:true,
            ignoreCase:true,
            colNames : ["Название поля"],
            colModel : [{"name":"caption","index":"caption"}],
            //        colNames : ['id','11'],
            //        colModel : [{name:'id'},{name:'22'}],
            pager : '#pager',
            pgbuttons: false,     // disable page control like next, back button
            pgtext: null,         // disable pager text like 'Page 0 of 10'
            viewrecords: false,    // disable current view record text like 'View 1-10 of 100'
            rowNum : 1000000,
            sortname : 'caption',
            sortorder : 'asc',
            viewrecords : true,
            caption : 'Поля',
           
            editurl: '/dogovor_archiv/documents/Update'
        }).jqGrid('navGrid', '#pager',{add: false, del: false, edit: false, search: true},
        {},
        {
        
        },
        {},
        {closeOnEscape:true, multipleSearch:true, closeAfterSearch:true}
        );
        $('#fields').jqGrid('navSeparatorAdd','#pager');
        $('#fields').jqGrid('navButtonAdd','#pager',{
            caption: 'Добавить',
            title: 'Создать документ',
            buttonicon: 'ui-icon-plus',
            onClickButton: function()
            {
                $(location).attr('href','/dogovor_archiv/field/editfield');
            },
            position:'last'
        })
        $('#fields').jqGrid('navButtonAdd','#pager',{
            caption: 'Редактировать',
            title: 'Редактировать запись',
            buttonicon: 'ui-icon-wrench',
            onClickButton: function()
            {
                var gsr = jQuery("#fields").jqGrid('getGridParam','selrow'); 
                if(gsr){
                    $(location).attr('href','/dogovor_archiv/documents/update?id='+gsr);
                } else { alert("Выберите запись") }
            },
            position:'last'
        })
    });
    

</script>