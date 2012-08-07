<?php
$this->breadcrumbs=array(
	'Заявка'=>array('claim/show', 'id'=>$model->claim_id),
	'Создать',
);

?>

<h1>Создать строку заявки</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>