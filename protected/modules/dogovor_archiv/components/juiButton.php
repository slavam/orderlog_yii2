<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of juiButton
 *
 * @author v.kriuchkov
 */
class rulesAddForm extends CInputWidget{
    //put your code here<?php
    public $model;
    public $attribute;
    
    function run()
    {
        echo CHtml::dropDownList('validator_select', '', CValidator::$builtInValidators);
        echo CHtml::ajaxLink('Добавить валидатор', 'http://mongo_yii/index.php/field/Field_validator_form_build/',array('update'=>'#rules-form','data'=>array('validator'=>'js:$("#validator_select").val()'),'type'=>'POST'));
        echo '<div id="rules-form"></div>';
    }
}
?>

