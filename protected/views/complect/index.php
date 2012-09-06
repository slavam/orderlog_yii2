<?php
$cs = Yii::app()->clientScript;    
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);
$this->breadcrumbs=array(
	'Комплекты',
);

//$this->menu=array(
//	array('label'=>'Create Complect', 'url'=>array('create')),
//	array('label'=>'Manage Complect', 'url'=>array('admin')),
//);
?>

<!--<h1>Комплекты</h1>-->

<?php 
//// $this->widget('zii.widgets.grid.CGridView', array(
//	'id'=>'complect-grid',
//	'dataProvider'=>$dataProvider,
//        'enablePagination'=>false,
//	'columns'=>array(
//                array(
//                    'name'=>'Тип',
//                    'value'=>'$data->complectType->name'),
//                array(
//                    'name'=>'Название',
//                    'value'=>'$data->name'),
//                array(
//                    'class'=>'CButtonColumn',
//                    'viewButtonUrl'=>'Yii::app()->createUrl("complect/show",array("id"=>$data->id))'),
//	),
//)); 
?>

<?php //echo CHtml::link('Добавить комплект', Yii::app()->createUrl("complect/create"))?>
<table id="complect-grid-table"></table>
<div id="complect-grid-pager"></div>
<script type="text/javascript">
    $(function() {
        var grid=$("#complect-grid-table");
        var rowid;
        var lastSel;
        var iddb;
        jQuery("#complect-grid-table").jqGrid( {
            url : '<?echo Yii::app()->createUrl('complect/GetDataForGrid')?>',
            datatype : 'json',
            mtype : 'POST',
            width:'100%',
            height:'auto',
            hoverrows:false,
            sortable:true,
            autowidth:true,
            ignoreCase:true,
            colNames : ['iddb','Тип','Название','Комментарий'],
            colModel : [
                {name:'iddb',index:'id', width:20, hidden:true},
                {name:'complect_type_id', index:'complect_type_id', width:20,editable:true,edittype: 'select', editoptions: {value:<?echo Helpers::BuildEditOptionsForGrid(ComplectType::model(), array('key'=>'id','value'=>'name'))?>}},
                {name:'name', index:'name', width:100,editable:true},
                {name:'comment',index:'comment', width:100,editable:true}
                ],
            pager : '#complect-grid-table',
            rowNum : 0,
            pgbuttons: false,     // disable page control like next, back button
            pgtext: '',         // disable pager text like 'Page 0 of 10'
            viewrecords: false,
            sortname : 'product',
            sortorder : 'asc',
            caption : 'Продукты',
            editurl:'<?echo Yii::app()->createUrl('/complect/update');?>',
            ondblClickRow: function(id){
                if(id && id!==lastSel){ 
                    grid.restoreRow(lastSel); 
                    lastSel=id; 
                }
                 sel_=grid.getGridParam('selrow');
                iddb=grid.getCell(sel_, 'iddb');
                
                grid.editRow(id, true,null,null,'<?echo Yii::app()->createUrl('/complect/update')?>'+'?iddb='+iddb); 
            }
    }).navGrid('#complect-grid-table',{search:false, view:false, del:true, add:false, edit:false, cloneToTop:true, refresh:false},
        {
            closeAfterEdit: true
        },
        {
           closeAfterAdd:true
        },
        {
            onclickSubmit:function(){
                sel_=grid.getGridParam('selrow');
                iddb=grid.getCell(sel_, 'iddb');
                return {"iddb":iddb};
            }
        },
        {
            closeOnEscape:true,
            multipleSearch:true,
            closeAfterSearch:true            
        }
        );
    $('#complect-grid-table').jqGrid('navButtonAdd','#complect-grid-table',{
            caption: '',//'Группа',
            title: 'Добавить продукт',
            buttonicon: 'ui-icon-plusthick',
            onClickButton: function()
            {
               
               var last_row_id = grid.getGridParam("reccount");
               var row = {"iddb":last_row_id+1,"name":"","direction_id":""};
               if (lastSel) grid.restoreRow(lastSel);
               
               grid.addRowData(last_row_id+1,row,"last");
               grid.editRow(last_row_id+1,true,null,null,'<?echo Yii::app()->createUrl('/complect/create')?>',{},after_save,null,afterrestore); 
               lastSel=last_row_id+1;
            }
            //position:'last'
        });
        function afterrestore(rowid)
{
   $('#complect-grid-table').delRowData(rowid);
}
function after_save(rowID, response ) {
			  var ret_iddb = $.parseJSON(response.responseText);
//			  alert(ret_iddb);
			  $('#complect-grid-table').jqGrid('setCell',rowID,'iddb',ret_iddb.iddb);
                          iddb=ret_iddb;
		  }
     
  })


</script>