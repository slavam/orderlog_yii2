<?php
$cs = Yii::app()->clientScript;    
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);

?>

<!--<h1>Характеристики</h1>-->

<?php 
//$this->widget('zii.widgets.grid.CGridView', array(
//	'id'=>'feature-grid',
//	'dataProvider'=>$dataProvider,
//        'enablePagination'=>false,
//	'columns'=>array(
//                array(
//                'name'=>'Характеристика',
//                'value'=>'$data->name'),
//                array(
//                'name'=>'Направление',
//                'value'=>'$data->direction->name'),
//            array(
//                'class'=>'CButtonColumn',
//                'buttons'=>array('view'=>array('visible'=>'false')),
//                'updateButtonUrl'=>'Yii::app()->createUrl("feature/update",array("id"=>$data->id))'),
//
//))); 
?>

<?php 
// echo CHtml::link('Добавить характеристику', Yii::app()->createUrl("feature/create"))?>


<table id="feature-grid-table"></table>
<div id="feature-grid-pager"></div>

    

<script type="text/javascript">
    $(function() {
        var grid=$("#feature-grid-table");
        var rowid;
        var lastSel;
        var iddb;
        jQuery("#feature-grid-table").jqGrid( {
            url : '<?echo Yii::app()->createUrl('feature/GetDataForGrid')?>',
            datatype : 'json',
            mtype : 'POST',
            width:'100%',
            height:'auto',
            hoverrows:false,
            sortable:true,
            autowidth:true,
            ignoreCase:true,
            colNames : ['iddb','Характеристика','Направление'],
            colModel : [
                {name:'iddb',index:'id', width:20, hidden:true},
                {name:'name', index:'name', width:70,editable:true},
//                {name:'direction_id',index:'direction_id', width:100,editable:true,edittype: 'select', editoptions: {value:<?//echo Direction::model()->findDirectionsJqgrid()?>}}
{name:'direction_id',index:'direction_id', width:100,editable:true,edittype: 'select', editoptions: {value:<?echo Helpers::BuildEditOptions(Direction::model(), array('key'=>'id','value'=>'name'))?>}}
                ],
            pager : '#feature-grid-table',
            rowNum : 0,
            pgbuttons: false,     // disable page control like next, back button
            pgtext: '',         // disable pager text like 'Page 0 of 10'
            viewrecords: false,
            sortname : 'product',
            sortorder : 'asc',
            caption : 'Характеристики',
            editurl:'<?echo Yii::app()->createUrl('/feature/update');?>',
            ondblClickRow: function(id){
                if(id && id!==lastSel){ 
                    grid.restoreRow(lastSel); 
                    lastSel=id; 
                }
                 sel_=grid.getGridParam('selrow');
                iddb=grid.getCell(sel_, 'iddb');
                
                grid.editRow(id, true,null,null,'<?echo Yii::app()->createUrl('/feature/update')?>'+'?iddb='+iddb); 
            }
    }).navGrid('#feature-grid-table',{search:false, view:false, del:true, add:false, edit:false, cloneToTop:true, refresh:false},
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
    $('#feature-grid-table').jqGrid('navButtonAdd','#feature-grid-table',{
            caption: '',//'Группа',
            title: 'Добавить характеристику',
            buttonicon: 'ui-icon-plusthick',
            onClickButton: function()
            {
               
               var last_row_id = grid.getGridParam("reccount");
               var row = {"iddb":last_row_id+1,"name":"","direction_id":""};
               if (lastSel) grid.restoreRow(lastSel);
               
               grid.addRowData(last_row_id+1,row,"last");
               grid.editRow(last_row_id+1,true,null,null,'<?echo Yii::app()->createUrl('/feature/create')?>',{},after_save,null,afterrestore); 
               lastSel=last_row_id+1;
            }
            //position:'last'
        });
        function afterrestore(rowid)
{
   $('#feature-grid-table').delRowData(rowid);
}
function after_save(rowID, response ) {
			  var ret_iddb = $.parseJSON(response.responseText);
//			  alert(ret_iddb);
			  $('#feature-grid-table').jqGrid('setCell',rowID,'iddb',ret_iddb.iddb);
                          iddb=ret_iddb;
		  }
     
  })


</script>