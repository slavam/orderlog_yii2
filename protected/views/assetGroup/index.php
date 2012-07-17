<?php
$cs = Yii::app()->clientScript;
 
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/ui.jqgrid.css');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/jqgrid/themes/redmond/jquery-ui-custom.css');
 
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/i18n/grid.locale-ru.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/jqgrid/js/jquery.jqGrid.min.js');
$this->breadcrumbs=array(
	'Группы товаров',
);

$this->menu=array(
	array('label'=>'Create AssetGroup', 'url'=>array('create')),
	array('label'=>'Manage AssetGroup', 'url'=>array('admin')),
);
?>
<script type="text/javascript">
   $.jgrid.no_legacy_api = true;
   $.jgrid.useJSON = true;
</script>
<div>
    <?php //include ("getDataForGrid.php");?>
</div>
<br/> 
<table id="list"></table> 
<div id="pager"></div> 


<script type="text/javascript">
$(function() {
    var lastSel;
    jQuery("#list").jqGrid( {
        url : 'index.php/?r=assetGroup/getDataForGrid',
        datatype : 'json',
        width : 600,
        height : 'autoheight',
        mtype : 'GET',
        colNames : [ 'ID', 'Группа', 'Супергруппа' ],
        colModel : [ {
            name : 'id',
            index : 'id',
            width : 60
        }, {
            name : 'name',
            index : 'name',
            width : 150,
            editable:true
        }, {
            name : 'b_name',
            index : 'b_name',
            width : 120
        } ],
        pager : '#pager',
        rowNum : 30,
        rowList : [ 10, 20, 30 ],
        sortname : 'id',
        sortorder : 'desc',
        viewrecords : true,
        caption : 'Группы товаров',
        
        ondblClickRow: function(id) {
            if (id && id != lastSel) {
                jQuery("#list").restoreRow(lastSel);
                jQuery("#list").editRow(id, true);
                lastSel = id;
            }
        },
        editurl: 'index.php/?r=assetGroup/updateRow'

    }).navGrid('#pager',{view:true, del:false, add:true, edit:true},
      {
        
      }, // default settings for edit
      {

      }, // default settings for add
      {}, // delete instead that del:false we need this
      {
          closeOnEscape:true, multipleSearch:true, closeAfterSearch:true,
          sopt:['eq','cn']
      }, // search options

      {
          width:700
      } /* view parameters*/
      );

});
</script>
<!--<h1>Группы товаров</h1>-->

<?php // $this->widget('zii.widgets.grid.CGridView', array(
//	'id'=>'claim-grid',
//	'dataProvider'=>$dataProvider,
//	'columns'=>array(
//                array(
//                'name'=>'Супергруппа',
//                'value'=>'$data->block->name',
//                ),
//                array(
//                'name'=>'Группа',
//                'value'=>'$data->name',
//                ),
//                array(
//                  'class'=>'CButtonColumn',
//                  'viewButtonUrl'=>'Yii::app()->createUrl("assetGroup/show",array("id"=>$data->id))', 
//                ),
//    ))); ?>
<?php //echo CHtml::link('Добавить группу', Yii::app()->createUrl("assetGroup/create"))?>