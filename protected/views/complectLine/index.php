<?php
$this->breadcrumbs=array(
	'Complect Lines',
);

$this->menu=array(
	array('label'=>'Create ComplectLine', 'url'=>array('create')),
	array('label'=>'Manage ComplectLine', 'url'=>array('admin')),
);
?>

<h1>Complect Lines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
