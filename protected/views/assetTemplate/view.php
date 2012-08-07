<?php
$this->breadcrumbs=array(
	'Asset Templates'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AssetTemplate', 'url'=>array('index')),
	array('label'=>'Create AssetTemplate', 'url'=>array('create')),
	array('label'=>'Update AssetTemplate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssetTemplate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssetTemplate', 'url'=>array('admin')),
);
?>

<h1>View AssetTemplate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
