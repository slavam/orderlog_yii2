<?php
$this->breadcrumbs=array(
	'Claim Lines',
);

$this->menu=array(
	array('label'=>'Create ClaimLine', 'url'=>array('create')),
	array('label'=>'Manage ClaimLine', 'url'=>array('admin')),
);
?>

<h1>Claim Lines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
