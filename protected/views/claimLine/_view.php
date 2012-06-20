<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('claim_id')); ?>:</b>
	<?php echo CHtml::encode($data->claim_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('count')); ?>:</b>
	<?php echo CHtml::encode($data->count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('for_whom')); ?>:</b>
	<?php echo CHtml::encode($data->for_whom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state_id')); ?>:</b>
	<?php echo CHtml::encode($data->state_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('change_date')); ?>:</b>
	<?php echo CHtml::encode($data->change_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->budget_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asset_id')); ?>:</b>
	<?php echo CHtml::encode($data->asset_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_id')); ?>:</b>
	<?php echo CHtml::encode($data->business_id); ?>
	<br />

	*/ ?>

</div>