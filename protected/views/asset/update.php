<?php
$this->breadcrumbs=array(
	'Товары'=>array('index'),
	$model->name=>array('show','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'List Asset', 'url'=>array('index')),
	array('label'=>'Create Asset', 'url'=>array('create')),
	array('label'=>'View Asset', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Asset', 'url'=>array('admin')),
);
?>

<h1>Изменить товар</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>