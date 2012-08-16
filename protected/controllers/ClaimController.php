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
				'actions'=>array('index','view','show','list','changeClaimState',
                                    'indexJqgrid','getDataForGrid','getDataForSubGrid','editClaimDialog','editClaim',
                                    'editClaimLineDialog','editClaimLine','claimLineDelete',
                                    'viewClaimWithLines'),
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
//			if(!isset($_GET['ajax']))
                        if (!Yii::app()->request->isAjaxRequest) 
                            $this->render('indexJqgrid',array(
                		'dataProvider'=>null, //$dataProvider,
        		));
//				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
        
        public function actionIndexJqgrid()
	{
//		$dataProvider=new CActiveDataProvider('Claim', array(
//                    'pagination'=>false, 
//                    'criteria'=>array(
//                        'order'=>'period_id desc, division_id, id',
//                        ),
//                ));
		$this->render('indexJqgrid',array(
			'dataProvider'=>null, //$dataProvider,
		));
	}

        public function actionGetDataForGrid()
	{
            $dataProvider=new CActiveDataProvider('Claim', array(
                'pagination'=>false,
                'criteria'=>array(
                    'order'=>'period_id desc, division_id, id',
                    ),
            ));
            
//            if(isset($_REQUEST['dir_selector'])&&$_REQUEST['dir_selector']){
//                $criteria_ = $dataProvider->getCriteria();
//                $criteria_->condition = 't.direction_id='.$_REQUEST['dir_selector'];
//            }
//            
//            
//            // if cal goes from EditAsset action to retrieve only one Asset
//            if(isset($_REQUEST['id'])&&$_REQUEST['id'])
//            {
//                $criteria_ = $dataProvider->getCriteria();
//                if($criteria_->condition!='') $criteria_->condition.=' AND ';
//                $criteria_->condition.='t.id ='.$_REQUEST['id'];
//            }
//            
//            $assets_ = $dataProvider->getData();
            $responce['status']='ok';
            $responce['rows']=array();

//            $pagination_block = $dataProvider->getPagination();
            $claims = $dataProvider->getData();
            
            foreach ($claims as $i=>$row) {
                $responce['rows'][$i]['id'] = $i+1;
                $responce['rows'][$i]['cell'] = array(
                    $row->id, 
                    $row->period->NAME, 
                    $row->claim_number,
                    $row->state->stateName->name,
                    $row->division->NAME,
                    $row->findDepartment($row->department_id),
                    $row->comment
                    );
            }
            echo CJSON::encode($responce);
        }

        public function actionGetDataForSubGrid()
        {
            $dataProvider=new CActiveDataProvider('ClaimLine', array(
                'pagination'=>false,
                'criteria'=>array(
                    'condition'=>'claim_id='.$_GET['claim_id'],
                    'order'=>'id',
                    ),
            ));
            $responce['status']='ok';
            $complects = $dataProvider->getData();
            $responce['rows']=array();
            foreach ($complects as $i=>$row) {
                $responce['rows'][$i]['id'] = $i+1;
                $responce['rows'][$i]['cell'] = array(
                    $row->id,
                    $row->asset->waretype->short_name, 
                    $row->asset->name, 
                    $row->count,
                    $row->cost,
                    $row->amount,
                    $row->description,
                    );
            }
            echo CJSON::encode($responce);
        }
    public function actionEditClaimDialog($id)
    {
    	if(Yii::app()->request->isAjaxRequest)
        {
            $model = $this->loadModel($id);

            // For jQuery core, Yii switches between the human-readable and minified
			// versions based on DEBUG status; so make sure to catch both of them
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            $this->renderPartial('_form',array('model'=>$model),false,true);
            Yii::app()->end();
        } 
    }
    public function actionEditClaim($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Claim'])) {
            $model->attributes = $_POST['Claim'];
            if($model->validate()){
                if ($model->save()) { 
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->actionGetDataForGrid(); //encode json only one asset by id
                        Yii::app()->end();
                    } else 
                        echo 'get out!';
                }//model->save
            } else {
                echo CJSON::encode(CActiveForm::validate($model)); 
                Yii::app()->end();
            }
        } else
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'err',
                    'message' => 'no Claim form passed!',
                ));
                Yii::app()->end();
            } else {
                echo 'get out!';
            }
    }

    public function actionEditClaimLineDialog($id)
    {
    	if(Yii::app()->request->isAjaxRequest)
        {
            $model = ClaimLine::model()->findByPk($id);

            // For jQuery core, Yii switches between the human-readable and minified
			// versions based on DEBUG status; so make sure to catch both of them
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            $this->renderPartial('/claimLine/_form',array('model'=>$model,'claim_id'=>$model->claim_id),false,true);
            Yii::app()->end();
        } 
    }
    public function actionEditClaimLine($id) {
        $model = ClaimLine::model()->findByPk($id);
        if (isset($_POST['ClaimLine'])) {
            $model->attributes = $_POST['ClaimLine'];
            if($model->validate()){
                if ($model->save()) { 
                    if (Yii::app()->request->isAjaxRequest) {
                        $_GET['claim_id'] = $model->claim_id;
                        $this->actionGetDataForSubGrid(); //encode json only one asset by id
                        Yii::app()->end();
                    } else 
                        echo 'get out!';
                }//model->save
            } else {
                echo CJSON::encode(CActiveForm::validate($model)); 
                Yii::app()->end();
            }
        } else
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'err',
                    'message' => 'no Claim form passed!',
                ));
                Yii::app()->end();
            } else {
                echo 'get out!';
            }
    }

    public function actionClaimLineDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$claimLine = ClaimLine::model()->findByPk($id);
                        $claimLine->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//			if(!isset($_GET['ajax']))
//				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

        public function actionViewClaimWithLines($id)
        {
    	if(Yii::app()->request->isAjaxRequest)
        {
            $model = $this->loadModel($id);

            // For jQuery core, Yii switches between the human-readable and minified
			// versions based on DEBUG status; so make sure to catch both of them
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            $this->renderPartial('showJqgrid',array('model'=>$model),false,true);
            Yii::app()->end();
        } 
            
        }
}
