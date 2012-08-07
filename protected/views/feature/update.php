<?php
$this->breadcrumbs=array(
	'Характеристики'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

//$this->menu=array(
//	array('label'=>'List Feature', 'url'=>array('index')),
//	array('label'=>'Create Feature', 'url'=>array('create')),
//	array('label'=>'View Feature', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Feature', 'url'=>array('admin')),
//);
?>

<h1>Изменить характеристику</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>