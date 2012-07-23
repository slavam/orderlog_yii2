<?php
$this->breadcrumbs=array(
	'Заявка'=>array('claim/show', 'id'=>$model->claim_id),
	'Изменить',
);

?>

<h1>Изменить строку заявки</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>