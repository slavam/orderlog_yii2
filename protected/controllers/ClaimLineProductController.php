<?php

class ClaimLineProductController extends Controller
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
				'actions'=>array('indexByLine','view'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ClaimLineProduct;
                $claim_line_id = $_GET['claim_line_id'];

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ClaimLineProduct']))
		{
			$model->attributes=$_POST['ClaimLineProduct'];
                        $model->claim_line_id = $claim_line_id;
			if($model->save())
				$this->redirect(array('claimLine/show','id'=>$claim_line_id));
		}
                $direction_id = $_GET['direction_id'];
		$this->render('create',array(
                    'model'=>$model,
                    'direction_id'=>$direction_id,
                    'claim_line_id' => $_GET['claim_line_id'],
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                $claim_line_id = $_GET['claim_line_id'];

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ClaimLineProduct']))
		{
			$model->attributes=$_POST['ClaimLineProduct'];
			if($model->save())
				$this->redirect(array('claimLine/show','id'=>$claim_line_id));
		}
                $direction_id = $model->product->direction_id;
		$this->render('update',array(
			'model'=>$model,
                    'direction_id'=>$direction_id,
                    'claim_line_id' => $_GET['claim_line_id'],
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

	/**
	 * Lists all models.
	 */
	public function actionIndexByLine()
	{            
            
            
            $dataProvider=new CActiveDataProvider('ClaimLineProduct', array(
                'criteria'=>array(
                    'condition'=>'claim_line_id='.$_GET['claim_line_id'],
                    'order'=>'id',
                ),
            ));
//            $direction_id = $dataProvider->data[0]->product->direction_id;
		$this->render('indexByLine',array(
                    'dataProvider'=>$dataProvider,
                    'direction_id'=>$dataProvider->data[0]->product->direction_id,
                    'claim_line_id'=>$_GET['claim_line_id'],
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ClaimLineProduct('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClaimLineProduct']))
			$model->attributes=$_GET['ClaimLineProduct'];

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
		$model=ClaimLineProduct::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='claim-line-product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
