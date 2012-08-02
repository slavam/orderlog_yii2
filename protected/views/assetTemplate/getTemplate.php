<?php
$this->breadcrumbs=array(
//	'Заявка'=>array('claim/show', 'id'=>$claim_id),
	'Шаблон');
?>

<h1>Выберите шаблон</h1>

<div class="form">

<?php 
    echo CHtml::beginForm();
?>
	<div class="row">
		<b>Шаблон</b>
                <br>
		<?php echo CHtml::dropDownList('asset_template_id',$asset_template_id, AssetTemplate::findAssetTemplates());?> 
		<?php //echo $form->error($complect_id,'complect_id'); ?>
	</div>
        <div class="row buttons">
		<?php echo CHtml::submitButton('Выбрать'); ?>
	</div>
<?php 
    echo CHtml::endForm();
?>
</div><!-- form -->