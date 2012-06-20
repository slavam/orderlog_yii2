<?php
$this->breadcrumbs=array(
	'Assets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Asset', 'url'=>array('index')),
	array('label'=>'Manage Asset', 'url'=>array('admin')),
);
?>

<h1>Create Asset</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>