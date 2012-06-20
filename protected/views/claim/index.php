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

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
