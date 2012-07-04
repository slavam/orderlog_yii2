<?php
$this->breadcrumbs=array(
	'Группы товаров'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'List AssetGroup', 'url'=>array('index')),
	array('label'=>'Manage AssetGroup', 'url'=>array('admin')),
);
?>

<h1>Создать группу товаров</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>