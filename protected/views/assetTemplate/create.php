<?php
$this->breadcrumbs=array(
	'Шаблоны'=>array('index'),
	'Создать',
);
?>

<h1>Создать шаблон</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>