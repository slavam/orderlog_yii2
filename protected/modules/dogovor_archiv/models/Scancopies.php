<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Scancopies
 *
 * @author v.kriuchkov
 */
class Scancopies extends EMongoGridFS{
    public $metadata = array();
    public $parent_document;
    //public $filedescription;
//    public $CC
    public function getCollectionName()
    {
        return 'scancopies';
    }
 
    public function rules()
    {
        return array(
            array('filename, metadata, parent_document,filedescription','safe'),
//            array('filename,filedescription','required'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'filename'=>'Файл',
            'filedescription'=>'Описание файла'
        );
    }


    public static function GetAttachmentType($attachmentType='')
    {
    switch ($attachmentType) {
    case 'image/jpeg':
            $result= CHtml::image(Yii::app()->request->baseUrl.'/images/attachment_type_picture.png','Изображение');
        break;

    default:
        $result=CHtml::image(Yii::app()->request->baseUrl.'/images/attachment_type_file.png','Файл');
        break;
    }
    return $result;
    }
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getFileDescription()
    {
        return $this->metadata['description'];
    }
    
//    public function setFiledDescription($value)
//    {
//        $this->metadata['filedescription'] = $value;
//    }
    
}

?>
