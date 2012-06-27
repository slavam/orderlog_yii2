<?php
$this->breadcrumbs=array(
	'Asset Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AssetGroup', 'url'=>array('index')),
	array('label'=>'Create AssetGroup', 'url'=>array('create')),
	array('label'=>'Update AssetGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssetGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssetGroup', 'url'=>array('admin')),
);
?>

<h1>View AssetGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'block_id',
	),
)); ?>
