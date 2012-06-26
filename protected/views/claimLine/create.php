<?php
$this->breadcrumbs=array(
	'Claim Lines'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'List ClaimLine', 'url'=>array('index')),
	array('label'=>'Manage ClaimLine', 'url'=>array('admin')),
);
?>

<h1>Создать строку заявки</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>