<script type="text/javascript">
$(document).ready(function(){
  $('#Asset_cost').live('change', function () {
    var my_id = "";
    $(this).next().each(function(){my_id = this.value });
    var q ='?r=asset/UpdateGrid&id='+my_id;
    jQuery.ajax({'url'    :q,
                 'data'   :{'Asset[cost]':$(this).val()},
                 'type'   :'post',
                 'success':function(){alert('Товар выбран');},
                 'error'  :function(){alert('error');},
                 'cache'  :false});
  })
});
</script> 

<div class="formWareByTemplate">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'claim-line-by-template-form',
	'enableAjaxValidation'=>false,
    )); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'claim-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
                'name'=>'Тип',
                'value'=> '($data->asset_template_id>0 ? "Шаблон":$data->asset->waretype->short_name)'),
                array(
                'name'=>'Название',
                'value'=> '($data->asset_template_id>0 ? $data->assettemplate->name:$data->asset->name)'),
                array(
                'name'=>'Количество',
                'value'=>'$data->amount'),
        ),
)); ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Подставить'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->