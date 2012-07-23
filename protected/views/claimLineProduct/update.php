<?php
$this->breadcrumbs=array(
	'Claim Line Products'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClaimLineProduct', 'url'=>array('index')),
	array('label'=>'Create ClaimLineProduct', 'url'=>array('create')),
	array('label'=>'View ClaimLineProduct', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClaimLineProduct', 'url'=>array('admin')),
);
?>

<h1>Update ClaimLineProduct <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>