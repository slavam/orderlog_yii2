<?php
$this->breadcrumbs=array(
	'Claims'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Claim', 'url'=>array('index')),
	array('label'=>'Manage Claim', 'url'=>array('admin')),
);
?>

<h1>Create Claim</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>