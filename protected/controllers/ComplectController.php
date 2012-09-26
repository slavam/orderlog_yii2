<?php

class ComplectController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','show','indexJqgrid','getDataForGrid','getDataForSubGrid'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

        public function actionShow($id)
	{
            $model =$this->loadModel($id);
            $this->render('show',array(
			'model'=>$model,
            ));
	}

        public function actionCreate()
	{
//		$model=new Complect;
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['Complect']))
//		{
//			$model->attributes=$_POST['Complect'];
//			if($model->save())
//				$this->redirect(array('index'));
//		}
//
//		$this->render('create',array(
//			'model'=>$model,
//		));
            $model=new Complect;

            if(isset($_POST['id']))
                {
                    $model->name=$_POST['name'];
                    $model->complect_type_id = $_POST['complect_type_id'];
                    $model->comment = $_POST['comment'];
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

//	public function actionUpdate($id)
//	{
//		$model=$this->loadModel($id);
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['Complect']))
//		{
//			$model->attributes=$_POST['Complect'];
//			if($model->save())
//				$this->redirect(array('index'));
//		}
//
//		$this->render('update',array(
//			'model'=>$model,
//		));
//	}

        public function actionUpdate() {
        $id = $_REQUEST['iddb'];
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        switch ($_POST['oper']) {
            case 'edit':
               $model->name=$_POST['name'];
                $model->complect_type_id = $_POST['complect_type_id'];
                $model->comment = $_POST['comment'];
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
                    $lines = $this->loadModel($id)->complectLines;
                    foreach ($lines as $line) {
                        $line->delete();
                    }
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Complect', array(
                    'pagination'=>false, 
                    'criteria'=>array(
                        'order'=>'complect_type_id desc, id',
                        ),
                ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

        public function actionIndexJqgrid()
	{

		$this->pageTitle='Комплекты';

		$dataProvider=new CActiveDataProvider('Complect', array(
                    'pagination'=>false, 
                    'criteria'=>array(
                        'order'=>'complect_type_id desc, id',
                        ),
                ));
		$this->render('indexJqgrid',array(
			'dataProvider'=>$dataProvider,
		));
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Complect('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Complect']))
			$model->attributes=$_GET['Complect'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Complect::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='complect-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        public function actionGetDataForGrid()
	{
            $dataProvider=new CActiveDataProvider('Complect', array(
                'criteria'=>array(
                    'order'=>'complect_type_id desc, id',
                    ),
            ));
//            $pagination_block = $dataProvider->getPagination();
            $complects = $dataProvider->getData();
            $responce['rows']=array();
            foreach ($complects as $i=>$row) {
                $responce['rows'][$i]['id'] = $i+1;
                $responce['rows'][$i]['cell'] = array($row->id, $row->complectType->name, $row->name,$row->comment);
            }
            echo CJSON::encode($responce);
        }

        public function actionGetDataForSubGrid()
        {
            $dataProvider=new CActiveDataProvider('ComplectLine', array(
                'pagination'=>false,
                'criteria'=>array(
                    'condition'=>'complect_id='.$_GET['line_id'],
                    'order'=>'id',
                    ),
            ));
            
            $complects = $dataProvider->getData();
            $responce['rows']=array();
            foreach ($complects as $i=>$row) {
                $responce['rows'][$i]['id'] = $i+1;
                $responce['rows'][$i]['cell'] = array($row->asset->waretype->short_name, $row->asset->name, $row->amount);
            }
            echo CJSON::encode($responce);
        }
}
