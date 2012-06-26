<?php
$this->breadcrumbs=array(
	'Заявка'=>array('claim/show', 'id'=>$model->claim_id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'List ClaimLine', 'url'=>array('index')),
	array('label'=>'Create ClaimLine', 'url'=>array('create')),
	array('label'=>'View ClaimLine', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClaimLine', 'url'=>array('admin')),
);
?>

<h1>Изменить строку заявки</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>