<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('claim_line_id')); ?>:</b>
	<?php echo CHtml::encode($data->claim_line_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('feature_id')); ?>:</b>
	<?php echo CHtml::encode($data->feature_id); ?>
	<br />


</div>