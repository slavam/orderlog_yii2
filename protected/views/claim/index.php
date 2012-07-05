<?php
$this->breadcrumbs=array(
	'Заявки',
);

$this->menu=array(
	array('label'=>'Create Claim', 'url'=>array('create')),
	array('label'=>'Manage Claim', 'url'=>array('admin')),
);
?>

<h1>Заявки</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim-grid',
	'dataProvider'=>$dataProvider,
        'enablePagination'=>false,
	'columns'=>array(
                array(
                'name'=>'Номер',
                'value'=>'$data->claim_number',
//                'value'=> 'CHtml::link($data->claim_number,
//                             Yii::app()->createUrl("claim/show",array("id"=>$data->primaryKey)))',
//                'type'  => 'raw',    
                ),
            
            
                array(
                'name'=>'Период',
                'value'=>'$data->period->NAME'),
                array(
                'name'=>'Статус',
                'value'=>' $data->state->stateName->name '),
                array(
                'name'=>'Отделение',
                'value'=>'$data->division->NAME'),
                array(
                'name'=>'Комментарий',
                'value'=>'$data->comment'),
                array(
                  'class'=>'CButtonColumn',
                  'viewButtonUrl'=>'Yii::app()->createUrl("claim/show",array("id"=>$data->id))', 
                ),
	),
)); ?>

<?php echo CHtml::link('Добавить заявку', Yii::app()->createUrl("claim/create"))?>

