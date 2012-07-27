<?php
$this->breadcrumbs=array(
	'Комплект'=>array('complect/show', 'id'=>$model->complect_id),
	'Создать',
);

//$this->menu=array(
//	array('label'=>'List ComplectLine', 'url'=>array('index')),
//	array('label'=>'Manage ComplectLine', 'url'=>array('admin')),
//);
?>

<h1>Создать строку комплекта "<?php echo $model->complect->name?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>