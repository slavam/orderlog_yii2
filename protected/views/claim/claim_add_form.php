<?php $form=$this->beginWidget('CActiveForm', array(
//    'action'=>'editClaim',
    'id'=>'whole-claim-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation' => true,
)); ?>
<?php echo $form->errorSummary($model); ?>
<table class="table_edit">
    <tr>
    	<td>
    		<table >
    		<tr>
		        <td><b>Направление</b></td>
		        <td><?php echo $form->dropDownList($model,'direction_id',Direction::model()->findDirections(),array('empty'=>'<Выберите направление>'));?> 
		            <?php echo $form->error($model,'direction_id'); ?></td>
            </tr>
            <tr>
		        <td><b>Отделение</b></td>
		        <td>
		            <?php echo $form->dropDownList($model,'division_id', Division::model()->All(),array('onChange'=>'getDepartments()','empty'=>'<Выберите отделение>'));?> 
		            <?php echo $form->error($model,'division_id'); ?>
		        </td>        
            </tr>
            <tr>
		        <td><b>Подразделение</b></td>
		        <td>
		            <?php 
                            if ($model->division_id>0) {
		                echo $form->dropDownList($model,'department_id', $model->id?Department::model()->findDepartmentsByDivision($model->division_id):array(),array('empty'=>'<Выберите подразделение>'));
		            } else {
		                echo $form->dropDownList($model,'department_id', $model->id?Department::model()->findDepartments():array(),array('empty'=>'<Выберите подразделение>'));
		            }
		            ?> 
		            <?php echo $form->error($model,'department_id'); ?>
		        </td>
            </tr>
		    <tr>
		        <td><b>Комментарий</b></td>
		        <td>
		            <?php echo $form->textField($model,'comment',array('size'=>60)); ?>
				<?php echo $form->error($model,'comment'); ?>
		        </td>
		    </tr>
            </table>
        </td>
        <td>
        	<table>
        	<tr>
		        <td><b>Период</b></td>
		        <td><?php echo $form->dropDownList($model,'period_id', Period::model()->findPeriods(),array('empty'=>'<Выберите период>'));?> 
		            <?php echo $form->error($model,'period_id'); ?></td>
		    	</td>
        	</tr>
        	<tr>
		        <td><b>Описание</b></td>
		        <td>
		            <?php echo $form->textArea($model,'description',array('rows'=>5, 'cols'=>60)); ?>
				<?php echo $form->error($model,'description'); ?>
		        </td>
        	</tr>
        	</table>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>