<?php
$this->breadcrumbs=array(
	'Asset Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AssetGroup', 'url'=>array('index')),
	array('label'=>'Create AssetGroup', 'url'=>array('create')),
	array('label'=>'View AssetGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AssetGroup', 'url'=>array('admin')),
);
?>

<h1>Update AssetGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>