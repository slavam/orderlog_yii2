<?php
$this->breadcrumbs=array(
	'Группы товаров'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AssetGroup', 'url'=>array('index')),
	array('label'=>'Create AssetGroup', 'url'=>array('create')),
	array('label'=>'Update AssetGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssetGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssetGroup', 'url'=>array('admin')),
);
?>

<h1>Группа товаров</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                array(               
                    'label'=>'Супергруппа',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->block->name),
                             
                ),
                array(               
                    'label'=>'Группа',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->name)
                ),
	),
)); ?>