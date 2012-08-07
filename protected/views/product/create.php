<?php
$this->breadcrumbs=array(
	'Продукты'=>array('index'),
	'Создать',
);

//$this->menu=array(
//	array('label'=>'List Product', 'url'=>array('index')),
//	array('label'=>'Manage Product', 'url'=>array('admin')),
//);
?>

<h1>Создать продукт</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>