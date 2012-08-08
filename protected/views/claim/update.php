<?php
$this->breadcrumbs=array(
	'Заявки'=>array('index'),
	$model->claim_number=>array('show','id'=>$model->id),
	'Изменить',
);

//$this->menu=array(
//	array('label'=>'List Claim', 'url'=>array('index')),
//	array('label'=>'Create Claim', 'url'=>array('create')),
//	array('label'=>'View Claim', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Claim', 'url'=>array('admin')),
//);
?>

<h1>Изменить заявку <?php echo $model->claim_number; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>