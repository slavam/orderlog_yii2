<?php
$this->breadcrumbs=array(
	'Комплект'=>array('complect/show', 'id'=>$model->complect_id),
//	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

//$this->menu=array(
//	array('label'=>'List ComplectLine', 'url'=>array('index')),
//	array('label'=>'Create ComplectLine', 'url'=>array('create')),
//	array('label'=>'View ComplectLine', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage ComplectLine', 'url'=>array('admin')),
//);
?>

<h1>Изменить строку комплекта "<?php echo $model->complect->name?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>