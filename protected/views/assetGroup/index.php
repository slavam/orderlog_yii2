<?php
$this->breadcrumbs=array(
	'Группы товаров',
);

$this->menu=array(
	array('label'=>'Create AssetGroup', 'url'=>array('create')),
	array('label'=>'Manage AssetGroup', 'url'=>array('admin')),
);
?>

<h1>Группы товаров</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
                array(
                'name'=>'Супергруппа',
                'value'=>'$data->block->name',
                ),
                array(
                'name'=>'Группа',
                'value'=>'$data->name',
                ),
                array(
                  'class'=>'CButtonColumn',
                  'viewButtonUrl'=>'Yii::app()->createUrl("assetGroup/show",array("id"=>$data->id))', 
                ),
            
    ))); ?>
<?php echo CHtml::link('Добавить группу', Yii::app()->createUrl("assetGroup/create"))?>