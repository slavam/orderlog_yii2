<?php

$this->breadcrumbs=array(
	'Товары'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'List Asset', 'url'=>array('index')),
	array('label'=>'Manage Asset', 'url'=>array('admin')),
);
?>

<h1>Создать товар</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>