<?php
$this->breadcrumbs=array(
	'Assets'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Asset', 'url'=>array('index')),
	array('label'=>'Create Asset', 'url'=>array('create')),
	array('label'=>'Update Asset', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Asset', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Asset', 'url'=>array('admin')),
);
?>

<h1>View Asset #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'part_number',
		'ware_type_id',
		'budget_item_id',
		'cost',
		'direction_id',
		'asset_group_id',
		'info',
		'unit_id',
                    array(               
                    'name'=>'place_id',
                    'type'=>'raw',
                    'value'=>$this->replacementPlace($model->place_id),
                ),          
//		'place_id',
	),
)); ?>
