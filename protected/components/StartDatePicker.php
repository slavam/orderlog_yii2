<?php
/**
 * Description of StartDatePicker
 *
 * @author v.kriuchkov
 */
class StartDatePicker extends CInputWidget{
public $attributeStart_date;
public $nameStart_date;
public $valueStart_date;
public $attributeStop_date;
public $nameStop_date;
public $valueStop_date;
public $disabled;
public $readonly;

function run()
{
    if($this->attributeStart_date && $this->attributeStop_date) {
    $this->attribute = TRUE;
    
    }   
    if($this->hasModel())
        {
            echo '<table><tbody><tr>';
            
            if (isset($this->attributeStart_date))
            {
             echo'<br />';
              echo '<td>';
              echo CHtml::label($this->model->getAttributeLabel($this->attributeStart_date), $this->attributeStart_date);
              $this->widget('zii.widgets.jui.CJuiDatePicker', array(
               'model'=>  $this->model,
               'language'=>'ru',                      
               'attribute'=>  $this->attributeStart_date,
               'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>'dd.mm.yy',
                ),
                'htmlOptions'=>array(
                    'style'=>'height:20px;',
                    'readonly'=>  $this->readonly?true:false,
                ),
                ));
             echo '</td>';
            }
            
            if (isset($this->attributeStop_date))
            {    
                echo '<td>';
                echo CHtml::label($this->model->getAttributeLabel($this->attributeStop_date), $this->attributeStop_date,array('style'=>'display:block'));
                    
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                       'model'=>  $this->model,
                        'language'=>'ru',
                        'attribute'=>$this->attributeStop_date,
                        'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat'=>'dd.mm.yy',
                        ),
                        'htmlOptions'=>array(
                            'style'=>'height:20px;',
                            'readonly'=>  $this->readonly?true:false,
                        ),
                    ));
                echo '</td>';    
            }
            echo '</tr></tbody></table>';
            echo '<div class="errorMessage">'.$this->model->getError($this->attributeStart_date).'</div>';
            echo '<div class="errorMessage">'.$this->model->getError($this->attributeStop_date).'</div>';
            
        }
        else {
                echo CHtml::textField($this->nameFrom, $this->valueFrom);
        }
}
}

?>
