<?php
$this->breadcrumbs=array(
	'Claim Lines'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ClaimLine', 'url'=>array('index')),
	array('label'=>'Create ClaimLine', 'url'=>array('create')),
	array('label'=>'Update ClaimLine', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClaimLine', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClaimLine', 'url'=>array('admin')),
);
?>

<h1>View ClaimLine #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'claim_id',
		'count',
		'amount',
		'description',
		'for_whom',
		'state_id',
		'change_date',
		'budget_item_id',
		'asset_id',
		'cost',
		'business_id',
	),
)); ?>
