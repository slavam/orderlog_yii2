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
                'actions' => array('index', 'view', 'show', 'updateGrid', 'getDataForGrid','getDirectionsForSelect','updateRow','editAssetDialog','editAsset'),
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
            /*
            array('deny', // deny all users
                'users' => array('*'),
            ),
             * 
             */
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
    public function actionEditAsset($id) {

    $model = $this->loadModel($id);
//    $this->performAjaxValidation($model);

    if (isset($_POST['Asset'])) {
        $model->attributes = $_POST['Asset'];
        if($model->validate()){
            if ($model->save()) { 
            	//$_POST['id_return'] = $model->id;
                if (Yii::app()->request->isAjaxRequest) {
                    $this->actionGetDataForGrid(); //encode json only one asset by id
                    Yii::app()->end();
                } else echo 'get out!';
            }//model->save
        }//validate
        else {echo CJSON::encode(CActiveForm::validate($model)); Yii::app()->end();}
/*       else {
            $y=CActiveForm::validate($model);
            $x=CJSON::encode(CActiveForm::validate($model)); 
            echo $x;
            Yii::app()->end();}
 * 
 */
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
     
     
        
        
/*        $model = new Asset;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Asset'])) {
            $model->attributes = $_POST['Asset'];
            //if ($model->save())
                //$this->redirect(array('view', 'id' => $model->id));
                
        }

        $this->render('create', array(
            'model' => $model,
        ));
        */
    }

    public function actionEditMultipleChoice() {
        

    if (isset($_POST['id'])) {
        
        $id = $_POST['id'];
        
        $model = $this->loadModel($id);
        
        if (isset($_POST['type_data']) && isset($_POST['multiple_arr'])) {
            
            $save_type = $_POST['type_data'];
            $save_arr  = $_POST['multiple_arr'];               
        
            switch ($save_type) {
            case 1:           
                $model->selection = $save_arr;
            break;
            case 2:           
                $model->sel_man = $save_arr;
            break;
            case 3:           
                $model->sel_prod = $save_arr;
            break;
            case 4:           
                $model->sel_feat = $save_arr;
            break;
            }    
        }
        if($model->validate()){
            if ($model->save()) { 
            //  $_POST['id_return'] = $model->id;
                if (Yii::app()->request->isAjaxRequest) {
//                    $v[text_plase] = $this->replacementPlace($save_arr);
//                    $v[data_plase] = $save_arr;                   
                    echo CJSON::encode(array(  
                    'text_place'=>$this->replacementPlace($save_arr,$save_type),
                    'data_place'=>$save_arr));                          
                    Yii::app()->end();
                } else echo 'get out!';
            } //model->save
        } //validate
        else {echo CJSON::encode(CActiveForm::validate($model)); Yii::app()->end(); }

/*       else {
            $y=CActiveForm::validate($model);
            $x=CJSON::encode(CActiveForm::validate($model)); 
            echo $x;
            Yii::app()->end();}
 * 
 */
    }
    else 
     if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'err',
            'message' => 'no Asset form passed!',
        ));
        Yii::app()->end();            
    }  else {
        echo 'get out!';
     }

     
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


    public function actionEditAssetDialog($id)
    {
    	if(Yii::app()->request->isAjaxRequest)
        {
            //$this->layout='//layouts/ajax';

            //$model = new Asset;
            $model = $this->loadModel($id);

            // For jQuery core, Yii switches between the human-readable and minified
			// versions based on DEBUG status; so make sure to catch both of them
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            $this->renderPartial('_form',array('model'=>$model),false,true);
            Yii::app()->end();
        } 
    }

//    public function actionGetDataForMultipleChoice($id)
    public function actionGetDataForMultipleChoice()
    {
    
      if ((isset($_POST['multiple_id'])) && (isset($_POST['direction_id']))) {
          
        $multiple_id = $_POST['multiple_id'];
        $direction_id = $_POST['direction_id'];
        
//        if ($multiple_id && $direction_id) {
        
        $responce = array();
	$responce['rows']=array();
      	//$responce['status']='no';

        // $to_index = Place::model()->findAllTowns();
        
        switch ($multiple_id) {
        case 1:
            $to_index = Place::model()->findAllTowns();
        break;
        case 2:
   	    $mans = Manufacturer::model()->findAll(array('order' => 'name'));
            foreach ($mans as $item) {
                $to_index[$item->id] = $item->name;
            }
        break;
        case 3:
            $criteria=new CDbCriteria;
            $criteria->condition="direction_id=".$direction_id;
            $criteria->order='name';

   	    $mans = Product::model()->findAll($criteria);
            foreach ($mans as $item) {
                $to_index[$item->id] = $item->name;
            }
            break;
    case 4:
            $criteria=new CDbCriteria;
            $criteria->condition="direction_id=".$direction_id;
            $criteria->order='name';

   	    $mans = Feature::model()->findAll($criteria);
            foreach ($mans as $item) {
                $to_index[$item->id] = $item->name;
            }
        break;
        }

     if ($to_index) {
	$responce['status']='ok';
        
        $i = 0;
        foreach ($to_index as $key=>$row) {

                 $responce['rows'][$i]['id'] = $key;           
                 $responce['rows'][$i]['cell'] = array(
	         	$key, 
	                $row,
                 );
                 $i++;
        }
                
    } 
     $responce['records'] = count($responce['rows']);               
//     }
 
     echo CJSON::encode($responce);
        }
      }
   

    public function actionUpdateRow()
        {
            if(isset($_REQUEST['id']))
            {


            /*
            	TODO: string validation before updating DB! (comment by o.lysenko 23.07.2012 12:17)
            */

                    $model=$this->loadModel($_REQUEST['id']);
                //    $model->name = $_REQUEST['name'];
                    $model->comment = $_REQUEST['comment'];
                  //  $model->part_number = $_REQUEST['part_number'];
                    $model->cost = $_REQUEST['cost'];
                    if($model->save())
    				$this->redirect(array('index'));
    				
            }
        }


    public function actionGetDirectionsForSelect()
        {

			$model=Direction::model()->findAll(array('order' => 'short_name'));
			$ret = CHtml::dropDownList('dir_selector',null,CHtml::listData($model,'id', 'short_name'),array('empty' => '<Все>'));

			return print $ret;
		}

    public function actionGetDataForGrid()  {


    Yii::beginProfile('blockID');
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
                        'with' => array('direction','assetgroup','assetgroup.block'=>array('alias'=>'block')),
                        'order' => 'block.name,assetgroup.name,t.name')
                  ));
            
            if(isset($_REQUEST['dir_selector'])&&$_REQUEST['dir_selector']){
                $criteria_ = $dataProvider->getCriteria();
                $criteria_->condition = 't.direction_id='.$_REQUEST['dir_selector'];
            }
            
            
            // if cal goes from EditAsset action to retrieve only one Asset
            if(isset($_REQUEST['id'])&&$_REQUEST['id'])
            {
                $criteria_ = $dataProvider->getCriteria();
                if($criteria_->condition!='') $criteria_->condition.=' AND ';
                $criteria_->condition.='t.id ='.$_REQUEST['id'];
            }
  
            

/*            
			$pagination = $dataProvider->getPagination();
			if(isset($_GET['page']))
                            $pagination->setCurrentPage($_GET['page']-1);
			if(isset($_GET['rows']))
                            $pagination->setPageSize($_GET['rows']);
*/
			$assets_ = $dataProvider->getData();

                        /*
			if(isset($_GET['page']))
				$responce['page'] = $_GET['page'];
			else $responce['page'] = $pagination->getCurrentPage();*/

        //    $responce['page'] = $pagination->getCurrentPage();
//            $responce['records'] = $dataProvider->getTotalItemCount();
//            $responce['total'] = "2";//ceil($responce['records'] / $_GET['rows']); 

			$responce['status']='ok';
			$responce['rows']=array();

            foreach ($assets_ as $i=>$row) {
                        $cell_red = FALSE;
                        $responce['rows'][$i]['id'] = $row['id'];
//	                $tmp = $row->assetGroup->block->name;
					if($row->budget_item_id) {
						$articles_=BudgetItem::model()->findByPk($row->budget_item_id);
						$article_name = $articles_->NAME;
						$article_code = $articles_->CODE;
                                                $template_budget_code = $row->assettemplate->budgetItem->CODE;
                                                $cell_red = ($template_budget_code !== $article_code);
//	                $tmp = $row->budgetItem->CODE;
					} else { $article_name = 'Н/Д'; $article_code = 'Н/Д'; }
	                $responce['rows'][$i]['cell'] = array(
	                			$row->id, 
//	                			'?', /*Тип записи*/
	                			$row->waretype->short_name, 
	                			$row->assetgroup->block->name, 
	                			$row->assetgroup->name, 
	                			$row->name, 
	                			$row->part_number, 
	                			$row->cost, 
	                			$row->comment,
	                			$article_name,
	                			$article_code,
	                			$cell_red
                                                );
				}

            echo CJSON::encode($responce);

            Yii::endProfile('blockID');

    }

    public function replacementPlace($place_id, $sel_type)
  {
        $ret_str = NULL;
        
        if (isset($place_id)) {
            if(!is_array($place_id))
              $PlaceArr = explode(',',$place_id);
            else $PlaceArr=$place_id;
        }
        if (($PlaceArr) && (isset($sel_type))) {
//        if ($PlaceArr) {
            foreach($PlaceArr as $key) {
//                $SelName = Place::model()->findTown($key);
//        	$ret_str .= "<b>".$SelName->title."</b>"."; ";
                
                switch ($sel_type) {
                case 1:           
                    $SelName = Place::model()->findTown($key)->title;
                break;
                case 2:           
                    $SelName = Manufacturer::model()->findByPk($key)->name;
                break;
                case 3:           
                    $SelName = Product::model()->findByPk($key)->name;
                break;
                case 4:           
                    $SelName = Feature::model()->findByPk($key)->name;
                break;
                }    
        	$ret_str .= "<b>".$SelName."</b>"."; ";

            }
        }
        return 	$ret_str;	
	
  }
     public function actionGetTemplateByAsset()
    {
         $template_id = $_POST['template_id'];

         $template = array();
        
        if ($template_id) {
            
            $templ_model = AssetTemplate::model()->findByPk($template_id);
            
            $template[asset_group_id] = $templ_model->assetgroup->block->name.' => '.$templ_model->assetgroup->name;
            $template[ware_type_id] = $templ_model->waretype->short_name;
        
            if ($templ_model->budget_item_id) {
                $article=BudgetItem::model()->findByPk($templ_model->budget_item_id);
                $article_code = $article->CODE;
                $template[budget_item_id] = $article->get2LevelNameBudgetItem($templ_model->budget_item_id)." => ".$article_code;
            } else {
                $template[budget_item_id] = "Н/Д";            
            }
            $template[direction_id_val] = $templ_model->direction_id;
            $template[direction_id] = $templ_model->direction->short_name;
            $template[ware_type_id] = $templ_model->waretype->short_name;
        }
        
        echo CJSON::encode($template);
        Yii::app()->end();
    }

}                                                                           	