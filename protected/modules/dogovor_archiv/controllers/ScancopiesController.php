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
if ($_FILES['attachments'])
{
    $image->filename = 'attachments';
    $image->metadata['contenttype']=$_FILES['attachments']['type'];
}
    $image->parent_document=$_REQUEST['parent_document'];
    $image->metadata = array('description'=>$_REQUEST['filedescription']);
    $res = $image->save(false,array('filename','parent_document','metadata'));

if ($res==true)
{
    $this->redirect(Yii::app()->createUrl('/dogovor_archiv/documents/update/?id='.$_REQUEST['parent_document']));
}
$this->render('scancopies_index',array('model'=>$model));
}
    
    function actionEditFileMetadata()
    {
        if ($pk = $_REQUEST['image_id'])
            {
                $model = Scancopies::model()->findByPk(new MongoId($pk));
            }
            else $model = new Scancopies;
        if ($_REQUEST['Scancopies'])
        {
            
        }
       if (Yii::app()->request->isAjaxRequest)
       {
        echo $this->renderPartial('scancopies_filemetadataform',array('model'=>$model),true,false);
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
