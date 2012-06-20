<?php
$this->breadcrumbs=array(
	'Blocks'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Block', 'url'=>array('index')),
	array('label'=>'Create Block', 'url'=>array('create')),
	array('label'=>'View Block', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Block', 'url'=>array('admin')),
);
?>

<h1>Update Block <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>