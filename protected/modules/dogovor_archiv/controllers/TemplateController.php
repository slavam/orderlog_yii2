<?php
/**
 * Description of TemplateController
 *
 * @author v.kriuchkov
 */
class TemplateController extends Controller{
    private $_model;

    function filters() {
        return array(
                array('application.filters.XssFilter','clean' => 'all')
            );
    }
    
    function actionIndex()
    {
        $this->actionView();
    }


    /*Страница списка шаблонов*/
    function actionView($id = null) {
        if (isset($id))
        {
            $model = $this->loadModel($id);
        }
        else {
            $model = new Template;
            if (count($model = $model->findAll())<1)
            {
                $create_link ='/dogovor_archiv/template/create';
                $model = sprintf('Нет шаблонов.<a href="%s">Создать шаблон</a>',$create_link);
            }
        }
        $this->render('template_main',array('templates'=>$model));
    }
    
    /*Страница создания шаблона*/
    function actionCreate() {
        
        $model = new Template;
//            $attributes['form']= array(//Тип документа (Договор, соглашение и т.д.)
//                'doc_type' => array(
//                    'attributes' => array('value'=>'Договор'),
//                    'weight'=>1,
//                    'rules'=>array('default'=>array('value'=>'Договор')),
//                    'reference'=>'section_1'
//                    ), 
//                'provider' => array(//Контрагент
//                    'type' => 'text',
//                    'attributes' => array(),
//                    'weight'=>2,
//                    'rules'=>array('safe'=>true,'required'=>true),
//                    'reference'=>'section_1'
//                    ), 
//                'provider_contact' => array(//Контрагент\контактное лицо
//                    'type' => 'text',
//                    'attributes' => array(),
//                    'weight'=>3,
//                    'rules'=>array('safe'=>true),
//                    'reference'=>'section_1'
//                    ), 
//                'dog_number' => array(
//                    'type' => 'text',
//                    'attributes' => array(),
//                    'weight'=>4,
//                    'reference'=>'section_1',
//                    'rules'=>array('safe'=>true,'required'=>true),           
//                    ), //Номер договора (реквизит)
//                'inside_number' => array(//Внутренний номер (Уникальный номер в ПК. Недоступен для редактирования)
//                    'type' => 'text',
//                    'attributes' => array(),
//                    'weight'=>4,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_1',
//                    ),
//                'dog_fact_date'=>array(//Дата фактического заведения договора в систему
//                    'type' => 'text',
//                    'attributes' => array(),
//                    'weight'=>5,
//                    'rules'=>array('safe'=>true,'default'=>array('value'=>'06.08.2012')),
//                    'reference'=>'section_1',
//                    ),
//                'dog_date'=>array(//Дата договора контрагента
//                    'type' => 'text',
//                    'attributes' => array(),
//                    'weight'=>6,
//                    'rules'=>array('safe'=>true,'required'=>true),
//                    'reference'=>'section_1',
//                    ),
//                'dog_period'=> array(//Период. Виджет из 2 полей
//                    'type' => 'application.components.StartDatePicker', 
//                    'attributes' => array('attributeStart_date'=>'start_date','attributeStop_date'=>'stop_date'), 
//                    'weight'=>7,
//                    'rules'=>array('safe'=>true),
//                    'reference'=>'section_1',
//                    ), 
//                'start_date' => array(//Начальная дата
//                    'type' => 'text', 
//                    'attributes' => array(),
//                    'weight'=>8,
//                    'rules'=>array('safe'=>true,'checkDateInterval'=>true,'date'=>array('allowEmpty'=>false,'format'=>'dd.mm.yyyy')),
//                    'reference'=>'section_1',
//                    'visible'=>false
//                    ),
//                'delimeter_1'=>array('data'=>'<hr />','weight'=>'8'),
//                'stop_date' => array(
//                    'type' =>'text', 
//                    'attributes' => array(),
//                    'visible'=>false,
//                    'weight'=>9,
//                    'rules'=>array('safe'=>true,'checkDateInterval'=>true,'date'=>array('allowEmpty'=>false,'format'=>'dd.mm.yyyy')),
//                    'reference'=>'section_1',
//                    ), //Конечная дата
//                'summ' => array(
//                    'type' => 'text', 
//                    'attributes' => array(),
//                    'weight'=>10,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_2'
//                    ), //Сумма
//                'dog_type'=>array(
//                    'type' => 'text', 
//                    'attributes' => array('value'=>'Розничный договор'),
//                    'weight'=>11,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_1'
//                    ), //Тип договора (Хоз, розничный и т.д.)
//                'dog_kind'=>array(
//                    'type' => 'dropdownlist',
//                    'items'=>  "Document::getDogTypes", 
//                    'attributes' => array(),
//                    'weight'=>12,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_1'
//                    ), //Вид договора
//                'recipient' => array('type' => 'text', 'attributes' => array(),
//                    'weight'=>13,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_1'
//                    ), //Получатель (Наша организация, Отделение)
//                'storage' => array(
//                    'type' => 'text',
//                    'attributes' => array(),
//                    'weight'=>14,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_2'
//                    ), //Место хранения
//                'subject' => array(
//                    'type' => 'text',
//                    'attributes' => array(),
//                    'weight'=>15,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_1'
//                    ), //Предмет договора
//                'delegation' => array('type' => 'dropdownlist', 'attributes' => array(),
//                    'weight'=>16,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_2'
//                    ), //Делегирование
//                'tarif' => array(
//                    'type' => 'text',
//                    'attributes' => array(),
//                    'weight'=>17,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_2'
//                    ), //Значение справочника тариф
//                'tarif_type' => array('type' => 'dropdownlist', 'attributes' => array(),
//                    'weight'=>18,
//                    'items'=>'Document::getTarifTypes',
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_2'
//                    ), //Значение справочника тариф с получателя, с плательщика
//                'reestr' => array('type' => 'checkbox', 'attributes' => array(),
//                    'weight'=>19,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_1'
//                    ), //Флаг наличия реестра
//                'delimeter'=>array('data'=>'<hr />','weight'=>20),
//                'author_login' => array('type' => 'text', 
//                    'attributes' => array(//Логин создателя договора в системе
//                        'maxlength' => 32,
//                        'minlength'=>2
//                    ),
//                    'weight'=>20,
//                    'rules'=>array('safe'=>true,'default'=>array('value'=>'v.kriuchkov')),
//                    'reference'=>'section_1'
//                  ), 
//                'status' => array(//Статус
//                    'type' => 'dropdownlist',
//                    'items'=> "Document::getStatuses",
//                    'attributes' => array(),
//                    'weight'=>4,
//                    'rules'=>array('required'=>true,),
//                    'reference'=>'section_1'
//                    ),
//                'note' => array(
//                    'type' => 'text',  //Примечание
//                    'attributes' => array(
//                        'maxlength' => 32,
//                        'minlength'=>2,
//                    ),
//                    'weight'=>22,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_2'
//                ),
//                'reward_percent' => array( //процент вознаграждения
//                    'type' => 'text', 
//                    'attributes' => array(
//                        'maxlength' => 32,
//                        'minlength'=>2,
//                    ),
//                    'weight'=>17,
//                    'rules'=>array('safe'=>true,),
//                    'reference'=>'section_1'
//                ),
//                
//            );
            $criteria = new EMongoCriteria;
            $criteria->addCond('system_name', 'in', array('author_login','dog_kind','doc_type','status'));
            $system_fields = Field::model()->findAll($criteria);
            if (count($system_fields>0))
            {
                foreach ($system_fields as $key=>$field)
                {
                    $arr = $field->toArray();
                    $model->form[$arr['system_name']] = $arr;
                }
            }
    if ($_POST['Template'])
    {
        $model->name = $_REQUEST['Template']['name'];
        $model->description = $_REQUEST['Template']['description'];
        if ($model->validate())
        {
            $model->save(true,array('form','name','description'));
            $this->redirect('/dogovor_archiv/template');
        }
    }   
  $this->render('/template/template_create',array('model'=>$model));
}
    
    public function loadModel($id)
	{
            if($this->_model===null)
            {
                    if(isset($id))
                    {
                         $_id = new EMongoCriteria;
                         $_id->addCond('_id', '==', new MongoId($id));
                         $this->_model=Template::model()->find($_id);
                    }
                    if($this->_model===null)
                            throw new CHttpException(404,'The requested page does not exist.');
            }
            return $this->_model;
	}
    
    /*Страница редактирования шаблона*/
    function actionEdit($id) {
        $model = $this->loadModel($id);
        
        if(isset($_POST['Template']))
		{
			$model->name=$_POST['Template']['name'];
			$model->description=$_POST['Template']['description'];
			if($model->save(true,array('form','name','description')))
				$this->redirect(array('/dogovor_archiv/template/view'));
		}
        $this->render('/template/template_create', array('model'=>$model));
    }
    
    /*Страница удаления шаблона*/
    function actionDelete($id) {
        $model = $this->loadModel($id);
        if (isset($id))
        {
            $model->delete();
            Yii::app()->user->setFlash('notice','Шаблон удален');
            $this->redirect('/dogovor_archiv/template');
            //$this->render('template/template_main');
        }
    }
    
    function actionEditFieldReference($templ_id=null)
    {
        if ($templ_id !==null)
        {
            $model = $this->loadModel($templ_id);
            $fields = new CArrayDataProvider($model->form,array('keyField'=>false,'keys'=>array('author_login')));
            $this->render('template_field_reference',array('model'=>$model,'fields'=>$fields));
        }
       else
           throw new CHttpException(404,'Не указан идентификатор шаблона');
    }
    
    function actionSaveFieldReference()
    {
        
    }
}

?>
