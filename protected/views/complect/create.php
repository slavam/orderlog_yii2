<?php
$this->breadcrumbs=array(
	'Комплекты'=>array('index'),
	'Создать',
);

//$this->menu=array(
//	array('label'=>'List Complect', 'url'=>array('index')),
//	array('label'=>'Manage Complect', 'url'=>array('admin')),
//);
?>

<h1>Создать комплект</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>