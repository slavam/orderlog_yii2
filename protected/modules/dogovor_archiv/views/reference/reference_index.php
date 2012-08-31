<h1>Справочники</h1>

<table id="reference"></table>
<div id="pager"></div>
<script type="text/javascript">
jQuery("#reference").jqGrid({
    url: '<?echo Yii::app()->createUrl('dogovor_archiv/reference/grid')?>',
    datatype: "json",
    mtype: "POST",
    colNames:["Справочник",'Описание'], 
    colModel:[
        {name:'name',index:'name', width:180,editable:true,hidden:true,editrules:{edithidden:true,required:true,custom:true,custom_func:RefNamecheck},formoptions:{elmprefix:'*'}},
        {name:'caption',index:'caption', width:180,editable:true,editrules:{required:true}},
    ], 
    height:'auto',
    width:400,
    pager : "#pager", 
    caption: "",
    editurl:'<?echo Yii::app()->createUrl('dogovor_archiv/reference/AddReferenсe')?>',
    subGrid: true,
    subGridRowExpanded: 
        function(subgrid_id, row_id) {
	    var subgrid_table_id;
            
	    subgrid_table_id = subgrid_id+'_t';
	    $('#'+subgrid_id).html('<table id="'+subgrid_table_id+'"></table><div id="'+subgrid_table_id+'_pager"></div>');
	    $('#'+subgrid_table_id).jqGrid({
	        url: '<?echo Yii::app()->createUrl('dogovor_archiv/reference/grid',array('action'=>'sub'))?>',
                
	        datatype: 'json',
	        mtype: 'POST',
	        postData: {'get':'subgrid','id':row_id},
	        colNames: ['Термин'],
	        colModel: [{name:'name', index:'name', width:80, editable:true, editrules:{required:true}}],
	        height: 'auto',
	        autowidth: true,
	        rownumWidth: 40,
	        rowNum: 10,
	        sortname: 'name',
	        sortorder: 'asc',
	        pager: $('#'+subgrid_table_id+'_pager'),
	        rowNum:10,
                viewrecords: true,
	        rowList:[10,20,50,100],
                editurl:'<?echo Yii::app()->createUrl('dogovor_archiv/reference/addreferenceitem')?>'+'?pid='+row_id
	    }).jqGrid('navGrid', '#'+subgrid_table_id+'_pager',{add: true, del: true, edit: true, search: true},
        {
            closeAfterEdit: true
           // afterComplete:function(responce,postdata,formid){alert(responce.responseText);}
        },
        {
           closeAfterAdd:true
          // afterComplete:function(responce,postdata,formid){alert(responce.responseText);}
        },
        {
          // afterComplete:function(responce,postdata,formid){alert(responce.responseText);}
        },
        {
            closeOnEscape:true,
            multipleSearch:true,
            closeAfterSearch:true
        }
    );
    }
}).jqGrid('navGrid', '#pager',{add: true, del: false, edit: true, search: false},
        {
            closeAfterEdit: true,
            bottominfo:'* Системное название справочника(только английские буквы и цифры)'
           // afterComplete:function(responce,postdata,formid){alert(responce.responseText);}
        },
        {
           closeAfterAdd:true,
           bottominfo:'* Системное название справочника(только английские буквы и цифры)'
          // afterComplete:function(responce,postdata,formid){alert(responce.responseText);}
        },
        {
          // afterComplete:function(responce,postdata,formid){alert(responce.responseText);}
        },
        {
            closeOnEscape:true,
            multipleSearch:true,
            closeAfterSearch:true
        }
    )
function RefNamecheck(value){ 
var regexp = /^[a-z0-9_]+$/i;
if(regexp.test(value)) 
    {
        return [true,"",""]; 
    } else 
    { 
        return [false,"В системном названии должны быть только цифры, латинский буквы и символ _",""];
    }
}
</script>