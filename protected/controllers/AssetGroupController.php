<?php

class AssetGroupController extends Controller
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
				'actions'=>array('index','view','show','jqgriddata','getDataForGrid','updateRow','updateCell','getDirectionsForSelect','addRow','getBlocks','relinkRow','GetAssetGroupsByDirection'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AssetGroup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AssetGroup']))
		{
			$model->attributes=$_POST['AssetGroup'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


        public function actionRelinkRow()
        {
            if(isset($_REQUEST['iddb']))
            {
                $model=$this->loadModel($_REQUEST['iddb']);
                $model->block_id=$_REQUEST['block_id'];
                if(!$model->save()) 
                {
                    //echo CJSON::encode("Error while saving model!");
                    return false;
                }
                
            }
        }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
        public function actionUpdateRow()
        {
            if(isset($_REQUEST['iddb']))
            {


            /*
            	TODO: string validation before updating DB! (comment by o.lysenko 23.07.2012 12:17)
            */

                if(isset($_REQUEST['parent'])&&($_REQUEST['parent']!="null"&&$_REQUEST['parent']!="")) {
                    $model=$this->loadModel($_REQUEST['iddb']);
                    $model->name = $_REQUEST['name'];
                    $model->comment = $_REQUEST['comment'];
                    $model->stamp = $_REQUEST['stamp'];
                    if($model->save())
    				$this->redirect(array('index'));
                }
                
                if(isset($_REQUEST['parent'])&&($_REQUEST['parent']=="null"||$_REQUEST['parent']=="")) {
                    $model=Block::model()->findByPk($_REQUEST['iddb']);
                    if($model===null)
						throw new CHttpException(404,'The requested page does not exist.');
                    $model->name = $_REQUEST['name'];
                    $model->comment = $_REQUEST['comment'];
                    $model->stamp = $_REQUEST['stamp'];
                    $model->direction_id = $_REQUEST['dir'];
                    if($model->save())
    				$this->redirect(array('index'));
                    
                }
            }
        }

        public function actionUpdateCell()
        {
            if(isset($_POST['id']))
            {
                //$model=$this->loadModel($_POST['id']);
                //$model->name = $_POST['name'];
                //if($model->save())
		//		$this->redirect(array('index'));
            }
        }

        public function actionAddRow()
        {
            if(isset($_POST['id']))
            {
                if(isset($_REQUEST['parent'])&&($_REQUEST['parent']=="null"||$_REQUEST['parent']==""))
                {
                    // TODO : Server-side validation!!! especialy direction!
                    $model = new Block;
                    $model->name = $_REQUEST['name'];
                    $model->comment = $_REQUEST['comment'];
                    $model->stamp = $_REQUEST['stamp'];
                    $model->direction_id = $_REQUEST['dir'];
                    if($model->save())
                    {
                        echo CJSON::encode($model->id);
                        //redirect with params?!
        		//$this->redirect(array('index'));
                    }
                }
                if(isset($_REQUEST['parent'])&&($_REQUEST['parent']!="null"&&$_REQUEST['parent']!=""))
                {
                    // TODO : Server-side validation!!! especialy direction!
                    $model = new AssetGroup;
                    $model->name = $_REQUEST['name'];
                    $model->comment = $_REQUEST['comment'];
                    $model->stamp = $_REQUEST['stamp'];
                    $model->block_id = $_REQUEST['iddb'];
                    if($model->save())
                    {
                        echo CJSON::encode($model->id);
        		//$this->redirect(array('index'));
                    }
                }
            }
        }

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AssetGroup']))
		{
			$model->attributes=$_POST['AssetGroup'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('AssetGroup', array(
                    'criteria'=>array(
                        'order'=>'id, name',
                        ),
                ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AssetGroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AssetGroup']))
			$model->attributes=$_GET['AssetGroup'];

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
		$model=AssetGroup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='asset-group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

        public function actionGetDirectionsForSelect()
        {

			$model=Direction::model()->findAll(array('order' => 'short_name'));
			$ret = CHtml::dropDownList('',null,CHtml::listData($model,'id', 'short_name'),array('empty' => '<Направление>'));

			return print $ret;
        }
            
        public function actionGetAssetGroupsByDirection(){
            $list=array();
            if (($dir=$_REQUEST['dir']))
            {
                $model = AssetGroup::model()->findAssetGroupsByDirection($dir);
                
                if (!empty($model))
                {
                    foreach($model as $value)
                    {
                        $list[$value->id] = $value->name;
                    }
                }
                
            }
            $html=array('encode'=>true,'empty'=>'<Выберите группу>');
                $options = CHtml::listOptions(null, $list, $html);
                echo $options;
        }
        
        public function actionGetBlocks()
        {

			$model=Block::model()->findAll(array('order' => 'name'));
			$ret = CHtml::dropDownList('supergroups-list',null,CHtml::listData($model,'id', 'name'),array('empty' => '<Группа>'));

			return print $ret;
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


			$responce['rows']=array();

			$r_i = 0;
				
            foreach ($blocks_ as $i=>$row) {
                $responce['rows'][$r_i]['id'] = $r_i+1;
                $responce['rows'][$r_i]['cell'] = array($row->id, $row->name, $row->comment, $row->stamp, $row->direction_id /*$row->directions->short_name*/,'0','null',false,false,true);
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
	                $responce['rows'][$r_i]['cell'] = array($row->id, $row->name, $row->comment, $row->stamp,'','1',"$parent_",true,true,true);
	                $r_i++;
				}


            }

/*			
			$new_super_block ='';
			$current_parent='null';
			$current_level ='0';
			$current_name  ='';

            $local_rows = $dataProvider_group->getData();

            foreach ($local_rows as $i=>$row) {
                $responce['rows'][$i]['id'] = $row['id'];

                if($new_super_block!=$row->block->name) {
                	$new_super_block=$row->block->name;
                	$current_name = $row->block->name;
	                $current_parent='null';
					$current_level ='0';
				}
                else {
                	$current_name = $row->name;
                	$current_parent='null';
					$current_level ='1';
				}

                $responce['rows'][$i]['cell'] = array($row->id, $current_name,$current_level,$current_parent,true,false,true);

            }
*/
            echo CJSON::encode($responce);
        }
}
