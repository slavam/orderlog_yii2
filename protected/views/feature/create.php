<?php
$this->breadcrumbs=array(
	'Характеристики'=>array('index'),
	'Создать',
);

//$this->menu=array(
//	array('label'=>'List Feature', 'url'=>array('index')),
//	array('label'=>'Manage Feature', 'url'=>array('admin')),
//);
?>

<h1>Создать характеристику</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>