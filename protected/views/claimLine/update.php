<?php
$this->breadcrumbs=array(
	'Claim Lines'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClaimLine', 'url'=>array('index')),
	array('label'=>'Create ClaimLine', 'url'=>array('create')),
	array('label'=>'View ClaimLine', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClaimLine', 'url'=>array('admin')),
);
?>

<h1>Update ClaimLine <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>