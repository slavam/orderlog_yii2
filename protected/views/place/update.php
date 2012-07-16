<?php
$this->breadcrumbs=array(
	'Places'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Place', 'url'=>array('index')),
	array('label'=>'Create Place', 'url'=>array('create')),
	array('label'=>'View Place', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Place', 'url'=>array('admin')),
);
?>

<h1>Update Place <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>