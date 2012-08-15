<?
foreach ($templates as $template)
{
echo '<p>';
echo CHtml::link($template->description,Yii::app()->createUrl('dogovor_archiv/documents/add',array('templ_id'=>$template->_id)));
echo'</p>';
}
?>
