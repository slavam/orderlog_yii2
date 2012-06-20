<div class="view">

	<b>Номер заявки:</b>
	<?php echo CHtml::link(CHtml::encode($data->claim_number), array('show', 'id'=>$data->id)); ?>
	<br />


	<b>Отделение:</b>
	<?php echo $data->division->NAME; ?>
	<br />

	<b>Период:</b>
	<?php echo $data->period->NAME; ?>
	<br />


	<b>Направление:</b>
	<?php echo $data->direction->name; ?>
	<br />

	<b>Состояние:</b>
	<?php echo $data->state->stateName->name; ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('period_id')); ?>:</b>
	<?php echo CHtml::encode($data->period_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	*/ ?>

</div>