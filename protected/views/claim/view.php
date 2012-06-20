<?php
$this->breadcrumbs=array(
	'Заявки'=>array('index'),
	$model->claim_number,
);

$this->menu=array(
	array('label'=>'Заявки', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Claim', 'url'=>array('admin')),
);
?>

<h1>View Claim #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'claim_number',
		'division_id',
		'create_date',
		'budgetary',
		'direction_id',
		'state_id',
		'period_id',
		'comment',
		'description',
	),
)); ?>
