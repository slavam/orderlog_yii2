<?php
$this->breadcrumbs=array(
	'Claim Line Features'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClaimLineFeature', 'url'=>array('index')),
	array('label'=>'Create ClaimLineFeature', 'url'=>array('create')),
	array('label'=>'View ClaimLineFeature', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClaimLineFeature', 'url'=>array('admin')),
);
?>

<h1>Update ClaimLineFeature <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>