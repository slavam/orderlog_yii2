<?php
$complete_form['title'] = 'Создание нового договора';
$complete_form['activeForm']= array(
        'id'=>'document-form', // Важный момент.
        'class'=>'CActiveForm',
        'enableAjaxValidation'=>false,);
foreach ($this->model->form as $key => $value) {
    if (!isset($value['hide']) || $value['hide'] !== true)
    {
    $complete_form['elements'][$key] = array(
        'type' => $value['type'],
        'attributes' => $value['attributes'],
        );
        if (isset($value['items']))
        {
            $complete_form['elements'][$key]['items']=$value['items'];
        }
        if (isset($value['visible']))
        {
            $complete_form['elements'][$key]['visible']=$value['visible'];
        }
    }
}
$complete_form['buttons'] = array(
    'login' => array(
        'type' => 'submit',
        'label' => 'Сохранить',
    )
);

return $complete_form;

//return $form = array(
//    'title'=>'222',
//    'elements'=>array(
//        'start_date'=>array('type'=>'text',),
//        'provider'=>array('type'=>'text',),
//    ),
//    'buttons'=>array('login' => array(
//        'type' => 'submit',
//        'label' => 'Сохранить',
//    ),
//        )
//);
?>
