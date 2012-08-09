<?php

$this->breadcrumbs=array(
	'Товары'=>array('index'),
	'Создать',
);
?>

<h1>Создать товар</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>