<?php

/**
 * This is the model class for table "purposes".
 *
 * The followings are the available columns in table 'purposes':
 * @property integer $id
 * @property integer $direction_id
 * @property string $name
 */
class Purpose extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Purpose the static model class
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
		return 'purposes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('direction_id', 'numerical', 'integerOnly'=>true),
			array('name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, direction_id, name', 'safe', 'on'=>'search'),
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
                    'direction' => array(self::BELONGS_TO, 'Direction', 'direction_id' ),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'direction_id' => 'Direction',
			'name' => 'Name',
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
		$criteria->compare('direction_id',$this->direction_id);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function findGoalsByDirection($direction_id) {
		$criteria=new CDbCriteria;
                $criteria->condition="direction_id=".$direction_id;
                $criteria->order='name';
       		$goals = Purpose::model()->findAll($criteria);
		return CHtml::listData($goals,'id','name');
         }
         public function getAllGoals(){
             return CHtml::listData(Purpose::model()->findAll(),'id','name');
         }
}
