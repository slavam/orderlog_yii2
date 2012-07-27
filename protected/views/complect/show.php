<?php
$this->breadcrumbs=array(
    'Комплекты'=>array('index'),
//    $model->claim_number,
);
?>

<?php if ($model->complect_type_id==1): ?>
    <h1>Шаблон "<?php echo $model->name; ?>"</h1>
<?php  else : ?>
    <h1>Набор "<?php echo $model->name; ?>"</h1>
<?php endif; ?>

<b>Комментарий :</b>
<?php echo $model->comment; ?>
<br />

<?php $dataProvider=new CActiveDataProvider('ComplectLine', array(
           'criteria'=>array(
             'condition'=>'complect_id='.$model->id,
             'order'=>'id',
            ),
             'pagination'=>array(
             'pageSize'=>20,
            ),
          )); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'complect-line-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
                'name'=>'Тип',
                'value'=> '$data->asset->wareType->short_name'),
                array(
                'name'=>'Название',
                'value'=> '$data->asset->name'),
                array(
                'name'=>'Количество',
                'value'=>'$data->amount'),
                array(
                  'class'=>'CButtonColumn',
                  'viewButtonUrl'=>'Yii::app()->createUrl("complectLine/show",array("id"=>$data->id))', 
                  'updateButtonUrl'=>'Yii::app()->createUrl("complectLine/update",array("id"=>$data->id))', 
                  'deleteButtonUrl'=>'Yii::app()->createUrl("complectLine/delete",array("id"=>$data->id))', 
                ),
	),
)); ?>
<?php echo CHtml::link(CHtml::encode('Добавить строку'), array('complectLine/create', 'complect_id'=>$model->id)); ?>  