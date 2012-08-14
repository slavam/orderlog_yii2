<h1>Шаблоны</h1>
<?
if (isset($templates) && is_array($templates))
{
    echo CHtml::tag('p',array('class'=>'add_template'),CHtml::link('Создать шаблон','/index.php/dogovor_archiv/template/create'));
    foreach ($templates as $key => $value) {
        echo CHtml::tag('p',array(),CHtml::link($value['name'],'/index.php/dogovor_archiv/template/view/id/'.$value['_id'],array('alt'=>'Просмотр шаблона')).CHtml::link(CHtml::image('/images/edit.png'),'/index.php/dogovor_archiv/template/edit/id/'.$value['_id'],array('alt'=>'Редактировать шаблон')).CHtml::link(CHtml::image('/images/remove.png'),'/index.php/dogovor_archiv/template/delete/id/'.$value['_id'],array('alt'=>'Удалить шаблон')));
    }
}
elseif(is_object ($templates))
{
    echo CHtml::link('Назад','/index.php/dogovor_archiv/template');
    print '<p> Имя документа: '.$templates->name.'</p>';
    print '<p> Описание документа: '.$templates->description.'</p>';
}
else print $templates;
?>