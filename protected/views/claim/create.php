<?php
$this->breadcrumbs=array(
	'Заявки'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'List Claim', 'url'=>array('index')),
	array('label'=>'Manage Claim', 'url'=>array('admin')),
);
?>

<h1>Создать заявку</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>