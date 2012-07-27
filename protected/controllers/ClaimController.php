<?php

class ClaimController extends Controller
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
				'actions'=>array('index','view','show','list','changeClaimState'),
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
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            $model=new Claim;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

            if(isset($_POST['Claim'])) {
                $model->attributes=$_POST['Claim'];
                $model->state_id = 1;
                $model->budgetary = true;
                $model->create_date = date("Y-m-d H:i:s", time());
                $model->claim_number = $model->direction->stamp.$model->id;
                if($model->save()) {
                    $model->claim_number = $model->direction->stamp.$model->id;
                    $model->save();
                    $this->redirect(array('show','id'=>$model->id));
                }  
            }
            $this->render('create',array(
                'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Claim']))
		{
                    $model->attributes=$_POST['Claim'];
                    if($model->save())
                            $this->redirect(array('show','id'=>$model->id));
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
                    $lines = $this->loadModel($id)->claimLines;
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
		$dataProvider=new CActiveDataProvider('Claim', array(
                    'pagination'=>false, 
                    'criteria'=>array(
                        'order'=>'period_id desc, division_id, id',
                        ),
                ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('Claim');
                $model=new Claim;
		$this->render('list',array(
			'dataProvider'=>$dataProvider,
                        'model'=>$model,
		));
	}
        
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Claim('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Claim']))
			$model->attributes=$_GET['Claim'];

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
		$model=Claim::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='claim-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

        public function actionChangeClaimState($id)
        {
            $model=Claim::model()->findByPk($id);
            $new_state = $model->state_id;
            if ($model->state->documentType->name == "Первичная заявка")
            {
                switch ($model->state->stateName->name)
                {
                    case "Черновик":
                        $new_state = 5; // "На согласовании"
                        break;
                    case "На согласовании":
                        $new_state = 2; // "Согласовано"
                        break;
                }    
            }       
            $model->state_id = $new_state;
            $model->save();
            $dataProvider=new CActiveDataProvider('Claim', array(
                'criteria'=>array(
                    'order'=>'period_id, division_id, id',
                ),
            ));
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
            ));
        }
}
