<?php

class AssetController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'show', 'updateGrid', 'getDataForGrid','getDirectionsForSelect'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionShow($id) {
        $this->render('show', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Asset;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Asset'])) {
            $model->attributes = $_POST['Asset'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Asset'])) {
            $model->attributes = $_POST['Asset'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Asset', array(
                    'pagination' => false,
                    'criteria' => array(
                        'order' => 'ware_type_id, name',
                    ),
                ));


        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Asset('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Asset']))
            $model->attributes = $_GET['Asset'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Asset::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'asset-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpdateGrid($id) {
        if (Yii::app()->request->isAjaxRequest)
        {
            $id=$_GET['id'];
        }
//        if ($id !== null) {
            $model = $this->loadModel($id);

            if (isset($_POST['Asset'])) {
                $model->attributes = $_POST['Asset'];
                if ($model->save()) {
//                $this->redirect(array('admin'));
                    $dataProvider = new CActiveDataProvider('Asset', array(
                                'pagination' => false,
                                'criteria' => array(
                                    'order' => 'ware_type_id, name',
                                ),
                            ));
                    $this->render('index', array(
                        'dataProvider' => $dataProvider,
                    ));
                }
            }
//        } else {
//           
//            echo CHtml::encode('error/ enter id');
//            // Завершаем приложение
//            Yii::app()->end();
//        }
    }

    public function actionGetDirectionsForSelect()
        {

			$model=Direction::model()->findAll(array('order' => 'short_name'));
			$ret = CHtml::dropDownList('dir_selector',null,CHtml::listData($model,'id', 'short_name'),array('empty' => '<Все>'));

			return print $ret;
		}

    public function actionGetDataForGrid()  {

            $responce = array();

            /*
            $dataProvider_FIN = new CActiveDataProvider('BudgetItem' , array(
            					'pagination'=>false, 
            					'criteria' => array(
	            					'order' => 'id')
	            					)
                  );

            $articles_ = $dataProvider_FIN->getData();*/

            $dataProvider = new CActiveDataProvider('Asset' , array(
            					'pagination'=>false, 
            					'criteria' => array(
            						'with' => array('direction','block','assetgroups'),
	            					'order' => 'block.name,assetgroups.name,t.name'))
//	            					'order' => 'block.name,assetGroup.name'))
                  );
            
            if(isset($_REQUEST['dir_selector'])&&$_REQUEST['dir_selector']){
                $criteria_ = $dataProvider->getCriteria();
                $criteria_->condition = 't.direction_id='.$_REQUEST['dir_selector'];
            }

/*                  
			$pagination = $dataProvider->getPagination();
			if(isset($_GET['page']))
                            $pagination->setCurrentPage(0);
			if(isset($_GET['rows']))
                            $pagination->setPageSize($_GET['rows']);
                            */

			$assets_ = $dataProvider->getData();

			$responce['rows']=array();

            foreach ($assets_ as $i=>$row) {
	                $responce['rows'][$i]['id'] = $row['id'];
//	                $tmp = $row->assetGroup->block->name;
					if($row->budget_item_id) {
						$articles_=BudgetItem::model()->findByPk($row->budget_item_id);
						$article_name = $articles_->NAME;
					} else $article_name = 'Н/Д';
	                $responce['rows'][$i]['cell'] = array(
	                			$row->id, 
	                			$row->block->name, 
	                			$row->assetgroups->name, 
	                			$row->waretype->short_name, 
	                			$row->name, 
	                			$row->cost, 
	                			$row->part_number, 
	                			$article_name);
				}

            echo CJSON::encode($responce);

    }
}                                                                           	