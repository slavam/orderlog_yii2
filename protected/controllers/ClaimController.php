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
                                    'indexJqgrid','getDataForGrid','getDataForSubGrid','getDataForDialogGrid','editClaimDialog','editClaim',
                                    'editClaimLineDialog','editClaimLine','claimLineDelete',
                                    'viewClaimWithLines','editClaimWithLinesJq','getDepartmensByDivision','findWorkerDepForList',
                                    'editWholeClaim','ReportGroup'),
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


	public function actionFindWorkerDepForList($id)
	{
		//lysenko 16.sep.2012 - TODO check ajax stuff
		echo ClaimLine::model()->findWorkerDepartment2levels($id);
        Yii::app()->end();

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

/*
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
                    $row->asset->unit->sign,
                    $row->count,
                    $row->cost,
                    $row->amount,
                    $row->asset->assetgroup->block->name." => ".$row->asset->assetgroup->name,//gruppa
                    'цель?',//zel'
                    $row->for_whom>0? $row->findWorker($row->for_whom): '',                  //for_whom
                    $row->for_whom>0? $row->findWorkerDepartment2levels($row->for_whom): '',//for_whom_div
//                    $row->budget_item_id>0 ? CHtml::encode($row->budgetItem->NAME): '',
                    $row->findFeaturesAsString($row->id),
                    $row->findProductsAsString($row->id),
//                    $row->position_id>0 ? CHtml::encode($row->findAddress($row->position_id)): '',   //o.lysenko 5.09.2012 18:52 - encoding &quot
                    $row->position_id>0 ? $row->findAddress($row->position_id): '',
                    $row->description,
                    $row->payer_id>0? Division::model()->findDivisionById($row->payer_id): '',//ZFO
                    $row->getBusinessName($row->business_id),
                    $row->budget_item_id>0 ? CHtml::encode($row->budgetItem->get2LevelNameBudgetItem($row->budget_item_id).' ('.$row->budgetItem->CODE.')'): '',
                    $row->status->short_name,
                    $row->asset->info,
                    $row->complect_id==null ? 'Вручную' : ($row->complect_id==2 ? 'Из набора' : 'Из шаблона')
                    );
            }
            echo CJSON::encode($responce);
        }
        */

        public function actionGetDataForSubGrid()
        {
            if ($_GET['claim_id'])
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
            }
            else $complects=array();
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
        
        
        public function actionGetDataForDialogGrid()
        {
            if ($_GET['claim_id'])
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
            }
            else $complects=array();
            $responce['rows']=array();
            foreach ($complects as $i=>$row) {
                $responce['rows'][$i]['id'] = $i+1;
                $responce['rows'][$i]['cell'] = array(
                    $row->id,
                    $row->asset->ware_type_id,//->short_name, 
                    $row->asset->name, 
                    $row->asset->unit_id,//->sign,
                    $row->count,
                    $row->cost,
                    $row->amount,
                    $row->asset->asset_group_id, //$row->asset->assetgroup->block->name." => ".$row->asset->assetgroup->name,//gruppa
                    'цель?',//zel'

                    //TODO: check if returns '' on view

                    $row->for_whom>0? $row->for_whom: '',//>0? $row->findWorker($row->for_whom): '',                  //for_whom
                    $row->for_whom>0? $row->findWorkerDepartment2levels($row->for_whom): '',//for_whom_div
//                    $row->budget_item_id>0 ? CHtml::encode($row->budgetItem->NAME): '',
                    $row->findFeaturesAsString($row->id),
                    $row->findProductsAsString($row->id),
//                    $row->position_id>0 ? CHtml::encode($row->findAddress($row->position_id)): '',   //o.lysenko 5.09.2012 18:52 - encoding &quot
                    //TODO: check if returns '' on view
                    $row->position_id>0? $row->position_id: '', //? $row->findAddress($row->position_id): '',
                    $row->description,
                    //TODO: check if returns '' on view
                    $row->payer_id>0? $row->payer_id: '',//Division::model()->findDivisionById($row->payer_id): '',//ZFO
                    
                    //TODO: check if returns '' on view
                    $row->business_id,//$row->getBusinessName($row->business_id),
                    //TODO: check if returns '' on view
                    $row->budget_item_id>0 ? $row->budget_item_id:'', //CHtml::encode($row->budgetItem->get2LevelNameBudgetItem($row->budget_item_id).' ('.$row->budgetItem->CODE.')'): '',
                    $row->status_id,//->short_name,
                    $row->asset->info,
                    //TODO: should be creation_method!!!
                    $row->complect_id,//==null ? 'Вручную' : ($row->complect_id==2 ? 'Из набора' : 'Из шаблона')
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

    /*
    public function actionEditClaimWithLinesJq($id)
    {
    	if(Yii::app()->request->isAjaxRequest)
        {
            $model = $this->loadModel($id);

            // For jQuery core, Yii switches between the human-readable and minified
			// versions based on DEBUG status; so make sure to catch both of them
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            $this->renderPartial('editClaimWithLinesJq',array('model'=>$model),false,true);
            Yii::app()->end();
        } 
    }
    */

    public function actionEditClaimWithLinesJq($id)
    {
    	if(Yii::app()->request->isAjaxRequest)
        {
           if ($id)
           {
            $model = $this->loadModel($id);
           }else $model=new Claim;

            // For jQuery core, Yii switches between the human-readable and minified
			// versions based on DEBUG status; so make sure to catch both of them
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            $this->renderPartial('editClaimWithLinesJq',array('model'=>$model),false,true);
            Yii::app()->end();
        } 
    }


    public function actionGetDepartmensByDivision($division_id)
    {
        $departments = Department::model()->findDepartmentsByDivision($division_id);
        echo CJSON::encode($departments);
        Yii::app()->end();
    }

/*
    public function actionEditWholeClaim($id){
        $model = $this->loadModel($id);
        if (isset($_POST['Claim'])) {
            $new_claim_fields = $_POST['Claim'];
            foreach ($new_claim_fields as $field => $value) {
                $model[key($new_claim_fields[$field])] = current($value);
            }
            if ($model->save()) { 
                $new_claim_lines = $_POST['ClaimLines'];

                foreach ($new_claim_lines as $line => $value) {
                    $model_line = ClaimLine::model()->findByPk($new_claim_lines[$line]['iddb']);
                    $model_line->count = $new_claim_lines[$line]['count'];
        //            $model_line->attributes = $new_claim_lines[$line];
//                    foreach ($new_claim_lines[$line] as $key => $value) {
//                        
//                        $model[$key] = $value;
//                    }
                    if (!$model_line->save())
                    {        
                        echo "Error"; // to do correct message
                        return;
                    }
                }
//            if($model->validate()){
                
                    if (Yii::app()->request->isAjaxRequest) {
//                        $this->actionGetDataForGrid(); //encode json only one asset by id
  //          $responce['status']='ok';
//            echo CJSON::encode($responce);
//            echo CJSON::encode(array(
  //          'status' => 'ok',
    //            'message' => 'no Asset form passed!',
     //   ));            
             
                    } else echo 'get out!';
                }//model->save
//            }//validate
//            else {echo CJSON::encode(CActiveForm::validate($model)); Yii::app()->end();}
        } else
        if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'err',
            'message' => 'no Asset form passed!',
        ));
        Yii::app()->end();            
    } else {
        echo 'get out!';
    }
                
//            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//            $responce['status']='ok';
//            echo CJSON::encode($responce);
//            Yii::app()->end();
//        } 
        
    }

*/

    public function actionEditWholeClaim($id){
        if ($id)
        {
            $model = $this->loadModel($id);
        }
        else 
        {
            $model=new Claim;
            
        }
        
        if (isset($_POST['Claim'])) {
            $new_claim_fields = $_POST['Claim'];
            
            foreach ($new_claim_fields as $field => $value) {
                $model[key($new_claim_fields[$field])] = current($value);
            }
            
            if (!$model->id)
            {
                $model->state_id = 1;
                $model->budgetary = true;
                $model->create_date = date("Y-m-d H:i:s", time());
                $model->claim_number = $model->direction->stamp.$model->id;
            }
            if ($model->save()) {
                
                if (!$id)
                {
                    $model->claim_number=$model->direction->stamp.$model->id;
                    $model->update(array('claim_number'));
                }
                $new_claim_lines = $_POST['ClaimLines'];
                
                if (is_array($new_claim_lines))
                {
                    foreach ($new_claim_lines as $line => $value) {
                        
                        
                            if(!($model_line = ClaimLine::model()->findByPk($new_claim_lines[$line]['iddb'])))
                            {
                                $model_line =new ClaimLine;
                            }
                            $model_line->claim_id = $model->id;
                            $model_line->asset_id = '12';
                            $model_line->count = $value['count'];
                            $model_line->amount=$value['amount'];
                            $model_line->cost=$value['cost'];
                            $model_line->description=$value['description'];
                            $model_line->for_whom=$value['for_whom'];
                            $model_line->budget_item_id=$value['budget_item'];
                            $model_line->business_id=$value['business'];
                            $model_line->payer_id=$value['payer'];
                            $model_line->status_id=$value['status'];
                            $model_line->how_created=$value['created'];
                            
//                            if ($model->id)
//                            {
//                                $model_line->change_date=date("Y-m-d H:i:s", time());
//                            }else
//                            {
//                                $model_line->created_at=date("Y-m-d H:i:s", time());
//                            }

                    //            $model_line->attributes = $new_claim_lines[$line];
            //                    foreach ($new_claim_lines[$line] as $key => $value) {
            //                        
            //                        $model[$key] = $value;
            //                    }
                                if (!$model_line->save())
                                {        
                                    
                                    echo "Ошибка сохранения строк заявки"; // to do correct message
                                    return;
                                }
                            }
                } 
                echo CJSON::encode(array(
                    'id'=>$model->id,
                    'period'=>$model->period->NAME,
                    'name'=>$model->claim_number,
                    'state'=>$model->state->stateName->name,
                    'division'=>$model->division->NAME,
                    'department'=>$model->findDepartment($model->department_id),
                    'comment'=>$model->comment,
                ));
                Yii::app()->end();
            }
        } else
        if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'err',
            'message' => 'no Asset form passed!',
        ));
        Yii::app()->end();            
    } else {
        echo 'get out!';
    }
                
//            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//            $responce['status']='ok';
//            echo CJSON::encode($responce);
//            Yii::app()->end();
//        } 
        
}

    
    public function actionReportGroup()
    {
        $model=Claim::model()->reportGroup();
        foreach ($model as $key=>$value)
        {
            $result[] =$value;
        }
        $this->render('reports/reportgroup',array('result'=>$result));
    }
}
