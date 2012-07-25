<?php
$this->breadcrumbs=array(
    'Строка заявки'=>array('claimLine/show', 'id'=>$dataProvider->data[0]->claim_line_id),
	'Продукты строки заявки',
);

?>

<h1>Продукты строки заявки</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim_line_product-grid',
	'dataProvider'=>$dataProvider,
        'enablePagination'=>false,
	'columns'=>array(
                array(
                'name'=>'Название продукта',
                'value'=>'$data->product->name'),
            array(
                'class'=>'CButtonColumn',
                'buttons'=>array(
                    'view'=>array('visible'=>'false'),
                    'update'=>array('url'=>'Yii::app()->createUrl("claimLineProduct/update",array("id"=>$data->id,"claim_line_id"=>$data->claim_line_id))'), 
                    'delete'=>array('url'=>'Yii::app()->createUrl("claimLineProduct/delete",array("id"=>$data->id))'), 
                
                ),
)))); ?>

<?php //echo CHtml::link('Добавить продукт в строку', Yii::app()->createUrl("claimLineProduct/create"))?>
<?php  echo CHtml::link('Добавить продукт в строку', Yii::app()->createUrl("claimLineProduct/create",array("direction_id"=>$direction_id,"claim_line_id"=>$claim_line_id)))?>

