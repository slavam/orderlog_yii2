<?php
$this->breadcrumbs=array(
	'Claim Lines'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClaimLine', 'url'=>array('index')),
	array('label'=>'Manage ClaimLine', 'url'=>array('admin')),
);
?>

<h1>Create ClaimLine</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>