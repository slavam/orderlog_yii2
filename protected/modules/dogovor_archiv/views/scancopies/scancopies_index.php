<?php
echo CHtml::beginForm(Yii::app()->createUrl('/dogovor_archiv/scancopies/index',array('id'=>$_REQUEST['id'])),'post',array('enctype'=>'multipart/form-data'));
echo CHtml::fileField('file');
echo CHtml::submitButton('Добавить');
echo CHtml::endForm();
?>
<div class="row">
   
</div>
<div id="scancopies">
<?
print_r($scancopies);
?>
</div>