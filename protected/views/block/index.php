<?php
$this->breadcrumbs=array(
	'Супергруппы',
);

$this->menu=array(
	array('label'=>'Создать супергруппу', 'url'=>array('create')),
	array('label'=>'Manage Block', 'url'=>array('admin')),
);
?>

<h1>Супергруппы</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
                array(
                'name'=>'Название',
                'value'=>'$data->name',
            ),
            array(
                'class'=>'CButtonColumn',
            ),
            
))); ?>

<?php echo CHtml::link('Добавить супергруппу', Yii::app()->createUrl("block/create"))?>