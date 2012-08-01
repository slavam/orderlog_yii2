<?php
$this->breadcrumbs=array(
	'Товары'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Asset', 'url'=>array('index')),
	array('label'=>'Create Asset', 'url'=>array('create')),
	array('label'=>'Update Asset', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Asset', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Asset', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                array(               
                    'label'=>'Тип',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->waretype->name),
                ),
                array(               
                    'label'=>'Группа',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->assetGroup->name.'=>'.$model->assetGroup->block->name),
                ),
                array(               
                    'label'=>'Название',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->name),
                ),
                array(               
                    'label'=>'Цена',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->cost),
                ),
                array(               
                    'label'=>'Тип цены',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->priceType->name),
                ),
                array(               
                    'label'=>'Номенклатурный номер',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->part_number),
                ),
                array(               
                    'label'=>'Статья бюджета',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->budget_item_id ? $model->budgetItem->NAME.' ('.$model->budgetItem->CODE.')' : 'Не указана'),
                ),
                array(               
                    'label'=>'Направление',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->direction->name),
                ),
                array(               
                    'label'=>'Единица измерения',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->unit->sign),
                ),
                array(               
                    'label'=>'Дополнительная информация',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->info),
                ),
	),
)); ?>
