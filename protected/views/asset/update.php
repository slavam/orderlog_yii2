<?php
$this->breadcrumbs=array(
	'Assets'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Asset', 'url'=>array('index')),
	array('label'=>'Create Asset', 'url'=>array('create')),
	array('label'=>'View Asset', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Asset', 'url'=>array('admin')),
);
?>

<h1>Update Asset <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>