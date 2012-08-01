<?php
$this->breadcrumbs=array(
	'Характеристики');
?>

<!--<h1>Характеристики</h1>-->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'feature-grid',
	'dataProvider'=>$dataProvider,
        'enablePagination'=>false,
	'columns'=>array(
                array(
                'name'=>'Характеристика',
                'value'=>'$data->name'),
                array(
                'name'=>'Направление',
                'value'=>'$data->direction->name'),
            array(
                'class'=>'CButtonColumn',
                'buttons'=>array('view'=>array('visible'=>'false')),
                'updateButtonUrl'=>'Yii::app()->createUrl("feature/update",array("id"=>$data->id))'),

))); ?>

<?php echo CHtml::link('Добавить характеристику', Yii::app()->createUrl("feature/create"))?>
