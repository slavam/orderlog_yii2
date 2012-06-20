<?php
$this->breadcrumbs=array(
	'Claims',
);

$this->menu=array(
	array('label'=>'Create Claim', 'url'=>array('create')),
	array('label'=>'Manage Claim', 'url'=>array('admin')),
);
?>

<h1>Claims</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'claim_number',
		'division_id',
		'direction_id',
		'state_id',
		/*
		'period_id',
		'comment',
		'description',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
