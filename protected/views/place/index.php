<?php
$this->breadcrumbs=array(
	'Places',
);

$this->menu=array(
	array('label'=>'Create Place', 'url'=>array('create')),
	array('label'=>'Manage Place', 'url'=>array('admin')),
);
?>

<h1>Адреса</h1>

<?php 
//var_dump($dataProvider);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'place-grid',
	'dataProvider'=>$dataProvider,
//        'enablePagination'=>false,
	'columns'=>array(
                array(
                'name'=>'Адрес',
                'value'=>'$data[\'title\']'),
                ),
//                array(
//                  'class'=>'CButtonColumn',
//                  'viewButtonUrl'=>'Yii::app()->createUrl("claim/show",array("id"=>$data->id))', 
//                ),
//	),
)); ?>


<?php echo CHtml::link(CHtml::encode('Дерево'), array('tree')); ?>