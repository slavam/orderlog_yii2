<?php
$this->breadcrumbs=array(
	'Товары'=>array('asset/index'),
	'Создать',
);
?>

<h1>Создать товар по шаблону "<?php echo $model->name?>"</h1>

<?php echo $this->renderPartial('_formTemplate', array('model'=>$model)); ?>