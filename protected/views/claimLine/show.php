<?php
$this->breadcrumbs=array(
	'Заявка'=>array('claim/show', 'id'=>$model->claim_id),
	$model->claim->claim_number,
);

$this->menu=array(
	array('label'=>'List ClaimLine', 'url'=>array('index')),
	array('label'=>'Create ClaimLine', 'url'=>array('create')),
	array('label'=>'Update ClaimLine', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClaimLine', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClaimLine', 'url'=>array('admin')),
);
?>

<h1>Строка заявки #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                array(               
                    'label'=>'Товар',
                    'type'=>'raw',
                    'value'=>CHtml::link(CHtml::encode($model->asset->name),
                             array('asset/show','id'=>$model->asset->id)),
                ),
                array(               
                    'label'=>'Количество',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->count).CHtml::encode($model->asset->unit->sign)
                ),
                array(               
                    'label'=>'Цена',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->cost)
                ),
                array(               
                    'label'=>'Сумма',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->amount)
                ),
                array(               
                    'label'=>'Описание',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->description)
                ),
                array(               
                    'label'=>'Бизнес',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->business->NAME)
                ),
                array(               
                    'label'=>'Статья бюджета',
                    'type'=>'raw',
                    'value'=>($model->budget_item_id>0 ? CHtml::encode($model->budgetItem->NAME): 0)
                ),
                array(               
                    'label'=>'Для кого',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->findWorker($model->for_whom))
                ),
                array(               
                    'label'=>'Расположение объекта',
                    'type'=>'raw',
                    'value'=>($model->position_id>0 ? CHtml::encode($model->findAddress($model->position_id)): '')
                ),
                array(               
                    'label'=>'Продукты',
                    'type'=>'raw',
                    'value'=>CHtml::link(CHtml::encode($model->findProductsAsString($model->id)),
                             array('claimLineProduct/indexByLine','claim_line_id'=>$model->id))
                ),
	),
)); ?>