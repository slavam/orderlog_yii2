<?php
$this->breadcrumbs=array(
	'Группы товаров'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'List AssetGroup', 'url'=>array('index')),
	array('label'=>'Create AssetGroup', 'url'=>array('create')),
	array('label'=>'View AssetGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AssetGroup', 'url'=>array('admin')),
);
?>

<h1>Изменить группу товаров</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>