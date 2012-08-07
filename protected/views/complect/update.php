<?php
$this->breadcrumbs=array(
	'Комплекты'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

//$this->menu=array(
//	array('label'=>'List Complect', 'url'=>array('index')),
//	array('label'=>'Create Complect', 'url'=>array('create')),
//	array('label'=>'View Complect', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Complect', 'url'=>array('admin')),
//);
?>

<h1>Изменить комплект</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>