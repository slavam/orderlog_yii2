<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'claim-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
            <b>Отделение</b>
            <br>
            <?php echo $form->dropDownList($model,'division_id', Division::All());?> 
            <?php echo $form->error($model,'division_id'); ?>
	</div>

	<div class="row">
            <b>Подразделение</b>
            <br>
            <?php if ($model->division_id>0) {
                echo $form->dropDownList($model,'department_id', Department::findDepartmentsByDivision($model->division_id));
            } else {
                echo $form->dropDownList($model,'department_id', Department::findDepartments());
            }
            ?> 
            <?php echo $form->error($model,'department_id'); ?>
	</div>

        <div class="row">
            <b>Направление</b>
            <br>
            <?php echo $form->dropDownList($model,'direction_id', Direction::findDirections());?> 
            <?php echo $form->error($model,'direction_id'); ?>
	</div>

	<div class="row">
		<b>Период</b>
                <br>
		<?php echo $form->dropDownList($model,'period_id', Period::findPeriods());?> 
		<?php echo $form->error($model,'period_id'); ?>
	</div>

	<div class="row">
		<b>Комментарий</b>
                <br>
		<?php echo $form->textField($model,'comment',array('size'=>80)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<b>Описание</b>
                <br>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->