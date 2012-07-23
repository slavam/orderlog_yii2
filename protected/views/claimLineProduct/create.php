<?php
$this->breadcrumbs=array(
	'Продукты строки заявки'=>array('indexByLine','claim_line_id'=>$claim_line_id),
	'Создать',
);

?>

<h1>Создать продукт строки заявки</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'direction_id'=>$direction_id,'claim_line_id'=>$claim_line_id)); ?>