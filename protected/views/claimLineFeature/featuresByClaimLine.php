<?php
$this->breadcrumbs=array(
    'Строка заявки'=>array('claimLine/show', 'id'=>$dataProvider->data[0]->claim_line_id),
	'Характеристики строки заявки',
);

?>

<h1>Характеристики строки заявки</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim_line_feature-grid',
	'dataProvider'=>$dataProvider,
        'enablePagination'=>false,
	'columns'=>array(
                array(
                'name'=>'Характеристика',
                'value'=>'$data->feature->name'),
            array(
                'class'=>'CButtonColumn',
                'buttons'=>array(
                    'view'=>array('visible'=>'false'),
                    'update'=>array('visible'=>'false'),
                    'delete'=>array('url'=>'Yii::app()->createUrl("claimLineFeature/delete",array("id"=>$data->id))'), 
                
                ),
)))); ?>

<?php  echo CHtml::link('Добавить характеристику в строку', Yii::app()->createUrl("claimLineFeature/create",array("direction_id"=>$direction_id,"claim_line_id"=>$claim_line_id)))?>

