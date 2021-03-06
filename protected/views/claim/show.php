<?php
$this->breadcrumbs=array(
    'Заявки'=>array('index'),
    $model->claim_number,
);
?>

<h1>Заявка #<?php echo $model->claim_number; ?></h1>

<b>Номер :</b>
<?php echo $model->claim_number; ?>
<br />

<b>Направление :</b>
<?php echo $model->direction->name; ?>
<br />

<b>Отделение :</b>
<?php echo $model->division->NAME; ?>
<br />

<b>Подразделение :</b>
<?php echo ($model->findDepartment($model->department_id)); ?>
<br />

<b>Статус :</b>
<?php echo $model->state->stateName->name; ?>
<br />

<b>Период :</b>
<?php echo $model->period->NAME; ?>
<br />

<b>Комментарий :</b>
<?php echo $model->comment; ?>
<br />

<b>Описание :</b>
<?php echo $model->description; ?>
<br />

<?php $dataProvider=new CActiveDataProvider('ClaimLine', array(
           'criteria'=>array(
             'condition'=>'claim_id='.$model->id,
             'order'=>'id',
            ),
             'pagination'=>array(
             'pageSize'=>20,
           ),
          )); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim-line-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
                'name'=>'Тип',
                'value'=> '$data->asset->waretype->short_name'),
                array(
                'name'=>'Название',
                'value'=> '$data->asset->name'),
                array(
                'name'=>'Количество',
                'value'=>'$data->count." ".$data->asset->unit->sign'),
                array(
                'name'=>'Цена',
                'value'=>'$data->cost'),
                array(
                'name'=>'Сумма',
                'value'=>'$data->amount'),
                array(
                'name'=>'Примечание',
                'value'=>'$data->description'),
                array(
                  'class'=>'CButtonColumn',
                  'viewButtonUrl'=>'Yii::app()->createUrl("claimLine/show",array("id"=>$data->id))', 
                  'updateButtonUrl'=>'Yii::app()->createUrl("claimLine/update",array("id"=>$data->id))', 
                  'deleteButtonUrl'=>'Yii::app()->createUrl("claimLine/delete",array("id"=>$data->id))', 
                ),
	),
)); ?>
<?php echo CHtml::link(CHtml::encode('Добавить строку'), array('claimLine/create', 'claim_id'=>$model->id)); ?>
<br/>
<?php echo CHtml::link(CHtml::encode('Добавить комплект'), array('claimLine/createLinesByComplect', 'claim_id'=>$model->id)); ?>
<br/>
<?php 
  if ($model->state->stateName->name != "Согласовано")
  {
    echo CHtml::link(CHtml::encode($model->state->stateName->name == 'Черновик' ? 'На согласование':'Согласовано'), array('claim/changeClaimState', 'id'=>$model->id)); 
  }
?>  