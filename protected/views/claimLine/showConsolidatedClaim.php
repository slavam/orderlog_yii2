<?php
$this->breadcrumbs=array(
	'Заявки'=>array('claim/index'),
);

$this->menu=array(
	array('label'=>'List ClaimLine', 'url'=>array('index')),
	array('label'=>'Create ClaimLine', 'url'=>array('create')),
	array('label'=>'Update ClaimLine', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClaimLine', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClaimLine', 'url'=>array('admin')),
);
?>

<h1>Консолидированная заявка</h1>

<h4>Период: <?php echo Period::model()->findByPk($period_id)->NAME ?></h4>
<h4>Направление: <?php echo Direction::model()->findByPk($direction_id)->name ?></h4>
<?php 
    $criteria=new CDbCriteria;
//    $criteria->join='join claims c on c.id=claim_id and c.period_id =1844 and c.state_id=2 and c.direction_id=1';
    $criteria->with=array(
        'claim'=>array('condition'=>'period_id='.$period_id.' and claim.state_id=2 and direction_id='.$direction_id, 'order'=>'claim.id'));

    $dataProvider=new CActiveDataProvider('ClaimLine', array('criteria'=>$criteria));
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'consolidate-claim-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
            array(
                'name'=>'Заявка',
                'value'=> 'CHtml::link($data->claim->claim_number,
                             Yii::app()->createUrl("claim/show",array("id"=>$data->claim->primaryKey)))',
                'type'  => 'raw',    
            ),
            array(
                'name'=>'Товар',
                'value'=>'CHtml::link($data->asset->name,
                    Yii::app()->createUrl("asset/show",array("id"=>$data->asset->primaryKey)))',
                'type'  => 'raw',    
            ),                        
            array(
                'name'=>'Количество',
                'value'=>'$data->count." ".$data->asset->unit->sign',
            ),
            array(
                'name'=>'Сумма',
                'value'=>'$data->amount',
            ),
))); ?>
