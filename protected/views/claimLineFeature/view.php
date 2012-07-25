<?php
$this->breadcrumbs=array(
	'Claim Line Features'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ClaimLineFeature', 'url'=>array('index')),
	array('label'=>'Create ClaimLineFeature', 'url'=>array('create')),
	array('label'=>'Update ClaimLineFeature', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClaimLineFeature', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClaimLineFeature', 'url'=>array('admin')),
);
?>

<h1>View ClaimLineFeature #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'claim_line_id',
		'feature_id',
	),
)); ?>
