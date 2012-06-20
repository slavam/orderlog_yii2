<?php
$this->breadcrumbs=array(
	'Супергруппы',
);

$this->menu=array(
	array('label'=>'Создать супергруппу', 'url'=>array('create')),
	array('label'=>'Manage Block', 'url'=>array('admin')),
);
?>

<h1>Blocks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
