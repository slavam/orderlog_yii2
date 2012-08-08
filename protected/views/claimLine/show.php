<?php
$this->breadcrumbs=array(
	'Заявка'=>array('claim/show', 'id'=>$model->claim_id),
	$model->claim->claim_number,
);

?>

<h2>Строка заявки #<?php echo $model->id; ?></h2>

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
                    'value'=>CHtml::encode($model->getBusinessName($model->business_id))
//                    'value'=>CHtml::encode($model->business->NAME)
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
                    'label'=>'Центр финансовой ответственности',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->payer ? $model->payer->NAME: "Не задан")
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
                array(               
                    'label'=>'Характеристики',
                    'type'=>'raw',
                    'value'=>CHtml::link(CHtml::encode($model->findFeaturesAsString($model->id)),
                             array('claimLineFeature/featuresByClaimLine','claim_line_id'=>$model->id))
                ),
                array(               
                    'label'=>'Добавлена',
                    'type'=>'raw',
                    'value'=>($model->complect_id==null ? 'Вручную' : 
                        ($model->complect_id==2 ? 'Из набора "'.CHtml::link(CHtml::encode($model->complect->name),array('complect/show','id'=>$model->complect_id)).'"' :
                        'Из шаблона "'.CHtml::link(CHtml::encode($model->complect->name),array('complect/show','id'=>$model->complect_id)).'"'))
                ),
	),
)); ?>
<?php  echo CHtml::link('Редактировать строку', array('update','id'=>$model->id)) ?>