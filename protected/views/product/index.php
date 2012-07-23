<?php
$this->breadcrumbs=array(
	'Продукты',
);

$this->menu=array(
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>Продукты</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$dataProvider,
        'enablePagination'=>false,
	'columns'=>array(
                array(
                'name'=>'Продукт',
                'value'=>'$data->name'),
                array(
                'name'=>'Направление',
                'value'=>'$data->direction->name'),
))); ?>

<?php echo CHtml::link('Добавить продукт', Yii::app()->createUrl("product/create"))?>
