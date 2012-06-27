<?php
$this->breadcrumbs=array(
	'Asset Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AssetGroup', 'url'=>array('index')),
	array('label'=>'Manage AssetGroup', 'url'=>array('admin')),
);
?>

<h1>Create AssetGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>