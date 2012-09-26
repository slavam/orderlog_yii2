<?php

class AssetTemplateController extends Controller
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
				'actions'=>array('index','view','show','getTemplate','createTemplateDlg','updateTemplateDlg',
                                    'indexJqgrid','getDataForGrid','getDataForDetails','create','update','CreateAssetByTemplate'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('show'),
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
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	/*
		$model=new AssetTemplate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AssetTemplate']))
		{
			$model->attributes=$_POST['AssetTemplate'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
		*/

    $model = new AssetTemplate;

    if (isset($_POST['AssetTemplate'])) {
        $model->attributes = $_POST['AssetTemplate'];
        if($model->validate()){
            if ($model->save()) { 
            //$_POST['id_return'] = $model->id;
                if (Yii::app()->request->isAjaxRequest) {

                //return json with the next fields to avoid jqgrid reload each time
                /*
				            'name'
				            'article'
				            'article_code'
				            'info'
				            'comment'

                */
						if($model->budget_item_id) {
						
							$articles_=BudgetItem::model()->findByPk($model->budget_item_id);
							$article_code = $articles_->CODE;
						    $article_name = $articles_->get2LevelNameBudgetItem($model->budget_item_id);
                                                    if(!$article_name) {
                                                        $article_name = $articles_->NAME;
                                                    }

						} else { $article_name = 'Н/Д'; $article_code = 'Н/Д'; }

        echo CJSON::encode(array(
            'status' => 'ok',
            'id' => $model->id,
            'asset_group_id' => $model->asset_group_id,
            'name' => $model->name,
            'article' => $article_name,
            'article_code' => $article_code,
            'info' => $model->info,
            'comment' => $model->comment
        ));

                    Yii::app()->end();
                } else echo 'get out!';
            }//model->save
        }//validate
        else {echo CJSON::encode(CActiveForm::validate($model)); Yii::app()->end();}
    }
    else
    if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'err',
            'message' => 'no Asset form passed!',
        ));
        Yii::app()->end();            
    } else {
        echo 'get out!';
    }

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
	/*
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AssetTemplate']))
		{
			$model->attributes=$_POST['AssetTemplate'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
		*/
    $model = $this->loadModel($id);

        switch ($_REQUEST['oper']) {
            case 'edit':
    if (isset($_POST['AssetTemplate'])) {
        $model->attributes = $_POST['AssetTemplate'];
        if($model->validate()){
            if ($model->save()) { 
            //$_POST['id_return'] = $model->id;
                if (Yii::app()->request->isAjaxRequest) {

                //return json with the next fields to avoid jqgrid reload each time
                /*
				            'name' 'article' 'article_code' 'info' 'comment'

                */
						if($model->budget_item_id) {
						
							$articles_=BudgetItem::model()->findByPk($model->budget_item_id);
							$article_code = $articles_->CODE;
						    $article_name = $articles_->get2LevelNameBudgetItem($model->budget_item_id);
                                                    if(!$article_name) {
                                                        $article_name = $articles_->NAME;
                                                    }

						} else { $article_name = 'Н/Д'; $article_code = 'Н/Д'; }

        echo CJSON::encode(array(
            'status' => 'ok',
            'id' => $model->id,
            'asset_group_id' => $model->asset_group_id,
            'name' => $model->name,
            'article' => $article_name,
            'article_code' => $article_code,
            'info' => $model->info,
            'comment' => $model->comment
        ));

                    Yii::app()->end();
                } else echo 'get out!';
            }//model->save
        }//validate
        else {echo CJSON::encode(CActiveForm::validate($model)); Yii::app()->end();}
    }
    else
    if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'err',
            'message' => 'no Asset form passed!',
        ));
        Yii::app()->end();            
    } else {
        echo 'get out!';
    }
    break; //edit

                    case 'del':
                    	//TODO: check before deletion!!! [o.lysenko 4.sep.2012 16:46]
                           $model->delete();
                           //echo 'deleted id='.$id;
                            echo CJSON::encode(array(
                                'status' => 'ok'
                                ));
                            Yii::app()->end(); 
                        
                        break;


    }//switch oper

	}//function

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
		$dataProvider=new CActiveDataProvider('AssetTemplate', array(
                    'pagination' => false,
                    'criteria' => array(
                        'order' => 'name')));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AssetTemplate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AssetTemplate']))
			$model->attributes=$_GET['AssetTemplate'];

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
		$model=AssetTemplate::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='asset-template-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        public function actionGetTemplate()
        {
            $asset_template_id = 0;
            if(isset($_POST['asset_template_id']))
            {
                $asset_template_id = $_POST['asset_template_id'];
                $this->redirect(array('createAssetByTemplate','asset_template_id'=>$asset_template_id));
            }

            $this->render('getTemplate',array(
                'asset_template_id'=>$asset_template_id,
            ));
        }
        
        public function actionCreateAssetByTemplate() {
            $template = AssetTemplate::model()->findByPk($_GET['asset_template_id']);
            $model = new Asset;
            $model->name = $template->name;
            $model->asset_template_id = $_GET['asset_template_id'];
            $model->asset_group_id = $template->asset_group_id;
            $model->cost = $template->cost;
            $model->price_type_id = $template->price_type_id;
            $model->ware_type_id = $template->ware_type_id;
            $model->budget_item_id = $template->budget_item_id;
            $model->unit_id = $template->unit_id;
            $model->direction_id = $template->direction_id;
            $model->part_number = $template->part_number;
            $model->info = $template->info;
            $model->comment = $template->comment;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Asset'])) {
            $model->attributes = $_POST['Asset'];
            if ($model->save())
                $this->redirect(array('/asset/index'));
        }

        $this->render('createAssetByTemplate', array(
            'model' => $model,
        ));
    }
    public function actionIndexJqgrid()
	{
			$this->pageTitle='Шаблоны';

            $dataProvider=new CActiveDataProvider('AssetTemplate', array(
                'pagination' => false,
                'criteria' => array(
                    'order' => 'name')));
            $this->render('indexJqgrid',array(
                    'dataProvider'=>$dataProvider,
            ));
        }


    public function actionCreateTemplateDlg()
    {
    	if(Yii::app()->request->isAjaxRequest)
        {
            //$this->layout='//layouts/ajax';

            $model = new AssetTemplate;
            //$model = $this->loadModel($id);

            // For jQuery core, Yii switches between the human-readable and minified
			// versions based on DEBUG status; so make sure to catch both of them
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            $this->renderPartial('_form',array('model'=>$model),false,true);
            Yii::app()->end();
        } 
    }

    public function actionUpdateTemplateDlg($id)
    {
    	if(Yii::app()->request->isAjaxRequest)
        {
            //$this->layout='//layouts/ajax';

            //$model = new AssetTemplate;
            $model = $this->loadModel($id);

            // For jQuery core, Yii switches between the human-readable and minified
			// versions based on DEBUG status; so make sure to catch both of them
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            $this->renderPartial('_form',array('model'=>$model),false,true);
            Yii::app()->end();
        } 
    }

    
        public function actionGetDataForGrid()
	{
            $responce = array();

            $dataProvider_block = new CActiveDataProvider('Block' , array(
            		                'pagination'=>false, 

                    'criteria'=>array(
                    'with'=>array('directions'),
                        'order'=>'directions.name, t.name',
                        ),
                  )
                  );
/*
			$pagination_block = $dataProvider_block->getPagination();
			if(isset($_GET['page']))
                            $pagination_block->setCurrentPage(0);
			if(isset($_GET['rows']))
                            $pagination_block->setPageSize($_GET['rows']);
*/
			$blocks_ = $dataProvider_block->getData();

			$responce['status']='ok';
			$responce['rows']=array();

			$r_i = 0;
				
            foreach ($blocks_ as $i=>$row) {
                $responce['rows'][$r_i]['id'] = $r_i+1;
                $responce['rows'][$r_i]['cell'] = array($row->id, $row->name,'','','','','0','null',false,false,true);
                $r_i++;

	            $dataProvider_group = new CActiveDataProvider('AssetGroup' , array(
	            	                'pagination'=>false, 

	                    'criteria'=>array(
	                    	'condition'=>'block_id='.$row->id,
	                        'order'=>'name',
	                        ),
	                  )
	                  );
/*	
				$pagination_group = $dataProvider_group->getPagination();
				if(isset($_GET['page']))
	                            $pagination_group->setCurrentPage(0);
				if(isset($_GET['rows']))
	                            $pagination_group->setPageSize($_GET['rows']);
*/
				$groups_ = $dataProvider_group->getData();
				$parent_ = $r_i;

				foreach ($groups_ as $i=>$row) {
	                $responce['rows'][$r_i]['id'] = $r_i+1;
	                $responce['rows'][$r_i]['cell'] = array($row->id, $row->name,'','','','','1',"$parent_",false,false,true);
	                $r_i++;


		            $dataProvider_template = new CActiveDataProvider('AssetTemplate' , array(
		            	                'pagination'=>false, 

		                    'criteria'=>array(
		                    	'condition'=>'asset_group_id='.$row->id,
		                        'order'=>'name',
		                        ),
		                  )
		                  );

		            $templates_ = $dataProvider_template->getData();
					$parent_t = $r_i;

			        foreach ($templates_ as $i=>$row) {
		                $responce['rows'][$r_i]['id'] = $r_i+1;                       //art,art_id,info,comment

						if($row->budget_item_id) {
						
							$articles_=BudgetItem::model()->findByPk($row->budget_item_id);
							//$article_name = $articles_->NAME;
							$article_code = $articles_->CODE;
						    $article_name = $articles_->get2LevelNameBudgetItem($row->budget_item_id);

						} else { $article_name = 'Н/Д'; $article_code = 'Н/Д'; }

		                $responce['rows'][$r_i]['cell'] = array($row->id,  $row->name,$article_name,$article_code,$row->info,$row->comment ,'2',"$parent_t",true,true,true);
		                $r_i++;
			        }

				}


            }

            echo CJSON::encode($responce);
            
        }
/*            
            
            
            $dataProvider=new CActiveDataProvider('AssetTemplate', array(
                'criteria'=>array(
                    'order'=>'name',
                    ),
            ));
//            $pagination_block = $dataProvider->getPagination();
            $claims = $dataProvider->getData();
            $responce['rows']=array();
            foreach ($claims as $i=>$row) {
                $responce['rows'][$i]['id'] = $i+1;
                $responce['rows'][$i]['cell'] = array(
                    $row->id, 
                    $row->name, 
                    );
            }
            echo CJSON::encode($responce);
        }
        */

        public function actionGetDataForDetails()
        {
            $dataProvider=new CActiveDataProvider('ClaimLine', array(
                'pagination'=>false,
                'criteria'=>array(
                    'condition'=>'claim_id='.$_GET['claim_id'],
                    'order'=>'id',
                    ),
            ));
            
            $complects = $dataProvider->getData();
            $responce['rows']=array();
            foreach ($complects as $i=>$row) {
                $responce['rows'][$i]['id'] = $i+1;
                $responce['rows'][$i]['cell'] = array(
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

}
