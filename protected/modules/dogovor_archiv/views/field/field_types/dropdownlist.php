<fieldset>
    <legend>Укажите, откуда брать элементы для списка</legend>
    <p>Элементы можно ввести вручную в поле "Указанные элементы" (один элемент на строку) или выбрать из списка справочников</p>
<?php
echo CHtml::label('Указанные элементы', 'items_list');
echo CHtml::textArea('items_list', '',array('cols'=>50,'rows'=>5));


echo CHtml::label('Справочник', 'items_reference');
echo CHtml::dropDownList('items_reference', null, Reference::model()->getAllReferences(),array('empty'=>'Ничего не выбрано'));
?>
</fieldset>
