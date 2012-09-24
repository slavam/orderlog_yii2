<?php

class ClaimLineController extends Controller
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
				'actions'=>array('index','view','show','showConsolidatedClaim','getClaimParams',
                                    'createLinesByComplect','getWaresForTemplatesByComplect',
                                    'editClaimLineDialog','editClaimLine','checkLimits',
                                    'getLimits','getClaimLinesByArticle'), //'selectWaresFromTemplates'), //,'isTemplatesIntoComplect'),
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
		$this->render('show',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new ClaimLine;
                $model->claim_id=$_GET['claim_id'];
                $model->count = 1;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ClaimLine']))
		{
			$model->attributes=$_POST['ClaimLine'];
                        $model->claim_id=$_GET['claim_id'];
                        $model->how_created = 3;  // hand make
                        $model->created_at = date("Y-m-d H:i:s", time());
                        $asset = Asset::model()->findByPk($model->asset_id);
                        $model->cost=$asset->cost;
                        $model->amount=$model->count*$asset->cost;
                        $model->budget_item_id=$asset->budget_item_id;
			if($model->save())
				$this->redirect(array('claim/show','id'=>$model->claim_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
//        private function isTemplatesIntoComplect($complect_id)
//        {
//            $criteria=new CDbCriteria;
//            $criteria->condition="asset_template_id>0 and complect_id=".$complect_id;
//            if (ComplectLine::model()->findAll($criteria))
//                return TRUE;
//            else
//                return false;
//        }
        public function actionCreateLinesByComplect()
        {
            $complect_id = 0;
            $business_id = 0;
            $for_whom = 0;
            $claim_id = $_GET['claim_id'];
            if(isset($_POST['complect_id']))
            {
                $complect_id = $_POST['complect_id'];
                $criteria=new CDbCriteria;
                $criteria->condition="asset_template_id>0 and complect_id=".$complect_id;
                if (ComplectLine::model()->count($criteria)>0)
//                    $this->redirect(array('claimLine/selectWaresFromTemplates','complect_id'=>$complect_id,'claim_id'=>$claim_id));
                    $this->redirect(array('claimLine/getWaresForTemplatesByComplect','complect_id'=>$complect_id,'claim_id'=>$claim_id,'for_whom'=>$_POST['for_whom'],'business_id'=>$_POST['business_id']));
                else {
                    $criteria->condition=null;
                    $criteria->condition="complect_id=".$complect_id;
                    $complect_lines = ComplectLine::model()->findAll($criteria);
                    $current_time = date("Y-m-d H:i:s", time());
                    foreach ($complect_lines as $c_l) {
                        $model=new ClaimLine;
                        $model->claim_id=$claim_id;
                        $model->how_created =$c_l->complect->complect_type_id;
                        $model->complect_id = $complect_id;
                        $model->created_at = $current_time;
                        $model->business_id=$_POST['business_id'];
                        $model->for_whom=$_POST['for_whom'];
                        $model->count = $c_l->amount;
                        $model->asset_id=$c_l->asset_id;
                        $asset = Asset::model()->findByPk($c_l->asset_id);
                        $model->cost=$asset->cost;
                        $model->amount=$c_l->amount*$asset->cost;
                        $model->budget_item_id=$asset->budget_item_id;
                        $model->save();
                    }
                    $this->redirect(array('claim/show','id'=>$claim_id));
                }
            }

            $this->render('createLinesByComplect',array(
		'claim_id'=>$claim_id,
                'complect_id'=>$complect_id,
                'business_id'=>$business_id,
                'for_whom'=>$for_whom,
            ));
        }

        public function actionGetWaresForTemplatesByComplect()
        {
            $claim_id = $_GET['claim_id'];
            $complect_id = $_GET['complect_id'];
            $business_id=$_GET['business_id'];
            $for_whom=$_GET['for_whom'];
            $criteria=new CDbCriteria;
            $criteria->condition="complect_id=".$complect_id;
            $criteria->order='id';
            $complect_lines = ComplectLine::model()->findAll($criteria);
            if(isset($_POST['my_button']))
            {
                $current_time = date("Y-m-d H:i:s", time());
                foreach ($complect_lines as $c_l) {
                    if ($c_l->asset_id<1) {
                        $c_l->asset_id = $_POST['asset_id_'.$c_l->id];
                    }
                    $model=new ClaimLine;
                    $model->claim_id=$claim_id;
                    $model->how_created =$c_l->complect->complect_type_id;
                    $model->complect_id = $complect_id;
                    $model->created_at = $current_time;
                    $model->business_id=$business_id;
                    $model->for_whom=$for_whom;
                    $model->count = $c_l->amount;
                    $model->asset_id=$c_l->asset_id;
                    $asset = Asset::model()->findByPk($c_l->asset_id);
                    $model->cost=$asset->cost;
                    $model->amount=$c_l->amount*$asset->cost;
                    $model->budget_item_id=$asset->budget_item_id;
                    $model->save();
                }
                $this->redirect(array('claim/show','id'=>$model->claim_id));
            }
            $this->render('getWaresForTemplatesByComplect',array(
                'complect_id'=>$complect_id,
                'complect_lines'=>$complect_lines,
            ));            
        }
        public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ClaimLine']))
		{
			$model->attributes=$_POST['ClaimLine'];
                        $asset = Asset::model()->findByPk($model->asset_id);
                        $model->cost=$asset->cost;
                        $model->amount=$model->count*$asset->cost;
                        $model->budget_item_id=$asset->budget_item_id;
			if($model->save())
				$this->redirect(array('claim/show','id'=>$model->claim_id));
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ClaimLine');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ClaimLine('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClaimLine']))
			$model->attributes=$_GET['ClaimLine'];

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
		$model=ClaimLine::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='claim-line-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionGetClaimParams()
        {
            $model=new Claim;
            if(isset($_POST['Claim']))
            {                          
                $this->redirect(array('claimLine/checkLimits', //showConsolidatedClaim',
                    'period_id'=>$_POST['Claim']['period_id'],
                    'direction_id'=>$_POST['Claim']['direction_id'],
                    'division_id'=>$_POST['Claim']['division_id']
                ));
            }
            $this->render('getClaimParams',array(
                'model'=>$model));
        }
        
        public function actionShowConsolidatedClaim()
        {
            $period_id=$_GET['period_id'];
            $direction_id=$_GET['direction_id'];
            $model=new ClaimLine();
            $this->render('showConsolidatedClaim',array(
		'period_id'=>$period_id,
                'direction_id'=>$direction_id,
                'model'=>$model,
		));
        }
        
        public function actionGetLimits($direction_id, $period_id, $division_id){
            $s = '';
            if ($division_id != '0'){
            $sql = '
                select c.division_id  as id, budget_item_id, sum(amount) as amount
                from claim_lines c_l
                join claims c on c.id=c_l.claim_id and c.division_id='.$division_id.'
                where budget_item_id > 0 and c.direction_id='.$direction_id.'
                    and c.period_id='.$period_id.'
                group by c.division_id, budget_item_id
                order by c.division_id, budget_item_id';
            }else { $sql = '
                select 0 as id, budget_item_id, sum(amount) as amount
                from claim_lines c_l
                join claims c on c.id=c_l.claim_id 
                where budget_item_id > 0 and c.direction_id='.$direction_id.'
                    and c.period_id='.$period_id.'
                group by budget_item_id
                order by budget_item_id';
            }
            $lines = ClaimLine::model()->findAllBySql($sql);
            $responce['rows']=array();
            
            foreach ($lines as $i=>$row) {
                $responce['rows'][$i]['id'] = $i+1;
                $l = BudgetItem::model()->getLimit($period_id, $row->budget_item_id, $row->id);
                $responce['rows'][$i]['cell'] = array(
                    $row->budget_item_id,
                    $period_id,
                    $row->id,  // division_id
                    $direction_id,
                    Division::model()->findByPk($row->id)->NAME, 
                    $row->budget_item_id,
                    $l, //$limits[$row->id][$row->budget_item_id], 
                    $row->amount,
                    $l-$row->amount,
                    );
            }
            echo CJSON::encode($responce);            
        }
        
        public function actionGetClaimLinesByArticle()
        {
            $s = '';
            if ($_GET['division_id']!='0') 
                $s = 'c.division_id='.$_GET['division_id'].' and ';
            $sql = '
                select c_l.*
                from claim_lines c_l
                join claims c on c.id=c_l.claim_id
                where budget_item_id='.$_GET['article_id'].' and 
                    c.direction_id='.$_GET['direction_id'].' and '.$s.'
                    c.period_id='.$_GET['period_id'].' 
                order by c.division_id, c_l.id';
            $lines = ClaimLine::model()->findAllBySql($sql);
            $responce['rows']=array();
            foreach ($lines as $i=>$row) {
                $responce['rows'][$i]['id'] = $row->id;
                $responce['rows'][$i]['cell'] = array(
                    $row->claim_id,
                    $row->claim->division->NAME,
                    $row->claim->findDepartment($row->claim->department_id),
                    $row->claim->claim_number,
                    $row->asset->waretype->short_name, 
                    $row->asset->name, 
                    $row->asset->unit_id,
                    $row->count,
                    $row->cost,
                    $row->amount,
                    $row->description,
                    $row->for_whom>0? $row->for_whom: '',
                    $row->for_whom>0? $row->findWorkerDepartment2levels($row->for_whom): '',
                    );
            }
            echo CJSON::encode($responce);
        }
        
        public function actionCheckLimits()
        {
            $this->render('checkLimits',array(
                'dataProvider'=>null, //$dataProvider,
                'period_id'=>$_GET['period_id'],
                'direction_id'=>$_GET['direction_id'],
                'division_id'=>$_GET['division_id'],
            ));
        }



//WITH RECURSIVE temp1 ( id, parent_id, title, PATH, LEVEL ) AS (
//SELECT T1.id, T1.parent_id, T1.title as name, CAST (T1.title AS VARCHAR(150)) as PATH, 1
//    FROM places T1 WHERE T1.parent_id IS NULL
//union
//select T2.id, T2.parent_id, T2.title, CAST( temp1.PATH ||'->'|| T2.title AS VARCHAR(150)), LEVEL + 1
//     FROM places T2 INNER JOIN temp1 ON( temp1.id= T2.parent_id)      )
//select * from temp1 ORDER BY PATH         
        
        
}
