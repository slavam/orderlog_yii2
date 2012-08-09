<?php
$this->breadcrumbs=array(
	'Продукты'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

//$this->menu=array(
//	array('label'=>'List Product', 'url'=>array('index')),
//	array('label'=>'Create Product', 'url'=>array('create')),
//	array('label'=>'View Product', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Product', 'url'=>array('admin')),
//);
?>

<h1>Изменить продукт</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>