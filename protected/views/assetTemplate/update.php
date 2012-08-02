<?php
$this->breadcrumbs=array(
	'Шаблоны'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

//$this->menu=array(
//	array('label'=>'List AssetTemplate', 'url'=>array('index')),
//	array('label'=>'Create AssetTemplate', 'url'=>array('create')),
//	array('label'=>'View AssetTemplate', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage AssetTemplate', 'url'=>array('admin')),
//);
?>

<h1>Изменить шаблон</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>