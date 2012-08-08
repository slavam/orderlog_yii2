<?php
$this->breadcrumbs=array(
	'Заявка'=>array('claim/show', 'id'=>$claim_id),
	'Создать',
);
?>

<h1>Выберите комплект</h1>

<div class="form">

<?php 
    echo CHtml::beginForm();
?>

	<div class="row">
		<b>Комплект</b>
                <br>
		<?php echo CHtml::dropDownList('complect_id',$complect_id, Complect::findComplects()); ?> 
	</div>
	<div class="row">
		<b>Бизнес</b>
                <br>
		<?php echo CHtml::dropDownList('business_id',$business_id, Business::findBusinesses()); ?>
	</div>
	<div class="row">
		<b>Для кого</b>
                <br>
		<?php echo CHtml::dropDownList('for_whom',$for_whom, Worker::findWorkers()); ?>
	</div>
        <div class="row buttons">
		<?php echo CHtml::submitButton('Выбрать'); ?>
	</div>

<?php // $this->endWidget();
    echo CHtml::endForm();
?>

</div><!-- form -->