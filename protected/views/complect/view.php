<?php
$this->breadcrumbs=array(
	'Complects'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Complect', 'url'=>array('index')),
	array('label'=>'Create Complect', 'url'=>array('create')),
	array('label'=>'Update Complect', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Complect', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Complect', 'url'=>array('admin')),
);
?>

<h1>View Complect #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'complect_type_id',
		'name',
		'comment',
	),
)); ?>
