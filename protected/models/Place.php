<?php

/**
 * This is the model class for table "places".
 *
 * The followings are the available columns in table 'places':
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property integer $position
 * @property string $tooltip
 * @property string $url
 * @property string $icon
 * @property integer $visible
 * @property string $task
 * @property string $options
 * @property integer $productid
 * @property integer $id2
 */
class Place extends CActiveRecord
{
public $PATH;	
    /**
	 * Returns the static model of the specified AR class.
	 * @return Place the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'places';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, position, url, visible, options, productid, id2', 'required'),
			array('parent_id, position, visible, productid, id2', 'numerical', 'integerOnly'=>true),
			array('title, url', 'length', 'max'=>255),
			array('tooltip, options', 'length', 'max'=>100),
			array('icon', 'length', 'max'=>50),
			array('task', 'length', 'max'=>64),
                        array('PATH','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, title, position, tooltip, url, icon, visible, task, options, productid, id2', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'title' => 'Title',
			'position' => 'Position',
			'tooltip' => 'Tooltip',
			'url' => 'Url',
			'icon' => 'Icon',
			'visible' => 'Visible',
			'task' => 'Task',
			'options' => 'Options',
			'productid' => 'Productid',
			'id2' => 'Id2',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('tooltip',$this->tooltip,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('task',$this->task,true);
		$criteria->compare('options',$this->options,true);
		$criteria->compare('productid',$this->productid);
		$criteria->compare('id2',$this->id2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function findAllPlaces()
        {
            $positions = Place::model()->findAllBySql("
                WITH RECURSIVE temp1 ( id, parent_id, title, PATH, LEVEL ) AS (
                  SELECT T1.id, T1.parent_id, T1.title as name, CAST (T1.title AS VARCHAR(150)) as PATH, 1
                    FROM places T1 WHERE T1.parent_id IS NULL
                  union
                    select T2.id, T2.parent_id, T2.title, CAST( temp1.PATH ||', '|| T2.title AS VARCHAR(150)), LEVEL + 1
                      FROM places T2 INNER JOIN temp1 ON( temp1.id= T2.parent_id)      )
                  select id, path as title from temp1 where level=3 ORDER BY PATH");
            $data = array(''=>'Задайте расположение');
            foreach($positions as $position){
                    $data[$position->id] = $position->title;
            }			
            return $data;
        }
                public function findAllAddresses()
        {
            return Place::model()->findAllBySql("
                WITH RECURSIVE temp1 ( id, parent_id, title, PATH, LEVEL ) AS (
                  SELECT T1.id, T1.parent_id, T1.title as name, CAST (T1.title AS VARCHAR(150)) as PATH, 1
                    FROM places T1 WHERE T1.parent_id IS NULL
                  union
                    select T2.id, T2.parent_id, T2.title, CAST( temp1.PATH ||', '|| T2.title AS VARCHAR(150)), LEVEL + 1
                      FROM places T2 INNER JOIN temp1 ON( temp1.id= T2.parent_id)      )
                  select id, path as title from temp1 where level=3 ORDER BY PATH");
        }
	/**
	 * Add or change record 
	 */
	public function AddRecord($place,$add_record)
	{

         if ($add_record != 2){
            $save_model = new Place;
                 $save_model->parent_id = $this->parent_model->id;
                 $save_model->title = $place;
                 $save_model->position = 0;
                 $save_model->tooltip = $this->parent_model->title;
                 $save_model->url = $this->url_save.$save_model->id;
                 $save_model->icon = "";
                 $save_model->visible = 1;
                 $save_model->task = "";
                 $save_model->options = '"';
                 $save_model->productid = $this->parent_model->id;
                 $save_model->id2 = $this->parent_model->id;

            } else {
            $save_model=$this->loadModel($this->parent_model->id);
                 $save_model->title = $place;
         }
               
            if (($save_model->save()) && ($add_record != 2)) {
                    $save_model->url = $save_model->url.$save_model->id;
                    $save_model->productid = $save_model->id;
                    $save_model->save();
            } else {
                    $save_model->save();                
            }
         return $save_model->id;
	}
        
}