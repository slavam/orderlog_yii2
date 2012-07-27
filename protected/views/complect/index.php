<?php

$this->breadcrumbs=array(
	'Комплекты',
);

//$this->menu=array(
//	array('label'=>'Create Complect', 'url'=>array('create')),
//	array('label'=>'Manage Complect', 'url'=>array('admin')),
//);
?>

<h1>Комплекты</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'complect-grid',
	'dataProvider'=>$dataProvider,
        'enablePagination'=>false,
	'columns'=>array(
                array(
                'name'=>'Тип',
                'value'=>'$data->complectType->name'),
                array(
                'name'=>'Название',
                'value'=>'$data->name'),
//                array(
//                'name'=>'Комментарий',
//                'value'=>'$data->comment'),
                array(
                  'class'=>'CButtonColumn',
                  'viewButtonUrl'=>'Yii::app()->createUrl("complect/show",array("id"=>$data->id))', 
                ),
	),
)); ?>

<?php echo CHtml::link('Добавить комплект', Yii::app()->createUrl("complect/create"))?>