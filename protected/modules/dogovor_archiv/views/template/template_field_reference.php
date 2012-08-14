<?
$this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $fields,
        'columns' => array(
                array('name'=>'author_login','value'=>'$data[\'caption\']?$data[\'caption\']:$data[\'system_name\']')
        ),
    ));
    echo CHtml::beginForm(CHtml::normalizeUrl(array('/dogovor_archiv/field/editfield','templ_id'=>(string)$model->_id)));
?>

<fieldset>
    <legend>Добавить существующее поле</legend>
    <?
    $fields = Field::model()->getAllFields($fields);
    echo CHtml::dropDownList('field', null, $fields); 
    echo CHtml::hiddenField('templ_id',(string)$model->_id);
    ?>
</fieldset>

<?
echo CHtml::submitButton();
echo CHtml::endForm();?>