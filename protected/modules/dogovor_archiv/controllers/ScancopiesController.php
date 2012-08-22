<?php

class ScancopiesController extends CController
{
    function actionIndex()
    {
        
    }
    
function actionEditFile()
{
if ($pk = $_REQUEST['image_id'])
{
    $image = Scancopies::model()->findByPk(new MongoId($pk));
}
else $image = new Scancopies;

    if ($image->scenario =='insert')
    {
        $image->filename = 'filename';
        $image->metadata['contenttype']=$_FILES['filename']['type'];
    }
    $image->parent_document=$_REQUEST['parent_document'];
    $image->metadata['description']=$_REQUEST['Scancopies']['filedescription'];
        
    if ($image->validate())
    {
        $res = $image->save(false,array('filename','parent_document','metadata'));
        if ($res==true)
        {
            echo CJSON::encode(array('status'=>'ok','message'=>'Сохранено'));
            Yii::app()->end();
        }
        else echo 'Не сохранено';
    }
    else {
        echo CJSON::encode(CActiveForm::validate($image)); Yii::app()->end();
        }
    
    
//    if (Yii::app()->request->isAjaxRequest)
//            {
//                echo "Сохранено";
//                Yii::app()->end();
//            }
//            $this->redirect(Yii::app()->createUrl('/dogovor_archiv/documents/update/?id='.$_REQUEST['parent_document']));
//$this->render('scancopies_index',array('model'=>$model));
}
    
    function actionEditFileMetadata()
    {
        if ($pk = $_REQUEST['image_id'])
            {
                $model = Scancopies::model()->findByPk(new MongoId($pk));
            }
            else $model = new Scancopies;
       if (Yii::app()->request->isAjaxRequest)
       {
            if ($model instanceof Scancopies)
            {
               echo $this->renderPartial('scancopies_filemetadataform',array('model'=>$model),true,false);
                
            }
            else   {
            echo 'Ошибка загрузки файла приложения';
            Yii::app()->end();
        }
        Yii::app()->end();
       }
       else $this->render('scancopies_filemetadataform',array('model'=>$model));
    }
    /**
     * Показ изображения
     * @param string $image_id
     * @return image stream
     */
    public function actionGetImage($image_id)
    {
        if ($image_id)
        {
            $image = Scancopies::model()->findByPk(new MongoId($image_id));
            if ($image)
            {
                $image = $image->getBytes();
                if ($_REQUEST['thumb'])
                {
                    $image = $this->img_resize($image, '100');
                }
                $this->renderPartial('scancopies_image_page',array('image'=>$image));
            }
        }
        else return;
    }
    
    public function actionFilesList()
    {
        $parent_id=$_REQUEST['parent_id'];
        $this->render('scancopies_files_list',array('parent_id'=>$parent_id));
    }


    /**
     * Изменение размера картинки
     */
    function img_resize($image, $size)
    {
        
        //$gis = getimagesize($image);
//        $type = '2';
//    switch($type)
//        {
//        case "1": $imorig = imagecreatefromgif($image); break;
//        case "2": $imorig = imagecreatefromjpeg($image);break;
//        case "3": $imorig = imagecreatefrompng($image); break;
//        default:  $imorig = imagecreatefromjpeg($image);
//        }
        $imorig = imagecreatefromstring($image);
        $x = imageSX($imorig);
        $y = imageSY($imorig);
        if($x <= $size)
        {
            $av = $x;
            $ah = $y;
        }
            else
        {
            $yc = $y*1.3333333;
            $d = $x>$yc?$x:$yc;
            $c = $d>$size ? $size/$d : $size;
              $av = $x*$c;        //высота исходной картинки
              $ah = $y*$c;        //длина исходной картинки
        }   
        //$im = imagecreate($av, $ah);
        $im = imagecreatetruecolor($av,$ah);
    if (imagecopyresized($im,$imorig , 0,0,0,0,$av,$ah,$x,$y))
        if ($resized_image = imagejpeg($im))
            return $resized_image;
            else
            return false;
    } 
}

?>
