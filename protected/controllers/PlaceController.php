<?php

class PlaceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $parent_model;
	public $parent_type;
        public $menu_id;
        public $url_save = "/claimline/create/";

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
				'actions'=>array('index','view','tree'),
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
                    /*
			array('deny',  // deny all users
				'users'=>array('*'),
			),
                     * 
                     */
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
		$model=new Place;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Place']))
		{
			$model->attributes=$_POST['Place'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Place']))
		{
			$model->attributes=$_POST['Place'];
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
                    $criteria=new CDbCriteria;
                    $criteria->condition='parent_id=:parent_id';
                    $criteria->params=array(':parent_id'=>$id);
                    
                    $posts=Place::model()->findAll($criteria); // $params не требуется
                    
                if ($posts) {
               		foreach($posts as $post) {
			$this->loadModel($post->id)->delete();
                        }
                }
                   
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('tree'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $rawData=Yii::app()->db->createCommand("
                WITH RECURSIVE temp1 ( id, parent_id, title, PATH, LEVEL ) AS (
                  SELECT T1.id, T1.parent_id, T1.title as name, CAST (T1.title AS VARCHAR(150)) as PATH, 1
                    FROM places T1 WHERE T1.parent_id IS NULL
                  union
                    select T2.id, T2.parent_id, T2.title, CAST( temp1.PATH ||', '|| T2.title AS VARCHAR(150)), LEVEL + 1
                      FROM places T2 INNER JOIN temp1 ON( temp1.id= T2.parent_id)      )
                  select id, path as title from temp1 where level=3 ORDER BY PATH")->queryAll();

            $dataProvider=new CArrayDataProvider($rawData, array(
                'id'=>'place',
                'sort'=>array(
                    'attributes'=>array(
                        'title'
                    ),
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
		$model=new Place('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Place']))
			$model->attributes=$_GET['Place'];

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
		$model=Place::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Form witn AJAX validation for creates a new record.
	 */
	public function actionAdd($id_add)
	{           
            $this->parent_model = $this->loadModel($id_add);

            $model=new PlaceForm;           
            $this->performAjaxValidation($model);

            if(isset($_POST['PlaceForm']))
            {
		$model->attributes=$_POST['PlaceForm'];

                if ($model->validate())
		{
                    if ($model->add_record == 0) {
                        
                        $findtown=Place::model()->findBySql("select * from places where upper(title) = upper('".$model->town."') AND parent_id = ".$this->parent_model->id);
                                
                        if (!$findtown) {
                            $town_id = Place::model()->AddRecord($model->town,$model->add_record,$this->parent_model);
                            $this->parent_model = $this->loadModel($town_id);
                        } else {
                                $this->parent_model = $this->loadModel($findtown->id);    
                        }
                        $place_id = Place::model()->AddRecord($model->place,$model->add_record,$this->parent_model);
                    } else {
                        $town_id = Place::model()->AddRecord($model->place,$model->add_record,$this->parent_model);                    
                    }
                    
                    $this->redirect(array('tree'));
                }
            }
                if ($this->parent_model->parent_id == 0) {                       	// region - add city and advertising place
			$this->parent_type = 0;
		} else  {                                                         
			$temp_model = $this->loadModel($this->parent_model->parent_id);
			if  ($temp_model->parent_id == 0 ) {				// city or advertising place
				$this->parent_type = 1;
			} else {
				$this->parent_type = 2;
                                $model->place = $this->parent_model->title;  
			} 
		}

		$this->renderPartial('addplace',array('model'=>$model),FALSE, TRUE);

	}

        public function actionTree()
	{
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerCoreScript('jquery.yiiactiveform.js'); 

            $model=new PlaceForm;
            $this->render('tree',array('model'=>$model));

/*
		$dataProvider=new CActiveDataProvider('Place');
		$this->render('tree',array(
			'dataProvider'=>$dataProvider,
		));
*/
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='advplace-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
