<?php
$cs = Yii::app()->clientScript;    
            $cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
            $cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery-ui-custom.min.js');
            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js',CClientScript::POS_HEAD);
$this->breadcrumbs=array(
	'Продукты',
);

//$this->menu=array(
//	array('label'=>'Create Product', 'url'=>array('create')),
//	array('label'=>'Manage Product', 'url'=>array('admin')),
//);
?>

<!--<h1>Продукты</h1>-->

<?php 
//$this->widget('zii.widgets.grid.CGridView', array(
////	'id'=>'product-grid',
//	'dataProvider'=>$dataProvider,
//        'enablePagination'=>false,
//	'columns'=>array(
//            array(
//                'name'=>'Продукт',
//                'value'=>'$data->name'),
//            array(
//                'name'=>'Направление',
//                'value'=>'$data->direction->name'),
//            array(
//                'class'=>'CButtonColumn',
//                'buttons'=>array('view'=>array('visible'=>'false')),
//                'updateButtonUrl'=>'Yii::app()->createUrl("product/update",array("id"=>$data->id))'),
//))); ?>

<table id="product-grid-table"></table>
<div id="product-grid-pager"></div>

    

<script type="text/javascript">
    $(function() {
        var grid=$("#product-grid-table");
        var rowid;
        var lastSel;
        jQuery("#product-grid-table").jqGrid( {
            url : '<?echo Yii::app()->createUrl('product/index')?>',
            datatype : 'json',
            mtype : 'GET',
            width:'100%',
            height:'auto',
            hoverrows:false,
            sortable:true,
            autowidth:true,
            ignoreCase:true,
            colNames : ['id','Продукт','Направление'],
            colModel : [
                {name:'id',index:'id', width:20, hidden:true},
                {name:'name', index:'name', width:70,editable:true},
                {name:'direction_id',index:'direction_id', width:100,editable:true,edittype: 'select', editoptions: {value:<?echo Direction::model()->findDirectionsJqgrid()?>}}
                ],
            pager : '#product-grid-pager',
            rowNum : 0,
            pgbuttons: false,     // disable page control like next, back button
            pgtext: '',         // disable pager text like 'Page 0 of 10'
            viewrecords: false,
            sortname : 'product',
            sortorder : 'asc',
            caption : 'Продукты',
            editurl:'<?echo Yii::app()->createUrl('/product/update');?>',
            ondblClickRow: function(id){
                if(id && id!==lastSel){ 
                    grid.restoreRow(lastSel); 
                    lastSel=id; 
                }
                grid.editRow(id, true); 
            }
    }).navGrid('#product-grid-pager',{search:false, view:false, del:true, add:false, edit:false, cloneToTop:true, refresh:false},
        {
            closeAfterEdit: true
        },
        {
           closeAfterAdd:true
        },
        {
            editData:{id:grid.jqGrid('getGridParam','selrow')}
        },
        {
            closeOnEscape:true,
            multipleSearch:true,
            closeAfterSearch:true
        }
        );
    $('#product-grid-table').jqGrid('navButtonAdd','#product-grid-pager',{
            caption: '',//'Группа',
            title: 'Добавить продукт',
            buttonicon: 'ui-icon-plusthick',
            onClickButton: function()
            {
                var last_row_id = grid.getGridParam("reccount");

                var _node = {"rows":[{}],position:"last"};
                var row = {"id":last_row_id+1,"name":"","direction_id":""};
                
//                parameters =
//                {
//                    rowID : "345345",
//                    initdata : {"id":223231,"name":"","direction_id":""},
//                    position :"last",
//                    useDefValues : false,
//                    useFormatter : false,
//                    addRowParams : {extraparam:{}}
//                }
//                grid.jqGrid ('addRowData',last_row_id+1, _node.rows[0].parent, _node.rows[0]);
               grid.addRowData(last_row_id+1,row,"last");
               grid.editRow(last_row_id+1,true,null,null,'<?echo Yii::app()->createUrl('/product/create')?>'); 
            }
            //position:'last'
        });
     
  })
  
</script>
<?
//$this->widget('application.components.jqgrid',array('dataProvider'=>$dataProvider,'gridId'=>'product_grid','options'=>array(
//    'url'=>'222',
//    'mtype'=>'GET',
//    'width'=>'100%',
//     'height'=>'auto',
//     'hoverrows'=>false,
//     'sortable'=>true,
//     'autowidth'=>true,
//     'ignoreCase'=>true,
//)));
?>

<?php // echo CHtml::link('Добавить продукт', Yii::app()->createUrl("product/create"))?>
