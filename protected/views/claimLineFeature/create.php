<?php
$this->breadcrumbs=array(
	'Характеристики строки заявки'=>array('featuresByClaimLine','claim_line_id'=>$claim_line_id),
	'Создать',
);

?>

<h1>Создать характеристику строки заявки</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'direction_id'=>$direction_id,'claim_line_id'=>$claim_line_id)); ?>