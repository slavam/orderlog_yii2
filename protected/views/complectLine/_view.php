<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('complect_id')); ?>:</b>
	<?php echo CHtml::encode($data->complect_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asset_id')); ?>:</b>
	<?php echo CHtml::encode($data->asset_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />


</div>