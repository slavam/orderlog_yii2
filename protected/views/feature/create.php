<?php
$this->breadcrumbs=array(
	'Характеристики'=>array('index'),
	'Создать',
);

?>

<h1>Создать характеристику</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>