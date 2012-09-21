<?php

/**
 * Description of PurposeController
 *
 * @author v.kriuchkov
 */
class PurposeController extends Controller{
   
    public function actionIndex()
    {
        $this->render('index');
    }
    
    public function actionGetDataForGrid()
	{
            $dataProvider = new CActiveDataProvider('Purpose', array(
                'pagination' => false,
                'criteria' => array(
                    'order' => 'direction_id, name',
                ),
            ));
            
            if (Yii::app()->request->isAjaxRequest)
            {
             $responce =array();
                foreach ($dataProvider->getData() as $i=>$row) {
	                $responce['rows'][$i]['id'] = $row['id'];
	                $responce['rows'][$i]['cell'] = array(
	                			$row->id, 
	                			$row->name,
	                			$row->direction->name
                            );
                }

            echo CJSON::encode($responce);
            Yii::app()->end();
            }
	}
        /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
    public function actionCreate()
	{
		$model=new Purpose;
                if(isset($_POST['id']))
                {
                    $model->name=$_POST['name'];
                    $model->direction_id = $_POST['direction_id'];
                    if ($model->save()) {
                        if (Yii::app()->request->isAjaxRequest) {
                            echo CJSON::encode(array(
                                'status' => 'ok',
                                'iddb' => $model->id,
                            ));
                            Yii::app()->end();
                        } else
                            $this->redirect(array('index'));
                    }
            }
        $this->render('create', array(
            'model' => $model,
        ));
        }
public function loadModel($id)
{
$model=Purpose::model()->findByPk($id);
if($model===null)
        throw new CHttpException(404,'The requested page does not exist.');

return $model;
}
        
public function actionUpdate() {
        $id = $_REQUEST['iddb'];
        $model = $this->loadModel($id);
        if (Yii::app()->request->isAjaxRequest)
        {
        switch ($_POST['oper']) {
            case 'edit':
                $model->name = $_POST['name'];
                $model->direction_id = $_POST['direction_id'];
                if ($model->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        echo "Запись отредактирована";
                    }
                    else
                    $this->redirect(array('index'));
                }
                        break;
                    case 'del':
                        $model->delete();
                        break;
                       
                }
                Yii::app()->end();
          }        
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
                    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
}

?>
