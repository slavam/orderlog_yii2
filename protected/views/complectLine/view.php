<?php
$this->breadcrumbs=array(
	'Complect Lines'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ComplectLine', 'url'=>array('index')),
	array('label'=>'Create ComplectLine', 'url'=>array('create')),
	array('label'=>'Update ComplectLine', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ComplectLine', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ComplectLine', 'url'=>array('admin')),
);
?>

<h1>View ComplectLine #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'complect_id',
		'asset_id',
		'amount',
	),
)); ?>
