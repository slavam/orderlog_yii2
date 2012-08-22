<div class="item">
<?php
echo CHtml::link(Scancopies::GetAttachmentType(
        $data->metadata['contenttype']).'&nbsp;'.$data->filename,
        Yii::app()->createUrl('/dogovor_archiv/scancopies/getimage',array('image_id'=>(string)$data->_id)),
        array('class'=>'lightbox'));
echo '&nbsp;';
echo CHtml::link(
        CHtml::image('/images/edit.png','Редактировать'),
        '#',
        array('onclick'=>'$("#file_select").dialog("open").load(\''.Yii::app()->createUrl('/dogovor_archiv/scancopies/editfilemetadata',array('image_id'=>(string)$data->_id,'parent_id'=>$_REQUEST['id'])).'\'); return false;','id'=>'item-description')
        );
echo '<p class="item-description">'.$data->metadata['description'].'</p>'
?>
</div>