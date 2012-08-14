<h3>Поиск документа</h3>
<div class="search_block">
<?php echo CHtml::beginForm('/documents/view','post'); ?>
 
<?php echo CHtml::errorSummary($model); ?>
 
<div class="row">
<?php echo CHtml::activeLabel($model,'provider'); ?>
<?php echo CHtml::activeTextField($model,'provider'); ?>
</div>
 
<div class="row">
<?php echo CHtml::activeLabel($model,'start_date'); ?>
<?php echo CHtml::activeTextField($model,'start_date'); ?>
</div>
 
<div class="row rememberMe">
<?php echo CHtml::activeLabel($model,'stop_date'); ?>
<?php echo CHtml::activeTextField($model,'stop_date'); ?>
</div>
 
<div class="row submit">
<?php echo CHtml::submitButton('Искать'); ?>
</div>
 
<?php echo CHtml::endForm(); ?>
</div><!-- form -->