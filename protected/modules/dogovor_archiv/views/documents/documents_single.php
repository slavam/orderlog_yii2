<?php
if ($attributes = $model->search())
{
foreach ($attributes->attrs as $attribute=>$value)
{
    if ($attribute == 'status')
    {
        $attributes->attrs[$attribute] = Document::checkStatus($value);
    }
    if ($attribute == 'reestr')
    {
        $attributes->attrs[$attribute] = Document::checkReestr($value);
    }
    if ($attribute == 'dog_kind')
    {
        $attributes->attrs[$attribute] = Document::checkDogKind($value);
    }
    if ($attribute == 'pay_system')
    {
        $attributes->attrs[$attribute] = Document::checkPaySystems($value);
    }
    $complete_attributes[] = $attribute;
}
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$attributes,
    'attributes'=> $complete_attributes
));
}
else echo 'Данных нет';
?>