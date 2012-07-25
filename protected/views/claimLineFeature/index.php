<?php
$this->breadcrumbs=array(
	'Claim Line Features',
);

$this->menu=array(
	array('label'=>'Create ClaimLineFeature', 'url'=>array('create')),
	array('label'=>'Manage ClaimLineFeature', 'url'=>array('admin')),
);
?>

<h1>Claim Line Features</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
