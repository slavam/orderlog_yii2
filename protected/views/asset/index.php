<?php
$this->breadcrumbs=array(
	'Товары',
);

$this->menu=array(
	array('label'=>'Create Asset', 'url'=>array('create')),
	array('label'=>'Manage Asset', 'url'=>array('admin')),
);
?>

<h1>Товары</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
                array(
                'name'=>'Тип',
                'value'=>'$data->wareType->short_name',
//                'value'=> 'CHtml::link($data->claim_number,
//                             Yii::app()->createUrl("claim/show",array("id"=>$data->primaryKey)))',
//                'type'  => 'raw',    
                ),
            
            
                array(
                'name'=>'Группа',
                'value'=>'$data->assetGroup->name'),
                array(
                'name'=>'Название',
                'value'=>' $data->name '),
                array(
                  'class'=>'CButtonColumn',
                  'viewButtonUrl'=>'Yii::app()->createUrl("asset/show",array("id"=>$data->id))', 
                ),
            
            ),

)); ?>


<?php //
//    $this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); 
?>
