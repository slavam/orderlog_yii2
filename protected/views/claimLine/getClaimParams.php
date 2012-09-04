<div class="form">
    
<?php 

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'claim-params-form',
)); ?>

	<div class="row">
            <b>Период</b>
            <br>
            <?php echo $form->dropDownList($model,'period_id',  Period::model()->findPeriods());?> 
            <?php echo $form->error($model,'period_id'); ?>
	</div>
	<div class="row">
            <b>Направление</b>
            <br>
            <?php echo $form->dropDownList($model,'direction_id', Direction::model()->findDirections());?> 
            <?php echo $form->error($model,'direction_id'); ?>
	</div>
    	<div class="row buttons">
            <?php echo CHtml::submitButton('Показать'); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
