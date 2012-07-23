<?php
$this->breadcrumbs=array(
	'Claim Line Products'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ClaimLineProduct', 'url'=>array('index')),
	array('label'=>'Create ClaimLineProduct', 'url'=>array('create')),
	array('label'=>'Update ClaimLineProduct', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClaimLineProduct', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClaimLineProduct', 'url'=>array('admin')),
);
?>

<h1>View ClaimLineProduct #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'claim_line_id',
		'product_id',
	),
)); ?>
