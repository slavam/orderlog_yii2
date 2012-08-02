<?php
$this->breadcrumbs=array(
	'Шаблоны',
);

//$this->menu=array(
//	array('label'=>'Create AssetTemplate', 'url'=>array('create')),
//	array('label'=>'Manage AssetTemplate', 'url'=>array('admin')),
//);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'asset-template-grid',
	'dataProvider'=>$dataProvider,
        'enablePagination'=>false,
	'columns'=>array(
                array(
                'name'=>'Название',
                'value'=>'$data->name'),
//                array(
//                'name'=>'Направление',
//                'value'=>'$data->direction->name'),
            array(
                'class'=>'CButtonColumn',
                'viewButtonUrl'=>'Yii::app()->createUrl("assetTemplate/show",array("id"=>$data->id))',
                'updateButtonUrl'=>'Yii::app()->createUrl("assetTemplate/update",array("id"=>$data->id))',
),
))); ?>

<?php echo CHtml::link('Добавить шаблон', Yii::app()->createUrl("assetTemplate/create"))?>
